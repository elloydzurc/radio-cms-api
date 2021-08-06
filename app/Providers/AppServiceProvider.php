<?php
declare(strict_types=1);

namespace App\Providers;

use App\Models\Ad;
use App\Models\AppUser;
use App\Models\Content;
use App\Models\Program;
use App\Models\Station;
use App\Models\User;
use App\Observers\AdObserver;
use App\Observers\AppUserObserver;
use App\Observers\ContentObserver;
use App\Observers\ProgramObserver;
use App\Observers\StationObserver;
use App\Observers\UserObserver;
use App\Services\Api\Ads\AdsProcessorResolver;
use App\Services\Api\Ads\Interfaces\AdsProcessorResolverInterface;
use App\Services\Api\AppUser\AppUserProcessorResolver;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorResolverInterface;
use App\Services\Api\Comment\CommentProcessorResolver;
use App\Services\Api\Comment\Interfaces\CommentProcessorResolverInterface;
use App\Services\Api\Content\ContentProcessorResolver;
use App\Services\Api\Content\Interfaces\ContentProcessorResolverInterface;
use App\Services\Api\Domain\FileManager\FileManager;
use App\Services\Api\Domain\FileManager\Interfaces\FileManagerInterface;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorResolverInterface;
use App\Services\Api\Playlist\PlaylistProcessorResolver;
use App\Services\Api\Program\Interfaces\ProgramProcessorResolverInterface;
use App\Services\Api\Program\ProgramProcessorResolver;
use App\Services\Api\Security\Interfaces\SecurityProcessorResolverInterface;
use App\Services\Api\Security\Interfaces\SocialAuthManagerInterface;
use App\Services\Api\Security\Interfaces\TokenManagerInterface;
use App\Services\Api\Security\SecurityProcessorResolver;
use App\Services\Api\Security\SocialAuthManager;
use App\Services\Api\Security\TokenManager;
use App\Services\Api\Station\Interfaces\StationProcessorResolverInterface;
use App\Services\Api\Station\StationProcessorResolver;
use App\Services\Cms\BranchIoLinkSyncer;
use App\Services\Cms\Interfaces\BranchIoLinkSyncerInterface;
use App\Services\Cms\Interfaces\PermissionSyncerInterface;
use App\Services\Cms\Interfaces\PushNotificationSyncerInterface;
use App\Services\Cms\PermissionSyncer;
use App\Services\Cms\PushNotificationSyncer;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
final class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Ad::observe(AdObserver::class);
        AppUser::observe(AppUserObserver::class);
        Content::observe(ContentObserver::class);
        Program::observe(ProgramObserver::class);
        Station::observe(StationObserver::class);
        User::observe(UserObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // API Services
        $this->app->singleton(
            AdsProcessorResolverInterface::class,
            AdsProcessorResolver::class
        );

        $this->app->singleton(
            AppUserProcessorResolverInterface::class,
            AppUserProcessorResolver::class
        );

        $this->app->singleton(
            CommentProcessorResolverInterface::class,
            CommentProcessorResolver::class
        );

        $this->app->singleton(
            ContentProcessorResolverInterface::class,
            ContentProcessorResolver::class
        );

        $this->app->singleton(
            FileManagerInterface::class,
            FileManager::class
        );

        $this->app->singleton(
            PlaylistProcessorResolverInterface::class,
            PlaylistProcessorResolver::class
        );

        $this->app->singleton(
            ProgramProcessorResolverInterface::class,
            ProgramProcessorResolver::class
        );

        $this->app->singleton(
            SecurityProcessorResolverInterface::class,
            SecurityProcessorResolver::class
        );

        $this->app->singleton(
            SocialAuthManagerInterface::class,
            SocialAuthManager::class
        );

        $this->app->singleton(
            StationProcessorResolverInterface::class,
            StationProcessorResolver::class
        );

        $this->app->singleton(
            TokenManagerInterface::class,
            TokenManager::class
        );

        // CMS Services
        $this->app->when(BranchIoLinkSyncer::class)
            ->needs('$branchIoKey')
            ->giveConfig('services.branchio.key');

        $this->app->when(BranchIoLinkSyncer::class)
            ->needs('$branchIoSecret')
            ->giveConfig('services.branchio.secret');

        $this->app->when(BranchIoLinkSyncer::class)
            ->needs('$branchIoLinks')
            ->giveConfig('services.branchio.links');

        $this->app->singleton(
            BranchIoLinkSyncerInterface::class,
            BranchIoLinkSyncer::class
        );

        $this->app->singleton(
            PermissionSyncerInterface::class,
            PermissionSyncer::class
        );

        $this->app->singleton(
            PushNotificationSyncerInterface::class,
            PushNotificationSyncer::class
        );
    }
}
