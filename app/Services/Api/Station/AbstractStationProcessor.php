<?php
declare(strict_types=1);

namespace App\Services\Api\Station;

use App\Repositories\Api\Interfaces\StationRepositoryInterface;
use App\Traits\AppConfigurationAwareTrait;

/**
 * Class AbstractStationProcessor
 *
 * @package App\Services\Api\Station
 */
abstract class AbstractStationProcessor
{
    use AppConfigurationAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\StationRepositoryInterface
     */
    protected StationRepositoryInterface $stationRepository;

    /**
     * AbstractSecurityProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\StationRepositoryInterface $stationRepository
     */
    public function __construct(StationRepositoryInterface $stationRepository)
    {
        $this->stationRepository = $stationRepository;
    }
}
