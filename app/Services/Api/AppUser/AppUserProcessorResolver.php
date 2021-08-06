<?php
declare(strict_types=1);

namespace App\Services\Api\AppUser;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AbstractApiService;
use App\Services\Api\Domain\Common\Exceptions\UnsupportedProcessorException;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorResolverInterface;

/**
 * Class AppUserProcessorResolver
 *
 * @package App\Services\Api\AppUser
 */
final class AppUserProcessorResolver extends AbstractApiService implements AppUserProcessorResolverInterface
{
    /**
     * @var \App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface[]
     */
    private iterable $processors;

    /**
     * AppUserRouteResolver constructor.
     *
     * @param \App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface[] $processors
     */
    public function __construct(AppUserProcessorInterface ...$processors)
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
