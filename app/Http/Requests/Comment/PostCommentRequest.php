<?php
declare(strict_types=1);

namespace App\Http\Requests\Comment;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Comment\PostCommentDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class PostCommentRequest
 *
 * @package App\Http\Requests\Comment
 */
final class PostCommentRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'comment' => ['required'],
            'content_id' => ['required', 'numeric'],
        ];
    }

    /**
     * Custom validation error messages
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'comment.required' => 'Comment is required',
            'content_id.required' => 'Content ID is required.',
            'content_id.numeric' => 'Invalid Content ID value.',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new PostCommentDto($this);
    }
}
