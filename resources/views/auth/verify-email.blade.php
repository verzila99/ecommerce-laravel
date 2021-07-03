@extends('layouts.default')
@section('content')

  <div class="container is-max-widescreen has-text-centered vh" >

    @if (session('status'))
      <div class="message is-dark" >
        <div class="message-body" >
          {{ session('status') }}
        </div >
      </div >
    @endif

    <h2 class="is-centered is-size-4 my-4" >
      {{__("Mail with confirmation has been sent on your email address,click at the link in the mail to confirm your
      email address")}}</h2 >
    <form method="post" action="{{ route('verification.send') }}" >
      @csrf
      <button type="submit" class="button is-warning verification-link is-centered is-link is-size-5 my-4"
      >{{__('Send email again')}}
      </button >
    </form >
  </div >
@endsection
