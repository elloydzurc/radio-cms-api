<?php
declare(strict_types=1);

namespace App\Repositories\Api\Interfaces;

use App\Http\Dto\Comment\PostCommentDto;
use App\Http\Dto\Common\ListRequestDto;
use App\Models\Comment;
use App\Repositories\AbstractRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Interface CommentRepositoryInterface
 *
 * @package App\Repositories\Api\Interfaces
 */
interface CommentRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listComments(ListRequestDto $queryParams): LengthAwarePaginator;

    /**
     * @param \App\Http\Dto\Comment\PostCommentDto $data
     * @param int $appUserId
     *
     * @return \App\Models\Comment
     */
    public function postComment(PostCommentDto $data, int $appUserId): Comment;
}
