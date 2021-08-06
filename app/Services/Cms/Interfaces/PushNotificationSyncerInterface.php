<?php
declare(strict_types=1);

namespace App\Services\Cms\Interfaces;

/**
 * Interface PushNotificationSyncerInterface
 *
 * @package App\Services\Cms\Interfaces
 */
interface PushNotificationSyncerInterface
{
    /**
     * Sync all notification to mobile
     */
    public function sync(): void;
}