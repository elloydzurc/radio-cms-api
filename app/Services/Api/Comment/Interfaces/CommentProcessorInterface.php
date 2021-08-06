<?php
declare(strict_types=1);

namespace App\Services\Api\Comment\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface CommentProcessorInterface
 *
 * @package App\Services\Api\Comment\Interfaces
 */
interface CommentProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const LIST_COMMENT_PROCESSOR = 'list_comment';

    /**
     * @var string
     */
    public const POST_COMMENT_PROCESSOR = 'post_comment';
}