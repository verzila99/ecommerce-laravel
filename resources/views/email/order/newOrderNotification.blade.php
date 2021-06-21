@component('mail::message',)
  # Introduction

  At {{ $created_at }}   Customer {{ $username }} has confirm order {{$id}}
  Phone number: {{$phone_number}}
  Email: {{$email}}
  Message: {{$message}}

  @component('mail::button', ['url' => ''])
    Button Text
  @endcomponent

  Thanks,<br >
  {{ config('app.name') }}
@endcomponent
