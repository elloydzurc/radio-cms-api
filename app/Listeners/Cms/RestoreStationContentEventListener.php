<?php
declare(strict_types=1);

namespace App\Listeners\Cms;

use App\Events\Cms\RestoreProgramContentEvent;
use App\Repositories\Cms\Interfaces\ContentRepositoryInterface;

/**
 * Class RestoreStationContentEventListener
 *
 * @package App\Listeners\Cms
 */
class RestoreStationContentEventListener
{
    /**
     * @var \App\Repositories\Cms\Interfaces\ContentRepositoryInterface
     */
    private ContentRepositoryInterface $repository;

    /**
     * RestoreStationContentEventListener constructor.
     *
     * @param \App\Repositories\Cms\Interfaces\ContentRepositoryInterface $repository
     */
    public function __construct(ContentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \App\Events\Cms\RestoreProgramContentEvent $event
     */
    public function handle(RestoreProgramContentEvent $event): void
    {
        $this->repository->restoreContentByProgramId($event->programId);
    }
}
