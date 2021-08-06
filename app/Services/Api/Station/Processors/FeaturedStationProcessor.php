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
 * Class FeaturedStationProcessor
 *
 * @package App\Services\Api\Station\Processors
 */
final class FeaturedStationProcessor extends AbstractStationProcessor implements StationProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $paginator = $this->stationRepository->featuredStation($data);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, StationIndexTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return StationProcessorInterface::FEATURED_STATION_PROCESSOR === $processor;
    }
}
