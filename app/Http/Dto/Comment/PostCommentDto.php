<?php
declare(strict_types=1);

namespace App\Http\Dto\Comment;

use App\Http\Dto\AbstractDto;

/**
 * Class PostCommentDto
 *
 * @package App\Http\Dto\Comment
 */
final class PostCommentDto extends AbstractDto
{
    /**
     * @var string
     */
    protected string $comment;

    /**
     * @var int
     */
    protected int $contentId;

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return int
     */
    public function getContentId(): int
    {
        return $this->contentId;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @param int $contentId
     */
    public function setContentId(int $contentId): void
    {
        $this->contentId = $contentId;
    }
}
