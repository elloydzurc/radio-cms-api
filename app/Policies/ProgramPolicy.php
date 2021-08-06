<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use App\Traits\ModelStatusAwareTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ProgramPolicy
 *
 * @package App\Policies
 */
class ProgramPolicy
{
    use HandlesAuthorization, ModelStatusAwareTrait;

    /**
     * Determine whether the user can view programs.
     *
     * @param  \App\Models\User  $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Program');
    }

    /**
     * Determine whether the user can view programs.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function view(User $user): bool
    {
        return $user->can('Read Program');
    }

    /**
     * Determine whether the user can create program.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create Program');
    }

    /**
     * Determine whether the user can update program.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update Program');
    }

    /**
     * Determine whether the user can delete program.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete Program');
    }

    /**
     * Determine whether the user can restore program.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can(['Restore Program', 'Read Station']);
    }

    /**
     * Determine whether the user can force delete program.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Program $program
     *
     * @return bool
     */
    public function addContent(User $user, Program $program): bool
    {
        return $user->can('Update Program') &&
            $user->canAny(['Create Content On Demand', 'Create Content Live Stream']) &&
            $this->isModelActive($program) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Program $program
     *
     * @return bool
     */
    public function attachAnyStation(User $user, Program $program): bool
    {
        return $user->can(['Update Program', 'Read Station']) && $this->isModelActive($program) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Program $program
     *
     * @return bool
     */
    public function attachStation(User $user, Program $program): bool
    {
        return $user->can(['Update Program', 'Read Station']) && $this->isModelActive($program) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Program $program
     *
     * @return bool
     */
    public function detachStation(User $user, Program $program): bool
    {
        return $user->can(['Update Program', 'Read Station']) && $this->isModelActive($program) === true;
    }
}
