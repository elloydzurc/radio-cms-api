<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Trait ConfigAwareTrait
 *
 * @package App\Traits
 */
trait ConfigAwareTrait
{
    /**
     * @var array
     */
    private array $configs = [];

    /**
     * @param string $key
     *
     * @return mixed
     */
    private function getConfig(string $key)
    {
        if (isset($this->configs[$key]) === false) {
            $this->configs[$key] = config($key);
        }

        return $this->configs[$key];
    }
}
