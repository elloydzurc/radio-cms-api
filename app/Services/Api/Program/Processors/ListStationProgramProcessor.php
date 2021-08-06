<?php
declare(strict_types=1);

namespace App\Services\Api\Program\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Program\AbstractProgramProcessor;
use App\Services\Api\Program\Exceptions\ProgramApiException;
use App\Services\Api\Program\Interfaces\ProgramProcessorInterface;
use App\Services\Api\Program\Transformers\ProgramIndexTransformer;
use Illuminate\Support\Arr;

/**
 * Class ListStationProgramProcessor
 *
 * @package App\Services\Api\StationContent\Processors
 */
final class ListStationProgramProcessor extends AbstractProgramProcessor implements ProgramProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Program\Exceptions\ProgramApiException
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $filters = $data->getFilters();
        $stationId = (int)(Arr::pull($filters, 'station_id') ?? 0);
        $data->setFilters($filters);

        /** @var null|\App\Models\Station $station */
        $station = $this->stationRepository->find($stationId);

        if ($station === null) {
            throw ProgramApiException::programStationNotExists($stationId);
        }

        if ($this->isModelActive($station) === false) {
            throw ProgramApiException::programStationNotActive($stationId);
        }

        $paginator = $this->programRepository->listStationPrograms($data, $stationId);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, ProgramIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return ProgramProcessorInterface::LIST_STATION_PROGRAM_PROCESSOR === $processor;
    }
}
