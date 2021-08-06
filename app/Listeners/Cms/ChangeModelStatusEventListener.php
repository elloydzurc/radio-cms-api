<?php
declare(strict_types=1);

namespace App\Listeners\Cms;

use App\Events\Cms\ChangeModelStatusEvent;
use App\Repositories\Cms\Interfaces\UserRepositoryInterface;

/**
 * Class ChangeModelStatusEventListener
 *
 * @package App\Listeners\Cms
 */
class ChangeModelStatusEventListener
{
    /**
     * @var \App\Repositories\Cms\Interfaces\UserRepositoryInterface
     */
    private UserRepositoryInterface $repository;

    /**
     * ChangeModelStatusEventListener constructor.
     *
     * @param \App\Repositories\Cms\Interfaces\UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param \App\Events\Cms\ChangeModelStatusEvent $event
     */
    public function handle(ChangeModelStatusEvent $event): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $model */
        $model = $event->model;
        $model->setAttribute('active', $event->status);

        $this->repository->save($model);
    }
}
