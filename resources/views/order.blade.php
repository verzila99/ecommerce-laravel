@extends('layouts.default')
@section('scripts')

  <script defer src="{{ asset('/js/app.js')}}" ></script >


@endsection
@section('title','Ecommerce shop')
@section('content')

  <section class="cart" >
    <div class="container is-max-widescreen" >
      <div class="table-container" >
        <table class="table is-fullwidth mt-5" >
          <thead >
          <tr >
            <th ><abbr id="table-title" title="Товар" >{{__('Product')}}</abbr ></th >
            <th class="is-hidden-touch"><abbr title="Цена" >{{__('Price')}}</abbr ></th >
            <th ><abbr title="Количество" >{{__('Quantity')}}</abbr ></th >
            <th ><abbr title="Сумма" >{{__('Sum')}}</abbr ></th >

          </tr >
          </thead >
          <tfoot ></tfoot >
          <tbody >
          @if(!empty($productList))
            @foreach($productList as $product)
              <tr class="cart-row" data-price="{{ $product['price']}}" data-id="{{
                    $product['id']}}" >
                <td class="cart-item" >
                  <div class="cart-item__icon is-hidden-touch" >
                    <img
                      src="{{ asset('storage/uploads/images/'.$product['id'].'/700x700/'
                                         . explode(',',$product['images'])[0] )}}"

                      alt=""
                      srcset=""
                    />
                  </div >
                  <a
                    href="/{{$product['category'] . "/" . $product['id'] }}"
                    title="{{ $product['title']}}"
                  >
                    {{ $product['title']}}</a >
                </td >
                <td class="price is-hidden-touch" > {{ number_format($product['price']/100,2,'.',',')}}</td >
                <td >
                  <div class="quantity" >
                    {{ $product['quantity']}}
                  </div >
                </td >
                <td ><span class
                           ="finalPrice" >{{number_format($product['price'] * $product['quantity']/100,2,'.',',')
                           }}</span >
                </td >

              </tr >
            @endforeach
          </tbody >
        </table >
      </div >

      <form class="cart-continue columns is-variable is-4 mt-5 is-justify-content-flex-end pl-5 pr-1" action="{{route
                ('order-confirmed')}}" method="POST" >
        @csrf
        <div class='user-data cart-summary column is-one-third-desktop is-half-tablet is-flex is-flex-direction-column
        is-justify-content-space-around
            is-align-items-center  px-2' >
          <div class="field" >
            <label for="name" class="label" >{{__('Name')}}</label >
            <p class="control has-icons-left" >
              <input id="name" class="input @error('name') is-danger @enderror" name="name"
                     type="text"
                     placeholder="{{__('Name')}}"
                     value="{{ old('name') }}" />

              <span class="icon is-small is-left" >
                                <i class="fas fa-user" ></i >
                            </span >
            </p >
            @error('name')
            <p class="help is-danger" >{{ $message }}</p >
            @enderror
          </div >
          <div class="field" >
            <label for="phone_number" class="label" >{{__('Phone number')}}</label >
            <p class="control has-icons-left" >
              <input id="phone_number" class="input @error('phone_number') is-danger @enderror"
                     name="phone_number"
                     type="text"
                     placeholder="{{__('Phone number')}}"
                     value="{{ old('phone_number') }}" />
              <span class="icon is-small is-left" >
                                <i class="fas fa-phone" ></i >
                            </span >
            </p >
            @error('phone_number')
            <p class="help is-danger" >{{ $message }}</p >
            @enderror
          </div >
          @auth
            <div class="field" >
              <label for="email"
                     class="label" >Email</label >
              <p class="control has-icons-left " >
                <input id="email"
                       class="input @error('email') is-danger @enderror"
                       name="email"
                       type="email"
                       placeholder="Email"
                       value="{{ auth()->user()->email }}"
                       readonly />
                <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
              </p >
              @error('email')
              <p class="help is-danger" >{{ $message }}</p >
              @enderror
            </div>
          @endauth
          @guest

          <div class="field" >
            <label for="email" class="label" >Email</label >
            <p class="control has-icons-left " >
              <input id="email" class="input @error('email') is-danger @enderror"
                     name="email" type="email"
                     placeholder="Email"
                     value="{{ old('email') }}" />
              <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
            </p >
            @error('email')
            <p class="help is-danger" >{{ $message }}</p >
            @enderror
          </div >
          @endguest
          <div class="field" >
            <label class="label" >{{__('Message')}}</label >
            <div class="control" >
              <textarea class="textarea" name="message" placeholder="{{__('Message')}}" ></textarea >
            </div >
          </div >
        </div >
        <div
          class="cart-summary column is-one-third-desktop is-half-tablet is-flex is-flex-direction-column is-justify-content-space-around
                    is-align-items-center px-2"
        >
          <h2 class="cart-summary__title has-text-weight-bold is-size-4" >
            {{__('Total')}}
          </h2 >
          <div class="cart-summary__divider" ></div >
          <div
            class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
          >
            <span class="cart-summary__sum--text" >{{__('Sum')}}</span >
            <div ><span class="has-text-weight-bold" >$ </span >
                        <span
                          class="cart-summary__sum--number has-text-weight-bold"
                        >{{number_format($sum/100 - 9.44,2,'.',',')}}</span >

            </div >
          </div >
          <div
            class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
          >
                    <span class="cart-summary__sum--text" >{{__('Delivery')}}</span
                    ><span class="cart-delivery-price has-text-weight-bold"
            ><span class="has-text-weight-bold" >$ </span >9.44 </span
            >
          </div >
          <div
            class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
          >
                    <span class="cart-summary__sum--text" >{{__('Total')}}</span
                    ><span
              class="cart-summary__sum--number-final has-text-weight-bold"
            ><span class="has-text-weight-bold" >$ </span >{{ number_format($sum/100,2,'.',',') }}
                        </span
            >
          </div >
          <button type="submit" class="button is-success is-fullwidth mt-6" >
            {{__('Checkout')}}
          </button >
        </div >
      </form >

    </div >
  </section >
  @else
    <section
      class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center my-6 px-4"
    >
      <h1 class="noitems-title my-6" >{{__('No items in the cart')}}</h1 >
      <h2 class="has-text-grey has-text-weight-bold is-size-5 my-6" >
        {{__('Find goods in our catalog or use the search')}}
      </h2 >
      <a href="/" class="button is-warning my-6" >{{__('Home')}}</a >
    </section >
  @endif
  <section
    class="noitems is-flex-direction-column is-justify-content-center is-align-items-center"
  >
    <h1 class="noitems-title" >{{__('No items in the cart')}}</h1 >
    <h2 class="has-text-grey has-text-weight-bold is-size-5 mt-6" >
      {{__('Find goods in our catalog or use the search')}}
    </h2 >
    <a href="/" class="button is-warning mt-6" >{{__('Home')}}</a >
  </section >
@endsection
