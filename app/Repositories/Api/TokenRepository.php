<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\TokenRepositoryInterface;
use App\Services\Api\Security\Interfaces\TokenManagerInterface;
use Illuminate\Support\Carbon;
use Laravel\Passport\Token;

/**
 * Class TokenRepository
 *
 * @package App\Repositories\Api
 */
class TokenRepository extends AbstractRepository implements TokenRepositoryInterface
{
    /**
     * TokenRepository constructor.
     *
     * @param \Laravel\Passport\Token $model
     */
    public function __construct(Token $model)
    {
        $this->model = $model;
    }

    /**
     * Delete all expired tokens
     */
    public function deleteExpiredTokens(): void
    {
        $this->model->newQuery()
            ->where('expires_at', '<', Carbon::now()->addSecond())
            ->delete();
    }

    /**
     * Delete all revoked tokens
     */
    public function deleteRevokedTokens(): void
    {
        $this->model->newQuery()
            ->where('revoked', '=', true)
            ->delete();
    }

    /**
     * @param string $tokenId
     * @param int $userId
     */
    public function deleteUserOldTokens(string $tokenId, int $userId): void
    {
        $this->model->newQuery()
            ->where('id', '<>', $tokenId)
            ->where('user_id', '=', $userId)
            ->where('name', '=', TokenManagerInterface::API_TOKEN_NAME)
            ->delete();
    }
}
