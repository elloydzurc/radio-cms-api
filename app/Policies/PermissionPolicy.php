<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class PermissionPolicy
 *
 * @package App\Policies
 */
class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view permission.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Permission');
    }

    /**
     * Determine whether the user can view permission.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read Permission');
    }

    /**
     * Determine whether the user can create permission.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create Permission');
    }

    /**
     * Determine whether the user can update permission.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update Permission');
    }

    /**
     * Determine whether the user can delete permission.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete Permission');
    }

    /**
     * Determine whether the user can restore permission.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('Restore Permission');
    }

    /**
     * Determine whether the user can force delete permission.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can force delete other user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function attachAnyRole(User $user): bool
    {
        return $user->can('Update Permission');
    }

    /**
     * Determine whether the user can force delete other user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function attachRole(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can force delete other user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function detachRole(User $user): bool
    {
        return $user->can('Update Permission');
    }
}
