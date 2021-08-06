<?php
declare(strict_types=1);

namespace App\Services\Api\Ads;

use App\Repositories\Api\Interfaces\AdsRepositoryInterface;
use App\Traits\AppConfigurationAwareTrait;

/**
 * Class AbstractAdsProcessor
 *
 * @package App\Services\Api\Ads
 */
abstract class AbstractAdsProcessor
{
    use AppConfigurationAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\AdsRepositoryInterface
     */
    protected AdsRepositoryInterface $adsRepository;

    /**
     * AbstractAdsProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\AdsRepositoryInterface $adsRepository
     */
    public function __construct(AdsRepositoryInterface $adsRepository)
    {
        $this->adsRepository = $adsRepository;
    }
}
