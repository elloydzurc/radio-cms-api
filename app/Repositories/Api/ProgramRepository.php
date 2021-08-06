<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\Common\ListRequestDto;
use App\Models\Interfaces\ContentInterface;
use App\Models\Program;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\ProgramRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ProgramRepository
 *
 * @package App\Repositories\Api
 */
class ProgramRepository extends AbstractRepository implements ProgramRepositoryInterface
{
    /**
     * StationContentRepository constructor.
     *
     * @param \App\Models\Program $model
     */
    public function __construct(Program $model)
    {
        $this->model = $model;
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listPrograms(ListRequestDto $data): LengthAwarePaginator
    {
        return $this->queryBuilder($data)
            ->withCount(['contents' => function (Builder $query) {
                $query->where('type', '!=', ContentInterface::TYPE_LIVE);
            }])
            ->where('active', true)
            ->whereNull('deleted_at')
            ->paginate($data->getPerPage());
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     * @param int $stationId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listStationPrograms(ListRequestDto $data, int $stationId): LengthAwarePaginator
    {
        $query = $this->queryBuilder($data)
            ->withCount(['contents' => function (Builder $query) {
                $query->where('type', '!=', ContentInterface::TYPE_LIVE);
            }])
            ->whereHas('stations', function (Builder $query) use ($stationId) {
                $query->where('station_id', $stationId);
            })
            ->where('active', true)
            ->whereNull('deleted_at');

        return $query->paginate($data->getPerPage());
    }
}
