<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy
 *
 * @package App\Policies
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view users.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read User');
    }

    /**
     * Determine whether the user can view users.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read User');
    }

    /**
     * Determine whether the user can create user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create User');
    }

    /**
     * Determine whether the user can update user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update User');
    }

    /**
     * Determine whether the user can delete user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete User');
    }

    /**
     * Determine whether the user can restore user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('Restore User');
    }

    /**
     * Determine whether the user can force delete user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function attachAnyStation(User $user): bool
    {
        return $user->can('Update User');
    }

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function attachStation(User $user): bool
    {
        return $user->can('Update User');
    }

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function detachStation(User $user): bool
    {
        return $user->can('Update User');
    }
}
