<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Mail\newOrderNotificationMail;
use App\Mail\WelcomeNewUserMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNewOrderNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderCreatedEvent  $event
     * @return void
     */
    public function handle(OrderCreatedEvent $event)
    {
      Mail::to($event->admin_email)->send(new newOrderNotificationMail($event->order_id,$event->order_username,
        $event->order_phone_number, $event->order_email, $event->order_message,$event->created_at));
    }
}
