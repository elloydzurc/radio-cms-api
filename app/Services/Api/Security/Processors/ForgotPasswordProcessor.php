<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Processors;

use App\Http\Dto\AbstractDto;
use App\Models\Interfaces\AppUserInterface;
use App\Notifications\Api\AppUserForgotPasswordNotification;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Security\AbstractSecurityProcessor;
use App\Services\Api\Security\Exceptions\SecurityException;
use App\Services\Api\Security\Interfaces\SecurityProcessorInterface;

/**
 * Class ForgotPasswordProcessor
 *
 * @package App\Services\Api\Security\Processors
 */
final class ForgotPasswordProcessor extends AbstractSecurityProcessor implements SecurityProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Security\Exceptions\SecurityException
     *
     * @var \App\Http\Dto\Security\ForgotPasswordRequestDto $data
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

        $this->appUserRepository->forgotPassword($appUser, $data);
        $appUser->notify(new AppUserForgotPasswordNotification($appUser, $data->getNewPassword()));

        return new DefaultResponse(
            $appUser,
            null,
            null,
            trans('messages.security.new_password_sent')
        );
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return SecurityProcessorInterface::FORGOT_PASSWORD_PROCESSOR === $processor;
    }
}
