@extends('layouts.default')
@section('scripts')
  <script defer
          src="{{ asset('js/app.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')
  <div class="container is-max-widescreen px-3" >
    <h1 class="is-size-4 has-text-weight-bold my-3" >{{__('My orders')}}</h1 >
    <div class="orders is-flex is-flex-direction-column is-justify-content-flex-start" >
      @if (!empty($ordersList))
        @foreach($ordersList as $order)
          <div class="order is-flex is-flex-direction-column is-justify-content-space-between is-align-items-center my-3" >
            <div class="measure field" >
              <div class="order-title active-order-tab field is-flex  is-justify-content-space-between
          is-align-items-center px-4" >
                <span class="order-number my-3 " ><span class="has-text-weight-bold" >{{__('Order number')}} :
                  </span ><span >{{ $order->id }}</span ></span >
                <span class="order-date my-3 " ><span class="has-text-weight-bold" >{{__('Order created')}} :
                  </span ><span >{{ $order->created_at  }}</span ></span >
                <span class="order-status my-3 " ><span class="has-text-weight-bold" >{{__('Status')}} : </span ><span >{{
                  $order->status ? __('Delivered') : __('In process')}}
                  </span ></span >
                <div class="category-filter__arrow" ></div >

              </div >

              <div class="order-info columns field is-flex is-justify-content-space-between is-align-items-flex-start my-3" >
                <div class="order-info__about column is-flex is-flex-direction-column is-justify-content-space-between
              is-align-items-flex-start my-3" >
                  <h2 class="is-size-4 has-text-weight-bold my-3" >{{__('Order info')}}</h2 >
                  <span class="order-number my-3" >{{__('Order number')}} : <span >{{ $order->id }}</span ></span >
                  <span class="order-date my-3" >{{__('Order created')}} : <span >{{ $order->created_at  }}</span ></span >
                  <span class="order-status my-3" >{{__('Status')}} : <span >{{ $order->status ? 'Delivered' : 'In
                  process'
                  }}</span ></span >
                </div >
                <div class="customer column is-flex is-flex-direction-column is-justify-content-space-between
                is-align-items-flex-start my-3" >
                  <h2 class="is-size-4 has-text-weight-bold my-3" >{{__('Customer')}}</h2 >
                  <span class="customer-name my-3" >{{__('Customer')}} : <span >{{ $order->username }}</span ></span >
                  <span class="customer-email my-3" >Email : <span >{{ $order->email }}</span ></span >
                  <span class="customer-phone my-3" >{{__('Phone number')}} : <span >{{ $order->phone_number }}</span ></span >
                </div >
              </div >
              <div class="products field  is-flex is-flex-direction-column is-justify-content-space-between
            is-align-items-flex-start px-3" >
                <h2 class="is-size-4 has-text-weight-bold my-3" >{{__('Order content')}}</h2 >
                @foreach($order->products as $product)
                  <div class="product field is-flex   is-align-items-center my-3" >
                    <div class="cart-item__icon is-hidden-mobile" >
                      <img src="{{ asset('storage/uploads/images/'.$product->id.'/45x45/' .
                                         explode(',',$product->images)[0])}}"

                           alt=""
                           srcset="" />
                    </div >
                    <div class="product-title " >{{ $product->title }}</div >
                    <div class="product-quantity px-3" >{{ $product->pivot->quantity}}</div >
                    <div class="product-price  px-3" >{{ $product->price/100}}</div >
                    <div class="product-sum  px-3" >{{ $product->pivot->quantity * $product->price/100}}</div >
                  </div >
                @endforeach
              </div >
              <div class="order-summary field columns is-flex is-flex-direction-column is-justify-content-space-between
              is-align-items-flex-end" >
                <div class="order-container column is-one-third is-flex is-flex-direction-column is-justify-content-space-between
              is-align-items-stretch my-3" >
                  <h2 class="is-size-5 has-text-weight-bold my-3" >{{__('Total')}}</h2 >
                  <div class="order-sum__without-delivery is-flex  is-justify-content-space-between my-3" ><span class="has-text-weight-bold" >{{__('Sum')}}:
                  </span > <span >$ {{ number_format($order->sum/100 - 9.44,2,'.',',')}} </span ></div >
                  <div class="delivery is-flex  is-justify-content-space-between my-3" ><span class="has-text-weight-bold" >{{__('Delivery')}}
                                                                                                        :</span >
                    <span >$ 9.44</span ></div >
                  <div class="order-sum is-flex  is-justify-content-space-between my-3" ><span class="has-text-weight-bold" >{{__('Total')}}:
                    </span > <span >$ {{
                number_format($order->sum/100,2,'.',',')}}
                  </span >
                  </div >
                </div >
              </div >
            </div >
          </div >
        @endforeach
      @else
        <section class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center order-success" >
          <h1 class="noitems-title" >{{__('There is nothing here...')}}</h1 >
          <h2 class="has-text-grey has-text-weight-bold is-size-5 mt-6" >
            {{__('Make your first purchase.')}}
          </h2 >
          <a href="/"
             class="button is-warning mt-6" >{{__('Home')}}</a >
        </section >
      @endif
    </div >

  </div >

@endsection
