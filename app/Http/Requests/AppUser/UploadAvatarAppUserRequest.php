<?php
declare(strict_types=1);

namespace App\Http\Requests\AppUser;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\AppUser\UploadAvatarAppUserDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class UploadAvatarAppUserRequest
 *
 * @package App\Http\Requests\AppUser
 */
final class UploadAvatarAppUserRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'avatar' => ['required', 'image', 'max:2048'],
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
            'avatar.required' => 'Avatar is required.',
            'avatar.image' => 'Avatar should be an image file.',
            'avatar.size' => 'Avatar size should be below 2MB.',
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new UploadAvatarAppUserDto($this);
    }
}
