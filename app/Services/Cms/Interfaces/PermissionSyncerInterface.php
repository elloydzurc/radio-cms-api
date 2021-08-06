<?php
declare(strict_types=1);

namespace App\Services\Cms\Interfaces;

/**
 * Interface PermissionSyncerInterface
 *
 * @package App\Services\Cms\Interfaces
 */
interface PermissionSyncerInterface
{
    /**
     * Sync all cms permissions
     */
    public function sync(): void;
}