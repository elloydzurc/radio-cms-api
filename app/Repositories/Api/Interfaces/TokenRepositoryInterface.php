<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Repositories\AbstractRepositoryInterface;

/**
 * Interface TokenRepositoryInterface
 *
 * @package App\Repositories\Api\Interfaces
 */
interface TokenRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * Delete all expired tokens
     */
    public function deleteExpiredTokens(): void;

    /**
     * Delete all revoked tokens
     */
    public function deleteRevokedTokens(): void;

    /**
     * @param string $tokenId
     * @param int $userId
     */
    public function deleteUserOldTokens(string $tokenId, int $userId): void;
}
