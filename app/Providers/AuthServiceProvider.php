<?php
declare(strict_types=1);

namespace App\Providers;

use App\Models\Ad;
use App\Models\AppUser;
use App\Models\AuditTrail;
use App\Models\Comment;
use App\Models\Content;
use App\Models\Permission;
use App\Models\Program;
use App\Models\PushNotification;
use App\Models\Report;
use App\Models\Role;
use App\Models\Station;
use App\Models\User;
use App\Policies\AdPolicy;
use App\Policies\AppUserPolicy;
use App\Policies\AuditTrailPolicy;
use App\Policies\CommentPolicy;
use App\Policies\ContentPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\PushNotificationPolicy;
use App\Policies\ReportPolicy;
use App\Policies\RolePolicy;
use App\Policies\StationPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 *
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Ad::class => AdPolicy::class,
        AppUser::class => AppUserPolicy::class,
        AuditTrail::class => AuditTrailPolicy::class,
        Comment::class => CommentPolicy::class,
        Content::class => ContentPolicy::class,
        Permission::class => PermissionPolicy::class,
        Program::class => ProgramPolicy::class,
        PushNotification::class => PushNotificationPolicy::class,
        Report::class => ReportPolicy::class,
        Role::class => RolePolicy::class,
        Station::class => StationPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
