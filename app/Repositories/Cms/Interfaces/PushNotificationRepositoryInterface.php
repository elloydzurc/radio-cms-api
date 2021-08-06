<?php
declare(strict_types=1);

namespace App\Repositories\Cms\Interfaces;

use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PushNotificationRepositoryInterface
 *
 * @package App\Repositories\Cms\Interfaces
 */
interface PushNotificationRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getActivePushNotifications(): Collection;
}
