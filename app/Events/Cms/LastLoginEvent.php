<?php
declare(strict_types=1);

namespace App\Events\Cms;

use App\Models\Interfaces\BaseModelInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class LastLoginEvent
 *
 * @package App\Events
 */
class LastLoginEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Interfaces\BaseModelInterface $user
     */
    public BaseModelInterface $user;

    /**
     * Event constructor.
     *
     * @param \App\Models\Interfaces\BaseModelInterface $user
     */
    public function __construct(BaseModelInterface $user)
    {
        $this->user = $user;
    }
}
