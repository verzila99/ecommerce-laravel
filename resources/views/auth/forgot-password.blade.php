@extends('layouts.default')
@section('content')

  <div class="container is-max-widescreen has-text-centered vh" >
    @if (session('status'))
      <div class="message is-info" >
        <div class="message-body" >
          {{ session('status') }}
        </div >
      </div >

    @endif
    <h2 class="is-centered is-size-4 my-4" >{{__('Enter your email')}}</h2 >
      <div class="container is-max-widescreen columns is-centered">
        <form method="post" action="{{ route('password.email') }}" class="column is-one-third-desktop is-half-tablet
        is-flex is-flex-direction-column">
          @csrf
          <div class="field">
            <label for="login-email" class="label"></label >
            <p class="control has-icons-left has-icons-right">
              <input id="login-email" name="email" class="input @error('email') is-danger @enderror"
                     type="email"
                     placeholder="Email"
              />
              <span class="icon is-small is-left">
                                   <i class="fas fa-envelope"></i >
                               </span >
              <span class="icon is-small is-right">
                                   <i class="fas fa-check"></i >
                               </span >
            </p >
            @error('email')
            <p class="help is-danger">{{ $message }}</p >
            @enderror
          </div >
          <button type="submit" class="button is-warning  is-centered is-link is-size-5 my-4"
          >{{__('Confirm')}}
          </button >
        </form >
      </div >
  </div >
@endsection
