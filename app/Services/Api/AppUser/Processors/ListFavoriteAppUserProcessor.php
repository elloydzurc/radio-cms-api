<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AppUser\AbstractAppUserProcessor;
use App\Services\Api\AppUser\Exceptions\AppUserApiException;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface;
use App\Services\Api\Content\Transformers\ContentIndexTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Class ListFavoriteAppUserProcessor
 *
 * @package App\Services\Api\AppUser\Processors
 */
final class ListFavoriteAppUserProcessor extends AbstractAppUserProcessor implements AppUserProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();

        $paginator = $this->contentRepository->listAppUserFavoriteContents($data, $appUserId);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, ContentIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return AppUserProcessorInterface::LIST_FAVORITE_APP_USER_PROCESSOR === $processor;
    }
}
