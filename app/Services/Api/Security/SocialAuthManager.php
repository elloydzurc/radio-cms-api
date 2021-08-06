<?php
declare(strict_types=1);

namespace App\Services\Api\Security;

use App\Http\Dto\Security\SingleSignOnRequestDto;
use App\Services\Api\Security\Exceptions\SecurityException;
use App\Services\Api\Security\Interfaces\SocialAuthManagerInterface;
use App\Services\Api\Security\SocialProviders\Interfaces\SocialProviderInterface;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class SocialAuthManager
 *
 * @package App\Services\Api\Security
 */
class SocialAuthManager implements SocialAuthManagerInterface
{
    /**
     * @var \App\Services\Api\Security\SocialProviders\Interfaces\SocialProviderInterface[]
     */
    private iterable $socialProviders;

    /**
     * SocialAuthManager constructor.
     *
     * @param \App\Services\Api\Security\SocialProviders\Interfaces\SocialProviderInterface[] $socialProviders
     */
    public function __construct(SocialProviderInterface ...$socialProviders)
    {
        $this->socialProviders = $socialProviders;
    }

    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     *
     * @throws \App\Services\Api\Security\Exceptions\SecurityException
     */
    public function getUserInfo(SingleSignOnRequestDto $data): void
    {
        try {
            $driver = Socialite::driver($data->getProvider());
            /** @var \Laravel\Socialite\Two\User $user */
            $user = $driver->userFromToken($data->getAccessToken());

            foreach ($this->socialProviders as $provider) {
                if ($provider->support($data->getProvider()) === true) {
                    $provider->parse($data, $user);
                    return;
                }
            }
        } catch (\Throwable $throwable) {
            throw SecurityException::invalidAccessToken($data->getProvider(), $throwable);
        }

        throw SecurityException::invalidSocialProvider($data->getProvider());
    }
}
