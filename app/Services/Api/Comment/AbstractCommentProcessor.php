<?php
declare(strict_types=1);

namespace App\Services\Api\Comment;

use App\Repositories\Api\Interfaces\CommentRepositoryInterface;
use App\Repositories\Api\Interfaces\ContentRepositoryInterface;
use App\Traits\AppConfigurationAwareTrait;
use App\Traits\AppUserAwareTrait;
use App\Traits\ModelStatusAwareTrait;

/**
 * Class AbstractCommentProcessor
 *
 * @package App\Services\Api\Comment
 */
abstract class AbstractCommentProcessor
{
    use AppConfigurationAwareTrait, AppUserAwareTrait, ModelStatusAwareTrait;

    /**
     * @var \App\Repositories\Api\Interfaces\CommentRepositoryInterface
     */
    protected CommentRepositoryInterface $commentRepository;

    /**
     * @var \App\Repositories\Api\Interfaces\ContentRepositoryInterface
     */
    protected ContentRepositoryInterface $contentRepository;

    /**
     * AbstractCommentProcessor constructor.
     *
     * @param \App\Repositories\Api\Interfaces\CommentRepositoryInterface $commentRepository
     * @param \App\Repositories\Api\Interfaces\ContentRepositoryInterface $contentRepository
     */
    public function __construct(
        CommentRepositoryInterface $commentRepository,
        ContentRepositoryInterface $contentRepository
    ) {
        $this->commentRepository = $commentRepository;
        $this->contentRepository = $contentRepository;
    }
}
