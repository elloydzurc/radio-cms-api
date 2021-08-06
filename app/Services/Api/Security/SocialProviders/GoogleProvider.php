<?php
declare(strict_types=1);

namespace App\Services\Api\Security\SocialProviders;

use App\Http\Dto\Security\SingleSignOnRequestDto;
use App\Models\Interfaces\AppUserInterface;
use App\Services\Api\Security\SocialProviders\Interfaces\SocialProviderInterface;
use Laravel\Socialite\Two\User;

/**
 * Class GoogleProvider
 *
 * @package App\Services\Api\Security\SocialProviders
 */
class GoogleProvider extends AbstractProvider implements SocialProviderInterface
{
    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     * @param \Laravel\Socialite\Two\User $socialProviderData
     */
    public function parse(SingleSignOnRequestDto $data, User $socialProviderData): void
    {
        $user = $socialProviderData->getRaw();

        $data->setAvatar($user['picture']);
        $data->setEmail($user['email']);
        $data->setFirstName($user['given_name']);
        $data->setLastName($user['family_name']);
        $data->setProviderId($user['id']);
    }

    /**
     * @param string $provider
     *
     * @return bool
     */
    public function support(string $provider): bool
    {
        return $provider === AppUserInterface::PROVIDER_GOOGLE;
    }
}
