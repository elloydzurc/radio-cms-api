<?php
declare(strict_types=1);

namespace App\Repositories\Cms;

use App\Models\User;
use App\Repositories\AbstractRepository;
use App\Repositories\Cms\Interfaces\UserRepositoryInterface;

/**
 * Class UserRepository
 *
 * @package App\Repositories\Cms
 */
final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * UserRepository constructor.
     *
     * @param \App\Models\User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    public function isUserAllowed(string $email): bool
    {
       return $this->model->newQuery()
            ->where('email', '=', $email)
            ->where('active', '=', true)
            ->whereNull('deleted_at')
            ->exists();
    }
}
