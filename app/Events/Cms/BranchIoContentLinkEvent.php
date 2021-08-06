<?php
declare(strict_types=1);

namespace App\Events\Cms;

use App\Models\Content;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserVerifiedEvent
 *
 * @package App\Events\Cms
 */
class BranchIoContentLinkEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Content $content
     */
    public Content $content;

    /**
     * Event constructor.
     *
     * @param \App\Models\Content $content
     */
    public function __construct(Content $content)
    {
        $this->content = $content;
    }
}
