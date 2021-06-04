@extends('admin.layouts.default')
@section('content')
<div class="admin-modal " id="orders">
    <table class="admin-table mt-5" >
      <thead >
      <tr >
        <th ><abbr title="Номер заказа" >Номер заказа</abbr ></th >
        <th ><abbr title="Заказчик" >Заказчик</abbr ></th >
        <th ><abbr title="Товары"  >Товары</abbr ></th >
        <th ><abbr title="Сумма" >Сумма</abbr ></th >
        <th ><abbr title="Заказ создан" >Заказ создан</abbr ></th >
        <th ><abbr title="Статус" >Статус</abbr ></th >
        <th ><abbr title="Поменять статус" >Поменять статус</abbr ></th >
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
                  <span class="admin-product__title">{{$product->product_title }}</span ><span
                  class="ml-3">{{$product->pivot->quantity
                  }}</span >
                </div >
              @endforeach
            </div >
          </td >
          <td class="price" > {{ number_format($order->sum,0,',',' ')}} р.</td >

          <td ><span class
                     ="finalPrice" >{{ $order->created_at  }}</span >
          </td >
          <td ><span class
                     ="" >{{ $order->status ? 'Доставлено' : 'В процессе'  }}</span >
          </td >
          <td >
            @if(!$order->status)
            <form action="{{route('orderUpdateStatus')}}" method="post">
              @csrf
              @method('put')
              <input type="hidden"  name="id" value="{{$order->id}}" >
            <button type="submit" class
                     ="button is-success" >Доставлен</button >
            </form >
            @endif
          </td >

        </tr >
      @endforeach
      </tbody >
    </table >

</div >
@endsection
