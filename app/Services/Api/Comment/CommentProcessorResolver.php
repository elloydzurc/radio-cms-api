<?php
declare(strict_types=1);

namespace App\Services\Api\Comment;

use App\Http\Dto\AbstractDto;
use App\Services\Api\AbstractApiService;
use App\Services\Api\Domain\Common\Exceptions\UnsupportedProcessorException;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;
use App\Services\Api\Comment\Interfaces\CommentProcessorInterface;
use App\Services\Api\Comment\Interfaces\CommentProcessorResolverInterface;

/**
 * Class CommentProcessorResolver
 *
 * @package App\Services\Api\Comment
 */
final class CommentProcessorResolver extends AbstractApiService implements CommentProcessorResolverInterface
{
    /**
     * @var \App\Services\Api\Comment\Interfaces\CommentProcessorInterface[]
     */
    private iterable $processors;

    /**
     * CommentProcessorResolver constructor.
     *
     * @param \App\Services\Api\Comment\Interfaces\CommentProcessorInterface ...$processors
     */
    public function __construct(CommentProcessorInterface ...$processors)
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
