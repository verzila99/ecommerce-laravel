@extends('admin.layouts.default')
@section('content')
  <div class="admin-modal " id="create-product" >
    @if (session('status'))
      <div class="message is-dark" >
        <div class="message-body" >
          {{ session('status') }}
        </div >
      </div >
    @endif
    @foreach($banners as $banner)
      <div class="field is-flex is-justify-content-space-between is-align-items-center" >
        <div class="banner-image" >
          <img src="{{ asset('storage/uploads/banners/1152x300/' . $banner->image)}}" alt="" >
        </div >
        <div
          class="banner-properties is-flex is-flex-direction-column is-justify-content-space-between
          is-align-items-flex-start px-4" >
          <p class="banner-property is-size-6 field" >{{$banner->url}}</p >
          <p class="banner-property is-size-6 field" >{{$banner->location}}</p >
          <p class="banner-property is-size-6 field" >{{$banner->position}}</p >
        </div >
        <div
          class="banner-actions is-flex is-flex-direction-column is-justify-content-space-between
          is-align-items-center block" >
          <a href=" {{ route('editBanner',['id'=>$banner->id]) }}" class="field button is-dark mb-4" >{{__('Edit')
          }}</a >
          <form action="{{ route('deleteBanner')}}" method="post" class="field">
            @csrf
            @method('delete')
            <input type="hidden" name="id"  value="{{$banner->id}}">
            <button type="submit" class="button is-primary field" >{{__('Delete')}}</button >
          </form >
        </div >
      </div >
  @endforeach
@endsection
