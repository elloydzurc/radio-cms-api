<?php
declare(strict_types=1);

namespace App\Services\Api\Comment\Processors;

use App\Http\Dto\AbstractDto;
use App\Services\Api\Comment\AbstractCommentProcessor;
use App\Services\Api\Comment\Interfaces\CommentProcessorInterface;
use App\Services\Api\Content\Exceptions\ContentApiException;
use App\Services\Api\Domain\Response\DefaultResponse;
use App\Services\Api\Domain\Response\Interfaces\ResponseInterface;

/**
 * Class PostCommentProcessor
 *
 * @package App\Services\Api\Comment\Processors
 */
final class PostCommentProcessor extends AbstractCommentProcessor implements CommentProcessorInterface
{
    /**
     * @inheritDoc
     *
     * @throws \App\Services\Api\Content\Exceptions\ContentApiException
     * @var \App\Http\Dto\Comment\PostCommentDto $data
     */
    public function process(AbstractDto $data): ResponseInterface
    {
        $appUserId = $this->getCurrentUserId();
        /** @var \App\Models\Content|null $content */
        $content = $this->contentRepository->find($data->getContentId());

        if ($content === null) {
            throw ContentApiException::notExists($data->getContentId());
        }

        if ($this->isModelActive($content) === false) {
            throw ContentApiException::notExists($data->getContentId());
        }

        $this->commentRepository->postComment($data, $appUserId);

        return new DefaultResponse(null);
    }

    /**
     * @inheritDoc
     */
    public function support(string $processor): bool
    {
        return CommentProcessorInterface::POST_COMMENT_PROCESSOR === $processor;
    }
}
