<?php
declare(strict_types=1);

namespace App\Observers;

use App\Events\Cms\BranchIoContentLinkEvent;
use App\Events\Cms\ChangeModelStatusEvent;
use App\Models\Content;
use App\Models\Interfaces\ContentInterface;

/**
 * Class ContentObserver
 *
 * @package App\Observers
 */
final class ContentObserver
{
    /**
     * Handle the content "deleted" event.
     *
     * @param \App\Models\Content $content
     * @return void
     */
    public function deleted(Content $content): void
    {
        ChangeModelStatusEvent::dispatch($content, false);
    }

    /**
     * Handle the content "restored" event.
     *
     * @param \App\Models\Content $content
     * @return void
     */
    public function restored(Content $content): void
    {
        ChangeModelStatusEvent::dispatch($content, true);
    }

    /**
     * Handle the content "saved" event.
     *
     * @param \App\Models\Content $content
     * @return void
     */
    public function saved(Content $content): void
    {
        if ($content->isDirty() === true) {
            BranchIoContentLinkEvent::dispatch($content);
        }
    }

    /**
     * Handle the content "saving" event.
     *
     * @param \App\Models\Content $content
     * @return void
     */
    public function saving(Content $content): void
    {
        $type = $content->getAttribute('type');
        $format = $content->getAttribute('format');

        if ($type === null || $format === ContentInterface::FORMAT_AUDIO) {
            $content->setAttribute('type', ContentInterface::TYPE_ON_DEMAND);
        }
    }
}
