<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\Common\ListRequestDto;
use App\Http\Dto\Playlist\ContentToPlaylistRequestDto;
use App\Http\Dto\Playlist\CreatePlaylistRequestDto;
use App\Http\Dto\Playlist\UpdatePlaylistRequestDto;
use App\Models\Content;
use App\Models\Playlist;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\PlaylistRepositoryInterface;
use App\Traits\AppUserAwareTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * Class PlaylistRepository
 *
 * @package App\Repositories\Api
 */
class PlaylistRepository extends AbstractRepository implements PlaylistRepositoryInterface
{
    use AppUserAwareTrait;

    /**
     * PlaylistRepository constructor.
     *
     * @param \App\Models\Playlist $model
     */
    public function __construct(Playlist $model)
    {
        $this->model = $model;
    }

    /**
     * @param \App\Models\Playlist $playlist
     * @param \App\Http\Dto\Playlist\ContentToPlaylistRequestDto $data
     *
     * @return \App\Models\Playlist
     */
    public function addContentToPlaylist(Playlist $playlist, ContentToPlaylistRequestDto $data): Playlist
    {
        $playlist->contents()->syncWithoutDetaching([
            $data->getContentId() => ['date_added' => Carbon::now()]
        ]);

        return $playlist;
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     * @param array $filters
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function contentOfPlaylist(ListRequestDto $data, array $filters): LengthAwarePaginator
    {
        return $this->queryBuilder($data, (new Content())->newQuery())
            ->with('program')
            ->whereHas('playlist', function (Builder $query) use ($filters) {
                return $query->where('id', $filters['playlist_id'])
                    ->where('app_user_id', $filters['app_user_id']);
            })
            ->where('active', true)
            ->whereIn('age_restriction', $this->getAppUserAgeRestrictions())
            ->whereHas('program', function (Builder $query) {
                $query->where('active', true);
            }, '>', 0)
            ->paginate($data->getPerPage());
    }

    /**
     * @param \App\Http\Dto\Playlist\CreatePlaylistRequestDto $data
     *
     * @return \App\Models\Playlist
     */
    public function createPlaylist(CreatePlaylistRequestDto $data): Playlist
    {
        $this->model->setAttribute('app_user_id', $data->getAppUserId());
        $this->model->setAttribute('name', $data->getName());
        $this->model->setAttribute('active', true);

        /** @var \App\Models\Playlist $playlist */
        $playlist = $this->save($this->model);

        return $playlist;
    }

    /**
     * @param \App\Models\Playlist $playlist
     *
     * @return null|bool
     * @throws \Exception
     */
    public function deletePlaylist(Playlist $playlist): ?bool
    {
        return $playlist->delete();
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listPlaylist(ListRequestDto $data): LengthAwarePaginator
    {
        $query = $this->queryBuilder($data)
            ->with(['contents' => function (BelongsToMany $query) {
                $query->select('thumbnail')
                    ->where('active', true)
                    ->whereIn('age_restriction', $this->getAppUserAgeRestrictions())
                    ->whereNotNull('thumbnail')
                    ->inRandomOrder()
                    ->limit(4);
            }])
            ->orderBy('created_at', 'DESC')
            ->withCount('contents');

        return $query->paginate($data->getPerPage());
    }

    /**
     * @param \App\Models\Playlist $playlist
     * @param \App\Http\Dto\Playlist\ContentToPlaylistRequestDto $data
     *
     * @return int
     */
    public function removeContentToPlaylist(Playlist $playlist, ContentToPlaylistRequestDto $data): int
    {
        return $playlist->contents()->detach($data->getContentId());
    }

    /**
     * @param \App\Models\Playlist $playlist
     * @param \App\Http\Dto\Playlist\UpdatePlaylistRequestDto $data
     *
     * @return \App\Models\Playlist
     */
    public function updatePlaylist(Playlist $playlist, UpdatePlaylistRequestDto $data): Playlist
    {
        $playlist->setAttribute('name', $data->getName());

        $this->save($playlist);

        return $playlist;
    }
}
