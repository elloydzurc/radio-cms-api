<?php
declare(strict_types=1);

namespace App\Observers;

use App\Events\Cms\ChangeModelStatusEvent;
use App\Models\AppUser;
use App\Models\Interfaces\AppUserInterface;
use App\Notifications\Api\AppUserVerificationNotification;

/**
 * Class AppUserObserver
 *
 * @package App\Observers
 */
final class AppUserObserver
{
    /**
     * Handle the app user "created" event.
     *
     * @param \App\Models\AppUser $appUser
     *
     * @return void
     */
    public function created(AppUser $appUser): void
    {
        if ($appUser->getAttribute('provider') === AppUserInterface::PROVIDER_APP) {
            $appUser->notify(new AppUserVerificationNotification());
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\Models\AppUser $appUser
     *
     * @return void
     */
    public function deleted(AppUser $appUser): void
    {
        ChangeModelStatusEvent::dispatch($appUser, false);
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\Models\AppUser $appUser
     *
     * @return void
     */
    public function restored(AppUser $appUser): void
    {
        ChangeModelStatusEvent::dispatch($appUser, true);
    }

    /**
     * Handle the app user "created" event.
     *
     * @param \App\Models\AppUser $appUser
     *
     * @return void
     */
    public function saving(AppUser $appUser): void
    {
        $appUser->setAttribute(
            'name',
            \sprintf(
                '%s %s',
                $appUser->getAttribute('first_name'),
                $appUser->getAttribute('last_name')
            )
        );
    }
}
