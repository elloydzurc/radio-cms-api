<?php
declare(strict_types=1);

namespace App\Http\Dto\Common;

use App\Http\Dto\AbstractDto;

/**
 * Class ListRequestDto
 *
 * @package App\Http\Dto\Common
 */
final class ListRequestDto extends AbstractDto
{
    /**
     * @var array
     */
    private array $excludeIds = [];

    /**
     * @var array
     */
    private array $filters = [];

    /**
     * @var null|int
     */
    private ?int $page = null;

    /**
     * @var int
     */
    private int $perPage = 15;

    /**
     * @var null|string
     */
    private ?string $searchKey = null;

    /**
     * @var null|string
     */
    private ?string $slug = null;

    /**
     * @var null|string
     */
    private ?string $sortBy = null;

    /**
     * @var string
     */
    private string $sortOrder = 'asc';

    /**
     * @var string[]
     */
    private array $with = [];

    /**
     * @param string $filterName
     * @param $filterValue
     *
     * @return $this
     */
    public function addFilter(string $filterName, $filterValue): self
    {
        $this->filters[$filterName] = $filterValue;

        return $this;
    }

    /**
     * @return array
     */
    public function getExcludeIds(): array
    {
        return $this->excludeIds;
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    /**
     * @return null|int
     */
    public function getPage(): ?int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @return string
     */
    public function getSearchKey(): ?string
    {
        return $this->searchKey;
    }

    /**
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return string
     */
    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    /**
     * @return string
     */
    public function getSortOrder(): string
    {
        return $this->sortOrder;
    }

    /**
     * @return array
     */
    public function getWith(): array
    {
        return $this->with;
    }

    /**
     * @param array $excludeIds
     */
    public function setExcludeIds(array $excludeIds): void
    {
        $this->excludeIds = $excludeIds;
    }

    /**
     * @param array $filters
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setFilters(array $filters = []): self
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @param null|int $page
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setPage(?int $page = null): self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @param int $perPage
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage ?? 15;

        return $this;
    }

    /**
     * @param null|string $searchKey
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setSearchKey(?string $searchKey = null): self
    {
        $this->searchKey = $searchKey;

        return $this;
    }

    /**
     * @param null|string $slug
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setSlug(?string $slug = null): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @param null|string $sortBy
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setSortBy(?string $sortBy = null): self
    {
        $this->sortBy = $sortBy;

        return $this;
    }

    /**
     * @param string $sortOrder
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setSortOrder(string $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    /**
     * @param array $with
     *
     * @return \App\Http\Dto\Common\ListRequestDto
     */
    public function setWith(array $with): self
    {
        $this->with = $with;

        return $this;
    }
}
