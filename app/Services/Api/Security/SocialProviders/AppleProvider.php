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
class AppleProvider extends AbstractProvider implements SocialProviderInterface
{
    /**
     * @param \App\Http\Dto\Security\SingleSignOnRequestDto $data
     * @param \Laravel\Socialite\Two\User $socialProviderData
     */
    public function parse(SingleSignOnRequestDto $data, User $socialProviderData): void
    {
        $data->setAvatar($socialProviderData->getAvatar() ?? '');
        $data->setEmail($socialProviderData->getEmail());
        $data->setProviderId($socialProviderData->getId());

        if ($data->getFirstName() !== null && $data->getLastName() !== null) {
            $data->setFirstName($data->getFirstName());
            $data->setLastName($data->getLastName());
        }
    }

    /**
     * @param string $provider
     *
     * @return bool
     */
    public function support(string $provider): bool
    {
        return $provider === AppUserInterface::PROVIDER_APPLE;
    }
}
