<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ReportPolicy
 *
 * @package App\Policies
 */
class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view reports.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->canAny([
            'Download App Users',
            'Download Programs',
            'Download Channels',
            'Download Episodes',
        ]);
    }

    /**
     * Determine whether the user can view reports.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->canAny([
            'Download App Users',
            'Download Programs',
            'Download Channels',
            'Download Episodes',
        ]);
    }

    /**
     * Determine whether the user can create user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function update(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore user.
     *
     * @param \App\Models\User $user
     * @return bool
     */
    public function restore(User $user): bool
    {
        return false;
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
}
