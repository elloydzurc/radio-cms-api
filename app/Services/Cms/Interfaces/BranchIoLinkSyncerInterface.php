<?php
declare(strict_types=1);

namespace App\Services\Cms\Interfaces;

use App\Models\Content;

/**
 * Interface BranchIoLinkSyncerInterface
 *
 * @package App\Services\Cms\Interfaces
 */
interface BranchIoLinkSyncerInterface
{
    /**
     * Sync content link on BranchIO
     */
    public function sync(Content $content): void;
}
