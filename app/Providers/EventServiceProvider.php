<?php

namespace App\Providers;

use App\Events\SendAdminEmailEvent;
use App\Events\ContentCreationNotificationEvent;
use App\Events\AppHelperEvent;
use App\Events\SendMemberEmailEvent;
use App\Events\ProcessUserPostEvent;
use App\Listeners\SendAdminEmailListener;
use App\Listeners\ContentCreationNotificationListener;
use App\Listeners\SendMemberEmailListener;
use App\Listeners\ProcessUserPostListener;
use App\Listeners\SaveActivityListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        AppHelperEvent::class => [
            SaveActivityListener::class,
        ],

        SendAdminEmailEvent::class => [
            SendAdminEmailListener::class,
        ],

        SendMemberEmailEvent::class => [
            SendMemberEmailListener::class,
        ],

        ProcessUserPostEvent::class => [
            ProcessUserPostListener::class,
        ],

        ContentCreationNotificationEvent::class => [
            ContentCreationNotificationListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
