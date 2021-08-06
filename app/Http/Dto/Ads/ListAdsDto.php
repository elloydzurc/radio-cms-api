<?php
declare(strict_types=1);

namespace App\Http\Dto\Ads;

use App\Http\Dto\AbstractDto;

/**
 * Class ListAdsDto
 *
 * @package App\Http\Dto\Ads
 */
final class ListAdsDto extends AbstractDto
{
    /**
     * @var int|null
     */
    private ?int $id = null;

    /**
     * @var string
     */
    private string $section;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSection(): string
    {
        return $this->section;
    }

    /**
     * @param int|null $id
     *
     * @return ListAdsDto
     */
    public function setId(?int $id): ListAdsDto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $section
     *
     * @return ListAdsDto
     */
    public function setSection(string $section): ListAdsDto
    {
        $this->section = $section;

        return $this;
    }
}
