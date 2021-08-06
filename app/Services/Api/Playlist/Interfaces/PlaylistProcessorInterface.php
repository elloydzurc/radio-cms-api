<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Interfaces;

use App\Services\Api\Domain\Common\Interfaces\ProcessorInterface;

/**
 * Interface PlaylistProcessorInterface
 *
 * @package App\Services\Api\Playlist\Interfaces
 */
interface PlaylistProcessorInterface extends ProcessorInterface
{
    /**
     * @var string
     */
    public const ADD_CONTENT_TO_PLAYLIST_PROCESSOR = 'add_content_to_playlist';

    /**
     * @var string
     */
    public const CREATE_PLAYLIST_PROCESSOR = 'create_playlist';

    /**
     * @var string
     */
    public const CONTENTS_PLAYLIST_PROCESSOR = 'contents_playlist';

    /**
     * @var string
     */
    public const DELETE_PLAYLIST_PROCESSOR = 'delete_playlist';

    /**
     * @var string
     */
    public const DETAILS_PLAYLIST_PROCESSOR = 'details_playlist';

    /**
     * @var string
     */
    public const LIST_PLAYLIST_PROCESSOR = 'list_playlist';

    /**
     * @var string
     */
    public const REMOVE_CONTENT_TO_PLAYLIST_PROCESSOR = 'remove_content_to_playlist';

    /**
     * @var string
     */
    public const UPDATE_PLAYLIST_PROCESSOR = 'update_playlist';
}