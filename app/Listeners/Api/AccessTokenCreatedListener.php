<?php
declare(strict_types=1);

namespace App\Listeners\Api;

use App\Repositories\Api\Interfaces\TokenRepositoryInterface;
use Laravel\Passport\Events\AccessTokenCreated;

/**
 * Class RevokeOldTokensListener
 *
 * @package App\Listeners\Cms
 */
class AccessTokenCreatedListener
{
    /**
     * @var \App\Repositories\Api\Interfaces\TokenRepositoryInterface
     */
    private TokenRepositoryInterface $tokenRepository;

    /**
     * RevokeOldTokensListener constructor.
     *
     * @param \App\Repositories\Api\Interfaces\TokenRepositoryInterface $tokenRepository
     */
    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * @param \Laravel\Passport\Events\AccessTokenCreated $event
     */
    public function handle(AccessTokenCreated $event): void
    {
        $this->tokenRepository->deleteUserOldTokens($event->tokenId, (int)$event->userId);
    }
}
