<?php
declare(strict_types=1);

namespace App\Listeners\Cms;

use App\Events\Cms\UserVerifiedEvent;
use App\Repositories\Cms\Interfaces\UserRepositoryInterface;

/**
 * Class UserVerifiedEventListener
 *
 * @package App\Listeners\Cms
 */
class UserVerifiedEventListener
{
    /**
     * @var \App\Repositories\Cms\Interfaces\UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * UserVerifiedListener constructor.
     *
     * @param \App\Repositories\Cms\Interfaces\UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param \App\Events\Cms\UserVerifiedEvent $event
     */
    public function handle(UserVerifiedEvent $event): void
    {
        $user = $event->user;
        $user->setAttribute('active', 1);

        $this->userRepository->save($event->user);
    }
}
