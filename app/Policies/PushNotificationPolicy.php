<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PushNotificationPolicy
 *
 * @package App\Policies
 */
class PushNotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view push notifications.
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Push Notification');
    }

    /**
     * Determine whether the user can view push notifications.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read Push Notification');
    }

    /**
     * Determine whether the user can create push notifications.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create Push Notification');
    }

    /**
     * Determine whether the user can update push notifications.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update Push Notification');
    }

    /**
     * Determine whether the user can delete push notifications.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete Push Notification');
    }

    /**
     * Determine whether the user can restore ad.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('Restore Push Notification');
    }

    /**
     * Determine whether the user can force delete push notifications.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
