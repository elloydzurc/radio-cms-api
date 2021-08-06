<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\Common\ListRequestDto;
use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Interface ContentRepositoryInterface
 *
 * @package App\Repositories\Api\Interfaces
 */
interface ContentRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allFeaturedContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator;

    /**
     * @param int $programId
     * @param array $formats
     *
     * @return \Illuminate\Support\Collection
     */
    public function getContentIds(int $programId, array $formats): Collection;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listProgramContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator;

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param int $appUserId
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listAppUserFavoriteContents(ListRequestDto $queryParams, int $appUserId): LengthAwarePaginator;
}
