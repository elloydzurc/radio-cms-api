<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class AppUserPolicy
 *
 * @package App\Policies
 */
class AppUserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view app users.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read App User');
    }

    /**
     * Determine whether the user can view app users.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read App User');
    }

    /**
     * Determine whether the user can create app user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create App User');
    }

    /**
     * Determine whether the user can update app user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update App User');
    }

    /**
     * Determine whether the user can delete app user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete App User');
    }

    /**
     * Determine whether the user can restore app user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('Restore App User');
    }

    /**
     * Determine whether the user can force delete app user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
