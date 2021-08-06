<?php
declare(strict_types=1);

namespace App\Services\Api\Content\Exceptions;

use App\Exceptions\ConflictException;

/**
 * Class ContentApiException
 *
 * @package App\Services\Api\Content\Exceptions
 */
final class ContentApiException extends ConflictException
{
    /**
     * @param int $contentId
     *
     * @return \App\Services\Api\Content\Exceptions\ContentApiException
     */
    public static function notExists(int $contentId): ContentApiException
    {
        $message = trans('messages.content.not_exists', [
            'contentId' => $contentId
        ]);

        return new self($message);
    }
}
