<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\Common\ListRequestDto;
use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface StationRepository
 *
 * @package App\Repositories\Api\Interfaces
 */
interface StationRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function featuredContentStation(ListRequestDto $queryParams): LengthAwarePaginator;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function featuredStation(ListRequestDto $queryParams): LengthAwarePaginator;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getStationIds(): Collection;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listStations(ListRequestDto $queryParams): LengthAwarePaginator;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function tuneInStations(ListRequestDto $queryParams): LengthAwarePaginator;
}
