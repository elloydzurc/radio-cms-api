<?php
declare(strict_types=1);

namespace App\Services\Cms;

use App\Jobs\ProcessPushNotification;
use App\Repositories\Cms\Interfaces\AppUserRepositoryInterface;
use App\Repositories\Cms\Interfaces\PushNotificationRepositoryInterface;
use App\Services\Cms\Interfaces\PushNotificationSyncerInterface;
use Illuminate\Support\Facades\Log;

/**
 * Class PushNotificationSyncer
 *
 * @package App\Services\Cms
 */
final class PushNotificationSyncer implements PushNotificationSyncerInterface
{
    /**
     * @var int
     */
    public const NUMBER_PER_BATCH = 500;

    /**
     * @var \App\Repositories\Cms\Interfaces\AppUserRepositoryInterface
     */
    private AppUserRepositoryInterface $appUserRepository;

    /**
     * @var \App\Repositories\Cms\Interfaces\PushNotificationRepositoryInterface
     */
    private PushNotificationRepositoryInterface $pushNotificationRepository;

    /**
     * PushNotificationSyncer constructor.
     *
     * @param \App\Repositories\Cms\Interfaces\AppUserRepositoryInterface $appUserRepository
     * @param \App\Repositories\Cms\Interfaces\PushNotificationRepositoryInterface $pushNotificationRepository
     */
    public function __construct(
        AppUserRepositoryInterface $appUserRepository,
        PushNotificationRepositoryInterface $pushNotificationRepository
    ) {
        $this->appUserRepository = $appUserRepository;
        $this->pushNotificationRepository = $pushNotificationRepository;
    }

    /**
     * Sync all cms permissions
     */
    public function sync(): void
    {
        $activePushNotifications = $this->pushNotificationRepository->getActivePushNotifications();

        if ($activePushNotifications->count() < 1) {
            return;
        }

        $appUserCount = $this->appUserRepository->countAppUser();
        $iterations = \ceil($appUserCount/self::NUMBER_PER_BATCH);

        /** @var \App\Models\PushNotification $pushNotification */
        foreach ($activePushNotifications as $pushNotification) {
            for ($iteration = 0; $iteration < $iterations; $iteration++) {
                $appUserIdRange = [
                    ($iteration * self::NUMBER_PER_BATCH) + 1,
                    ($iteration + 1) * self::NUMBER_PER_BATCH
                ];

                dispatch(new ProcessPushNotification($pushNotification, $appUserIdRange));
            }
        }
    }
}
