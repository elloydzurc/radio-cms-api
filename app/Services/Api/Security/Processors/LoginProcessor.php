<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Processors;

use App\Events\Cms\LastLoginEvent;
use App\Http\Dto\AbstractDto;
use App\Models\Interfaces\AppUserInterface;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Security\AbstractSecurityProcessor;
use App\Services\Api\Security\Exceptions\SecurityException;
use App\Services\Api\Security\Interfaces\SecurityProcessorInterface;
use App\Services\Api\Security\Transformers\LoginTransformer;
use Illuminate\Support\Facades\Hash;

/**
 * Class LoginProcessor
 *
 * @package App\Services\Api\Security\Processors
 */
final class LoginProcessor extends AbstractSecurityProcessor implements SecurityProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Security\Exceptions\SecurityException
     *
     * @var \App\Http\Dto\Security\LoginRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $criteria = [
            'email' => $data->getEmail(),
            'provider' => AppUserInterface::PROVIDER_APP
        ];

        /** @var null|\App\Models\AppUser $appUser */
        $appUser = $this->appUserRepository->findOneByCriteria($criteria);

        if ($appUser === null) {
            throw SecurityException::userEmailNotExists();
        }

        if ($this->isModelActive($appUser) === false) {
            throw SecurityException::userNotActive();
        }

        if (Hash::check($data->getPassword(), $appUser->getAttribute('password')) === false) {
            throw SecurityException::authenticationFailed();
        }

        LastLoginEvent::dispatch($appUser);

        $this->appUserRepository->addDevice($appUser, $data->getDeviceId());
        $token = $this->tokenManager->grantToken($appUser);
        $appUser->setAttribute('token', $token->accessToken);

        return new DefaultResponse($appUser, LoginTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return SecurityProcessorInterface::LOGIN_PROCESSOR === $processor;
    }
}
