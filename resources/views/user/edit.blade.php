@extends('layouts.default')
@section('scripts')
    <script defer src="{{ asset('/js/app.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')

    <div class="container is-max-widescreen" >
        <h1 class="is-size-3 has-text-weight-bold my-4" >{{__('Profile')}}</h1 >
        <div class="columns profile-column" >
            <div class="column is-one-third block is-flex is-flex-direction-column is-justify-content-space-between
            is-align-items-flex-start mb-4" >

                <form
                    method="POST" action="{{ route('update')}}"
                    class=" is-flex-direction-column is-justify-content-space-around is-align-items-center"
                >
                    @csrf
                    <input type="hidden" name="_method" value="PUT" >
                    <div class="field" >
                        <label for="name" class="label has-text-grey" >{{__('Name')}}</label >
                        <p class="control has-icons-left" >
                            <input id="name" class="input @error('name') is-danger @enderror" name="name"
                                   type="text"
                                   placeholder="Имя"
                                   value="{{ old('name') ??  $user->name}}" />
                            <span class="icon is-small is-left" >
                                <i class="fas fa-user" ></i >
                            </span >
                        </p >
                        @error('name')
                        <p class="help is-danger" >{{ $message }}</p >
                        @enderror
                    </div >

                    <div class="field" >
                        <label for="email" class="label has-text-grey" >Email</label >
                        <p class="control has-icons-left " >
                            <input id="email" class="input @error('email') is-danger @enderror"
                                   name="email" type="email"
                                   placeholder="Email"
                                   value="{{ old('email') ??  $user->email}}" />
                            <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
                        </p >
                        @error('email')
                        <p class="help is-danger" >{{ $message }}</p >
                        @enderror
                    </div >
                    <div class="field" >
                        <label for="password" class="label has-text-grey" >{{__('Password')}}</label >
                        <p class="control has-icons-left" >
                            <input
                                id="password"
                                name="password"
                                class="input  @error('password') is-danger @enderror"
                                type="password"
                                placeholder="Пароль"
                            />
                            <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
                        </p >
                        @error('password')
                        <p class="help is-danger" >{{ $message }}</p >
                        @enderror
                    </div >
                    <div class="field" >
                        <label for="confirmation" class="label has-text-grey" >
                          {{__('Password again')}}</label >
                        <p class="control has-icons-left" >
                            <input
                                id="confirmation"
                                name="password_confirmation"
                                class="input  @error('password-confirmation') is-danger @enderror"
                                type="password"
                                placeholder="Подтвердите пароль"
                            />
                            <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
                        </p >
                        @error('password-confirmation')
                        <p class="help is-danger" >{{ $message }}</p >
                        @enderror
                    </div >
                    <div class="field" >
                        <p class="control" >
                            <button type="submit" class="button is-success profile-edit__button"
                            >{{__('Save')}}
                            </button >
                        </p >
                    </div >
                </form >

            </div >
        </div >
    </div >


@endsection
