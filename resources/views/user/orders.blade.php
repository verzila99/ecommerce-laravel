@extends('layouts.default')
@section('scripts')
  <script defer src="{{ asset('js/app.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')

  <div class="container is-max-widescreen" >
    <div class="table-container" >
      @if (!is_empty($ordersList))
        <table class="admin-table mt-5" >
          <thead >
          <tr >
            <th ><abbr title="Номер заказа" >Номер заказа</abbr ></th >
            <th ><abbr title="Заказчик" >Заказчик</abbr ></th >
            <th ><abbr title="Товары" >Товары</abbr ></th >
            <th ><abbr title="Сумма" >Сумма</abbr ></th >
            <th ><abbr title="Заказ создан" >Заказ создан</abbr ></th >
            <th ><abbr title="Статус" >Статус</abbr ></th >
          </tr >
          </thead >
          <tfoot ></tfoot >
          <tbody >
          @foreach($ordersList as $order)
            <tr class="cart-row my-3" >
              <td >
                <p class="" >
                  {{ $order->id }}
                </p >
              </td >
              <td >
                <p class="" >
                  {{ $order->username }}
                </p >
              </td >
              <td class="" >
                <div class="is-flex is-flex-direction-column" >
                  @foreach($order->products as $product)

                    <div
                      class="is-flex is-justify-content-space-between " >
                      <span class="admin-product__title" >{{$product->product_title }}</span ><span
                        class="ml-3" >{{$product->pivot->quantity
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

            </tr >
          @endforeach
          </tbody >
        </table >
      @else
        <section
          class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center order-success"
        >
          <h1 class="noitems-title" >Здесь пока пусто...</h1 >
          <h2 class="has-text-grey has-text-weight-bold is-size-5 mt-6" >
            Сделайте первый заказ.
          </h2 >
          <a href="/" class="button is-warning mt-6" >На главную</a >
        </section >
      @endif
    </div >

  </div >

@endsection
