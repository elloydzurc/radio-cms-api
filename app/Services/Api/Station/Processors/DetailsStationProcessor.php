<?php
declare(strict_types=1);

namespace App\Services\Api\Station\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Station\AbstractStationProcessor;
use App\Services\Api\Station\Exceptions\StationApiException;
use App\Services\Api\Station\Interfaces\StationProcessorInterface;
use App\Services\Api\Station\Transformers\StationWithLiveContentTransformer;

/**
 * Class DetailsStationProcessor
 *
 * @package App\Services\Api\Station\Processors
 */
final class DetailsStationProcessor extends AbstractStationProcessor implements StationProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Station\Exceptions\StationApiException
     * @var \App\Http\Dto\Common\DetailsRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        /** @var null|\App\Models\Station $station */
        $station = $this->stationRepository->find($data->getId(), ['liveContent']);

        if ($station === null) {
            throw StationApiException::notFound($data->getId());
        }

        return new DefaultResponse($station, StationWithLiveContentTransformer::class);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return StationProcessorInterface::DETAILS_STATION_PROCESSOR === $processor;
    }
}
