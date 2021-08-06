<?php
declare(strict_types=1);

namespace App\Http\Dto\Common;

use App\Http\Dto\AbstractDto;

/**
 * Class DetailsRequestDto
 *
 * @package App\Http\Dto\Common
 */
final class DetailsRequestDto extends AbstractDto
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var null|int
     */
    private ?int $parentId = null;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return null|int
     */
    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    /**
     * @param int $id
     *
     * @return DetailsRequestDto
     */
    public function setId(int $id): DetailsRequestDto
    {
        $this->id = $id;

        return $this;
}
}
