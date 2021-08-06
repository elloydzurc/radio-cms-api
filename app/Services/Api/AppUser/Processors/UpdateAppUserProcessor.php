<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AppUser\AbstractAppUserProcessor;
use App\Services\Api\AppUser\Exceptions\AppUserApiException;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface;
use App\Services\Api\AppUser\Transformers\AppUserDetailsTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Traits\AppUserAwareTrait;

/**
 * Class UpdateAppUserProcessor
 *
 * @package App\Services\Api\AppUser\Processors
 */
final class UpdateAppUserProcessor extends AbstractAppUserProcessor implements AppUserProcessorInterface
{
    use AppUserAwareTrait;

    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\AppUser\Exceptions\AppUserApiException
     * @var \App\Http\Dto\AppUser\UpdateAppUserDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        /** @var null|\App\Models\AppUser $appUser */
        $appUser = $this->appUserRepository->find($data->getId());

        if ($appUser === null) {
            throw AppUserApiException::notExists($data->getId());
        }

        if ($this->isModelActive($appUser) === false) {
            throw AppUserApiException::notExists($data->getId());
        }

        $appUser = $this->appUserRepository->updateData($appUser, $data);

        return new DefaultResponse($appUser, AppUserDetailsTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return AppUserProcessorInterface::UPDATE_APP_USER_PROCESSOR === $processor;
    }
}
