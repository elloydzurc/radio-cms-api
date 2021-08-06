<?php
declare(strict_types=1);

namespace App\Repositories\Cms;

use App\Models\Content;
use App\Repositories\AbstractRepository;
use App\Repositories\Cms\Interfaces\ContentRepositoryInterface;

/**
 * Class ContentRepository
 *
 * @package App\Repositories\Cms
 */
final class ContentRepository extends AbstractRepository implements ContentRepositoryInterface
{
    /**
     * ContentRepository constructor.
     *
     * @param \App\Models\Content $model
     */
    public function __construct(Content $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $programId
     */
    public function restoreContentByProgramId(int $programId): void
    {
        $this->model->newQuery()
            ->withTrashed()
            ->where('program_id', $programId)
            ->update([
                'active' => true,
                'deleted_at' => null
            ]);
    }
}
