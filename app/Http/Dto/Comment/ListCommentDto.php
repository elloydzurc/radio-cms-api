<?php
declare(strict_types=1);

namespace App\Http\Dto\Comment;

use App\Http\Dto\AbstractDto;

/**
 * Class ListCommentDto
 *
 * @package App\Http\Dto\Comment
 */
final class ListCommentDto extends AbstractDto
{
    /**
     * @var int
     */
    protected int $contentId;

    /**
     * @return int
     */
    public function getContentId(): int
    {
        return $this->contentId;
    }

    /**
     * @param int $contentId
     */
    public function setContentId(int $contentId): void
    {
        $this->contentId = $contentId;
    }
}
