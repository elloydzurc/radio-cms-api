<?php
declare(strict_types=1);

namespace App\Http\Requests\Playlist;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Playlist\UpdatePlaylistRequestDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class UpdatePlaylistRequest
 *
 * @package App\Http\Requests\Playlist
 */
final class UpdatePlaylistRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'playlist_id' => ['required', 'numeric'],
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
            'name.required' => 'Name is required.',
            'playlist_id.required' => 'Playlist ID is required.',
            'playlist_id.numeric' => 'Invalid playlist ID value.'
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new UpdatePlaylistRequestDto($this);
    }
}
