<?php
declare(strict_types=1);

namespace App\Observers;

use App\Events\Cms\ChangeModelStatusEvent;
use App\Models\User;
use App\Notifications\Cms\UserDeletedNotification;
use App\Notifications\Cms\UserVerificationNotification;

/**
 * Class UserObserver
 *
 * @package App\Observers
 */
final class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function created(User $user): void
    {
        $user->notify(new UserVerificationNotification());
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function deleted(User $user): void
    {
        $user->notify(new UserDeletedNotification());

        ChangeModelStatusEvent::dispatch($user, false);
    }

    /**
     * Handle the user "restored" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function restored(User $user): void
    {
        ChangeModelStatusEvent::dispatch($user, true);
    }

    /**
     * Handle the user "created" event.
     *
     * @param \App\Models\User $user
     *
     * @return void
     */
    public function saving(User $user): void
    {
        $user->setAttribute(
            'name',
            \sprintf(
                '%s %s',
                $user->getAttribute('first_name'),
                $user->getAttribute('last_name')
            )
        );
    }
}
