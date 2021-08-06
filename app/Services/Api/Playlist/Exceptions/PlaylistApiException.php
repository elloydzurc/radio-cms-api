<?php
declare(strict_types=1);

namespace App\Services\Api\Playlist\Exceptions;

use App\Exceptions\ConflictException;

/**
 * Class PlaylistApiException
 *
 * @package App\Services\Api\Playlist\Exceptions
 */
final class PlaylistApiException extends ConflictException
{
    /**
     * @param string $playlist
     *
     * @return \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     */
    public static function alreadyExists(string $playlist): PlaylistApiException
    {
        $message = trans('messages.playlist.already_exists', [
            'name' => $playlist
        ]);

        return new self($message);
    }

    /**
     * @param int $content
     *
     * @return \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     */
    public static function contentNotExists(int $content): PlaylistApiException
    {
        $message = trans('messages.playlist.content_not_exists', [
            'id' => $content
        ]);

        return new self($message);
    }

    /**
     * @param string $playlist
     *
     * @return \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     */
    public static function nameExists(string $playlist): PlaylistApiException
    {
        $message = trans('messages.playlist.name_exists', [
            'name' => $playlist
        ]);

        return new self($message);
    }

    /**
     * @return \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     */
    public static function notExists(): PlaylistApiException
    {
        $message = trans('messages.playlist.not_exists');

        return new self($message);
    }

    /**
     * @param int $playlist
     *
     * @return \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     */
    public static function unableToDelete(int $playlist): PlaylistApiException
    {
        $message = trans('messages.playlist.delete_error', [
            'id' => $playlist
        ]);

        return new self($message);
    }

    /**
     * @param int $content
     *
     * @return \App\Services\Api\Playlist\Exceptions\PlaylistApiException
     */
    public static function unableToRemoveContent(int $content): PlaylistApiException
    {
        $message = trans('messages.playlist.remove_content_failed', [
            'id' => $content
        ]);

        return new self($message);
    }
}
