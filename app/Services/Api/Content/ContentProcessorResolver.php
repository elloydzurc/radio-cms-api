<?php
declare(strict_types=1);

namespace App\Services\Api\Content;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AbstractApiService;
use App\Services\Api\Domain\Common\Exceptions\UnsupportedProcessorException;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Content\Interfaces\ContentProcessorInterface;
use App\Services\Api\Content\Interfaces\ContentProcessorResolverInterface;

/**
 * Class ContentProcessorResolver
 *
 * @package App\Services\Api\Content
 */
final class ContentProcessorResolver extends AbstractApiService implements ContentProcessorResolverInterface
{
    /**
     * @var \App\Services\Api\Security\Interfaces\SecurityProcessorInterface[]
     */
    private iterable $processors;

    /**
     * StationContentProcessorResolver constructor.
     *
     * @param \App\Services\Api\Content\Interfaces\ContentProcessorInterface ...$processors
     */
    public function __construct(ContentProcessorInterface ...$processors)
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
