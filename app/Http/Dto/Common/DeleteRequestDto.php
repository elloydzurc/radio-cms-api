<?php
declare(strict_types=1);

namespace App\Http\Dto\Common;

use App\Http\Dto\AbstractDto;

/**
 * Class DeleteRequestDto
 *
 * @package App\Http\Dto\Common
 */
final class DeleteRequestDto extends AbstractDto
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return DeleteRequestDto
     */
    public function setId(int $id): DeleteRequestDto
    {
        $this->id = $id;

        return $this;
    }
}
