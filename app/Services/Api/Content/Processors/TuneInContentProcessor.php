<?php
declare(strict_types=1);

namespace App\Services\Api\Content\Processors;

use App\Http\Dto\AbstractDto;
use App\Models\Interfaces\ContentInterface;
use App\Services\Api\Content\AbstractContentProcessor;
use App\Services\Api\Content\Exceptions\ContentApiException;
use App\Services\Api\Content\Interfaces\ContentProcessorInterface;
use App\Services\Api\Content\Transformers\ContentIndexTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use Illuminate\Support\Arr;

/**
 * Class TuneInContentProcessor
 *
 * @package App\Services\Api\Content\Processors
 */
final class TuneInContentProcessor extends AbstractContentProcessor implements ContentProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Content\Exceptions\ContentApiException
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $filters = $data->getFilters();
        $formats = ContentInterface::ALL_AUDIO_FORMAT;

        $contentId = Arr::pull($filters, 'content_id');
        $criteria = [
            'id' => $contentId,
            'active' => true,
            'deleted_at' => null,
        ];

        $content = $this->contentRepository->findOneByCriteria($criteria);

        if ($content === null) {
            throw ContentApiException::notExists($contentId);
        }

        if ($this->isModelActive($content) === false) {
            throw ContentApiException::notExists($contentId);
        }

        $programId = $content->getAttribute('program_id');
        $contentIds = $this->contentRepository->getContentIds($programId, $formats);
        $contentPageLocation = $contentIds->search($contentId);

        if ($contentPageLocation === false) {
            throw ContentApiException::notExists($contentId);
        }

        // Audio only for now
        $filters['format'] = $formats;
        $filters['program_id'] = $programId;

        $data->setPerPage($this->getAllowedTuneInStationContent())
            ->setPage($data->getPage()  ?? $contentPageLocation + 1)
            ->setFilters($filters)
            ->setSortBy('id')
            ->setSortOrder('ASC');

        $paginator = $this->contentRepository->listContents($data, $this->getCurrentUserId());
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, ContentIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return ContentProcessorInterface::TUNE_IN_CONTENT_PROCESSOR === $processor;
    }
}
