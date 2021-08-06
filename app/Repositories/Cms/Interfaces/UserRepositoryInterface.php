<?php
declare(strict_types=1);

namespace App\Repositories\Cms\Interfaces;

use App\Repositories\AbstractRepositoryInterface;

/**
 * Interface UserRepositoryInterface
 *
 * @package App\Repositories\Cms\Interfaces
 */
interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $email
     *
     * @return bool
     */
    public function isUserAllowed(string $email): bool;
}