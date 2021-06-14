<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

  public $order_id;
  public $order_username;
  public $order_phone_number;
  public $order_message;
  public $order_email;
  public $admin_email ='verzila0003@yandex.ru';
  public $created_at;


  /**
   * Create a new event instance.
   *
   * @param $order
   */
    public function __construct($order)
    {
        $this->order_id=$order->id;
        $this->order_username=$order->username;
        $this->order_phone_number=$order->phone_number;
        $this->order_email=$order->email;
        $this->order_message=$order->message;
        $this->created_at=$order->created_at;

    }


}
