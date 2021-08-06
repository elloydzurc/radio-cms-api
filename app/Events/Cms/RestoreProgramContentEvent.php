<?php
declare(strict_types=1);

namespace App\Events\Cms;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class RestoreProgramContentEvent
 *
 * @package App\Events\Cms
 */
class RestoreProgramContentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var int $programId
     */
    public int $programId;

    /**
     * Event constructor.
     *
     * @param int $programId
     */
    public function __construct(int $programId)
    {
        $this->programId = $programId;
    }
}
