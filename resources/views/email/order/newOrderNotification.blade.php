@component('mail::message',)
  # Introduction

  {{ $created_at }}        {{ $username }} оформил заказ номер {{$id}}
  Телефон: {{$phone_number}}
  Сообщение: {{$message}}
  Email: {{$email}}

  @component('mail::button', ['url' => ''])
    Button Text
  @endcomponent

  Thanks,<br >
  {{ config('app.name') }}
@endcomponent
