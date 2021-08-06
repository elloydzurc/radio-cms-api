<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\Ads\ListAdsDto;
use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface AdsRepositoryInterface
 *
 * @package App\Repositories\Api\Interfaces
 */
interface AdsRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Http\Dto\Ads\ListAdsDto $data
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function listAds(ListAdsDto $data): Collection;
}
