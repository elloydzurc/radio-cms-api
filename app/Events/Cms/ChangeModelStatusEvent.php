<?php
declare(strict_types=1);

namespace App\Events\Cms;

use App\Models\Interfaces\BaseModelInterface;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class ChangeModelStatusEvent
 *
 * @package App\Events\Cms
 */
class ChangeModelStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \App\Models\Interfaces\BaseModelInterface $model
     */
    public BaseModelInterface $model;

    /**
     * @var bool
     */
    public bool $status;

    /**
     * Event constructor.
     *
     * @param \App\Models\Interfaces\BaseModelInterface $model
     * @param bool $status
     */
    public function __construct(BaseModelInterface $model, bool $status)
    {
        $this->model = $model;
        $this->status = $status;
    }
}
