<?php
declare(strict_types=1);

namespace App\Providers;

use App\Http\Controllers\Cms\RadyoNowLoginController;
use App\Nova\Metrics\AppUsersPartition;
use App\Nova\Metrics\AppUsersValue;
use App\Nova\Metrics\ChannelsPartition;
use App\Nova\Metrics\CmsUsersValue;
use App\Nova\Metrics\ContentsPartition;
use App\Nova\Metrics\ContentsValue;
use App\Nova\Metrics\ProgramsValue;
use App\Nova\Metrics\PushNotificationValue;
use App\Nova\Permission;
use App\Nova\Role;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Repositories\Cms\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Http\Controllers\LoginController;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Vyuldashev\NovaPermission\NovaPermissionTool;

/**
 * Class NovaServiceProvider
 *
 * @package App\Providers
 */
class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot():  void
    {
        parent::boot();

        $this->app->alias(
            RadyoNowLoginController::class,
            LoginController::class
        );
    }

    /**
     * Get the cards that should be displayed on the default Nova dashboard.
     *
     * @return array
     */
    protected function cards(): array
    {
        return [
            AppUsersPartition::make()->width('2/3'),
            AppUsersValue::make()->width('1/3')->defaultRange('ALL'),
            ProgramsValue::make()->width('1/2')->defaultRange('ALL'),
            ChannelsPartition::make()->width('1/2'),
            ContentsPartition::make()->width('2/3'),
            ContentsValue::make()->width('1/3')->defaultRange('ALL'),
            CmsUsersValue::make()->width('1/2')->defaultRange('ALL'),
            PushNotificationValue::make()->width('1/2')->defaultRange('ALL'),
        ];
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function ($user) {
            /** @var UserRepositoryInterface $userRepository */
            $userRepository = app(UserRepositoryInterface::class);

            return $userRepository->isUserAllowed($user->email);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // No body needed
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes(): void
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools(): array
    {
        return [
            NovaPermissionTool::make()
                ->permissionPolicy(PermissionPolicy::class)
                ->permissionResource(Permission::class)
                ->rolePolicy(RolePolicy::class)
                ->roleResource(Role::class),
        ];
    }

    /**
     * Sort resources by priority
     */
    protected function resources(): void
    {
        parent::resources();

        Nova::sortResourcesBy(function ($resource) {
            return $resource::$priority ?? 9999;
        });
    }
}
