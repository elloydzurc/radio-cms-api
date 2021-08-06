<?php
declare(strict_types=1);

namespace App\Http\Requests\Playlist;

use App\Http\Dto\AbstractDto;
use App\Http\Dto\Playlist\ContentToPlaylistRequestDto;
use App\Http\Requests\AbstractFormRequest;

/**
 * Class ContentToPlaylistRequest
 *
 * @package App\Http\Requests\Playlist
 */
final class ContentToPlaylistRequest extends AbstractFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'playlist_id' => ['required', 'numeric'],
            'content_id' => ['required', 'numeric']
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
            'playlist_id.required' => 'Playlist ID is required.',
            'playlist_id.numeric' => 'Invalid playlist ID value.',
            'content_id.required' => 'Content ID is required.',
            'content_id.numeric' => 'Invalid content ID value.'
        ];
    }

    /**
     * @return \App\Http\Dto\AbstractDto
     * @throws \App\Http\Dto\UnableToParseRequestDataException
     */
    public function getData(): AbstractDto
    {
        return new ContentToPlaylistRequestDto($this);
    }
}
