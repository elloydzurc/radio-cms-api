<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Processors;

use App\Events\Cms\LastLoginEvent;
use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Security\AbstractSecurityProcessor;
use App\Services\Api\Security\Exceptions\SecurityException;
use App\Services\Api\Security\Interfaces\SecurityProcessorInterface;
use App\Services\Api\Security\Transformers\LoginTransformer;

/**
 * Class SingleSignOnProcessor
 *
 * @package App\Services\Api\Security\Processors
 */
final class SingleSignOnProcessor extends AbstractSecurityProcessor implements SecurityProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Security\Exceptions\SecurityException
     * @var \App\Http\Dto\Security\SingleSignOnRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $this->socialAuthManager->getUserInfo($data);

        $criteria = [
            'email' => $data->getEmail(),
        ];

        /** @var null|\App\Models\AppUser $appUser */
        $appUser = $this->appUserRepository->findOneByCriteria($criteria);

        if ($appUser === null) {
            $appUser = $this->appUserRepository->createSingleSignOnData($data);
        }

        if ($this->isModelActive($appUser) === false) {
            throw SecurityException::userNotActive();
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
        return SecurityProcessorInterface::SINGLE_SIGN_ON_PROCESSOR === $processor;
    }
}
