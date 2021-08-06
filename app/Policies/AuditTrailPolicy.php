<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class AuditTrailPolicy
 *
 * @package App\Policies
 */
class AuditTrailPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view audit trail.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Audit Trail');
    }

    /**
     * Determine whether the user can view audit trail.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read Audit Trail');
    }

    /**
     * Determine whether the user can create audit trail.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update audit trail.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete audit trail.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore audit trail.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can force delete audit trail.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
