<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AbstractApiService;
use App\Services\Api\Domain\Common\Exceptions\UnsupportedProcessorException;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorResolverInterface;

/**
 * Class PlaylistProcessorResolver
 *
 * @package App\Services\Api\Playlist
 */
final class PlaylistProcessorResolver extends AbstractApiService implements PlaylistProcessorResolverInterface
{
    /**
     * @var \App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface[]
     */
    private iterable $processors;

    /**
     * PlaylistProcessorResolver constructor.
     *
     * @param \App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface ...$processors
     */
    public function __construct(PlaylistProcessorInterface ...$processors)
    {
        $this->processors = $processors;
    }

    /**
     * @param string $processor
     * @param \App\Http\Dto\AbstractDto $requestDto
     *
     * @return \App\Services\Api\Domain\Response\Interfaces\ResponseInterface
     * @throws \App\Services\Api\Domain\Common\Exceptions\UnsupportedProcessorException
     */
    public function resolve(string $processor, AbstractDto $requestDto): ResponseInterface
    {
        $processorName = $this->getRouteName($processor);

        foreach ($this->processors as $route) {
            if ($route->support($processorName) === true) {
                return $route->process($requestDto);
            }
        }

        throw new UnsupportedProcessorException(
            trans('messages.domain.unsupported_processor', ['processor' => $processorName])
        );
    }
}
