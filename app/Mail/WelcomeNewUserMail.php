<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeNewUserMail extends Mailable
{
    use Queueable, SerializesModels;

  public string $name;


  /**
   * Create a new message instance.
   *
   * @param $name
   */
    public function __construct($name)
    {
      $this->name = $name;
    }


  /**
   * Build the message.
   *
   * @return $this
   */
    public function build(): static
    {
        return $this->markdown('email.welcomeNewUser',['name'=>$this->name]);
    }
}
