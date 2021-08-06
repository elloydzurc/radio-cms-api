<?php
declare(strict_types=1);

namespace App\Services\Api\Comment\Transformers;

use App\Models\Comment;
use App\Services\Api\AppUser\Transformers\AppUserIndexTransformer;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract;

/**
 * Class CommentDetailsTransformer
 *
 * @package App\Services\Api\Comment\Transformers
 */
class CommentDetailsTransformer extends TransformerAbstract
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'appUser'
    ];

    /**
     * @param \App\Models\Comment $comment
     *
     * @return array
     */
    public function transform(Comment $comment): array
    {
        return [
            'id' => $comment->getAttribute('id'),
            'comment' => $comment->getAttribute('comment'),
            'created_at' => $comment->getAttribute('created_at'),
        ];
    }

    /**
     * @param \App\Models\Comment $comment
     *
     * @return \League\Fractal\Resource\ResourceAbstract
     */
    public function includeAppUser(Comment $comment): ResourceAbstract
    {
        $resource = $this->null();
        $appUser = $comment->getRelation('appUser');

        if ($appUser !== null) {
            $resource = $this->item($appUser, new AppUserIndexTransformer());
        }

        return $resource;
    }
}
