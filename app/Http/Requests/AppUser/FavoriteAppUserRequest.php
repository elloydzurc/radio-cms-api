<?php
declare(strict_types=1);

namespace App\Http\Requests\AppUser;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\AppUser\FavoriteAppUserDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class FavoriteAppUserRequest
 *
 * @package App\Http\Requests\AppUser
 */
final class FavoriteAppUserRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric'],
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
            'id.required' => 'App User ID is required',
            'id.numeric' => 'Invalid App user ID value.',
            'content_id.required' => 'Content ID is required.',
            'content_id.numeric' => 'Invalid Contetn ID value.',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new FavoriteAppUserDto($this);
    }
}
