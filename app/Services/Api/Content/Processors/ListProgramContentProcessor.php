<?php
declare(strict_types=1);

namespace App\Services\Api\Content\Processors;

use App\Http\Dto\AbstractDto;
use App\Models\Interfaces\ContentInterface;
use App\Services\Api\Content\AbstractContentProcessor;
use App\Services\Api\Content\Interfaces\ContentProcessorInterface;
use App\Services\Api\Content\Transformers\ContentIndexTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Class ListProgramContentProcessor
 *
 * @package App\Services\Api\Content\Processors
 */
final class ListProgramContentProcessor extends AbstractContentProcessor implements ContentProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $filters = $data->getFilters();

        if (isset($filters['format']) === true) {
            $filters['format'] = $filters['format'] === ContentInterface::FORMAT_AUDIO ?
                ContentInterface::ALL_AUDIO_FORMAT : ContentInterface::ALL_VIDEO_FORMAT;
            $data->setFilters($filters);
        }

        $paginator = $this->contentRepository->listProgramContents($data, $this->getCurrentUserId());
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, ContentIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return ContentProcessorInterface::LIST_PROGRAM_CONTENT_PROCESSOR === $processor;
    }
}
