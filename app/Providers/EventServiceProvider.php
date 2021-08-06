<?php
declare(strict_types=1);

namespace App\Providers;

use App\Events\Cms\BranchIoContentLinkEvent;
use App\Events\Cms\ChangeModelStatusEvent;
use App\Events\Cms\RestoreProgramContentEvent;
use App\Events\Cms\UserVerifiedEvent;
use App\Events\Cms\LastLoginEvent;
use App\Listeners\Api\AccessTokenCreatedListener;
use App\Listeners\Cms\BranchIoContentLinkEventListener;
use App\Listeners\Cms\ChangeModelStatusEventListener;
use App\Listeners\Cms\LastLoginEventListener;
use App\Listeners\Cms\RestoreStationContentEventListener;
use App\Listeners\Cms\UserVerifiedEventListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;
use SocialiteProviders\Manager\SocialiteWasCalled;

/**
 * Class EventServiceProvider
 *
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AccessTokenCreated::class => [
            AccessTokenCreatedListener::class,
        ],
        BranchIoContentLinkEvent::class => [
            BranchIoContentLinkEventListener::class,
        ],
        ChangeModelStatusEvent::class => [
            ChangeModelStatusEventListener::class
        ],
        LastLoginEvent::class => [
            LastLoginEventListener::class
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RestoreProgramContentEvent::class => [
            RestoreStationContentEventListener::class
        ],
        SocialiteWasCalled::class => [
            'SocialiteProviders\\Apple\\AppleExtendSocialite@handle',
        ],
        UserVerifiedEvent::class => [
            UserVerifiedEventListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot(): void
    {
        parent::boot();
    }
}
