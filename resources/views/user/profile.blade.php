@extends('layouts.default')
@section('scripts')
    <script defer src="{{ asset('js/app.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')

    <div class="container is-max-widescreen" >
        @if (session('status'))
            <div class="message is-info" >
                <div class="message-body" >
                {{ session('status') }}
                </div >
            </div >

        @endif
        <h1 class="is-size-3 has-text-weight-bold my-4" >{{__('Profile')}}</h1 >
        <div class="columns profile-column" >
            <div class="column is-one-third block is-flex is-flex-direction-column is-justify-content-space-between
            is-align-items-flex-start mb-4" >

                <div class="user-info is-flex is-flex-direction-column is-justify-content-space-between " >
                    <div class="profile-row block is-flex is-justify-content-space-between" >
                        <h4 class=" block has-text-grey" >{{__('Name')}}:</h4 >
                        <p >{{ $user->name }}</p >
                    </div >

                    <div class="profile-row block is-flex is-justify-content-space-between" >
                        <h4 class=" block has-text-grey" >Email:</h4 >
                        <p >{{ $user->email }}</p >
                    </div >
                    <div class="profile-row block is-flex is-justify-content-space-between" >
                        <h4 class=" block has-text-grey" >Date of registration:</h4 >
                        <p >{{ $user->created_at }}</p >
                    </div >
                </div >
                <a href="{{ route('edit') }}" class="button is-success  profile-edit__button"
                >{{__('Edit')}}</a >

            </div >
        </div >
    </div >


@endsection
