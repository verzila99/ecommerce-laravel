@extends('admin.layouts.default')
@section('content')
<div class="admin-modal " id="orders">
  @if (session('status'))
    <div class="message is-dark" >
      <div class="message-body" >
        {{ session('status') }}
      </div >
    </div >
  @endif
    <table class="admin-table mt-5" >
      <thead >
      <tr >
        <th ><abbr title="{{__('Order number')}}" >{{__('Order number')}}</abbr ></th >
        <th ><abbr title="{{__('Customer')}}" >{{__('Customer')}}</abbr ></th >
        <th ><abbr title="{{__('Products')}}"  >{{__('Products')}}</abbr ></th >
        <th ><abbr title="{{__('Sum')}}" >{{__('Sum')}}</abbr ></th >
        <th ><abbr title="{{__('Order created')}}" >{{__('Order created')}}</abbr ></th >
        <th ><abbr title="{{__('Status')}}" >{{__('Status')}}</abbr ></th >
        <th ><abbr title="{{__('Change status')}}" >{{__('Change status')}}</abbr ></th >
        <th ><abbr title="{{__('Delete order')}}" >{{__('Delete order')}}</abbr ></th >
      </tr >
      </thead >
      <tfoot ></tfoot >
      <tbody >
      @foreach($ordersList as $order)
        <tr class="cart-row my-3" >
          <td >
            <p class="" >
              {{  $order->id }}
            </p >
          </td >
          <td >
            <p class="" >
              {{  $order->username }}
            </p >
          </td >
          <td class="" >
            <div class="is-flex is-flex-direction-column" >
              @foreach($order->products as $product)

                <div
                  class="is-flex is-justify-content-space-between " >
                  <span class="admin-product__title">{{$product->title }}</span ><span
                  class="ml-3">{{$product->pivot->quantity
                  }}</span >
                </div >
              @endforeach
            </div >
          </td >
          <td class="price" >$ {{ number_format($order->sum/100,2,'.',',')}}</td >

          <td ><span class
                     ="finalPrice" >{{ $order->created_at  }}</span >
          </td >
          <td ><span class
                     ="" >{{ $order->status ? __('Delivered') : __('In process') }}</span >
          </td >
          <td >
            @if(!$order->status)
            <form action="{{route('orderUpdateStatus')}}" method="post">
              @csrf
              @method('put')
              <input type="hidden"  name="id" value="{{$order->id}}" >
            <button type="submit" class
                     ="button is-success" >{{__('Delivered')}}</button >
            </form >
            @endif
          </td >
          <td >

            <form action="{{route('orderDelete')}}" method="post">
              @csrf
              @method('delete')
              <input type="hidden"  name="id" value="{{$order->id}}" >
            <button type="submit" class
                     ="button is-primary" >{{__('Delete')}}</button >
            </form >

          </td >

        </tr >
      @endforeach
      </tbody >
    </table >

</div >
@endsection
