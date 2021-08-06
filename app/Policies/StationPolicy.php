<?php
declare(strict_types=1);

namespace App\Policies;

use App\Models\Station;
use App\Models\User;
use App\Traits\ModelStatusAwareTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class StationPolicy
 *
 * @package App\Policies
 */
class StationPolicy
{
    use HandlesAuthorization, ModelStatusAwareTrait;

    /**
     * Determine whether the user can view station.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return $user->can('Read Station');
    }

    /**
     * Determine whether the user can view station.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Station $station
     *
     * @return bool
     */
    public function view(User $user, Station $station): bool
    {
        return $user->can('Read Station');
    }

    /**
     * Determine whether the user can create station.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->can('Create Station');
    }

    /**
     * Determine whether the user can update station.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function update(User $user): bool
    {
        return $user->can('Update Station');
    }

    /**
     * Determine whether the user can delete station.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->can('Delete Station');
    }

    /**
     * Determine whether the user can restore station.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function restore(User $user): bool
    {
        return $user->can('Restore Station');
    }

    /**
     * Determine whether the user can force delete station.
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Station $station
     *
     * @return bool
     */
    public function attachAnyProgram(User $user, Station $station): bool
    {
        return $user->can(['Update Station', 'Read Program']) && $this->isModelActive($station) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Station $station
     *
     * @return bool
     */
    public function attachProgram(User $user, Station $station): bool
    {
        return $user->can(['Update Station', 'Read Program']) && $this->isModelActive($station) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Station $station
     *
     * @return bool
     */
    public function detachProgram(User $user, Station $station): bool
    {
        return $user->can(['Update Station', 'Read Program']) && $this->isModelActive($station) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Station $station
     *
     * @return bool
     */
    public function attachAnyUser(User $user, Station $station): bool
    {
        return $user->can(['Update Station', 'Read User']) && $this->isModelActive($station) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Station $station
     *
     * @return bool
     */
    public function attachUser(User $user, Station $station): bool
    {
        return $user->can(['Update Station', 'Read User']) && $this->isModelActive($station) === true;
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Models\Station $station
     *
     * @return bool
     */
    public function detachUser(User $user, Station $station): bool
    {
        return $user->can(['Update Station', 'Read User']) && $this->isModelActive($station) === true;
    }
}
