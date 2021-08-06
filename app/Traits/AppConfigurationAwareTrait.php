<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Trait AppConfigurationAwareTrait
 *
 * @package App\Traits
 */
trait AppConfigurationAwareTrait
{
    use ConfigAwareTrait;

    /**
     * @return int
     */
    public function getAllowedFeaturedStation(): int
    {
        return (int)$this->getConfig('cms.allowed_featured_station');
    }

    /**
     * @return int
     */
    public function getAllowedTuneInStation(): int
    {
        return (int)$this->getConfig('cms.allowed_tune_in_station');
    }

    /**
     * @return int
     */
    public function getAllowedTuneInStationContent(): int
    {
        return (int)$this->getConfig('cms.allowed_tune_in_station_content');
    }
}
