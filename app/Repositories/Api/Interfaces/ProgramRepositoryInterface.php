<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\Common\ListRequestDto;
use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface ProgramRepositoryInterface
 *
 * @package App\Repositories\Api\Interfaces
 */
interface ProgramRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listPrograms(ListRequestDto $data): LengthAwarePaginator;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $data
     * @param int $stationId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listStationPrograms(ListRequestDto $data, int $stationId): LengthAwarePaginator;
}
