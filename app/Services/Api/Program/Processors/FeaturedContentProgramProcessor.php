<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Content\Transformers\ContentDetailsTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Program\AbstractProgramProcessor;
use App\Services\Api\Program\Interfaces\ProgramProcessorInterface;

/**
 * Class FeaturedContentProgramProcessor
 *
 * @package App\Services\Api\StationContent\Processors
 */
final class FeaturedContentProgramProcessor extends AbstractProgramProcessor implements ProgramProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();

        $paginator = $this->contentRepository->allFeaturedContents($data, $appUserId);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, ContentDetailsTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return ProgramProcessorInterface::FEATURED_CONTENT_PROGRAM_PROCESSOR === $processor;
    }
}
