<?php
declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Interface BaseRepositoryInterface
 *
 * @package App\Repositories
 */
interface AbstractRepositoryInterface
{
    /**
     * @param int $id
     *
     * @param array $relatedModels
     * @param array $withModelCount
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function find(int $id, array $relatedModels = [], array $withModelCount = []): ?Model;

    /**
     * @param string $column
     * @param string $value
     *
     * @param array $relatedModels
     *
     * @param array $withModelCount
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function findBy(string $column, string $value, array $relatedModels = [], array $withModelCount = []): ?Model;

    /**
     * @param array $criteria
     *
     * @param array $relatedModels
     * @param array $withModelCount
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllByCriteria(array $criteria, array $relatedModels = [], array $withModelCount = []): Collection;

    /**
     * @param array $criteria
     *
     * @param array $relatedModels
     * @param array $withModelCount
     *
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function findOneByCriteria(array $criteria, array $relatedModels = [], array $withModelCount = []): ?Model;

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function save(Model $model): Model;
}
