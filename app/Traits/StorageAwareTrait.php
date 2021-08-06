<?php
declare(strict_types=1);

namespace App\Traits;

/**
 * Trait StorageAwareTrait
 *
 * @package App\Traits
 */
trait StorageAwareTrait
{
    use ConfigAwareTrait;

    /**
     * @return string
     */
    protected function getStorageDefault(): string
    {
        return (string)$this->getConfig('filesystems.default');
    }
}
