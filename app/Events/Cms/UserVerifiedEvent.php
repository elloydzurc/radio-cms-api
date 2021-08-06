<?php
declare(strict_types=1);

namespace App\Events\Cms;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserVerifiedEvent
 *
 * @package App\Events\Cms
 */
class UserVerifiedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\User $user
     */
    public User $user;

    /**
     * Event constructor.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
