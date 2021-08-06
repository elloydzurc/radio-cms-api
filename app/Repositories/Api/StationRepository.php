<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\Common\ListRequestDto;
use App\Models\Station;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\StationRepositoryInterface;
use App\Traits\AppUserAwareTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Support\Collection;

/**
 * Class StationRepository
 *
 * @package App\Repositories\Api
 */
class StationRepository extends AbstractRepository implements StationRepositoryInterface
{
    use AppUserAwareTrait;

    /**
     * StationRepository constructor.
     *
     * @param \App\Models\Station $model
     */
    public function __construct(Station $model)
    {
        $this->model = $model;
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function featuredContentStation(ListRequestDto $queryParams): LengthAwarePaginator
    {
        $self = $this;

        $query = $this->queryBuilder($queryParams)
            ->with(['featuredContent' => static function (HasOneThrough $query) use ($self) {
                $query->whereIn('age_restriction', $self->getAppUserAgeRestrictions())
                    ->inRandomOrder();
            }])
            ->where('active', true)
            ->where('featured', false)
            ->has('featuredContent', '>', 0);

        return $query->paginate($queryParams->getPerPage());
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function featuredStation(ListRequestDto $queryParams): LengthAwarePaginator
    {
        $self = $this;

        $query = $this->queryBuilder($queryParams)
            ->with(['liveContent' => static function (HasOneThrough $query) use ($self) {
                $query->select('id')
                    ->whereIn('age_restriction', $self->getAppUserAgeRestrictions());
            }])
            ->where('active', true)
            ->where('featured', true);

        return $query->paginate($this->getAllowedFeaturedStation());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getStationIds(): Collection
    {
        return $this->model->newQuery()
            ->select('id')
            ->where('active', true)
            ->whereNull('deleted_at')
            ->orderBy('id', 'ASC')
            ->get()
            ->pluck('id');
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listStations(ListRequestDto $queryParams): LengthAwarePaginator
    {
        $query = $this->queryBuilder($queryParams)
            ->where('active', true);

        return $query->paginate($queryParams->getPerPage(), ['*'], 'page', $queryParams->getPage());
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function tuneInStations(ListRequestDto $queryParams): LengthAwarePaginator
    {
        $self = $this;

        $query = $this->queryBuilder($queryParams)
            ->with(['liveContent' => static function (HasOneThrough $query) use ($self) {
                $query->whereIn('age_restriction', $self->getAppUserAgeRestrictions());
            }])
            ->where('active', true);

        return $query->paginate($queryParams->getPerPage(), ['*'], 'page', $queryParams->getPage());
    }
}
