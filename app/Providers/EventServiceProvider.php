<?php

namespace App\Providers;

use App\Events\AdminEvent;
use App\Events\ContentCreationEvent;
use App\Events\HelperEvent;
use App\Events\MemberEvent;
use App\Events\ProcessUserPost;
use App\Listeners\AdminListener;
use App\Listeners\ContentCreationListener;
use App\Listeners\MemberListener;
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

        HelperEvent::class => [
            SaveActivityListener::class,
        ],

        AdminEvent::class => [
            AdminListener::class,
        ],

        MemberEvent::class => [
            MemberListener::class,
        ],

        ProcessUserPost::class => [
            ProcessUserPostListener::class,
        ],

        ContentCreationEvent::class => [
            ContentCreationListener::class,
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
}
