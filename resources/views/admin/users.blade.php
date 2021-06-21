@extends('admin.layouts.default')
@section('content')
  @if (session('status'))
    <div class="message is-dark" >
      <div class="message-body" >
        {{ session('status') }}
      </div >
    </div >
  @endif
  @if($users->count()>0)
  @foreach($users as $user)
    <div class="user  is-flex is-align-items-center is-justify-content-space-between py-3">
    <div
      class="is-flex-grow-1 is-flex is-align-items-center is-justify-content-space-between">

      <div class="user-id px-3">{{$user->id}}</div>
      <div class="user-name">{{$user->name}}</div>
      <div class="user-email px-3">{{$user->email}}</div>
      <div class="user-registered px-3">{{$user->created_at}}</div>

      <form class=" is-flex px-5" action="{{ route('updateRole') }}" method="post">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $user->id }}" >
        <div class="user-role" >
          <div class="select is-small mr-3" >
            <select class="" name="role"  >
              <option value="1" >Admin</option >
              <option value="0" @if($user->role!==1) selected @endif>Not admin</option >
            </select >
          </div >
        </div >
      <button type="submit" class="button is-small is-warning">{{__('Save')}}</button>
      </form >
    </div>
      <form action="{{route('userDelete')}}" method="post" class="user-delete px-3">
        @csrf
        @method( "DELETE")
        <input type="hidden" name="id" value="{{$user->id}}" >
        <button type="submit" class="button is-small is-primary">{{__('Delete')}}</button>
      </form>
    </div >
  @endforeach
  @else
  <h2 class="is-centered">{{__('No users')}}</h2>
  @endif
@endsection
