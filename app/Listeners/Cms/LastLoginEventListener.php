<?php
declare(strict_types=1);

namespace App\Listeners\Cms;

use App\Events\Cms\LastLoginEvent;
use App\Repositories\Cms\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Carbon;

/**
 * Class LastLoginEventListener
 *
 * @package App\Listeners\Cms
 */
class LastLoginEventListener
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
     * @param \App\Events\Cms\LastLoginEvent $event
     */
    public function handle(LastLoginEvent $event): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $user */
        $user = $event->user;
        $user->setAttribute('last_login', Carbon::now());

        $this->userRepository->save($user);
    }
}
