<?php
declare(strict_types=1);

namespace App\Services\Api\Station\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Station\AbstractStationProcessor;
use App\Services\Api\Station\Interfaces\StationProcessorInterface;
use App\Services\Api\Station\Transformers\StationIndexTransformer;

/**
 * Class ListStationProcessor
 *
 * @package App\Services\Api\Station\Processors
 */
final class ListStationProcessor extends AbstractStationProcessor implements StationProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $paginator = $this->stationRepository->listStations($data);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, StationIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return StationProcessorInterface::LIST_STATION_PROCESSOR === $processor;
    }
}
