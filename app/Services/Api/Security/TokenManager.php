<?php
declare(strict_types=1);

namespace App\Services\Api\Security;

use App\Models\AppUser;
use App\Repositories\Api\Interfaces\AppUserRepositoryInterface;
use App\Services\Api\Security\Interfaces\TokenManagerInterface;
use Illuminate\Support\Carbon;
use Laravel\Passport\PersonalAccessTokenResult;

/**
 * Class TokenManager
 *
 * @package App\Services\Api\Security
 */
class TokenManager implements TokenManagerInterface
{
    /**
     * @var \App\Repositories\Api\Interfaces\AppUserRepositoryInterface
     */
    protected AppUserRepositoryInterface $appUserRepository;

    /**
     * TokenManager constructor.
     *
     * @param \App\Repositories\Api\Interfaces\AppUserRepositoryInterface $appUserRepository
     */
    public function __construct(AppUserRepositoryInterface $appUserRepository)
    {
        $this->appUserRepository = $appUserRepository;
    }

    /**
     * @param \App\Models\AppUser $appUser
     *
     * @return \Laravel\Passport\PersonalAccessTokenResult
     */
    public function grantToken(AppUser $appUser): PersonalAccessTokenResult
    {
        $accessToken = $appUser->createToken(self::API_TOKEN_NAME);
        $oauthClient = $accessToken->token;
        $currentDataTime = Carbon::now();

        $oauthClient->setAttribute('expires_at', $currentDataTime->addWeek());
        $this->appUserRepository->save($oauthClient);

        return $accessToken;
    }

    /**
     * @param \App\Models\AppUser $appUser
     *
     * @return bool
     */
    public function revokeToken(AppUser $appUser): bool
    {
        return $appUser->tokens()->delete() > 0;
    }
}
