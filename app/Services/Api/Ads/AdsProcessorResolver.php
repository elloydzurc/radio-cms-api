<?php
declare(strict_types=1);

namespace App\Services\Api\Ads;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AbstractApiService;
use App\Services\Api\Domain\Common\Exceptions\UnsupportedProcessorException;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Ads\Interfaces\AdsProcessorInterface;
use App\Services\Api\Ads\Interfaces\AdsProcessorResolverInterface;

/**
 * Class AdsProcessorResolver
 *
 * @package App\Services\Api\Ads
 */
final class AdsProcessorResolver extends AbstractApiService implements AdsProcessorResolverInterface
{
    /**
     * @var \App\Services\Api\Ads\Interfaces\AdsProcessorInterface[]
     */
    private iterable $processors;

    /**
     * AdsProcessorResolver constructor.
     *
     * @param \App\Services\Api\Ads\Interfaces\AdsProcessorInterface ...$processors
     */
    public function __construct(AdsProcessorInterface ...$processors)
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
