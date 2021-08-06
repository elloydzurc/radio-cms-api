<?php
declare(strict_types=1);

namespace App\Providers;

use App\Services\Api\Ads\AdsProcessorResolver;
use App\Services\Api\Ads\Interfaces\AdsProcessorInterface;
use App\Services\Api\Ads\Processors\ListAdsProcessor;
use App\Services\Api\AppUser\AppUserProcessorResolver;
use App\Services\Api\AppUser\Interfaces\AppUserProcessorInterface;
use App\Services\Api\AppUser\Processors\AddDeviceAppUserProcessor;
use App\Services\Api\AppUser\Processors\AddFavoriteAppUserProcessor;
use App\Services\Api\AppUser\Processors\DeleteDeviceAppUserProcessor;
use App\Services\Api\AppUser\Processors\DeleteFavoriteAppUserProcessor;
use App\Services\Api\AppUser\Processors\DetailsAppUserProcessor;
use App\Services\Api\AppUser\Processors\InboxAppUserProcessor;
use App\Services\Api\AppUser\Processors\ListFavoriteAppUserProcessor;
use App\Services\Api\AppUser\Processors\UpdateAppUserProcessor;
use App\Services\Api\AppUser\Processors\UploadAvatarAppUserProcessor;
use App\Services\Api\Comment\CommentProcessorResolver;
use App\Services\Api\Comment\Interfaces\CommentProcessorInterface;
use App\Services\Api\Comment\Processors\ListCommentProcessor;
use App\Services\Api\Comment\Processors\PostCommentProcessor;
use App\Services\Api\Content\ContentProcessorResolver;
use App\Services\Api\Content\Interfaces\ContentProcessorInterface;
use App\Services\Api\Content\Processors\DetailsContentProcessor;
use App\Services\Api\Content\Processors\ListProgramContentProcessor;
use App\Services\Api\Content\Processors\TuneInContentProcessor;
use App\Services\Api\Playlist\Interfaces\PlaylistProcessorInterface;
use App\Services\Api\Playlist\PlaylistProcessorResolver;
use App\Services\Api\Playlist\Processors\AddContentToPlaylistProcessor;
use App\Services\Api\Playlist\Processors\ContentPlaylistProcessor;
use App\Services\Api\Playlist\Processors\CreatePlaylistProcessor;
use App\Services\Api\Playlist\Processors\DeletePlaylistProcessor;
use App\Services\Api\Playlist\Processors\DetailsPlaylistProcessor;
use App\Services\Api\Playlist\Processors\ListPlaylistProcessor;
use App\Services\Api\Playlist\Processors\RemoveContentToPlaylistProcessor;
use App\Services\Api\Playlist\Processors\UpdatePlaylistProcessor;
use App\Services\Api\Program\Interfaces\ProgramProcessorInterface;
use App\Services\Api\Program\Processors\DetailsProgramProcessor;
use App\Services\Api\Program\Processors\FeaturedContentProgramProcessor;
use App\Services\Api\Program\Processors\ListProgramProcessor;
use App\Services\Api\Program\Processors\ListStationProgramProcessor;
use App\Services\Api\Program\ProgramProcessorResolver;
use App\Services\Api\Security\Interfaces\SecurityProcessorInterface;
use App\Services\Api\Security\Processors\ChangePasswordProcessor;
use App\Services\Api\Security\Processors\ForgotPasswordProcessor;
use App\Services\Api\Security\Processors\LoginProcessor;
use App\Services\Api\Security\Processors\LogoutProcessor;
use App\Services\Api\Security\Processors\SignUpProcessor;
use App\Services\Api\Security\Processors\SingleSignOnProcessor;
use App\Services\Api\Security\SecurityProcessorResolver;
use App\Services\Api\Security\SocialAuthManager;
use App\Services\Api\Security\SocialProviders\AppleProvider;
use App\Services\Api\Security\SocialProviders\FacebookProvider;
use App\Services\Api\Security\SocialProviders\GoogleProvider;
use App\Services\Api\Security\SocialProviders\Interfaces\SocialProviderInterface;
use App\Services\Api\Station\Interfaces\StationProcessorInterface;
use App\Services\Api\Station\Processors\DetailsStationProcessor;
use App\Services\Api\Station\Processors\FeaturedContentStationProcessor;
use App\Services\Api\Station\Processors\FeaturedStationProcessor;
use App\Services\Api\Station\Processors\ListStationProcessor;
use App\Services\Api\Station\Processors\TuneInStationProcessor;
use App\Services\Api\Station\StationProcessorResolver;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class CollectorServiceProvider
 *
 * @package App\Providers
 */
class CollectorServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot(): void
    {
        // Ads module
        $this->app->when(AdsProcessorResolver::class)
            ->needs(AdsProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(ListAdsProcessor::class),
                ];
            });

        // AppUser Module
        $this->app->when(AppUserProcessorResolver::class)
            ->needs(AppUserProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(AddDeviceAppUserProcessor::class),
                    $app->make(AddFavoriteAppUserProcessor::class),
                    $app->make(DeleteDeviceAppUserProcessor::class),
                    $app->make(DeleteFavoriteAppUserProcessor::class),
                    $app->make(DetailsAppUserProcessor::class),
                    $app->make(InboxAppUserProcessor::class),
                    $app->make(ListFavoriteAppUserProcessor::class),
                    $app->make(UpdateAppUserProcessor::class),
                    $app->make(UploadAvatarAppUserProcessor::class),
                ];
            });

        // Comment module
        $this->app->when(CommentProcessorResolver::class)
            ->needs(CommentProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(ListCommentProcessor::class),
                    $app->make(PostCommentProcessor::class),
                ];
            });

        // Content module
        $this->app->when(ContentProcessorResolver::class)
            ->needs(ContentProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(DetailsContentProcessor::class),
                    $app->make(ListProgramContentProcessor::class),
                    $app->make(TuneInContentProcessor::class),
                ];
            });

        // Playlist module
        $this->app->when(PlaylistProcessorResolver::class)
            ->needs(PlaylistProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(AddContentToPlaylistProcessor::class),
                    $app->make(CreatePlaylistProcessor::class),
                    $app->make(ContentPlaylistProcessor::class),
                    $app->make(DeletePlaylistProcessor::class),
                    $app->make(DetailsPlaylistProcessor::class),
                    $app->make(ListPlaylistProcessor::class),
                    $app->make(RemoveContentToPlaylistProcessor::class),
                    $app->make(UpdatePlaylistProcessor::class),
                ];
            });

        // Program module
        $this->app->when(ProgramProcessorResolver::class)
            ->needs(ProgramProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(DetailsProgramProcessor::class),
                    $app->make(FeaturedContentProgramProcessor::class),
                    $app->make(ListProgramProcessor::class),
                    $app->make(ListStationProgramProcessor::class),
                ];
            });

        // Security module
        $this->app->when(SecurityProcessorResolver::class)
            ->needs(SecurityProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(ChangePasswordProcessor::class),
                    $app->make(ForgotPasswordProcessor::class),
                    $app->make(LoginProcessor::class),
                    $app->make(LogoutProcessor::class),
                    $app->make(SignUpProcessor::class),
                    $app->make(SingleSignOnProcessor::class),
                ];
            });

        $this->app->when(SocialAuthManager::class)
            ->needs(SocialProviderInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(AppleProvider::class),
                    $app->make(FacebookProvider::class),
                    $app->make(GoogleProvider::class),
                ];
            });

        // Station module
        $this->app->when(StationProcessorResolver::class)
            ->needs(StationProcessorInterface::class)
            ->give(function (Application $app) {
                return [
                    $app->make(DetailsStationProcessor::class),
                    $app->make(FeaturedContentStationProcessor::class),
                    $app->make(FeaturedStationProcessor::class),
                    $app->make(ListStationProcessor::class),
                    $app->make(TuneInStationProcessor::class),
                ];
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Do nothing for now
    }
}
