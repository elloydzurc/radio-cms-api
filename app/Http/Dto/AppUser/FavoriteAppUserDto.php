<?php
declare(strict_types=1);

namespace App\Http\Dto\AppUser;

use App\Http\Dto\AbstractDto;

/**
 * Class FavoriteAppUserDto
 *
 * @package App\Http\Dto\AppUser
 */
final class FavoriteAppUserDto extends AbstractDto
{
    /**
     * @var int
     */
    protected int $contentId;

    /**
     * @var int $id
     */
    protected int $id;

    /**
     * @return int
     */
    public function getContentId(): int
    {
        return $this->contentId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $contentId
     */
    public function setContentId(int $contentId): void
    {
        $this->contentId = $contentId;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
