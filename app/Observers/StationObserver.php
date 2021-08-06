<?php
declare(strict_types=1);

namespace App\Observers;

use App\Events\Cms\ChangeModelStatusEvent;
use App\Models\Station;

/**
 * Class StationObserver
 *
 * @package App\Observers
 */
final class StationObserver
{
    /**
     * Handle the station "deleted" event.
     *
     * @param \App\Models\Station $station
     *
     * @return void
     */
    public function deleted(Station $station): void
    {
        ChangeModelStatusEvent::dispatch($station, false);
    }
}
