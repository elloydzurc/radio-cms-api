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
use Illuminate\Support\Arr;

/**
 * Class TuneInStationProcessor
 *
 * @package App\Services\Api\Station\Processors
 */
final class TuneInStationProcessor extends AbstractStationProcessor implements StationProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Station\Exceptions\StationApiException
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $filters = $data->getFilters();
        $stationId = Arr::pull($filters, 'id');

        $stationIds = $this->stationRepository->getStationIds();
        $stationPageLocation = $stationIds->search($stationId);

        if ($stationPageLocation === false) {
            throw StationApiException::notFound($stationId);
        }

       $data->setFilters([])
            ->setPerPage($this->getAllowedTuneInStation())
            ->setPage($data->getPage()  ?? $stationPageLocation + 1)
            ->setSortBy('id')
            ->setSortOrder('ASC');

        $paginator = $this->stationRepository->tuneInStations($data);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, StationWithLiveContentTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return StationProcessorInterface::TUNE_IN_STATION_PROCESSOR === $processor;
    }
}
