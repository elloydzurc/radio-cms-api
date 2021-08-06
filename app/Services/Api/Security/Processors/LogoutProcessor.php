<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Security\AbstractSecurityProcessor;
use App\Services\Api\Security\Exceptions\SecurityException;
use App\Services\Api\Security\Interfaces\SecurityProcessorInterface;

/**
 * Class LogoutProcessor
 *
 * @package App\Services\Api\Security\Processors
 */
final class LogoutProcessor extends AbstractSecurityProcessor implements SecurityProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Security\Exceptions\SecurityException
     * @var \App\Http\Dto\Common\EmptyRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $userId = $this->getCurrentUserId();
        /** @var \App\Models\AppUser $appUser */
        $appUser = $this->appUserRepository->find($userId);

        if ($appUser === null) {
            throw SecurityException::userIdNotExists();
        }

        if ($this->tokenManager->revokeToken($appUser) === false) {
            throw SecurityException::unableToRevokeToken($userId);
        }

        return new DefaultResponse(null);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return SecurityProcessorInterface::LOGOUT_PROCESSOR === $processor;
    }
}
