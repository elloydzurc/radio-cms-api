<?php
declare(strict_types=1);

namespace App\Repositories\Cms\Interfaces;

use App\Repositories\AbstractRepositoryInterface;

/**
 * Interface ContentRepositoryInterface
 *
 * @package App\Repositories\Cms\Interfaces
 */
interface ContentRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int $programId
     */
    public function restoreContentByProgramId(int $programId): void;
}
