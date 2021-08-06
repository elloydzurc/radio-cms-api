<?php
declare(strict_types=1);

namespace App\Repositories\Api;

use App\Http\Dto\Comment\PostCommentDto;
use App\Http\Dto\Common\ListRequestDto;
use App\Models\Comment;
use App\Repositories\AbstractRepository;
use App\Repositories\Api\Interfaces\CommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class AdsRepository
 *
 * @package App\Repositories\Api
 */
class CommentRepository extends AbstractRepository implements CommentRepositoryInterface
{
    /**
     * CommentRepository constructor.
     *
     * @param \App\Models\Comment $model
     */
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listComments(ListRequestDto $queryParams): LengthAwarePaginator
    {
        $query = $this->queryBuilder($queryParams)
            ->with('appUser')
            ->where('active', '=', true)
            ->whereNull('deleted_at');

        return $query->paginate($queryParams->getPerPage(), ['*'], 'page', $queryParams->getPage());
    }

    /**
     * @param \App\Http\Dto\Comment\PostCommentDto $data
     * @param int $appUserId
     *
     * @return \App\Models\Comment
     */
    public function postComment(PostCommentDto $data, int $appUserId): Comment
    {
        $this->model->setAttribute('app_user_id', $appUserId);
        $this->model->setAttribute('content_id', $data->getContentId());
        $this->model->setAttribute('comment', $data->getComment());

        $this->save($this->model);

        return $this->model;
    }
}
