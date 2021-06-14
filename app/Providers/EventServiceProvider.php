<?php

namespace App\Providers;

use App\Events\UserRegisteredEvent;
use App\Events\OrderCreatedEvent;
use App\Listeners\SendUserWelcomeMailListener;
use App\Listeners\SendNewOrderNotificationListener;
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
            SendEmailVerificationNotification::class],
        UserRegisteredEvent::class=>[SendUserWelcomeMailListener::class],
        OrderCreatedEvent::class=>[SendNewOrderNotificationListener::class],

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
