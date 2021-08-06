<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\Common\ListRequestDto;
use App\Models\Content;
use App\Models\Interfaces\ContentInterface;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\ContentRepositoryInterface;
use App\Traits\AppUserAwareTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * Class StationContentRepository
 *
 * @package App\Repositories\Api
 */
class ContentRepository extends AbstractRepository implements ContentRepositoryInterface
{
    use AppUserAwareTrait;

    /**
     * StationContentRepository constructor.
     *
     * @param \App\Models\Content $model
     */
    public function __construct(Content $model)
    {
        $this->model = $model;
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allFeaturedContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator
    {
        $query = $this->queryBuilder($queryParams)
            ->withCount(['appUsers' => static function (Builder $query) use ($appUserId) {
                if ($appUserId !== null) {
                    $query->where('app_user_id', '=', $appUserId);
                }
            }])
            ->with('program')
            ->where('featured', '=', true)
            ->where('active', '=', true)
            ->whereIn('age_restriction', $this->getAppUserAgeRestrictions())
            ->inRandomOrder();

        return $query->paginate($queryParams->getPerPage());
    }

    /**
     * @param int $programId
     * @param array $formats
     *
     * @return \Illuminate\Support\Collection
     */
    public function getContentIds(int $programId, array $formats): Collection
    {
        return $this->model->newQuery()
            ->select('id')
            ->where('active', true)
            ->whereNull('deleted_at')
            ->where('program_id', $programId)
            ->whereIn('format', $formats)
            ->whereIn('age_restriction', $this->getAppUserAgeRestrictions())
            ->orderBy('id', 'ASC')
            ->get()
            ->pluck('id');
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator
    {
        $query = $this->queryBuilder($queryParams)
            ->withCount(['appUsers' => static function (Builder $query) use ($appUserId) {
                if ($appUserId !== null) {
                    $query->where('app_user_id', '=', $appUserId);
                }
            }])
            ->where('active', true)
            ->whereIn('age_restriction', $this->getAppUserAgeRestrictions());

        return $query->paginate($queryParams->getPerPage(), ['*'], 'page', $queryParams->getPage());
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listProgramContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator
    {
        $query = $this->queryBuilder($queryParams)
            ->withCount(['appUsers' => static function (Builder $query) use ($appUserId) {
                if ($appUserId !== null) {
                    $query->where('app_user_id', '=', $appUserId);
                }
            }])
            ->where('active', '=', true)
            ->where('type', '=', ContentInterface::TYPE_ON_DEMAND)
            ->whereIn('age_restriction', $this->getAppUserAgeRestrictions())
            ->whereNull('deleted_at');

        return $query->paginate($queryParams->getPerPage(), ['*'], 'page', $queryParams->getPage());
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAppUserFavoriteContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator
    {
        $query = $this->queryBuilder($queryParams)
            ->withCount(['appUsers' => static function (Builder $query) use ($appUserId) {
                if ($appUserId !== null) {
                    $query->where('app_user_id', '=', $appUserId);
                }
            }])
            ->whereHas('appUsers', static function (Builder $query) use ($appUserId) {
                if ($appUserId !== null) {
                    $query->where('app_user_id', '=', $appUserId);
                }
            })
            ->where('active', '=', true)
            ->whereIn('age_restriction', $this->getAppUserAgeRestrictions())
            ->whereNull('deleted_at');

        return $query->paginate($queryParams->getPerPage(), ['*'], 'page', $queryParams->getPage());
    }
}
