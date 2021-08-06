<?php
declare(strict_types=1);

namespace App\Jobs;

use App\Models\PushNotification;
use App\Notifications\Api\MobilePushNotification;
use App\Repositories\Cms\Interfaces\AppUserRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Class ProcessPushNotification
 *
 * @package App\Jobs
 */
class ProcessPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private array $appUserIdRange;

    /**
     * @var \App\Models\PushNotification
     */
    private PushNotification $pushNotification;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PushNotification $pushNotification, array $appUserIdRange)
    {
        $this->pushNotification = $pushNotification;
        $this->appUserIdRange = $appUserIdRange;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        /** @var \App\Repositories\Cms\Interfaces\AppUserRepositoryInterface $appUserRepository */
        $appUserRepository = app(AppUserRepositoryInterface::class);
        $appUsers = $appUserRepository->getAppUsersByIdRange($this->appUserIdRange);

        if ($appUsers->count() < 1) {
            Log::info(
                \sprintf(
                    'No device found on App User With ID of %d - %d',
                    $this->appUserIdRange[0],
                    $this->appUserIdRange[1]
                )
            );

            return;
        }

        /** @var \App\Models\AppUser $appUser */
        foreach ($appUsers as $appUser) {
            Log::info(
                \sprintf(
                    'Sending %s to App User %s',
                    $this->pushNotification->getAttribute('name'),
                    $appUser->devices()->pluck('device_id')
                )
            );

            $appUser->notify(new MobilePushNotification($this->pushNotification));
        }
    }
}
