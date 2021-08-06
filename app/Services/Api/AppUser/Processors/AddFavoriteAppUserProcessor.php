<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AppUser\AbstractAppUserProcessor;
use App\Services\Api\AppUser\Exceptions\AppUserApiException;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface;
use App\Services\Api\Content\Exceptions\ContentApiException;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Class AddFavoriteAppUserProcessor
 *
 * @package App\Services\Api\AppUser\Processors
 */
final class AddFavoriteAppUserProcessor extends AbstractAppUserProcessor implements AppUserProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\AppUser\Exceptions\AppUserApiException
     * @throws \App\Services\Api\Content\Exceptions\ContentApiException
     * @var \App\Http\Dto\AppUser\FavoriteAppUserDto $data
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

        /** @var \App\Models\Content|null $content */
        $content = $this->contentRepository->find($data->getContentId());

        if ($content === null) {
            throw ContentApiException::notExists($data->getContentId());
        }

        if ($this->isModelActive($content) === false) {
            throw ContentApiException::notExists($data->getContentId());
        }

        $this->appUserRepository->addFavorite($appUser, $data->getContentId());

        return new DefaultResponse(null);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return AppUserProcessorInterface::ADD_FAVORITE_APP_USER_PROCESSOR === $processor;
    }
}
