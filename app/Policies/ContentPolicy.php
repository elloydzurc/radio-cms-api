<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ContentPolicy
 *
 * @package App\Policies
 */
class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view content.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->canAny(['Read Content On Demand', 'Read Content Live Stream']);
    }

    /**
     * Determine whether the user can view content.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->canAny(['Read Content On Demand', 'Read Content Live Stream']);
    }

    /**
     * Determine whether the user can create content.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->canAny(['Create Content On Demand', 'Create Content Live Stream']);
    }

    /**
     * Determine whether the user can update content.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->canAny(['Update Content On Demand', 'Update Content Live Stream']);
    }

    /**
     * Determine whether the user can delete content.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->canAny(['Delete Content On Demand', 'Delete Content Live Stream']);
    }

    /**
     * Determine whether the user can restore content.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->canAny(['Restore Content On Demand', 'Restore Content Live Stream']);
    }

    /**
     * Determine whether the user can force delete other content.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
