<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class newOrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

  public $order_id;
  public $order_username;
  public $order_phone_number;
  public $order_email;
  public $order_message;
  public $created_at;


  /**
   * Create a new message instance.
   *
   * @param $order_id
   * @param $order_username
   * @param $order_phone_number
   * @param $order_email
   * @param $order_message
   * @param $created_at
   */
    public function __construct($order_id, $order_username, $order_phone_number, $order_email, $order_message,$created_at)
    {
        $this->order_id= $order_id;
        $this->order_username= $order_username;
        $this->order_phone_number= $order_phone_number;
        $this->order_email= $order_email;
        $this->order_message= $order_message;
        $this->created_at= $created_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

      return $this->markdown('email.order.newOrderNotification',[
        'id'=>$this->order_id,
        'username' => $this->order_username,
        'phone_number' => $this->order_phone_number,
        'email' => $this->order_email,
        'message' => $this->order_message,
        'created_at' => $this->created_at]);
    }
}
