<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class CommentPolicy
 *
 * @package App\Policies
 */
class CommentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view comments.
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Comment');
    }

    /**
     * Determine whether the user can view comments.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read Comment');
    }

    /**
     * Determine whether the user can create comments.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update comments.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update Comment');
    }

    /**
     * Determine whether the user can delete comments.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete Comment');
    }

    /**
     * Determine whether the user can restore comments.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('Restore Comment');
    }

    /**
     * Determine whether the user can force delete comments.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
