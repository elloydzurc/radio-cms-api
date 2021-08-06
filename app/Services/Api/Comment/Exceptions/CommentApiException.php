<?php
declare(strict_types=1);

namespace App\Services\Api\Comment\Exceptions;

use App\Exceptions\ConflictException;

/**
 * Class CommentApiException
 *
 * @package App\Services\Api\Comment\Exceptions
 */
final class CommentApiException extends ConflictException
{
    /**
     * @param string $section
     * @param int|null $adsId
     *
     * @return \App\Services\Api\Comment\Exceptions\CommentApiException
     */
    public static function notFound(string $section, ?int $adsId): CommentApiException
    {
        $message = trans('messages.ads.not_exists', [
            'section' => $section,
            'id' => $adsId
        ]);

        return new self($message);
    }
}
