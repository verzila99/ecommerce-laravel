<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\Messages\MailMessage;

class AuthServiceProvider extends ServiceProvider
{
  /**
   * The policy mappings for the application.
   *
   * @var array
   */
  protected $policies = [
    'App\Models\User'    => 'App\Policies\UserPolicy',
    'App\Models\Product' => 'App\Policies\ProductPolicy',
  ];


  /**
   * Register any authentication / authorization services.
   *
   * @return void
   */
  public function boot(): void
  {
    $this->registerPolicies();

    VerifyEmail::toMailUsing(
      function ($notifiable, $url) {
        return (new MailMessage)
          ->subject('Verify Email Address')
          ->line('Click the button below to verify your email address.')
          ->action(
          'Verify Email Address',
          preg_replace('/127.0.0.1:8000/','localhost:3000',$url)
        );
      }
    );

    ResetPassword::createUrlUsing(
      function ($user, string $token) {
        return 'localhost:3000/reset-password?token=' . $token;
      }
    );
  }
}
