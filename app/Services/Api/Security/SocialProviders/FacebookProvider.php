<?php
declare(strict_types=1);

namespace App\Services\Api\Security\SocialProviders;

use App\Http\Dto\Security\SingleSignOnRequestDto;
use App\Models\Interfaces\AppUserInterface;
use App\Services\Api\Security\SocialProviders\Interfaces\SocialProviderInterface;
use Laravel\Socialite\Two\User;

/**
 * Class FacebookProvider
 *
 * @package App\Services\Api\Security\SocialProviders
 */
class FacebookProvider extends AbstractProvider implements SocialProviderInterface
{
    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     * @param \Laravel\Socialite\Two\User $socialProviderData
     */
    public function parse(SingleSignOnRequestDto $data, User $socialProviderData): void
    {
        [$firstName, $lastName] = $this->getFirstNameAndLastName($socialProviderData->getName());

        $data->setAvatar($socialProviderData->getAvatar());
        $data->setEmail($socialProviderData->getEmail());
        $data->setFirstName($firstName);
        $data->setLastName($lastName);
        $data->setProviderId($socialProviderData->getId());
    }

    /**
     * @param string $provider
     *
     * @return bool
     */
    public function support(string $provider): bool
    {
        return $provider === AppUserInterface::PROVIDER_FACEBOOK;
    }
}
