<?php
declare(strict_types=1);

namespace App\Listeners\Cms;

use App\Events\Cms\BranchIoContentLinkEvent;
use App\Services\Cms\Interfaces\BranchIoLinkSyncerInterface;

/**
 * Class BranchIoContentLinkEventListener
 *
 * @package App\Listeners\Cms
 */
class BranchIoContentLinkEventListener
{
    /**
     * @var \App\Services\Cms\Interfaces\BranchIoLinkSyncerInterface
     */
    private BranchIoLinkSyncerInterface $branchIoLinkSyncer;

    /**
     * BranchIoContentLinkEventListener constructor.
     *
     * @param \App\Services\Cms\Interfaces\BranchIoLinkSyncerInterface $branchIoLinkSyncer
     */
    public function __construct(BranchIoLinkSyncerInterface $branchIoLinkSyncer)
    {
        $this->branchIoLinkSyncer = $branchIoLinkSyncer;
    }

    /**
     * @param \App\Events\Cms\BranchIoContentLinkEvent $event
     */
    public function handle(BranchIoContentLinkEvent $event): void
    {
        $this->branchIoLinkSyncer->sync($event->content);
    }
}
