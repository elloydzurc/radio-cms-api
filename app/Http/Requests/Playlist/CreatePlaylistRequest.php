<?php
declare(strict_types=1);

namespace App\Http\Requests\Playlist;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Playlist\CreatePlaylistRequestDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class CreatePlaylistRequest
 *
 * @package App\Http\Requests\Playlist
 */
final class CreatePlaylistRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required']
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
            'name.required' => 'Name is required.'
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new CreatePlaylistRequestDto($this);
    }
}
