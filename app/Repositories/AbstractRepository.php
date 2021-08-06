<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Http\Dto\Common\ListRequestDto;
use App\Traits\AppConfigurationAwareTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class AbstractRepository
 *
 * @package App\Repositories
 */
abstract class AbstractRepository implements AbstractRepositoryInterface
{
    use AppConfigurationAwareTrait;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected Model $model;

    /**
     * @param int $id
     *
     * @param array $relatedModels
     * @param array $withModelCount
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function find(int $id, array $relatedModels = [], array $withModelCount = []): ?Model
    {
        $query = $this->model->newQuery();

        if (empty($relatedModels) === false) {
            $query->with($relatedModels);
        }

        if (empty($withModelCount) === false) {
            $query->withCount($withModelCount);
        }

        return $query->withTrashed()->find($id);
    }

    /**
     * @param string $column
     * @param string $value
     * @param array $relatedModels
     * @param array $withModelCount
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function findBy(string $column, string $value, array $relatedModels = [], array $withModelCount = []): ?Model
    {
        $query = $this->model->newQuery();

        if (empty($relatedModels) === false) {
            $query->with($relatedModels);
        }

        if (empty($withModelCount) === false) {
            $query->withCount($withModelCount);
        }

        return $query->where($column, '=', $value)
            ->withTrashed()
            ->first();
    }

    /**
     * @param array $criteria
     *
     * @param array $relatedModels
     * @param array $withModelCount
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllByCriteria(array $criteria, array $relatedModels = [], array $withModelCount = []): Collection
    {
        $query = $this->model->newQuery();

        foreach ($criteria as $column => $value) {
            $condition = \is_array($value) === true ? 'whereIn' : 'where';
            $query->{$condition}($column, $value);
        }

        if (empty($relatedModels) === false) {
            $query->with($relatedModels);
        }

        if (empty($withModelCount) === false) {
            $query->withCount($withModelCount);
        }

        return $query->get();
    }

    /**
     * @param array $criteria
     *
     * @param array $relatedModels
     * @param array $withModelCount
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function findOneByCriteria(array $criteria, array $relatedModels = [], array $withModelCount = []): ?Model
    {
        $query = $this->model->newQuery();

        foreach ($criteria as $column => $value) {
            $condition = \is_array($value) === true ? 'whereIn' : 'where';
            $query->{$condition}($column, $value);
        }

        if (empty($relatedModels) === false) {
            $query->with($relatedModels);
        }

        if (empty($withModelCount) === false) {
            $query->withCount($withModelCount);
        }

        return $query->withTrashed()->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(Model $model): Model
    {
        $model->save();

        return $model;
    }

    /**
     * @param \App\Http\Dto\Common\ListRequestDto $queryParams
     * @param null|\Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function queryBuilder(ListRequestDto $queryParams, ?Builder $query = null): Builder
    {
        $query = $query ?? $this->model->newQuery();

        // Eager Loading
        if (empty($queryParams->getWith()) === false) {
            $query->with($queryParams->getWith());
        }

        // Filtering
        if (empty($queryParams->getFilters()) === false) {
            $this->filterBuilder($query, $queryParams->getFilters());
        }

        // Searching
        if ($queryParams->getSearchKey() !== null) {
            $this->searchBuilder($query, $queryParams->getSearchKey());
        }

        // Ordering
        if ($queryParams->getSortBy() !== null) {
            $query->orderBy($queryParams->getSortBy(), $queryParams->getSortOrder());
        }

        // Exclude ID
        if (empty($queryParams->getExcludeIds()) === false) {
            $query->whereNotIn('id', $queryParams->getExcludeIds());
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $filters
     */
    protected function filterBuilder(Builder $query, array $filters): void
    {
        foreach ($filters as $column => $value) {
            if ($column === 'id') {
                continue;
            }

            if (\is_array($value) === false) {
                $value = \explode(',', (string)$value);
            }

            $count = \count($value);
            if ($count <= 1) {
                $query->where($column, '=', $value);
            } else {
                $query->whereIn($column, $value);
            }
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $keyword
     */
    protected function searchBuilder(Builder $query, string $keyword): void
    {
        foreach ($this->model->getSearchable() as $column) {
            $query->orWhere($column, 'LIKE', '%' . $keyword . '%');
        }
    }
}
