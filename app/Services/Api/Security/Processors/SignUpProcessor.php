<?php
declare(strict_types=1);

namespace App\Services\Api\Security\Processors;

use App\Http\Dto\AbstractDto;
use App\Models\Interfaces\AppUserInterface;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Security\AbstractSecurityProcessor;
use App\Services\Api\Security\Exceptions\SecurityException;
use App\Services\Api\Security\Interfaces\SecurityProcessorInterface;

/**
 * Class SignUpProcessor
 *
 * @package App\Services\Api\Security\Processors
 */
final class SignUpProcessor extends AbstractSecurityProcessor implements SecurityProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Security\Exceptions\SecurityException
     *
     * @var \App\Http\Dto\Security\SignUpRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $criteria = [
            'email' => $data->getEmail(),
        ];

        /** @var null|\App\Models\AppUser $appUser */
        $appUser = $this->appUserRepository->findOneByCriteria($criteria);

        if ($appUser !== null) {
            throw SecurityException::userEmailExists();
        }

        $appUser = $this->appUserRepository->signUp($data);

        return new DefaultResponse($appUser);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return SecurityProcessorInterface::SIGN_UP_PROCESSOR === $processor;
    }
}
