<?php
declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Api\AdsRepository;
use App\Repositories\Api\AppUserRepository;
use App\Repositories\Api\CommentRepository;
use App\Repositories\Api\Interfaces\AdsRepositoryInterface;
use App\Repositories\Api\Interfaces\AppUserRepositoryInterface;
use App\Repositories\Api\Interfaces\CommentRepositoryInterface;
use App\Repositories\Api\Interfaces\PlaylistRepositoryInterface;
use App\Repositories\Api\Interfaces\ProgramRepositoryInterface;
use App\Repositories\Api\Interfaces\StationRepositoryInterface;
use App\Repositories\Api\Interfaces\TokenRepositoryInterface;
use App\Repositories\Api\PlaylistRepository;
use App\Repositories\Api\ProgramRepository;
use App\Repositories\Api\StationRepository;
use App\Repositories\Api\TokenRepository;
use App\Repositories\Cms\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Cms\Interfaces\ContentRepositoryInterface;
use App\Repositories\Cms\Interfaces\PushNotificationRepositoryInterface;
use App\Repositories\Cms\Interfaces\UserRepositoryInterface;
use App\Repositories\Cms\PermissionRepository;
use App\Repositories\Cms\ContentRepository;
use App\Repositories\Cms\PushNotificationRepository;
use App\Repositories\Cms\UserRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Class RepositoryServiceProvider
 *
 * @package App\Providers
 */
final class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // API Repositories
        $this->app->singleton(
            AdsRepositoryInterface::class,
            AdsRepository::class
        );

        $this->app->singleton(
            AppUserRepositoryInterface::class,
            AppUserRepository::class
        );

        $this->app->singleton(
            CommentRepositoryInterface::class,
            CommentRepository::class
        );

        $this->app->singleton(
            PlaylistRepositoryInterface::class,
            PlaylistRepository::class
        );

        $this->app->singleton(
            ProgramRepositoryInterface::class,
            ProgramRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Api\Interfaces\PushNotificationRepositoryInterface::class,
            \App\Repositories\Api\PushNotificationRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Api\Interfaces\ContentRepositoryInterface::class,
            \App\Repositories\Api\ContentRepository::class
        );

        $this->app->singleton(
            StationRepositoryInterface::class,
            StationRepository::class
        );

        $this->app->singleton(
            TokenRepositoryInterface::class,
            TokenRepository::class
        );

        // CMS Repositories
        $this->app->singleton(
            \App\Repositories\Cms\Interfaces\AppUserRepositoryInterface::class,
            \App\Repositories\Cms\AppUserRepository::class
        );

        $this->app->singleton(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->singleton(
            PushNotificationRepositoryInterface::class,
            PushNotificationRepository::class
        );

        $this->app->singleton(
            ContentRepositoryInterface::class,
            ContentRepository::class
        );

        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }
}
