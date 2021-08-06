<?php
declare(strict_types=1);

namespace App\Services\Api\Comment\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Comment\AbstractCommentProcessor;
use App\Services\Api\Comment\Interfaces\CommentProcessorInterface;
use App\Services\Api\Comment\Transformers\CommentDetailsTransformer;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Class ListCommentProcessor
 *
 * @package App\Services\Api\Comment\Processors
 */
final class ListCommentProcessor extends AbstractCommentProcessor implements CommentProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @var \App\Http\Dto\Common\ListRequestDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $paginator = $this->commentRepository->listComments($data);
        $entities = $paginator->getCollection();

        return new DefaultResponse($entities, CommentDetailsTransformer::class, $paginator);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return CommentProcessorInterface::LIST_COMMENT_PROCESSOR === $processor;
    }
}
