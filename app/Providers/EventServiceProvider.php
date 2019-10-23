<?php

namespace App\Providers;

use App\Events\EmailReceived;
use App\Events\SendEmail;
use App\Listeners\SendPaymentEmail;
use App\Listeners\StoreEmailAttributes;
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

        EmailReceived::class => [ // if i fire this event
            StoreEmailAttributes::class, // i want to do this
        ],

        SendEmail::class => [ // if i fire this event
            SendPaymentEmail::class, // i want to do this
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
