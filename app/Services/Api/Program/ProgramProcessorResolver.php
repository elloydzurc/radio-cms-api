<?php
declare(strict_types=1);

namespace App\Services\Api\Program;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AbstractApiService;
use App\Services\Api\Domain\Common\Exceptions\UnsupportedProcessorException;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Program\Interfaces\ProgramProcessorInterface;
use App\Services\Api\Program\Interfaces\ProgramProcessorResolverInterface;

/**
 * Class ProgramProcessorResolver
 *
 * @package App\Services\Api\Program
 */
final class ProgramProcessorResolver extends AbstractApiService implements ProgramProcessorResolverInterface
{
    /**
     * @var \App\Services\Api\Program\Interfaces\ProgramProcessorInterface[]
     */
    private iterable $processors;

    /**
     * ProgramProcessorResolver constructor.
     *
     * @param \App\Services\Api\Program\Interfaces\ProgramProcessorInterface ...$processors
     */
    public function __construct(ProgramProcessorInterface ...$processors)
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
