<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Program\AbstractProgramProcessor;
use App\Services\Api\Program\Interfaces\ProgramProcessorInterface;
use App\Services\Api\Program\Transformers\ProgramIndexTransformer;

/**
 * Class ListProgramProcessor
 *
 * @package App\Services\Api\StationContent\Processors
 */
final class ListProgramProcessor extends AbstractProgramProcessor implements ProgramProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $paginator = $this->programRepository->listPrograms($data);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, ProgramIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return ProgramProcessorInterface::LIST_PROGRAM_PROCESSOR === $processor;
    }
}
