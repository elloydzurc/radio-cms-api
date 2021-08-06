<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class AdPolicy
 *
 * @package App\Policies
 */
class AdPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view ads.
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Ads');
    }

    /**
     * Determine whether the user can view ads.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read Ads');
    }

    /**
     * Determine whether the user can create ads.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create Ads');
    }

    /**
     * Determine whether the user can update ads.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update Ads');
    }

    /**
     * Determine whether the user can delete ads.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete Ads');
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
        return $user->can('Restore Ads');
    }

    /**
     * Determine whether the user can force delete ads.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
