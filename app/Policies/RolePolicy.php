<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class RolePolicy
 *
 * @package App\Policies
 */
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view role.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Role');
    }

    /**
     * Determine whether the user can view role.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read Role');
    }

    /**
     * Determine whether the user can create role.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create Role');
    }

    /**
     * Determine whether the user can update role.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update Role');
    }

    /**
     * Determine whether the user can delete role.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete Role');
    }

    /**
     * Determine whether the user can restore role.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('Restore Role');
    }

    /**
     * Determine whether the user can force delete role.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can attach any role to user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function attachAnyUser(User $user): bool
    {
        return $user->can('Update Role');
    }

    /**
     * Determine whether the user can attach role to user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function attachUser(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can detach role to user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function detachUser(User $user): bool
    {
        return $user->can('Update Role');
    }
}
