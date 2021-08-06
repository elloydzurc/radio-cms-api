<?php
declare(strict_types=1);

namespace App\Services\Api\Station\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface StationProcessorInterface
 *
 * @package App\Services\Api\Station\Interfaces
 */
interface StationProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const DETAILS_STATION_PROCESSOR = 'details_station';

    /**
     * @var string
     */
    public const FEATURED_CONTENT_STATION_PROCESSOR = 'featured_content_station';

    /**
     * @var string
     */
    public const FEATURED_STATION_PROCESSOR = 'featured_station';

    /**
     * @var string
     */
    public const LIST_STATION_PROCESSOR = 'list_station';

    /**
     * @var string
     */
    public const TUNE_IN_STATION_PROCESSOR = 'tune_in_station';
}