<?php
declare(strict_types=1);

namespace App\Services\Api\Ads\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface AdsProcessorInterface
 *
 * @package App\Services\Api\Ads\Interfaces
 */
interface AdsProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const LIST_ADS_PROCESSOR = 'list_ads';
}