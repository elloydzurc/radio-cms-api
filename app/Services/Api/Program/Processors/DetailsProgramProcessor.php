<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Program\AbstractProgramProcessor;
use App\Services\Api\Program\Exceptions\ProgramApiException;
use App\Services\Api\Program\Interfaces\ProgramProcessorInterface;
use App\Services\Api\Program\Transformers\ProgramDetailsTransformer;

/**
 * Class DetailsProgramProcessor
 *
 * @package App\Services\Api\StationContent\Processors
 */
final class DetailsProgramProcessor extends AbstractProgramProcessor implements ProgramProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Program\Exceptions\ProgramApiException
     * @var \App\Http\Dto\Common\DetailsRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        /** @var null|\App\Models\Program $program */
        $program = $this->programRepository->find($data->getId());

        if ($program === null || $this->isModelActive($program) === false) {
            throw ProgramApiException::programNotExists($data->getId());
        }

        return new DefaultResponse($program, ProgramDetailsTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return ProgramProcessorInterface::DETAILS_PROGRAM_PROCESSOR === $processor;
    }
}
