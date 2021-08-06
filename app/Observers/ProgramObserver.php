<?php
declare(strict_types=1);

namespace App\Observers;

use App\Events\Cms\ChangeModelStatusEvent;
use App\Events\Cms\RestoreProgramContentEvent;
use App\Models\Program;

/**
 * Class ProgramObserver
 *
 * @package App\Observers
 */
final class ProgramObserver
{
    /**
     * Handle the program "deleted" event.
     *
     * @param \App\Models\Program $program
     *
     * @return void
     */
    public function deleted(Program $program): void
    {
        ChangeModelStatusEvent::dispatch($program, false);
    }

    /**
     * Handle the program "restored" event.
     *
     * @param \App\Models\Program $program
     *
     * @return void
     */
    public function restored(Program $program): void
    {
        ChangeModelStatusEvent::dispatch($program, true);
        // Restore all contents under restored program
        RestoreProgramContentEvent::dispatch($program->getAttribute('id'));
    }
}
