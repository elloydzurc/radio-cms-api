<?php
declare(strict_types=1);

namespace App\Observers;

use App\Models\Ad;

/**
 * Class AdObserver
 *
 * @package App\Observers
 */
final class AdObserver
{
    /**
     * Handle the ad "created" event.
     *
     * @param \App\Models\Ad $ad
     *
     * @return void
     */
    public function created(Ad $ad): void
    {
        $ad->setAttribute('code', 'AD-' . $ad->getAttribute('id'));
        $ad->save();
    }

    /**
     * Handle the ad "created" event.
     *
     * @param \App\Models\Ad $ad
     *
     * @return void
     */
    public function saved(Ad $ad): void
    {
        // TODO Add to pivot table
    }
}
