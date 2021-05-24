@extends('layouts.default')
@section('scripts')

    <script defer src="{{ asset('js/app.js')}}" ></script >
    <script defer src="{{ asset('js/cart.js')}}" ></script >

@endsection
@section('title','Ecommerce shop')
@section('content')

    <section class="cart" >
        <div class="container is-max-widescreen" >
            <div class="table-container" >
                <table class="table is-fullwidth mt-5" >
                    <thead >
                    <tr >
                        <th ><abbr id="table-title" title="Товар" >Товар</abbr ></th >
                        <th ><abbr title="Цена" >Цена</abbr ></th >
                        <th ><abbr title="Количество" >Количество</abbr ></th >
                        <th ><abbr title="Сумма" >Сумма</abbr ></th >

                    </tr >
                    </thead >
                    <tfoot ></tfoot >
                    <tbody >

                    @foreach($productList as $product)
                        <tr class="cart-row" data-price="{{ $product['product_price']}}" data-product_id="{{
                    $product['product_id']}}" >
                            <td class="cart-item" >
                                <div class="cart-item__icon" >
                                    <img
                                        src="{{ asset('storage/uploads/' .$product['product_image'])}}"

                                        alt=""
                                        srcset=""
                                    />
                                </div >
                                <a
                                    href="/{{$product['product_category'] . "/" . $product['product_id'] }}"
                                    title="{{ $product['product_title']}}"
                                >
                                    {{ $product['product_title']}}</a >
                            </td >
                            <td class="price" > {{ number_format($product['product_price'],0,',',' ')}}</td >
                            <td >
                                <div class="quantity" >
                                    {{ $product['quantity']}}
                                </div >
                            </td >
                            <td ><span class
                                       ="finalPrice" >{{number_format($product['product_price'] * $product['quantity'],0,',',' ')  }}</span >
                            </td >

                        </tr >
                    @endforeach
                    </tbody >
                </table >
            </div >

                <form class="cart-continue mt-5 is-flex is-justify-content-flex-end" action="{{route('order-confirmed')}}" method="POST" >
                    @csrf
                    <div class='user-data cart-summary is-flex is-flex-direction-column is-justify-content-space-around
            is-align-items-center' >
                        <div class="field" >
                            <label for="name" class="label" >Имя</label >
                            <p class="control has-icons-left" >
                                <input id="name" class="input @error('name') is-danger @enderror" name="name"
                                       type="text"
                                       placeholder="Имя"
                                       value="{{ old('name') }}"/>

                                <span class="icon is-small is-left" >
                                <i class="fas fa-user" ></i >
                            </span >
                            </p >
                            @error('name')
                            <p class="help is-danger" >{{ $message }}</p >
                            @enderror
                        </div >
                        <div class="field" >
                            <label for="phone_number" class="label" >Номер телефона</label >
                            <p class="control has-icons-left" >
                                <input id="phone_number" class="input @error('phone_number') is-danger @enderror"
                                       name="phone_number"
                                       type="text"
                                       placeholder="Номер телефона"
                                       value="{{ old('phone_number') }}"/>
                                <span class="icon is-small is-left" >
                                <i class="fas fa-phone" ></i >
                            </span >
                            </p >
                            @error('phone_number')
                            <p class="help is-danger" >{{ $message }}</p >
                            @enderror
                        </div >
                        <div class="field" >
                            <label for="email" class="label" >Email</label >
                            <p class="control has-icons-left " >
                                <input id="email" class="input @error('email') is-danger @enderror"
                                       name="email" type="email"
                                       placeholder="Email"
                                       value="{{ old('email') }}"/>
                                <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
                            </p >
                            @error('email')
                            <p class="help is-danger" >{{ $message }}</p >
                            @enderror
                        </div >
                        <div class="field" >
                            <label class="label" >Сообщение</label >
                            <div class="control" >
                                <textarea class="textarea"  name="message" placeholder="Сообщение" ></textarea >
                            </div >
                        </div >
                    </div >
                    <div
                        class="cart-summary  is-flex is-flex-direction-column is-justify-content-space-around
                    is-align-items-center ml-6"
                    >
                        <h2 class="cart-summary__title has-text-weight-bold is-size-4" >
                            Итого
                        </h2 >
                        <div class="cart-summary__divider" ></div >
                        <div
                            class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
                        >
                            <span class="cart-summary__sum--text" >Товаров на</span >
                            <div >
                        <span
                            class="cart-summary__sum--number has-text-weight-bold"
                        >{{number_format($sum - 944,0,',',' ')}}</span >
                                <span class="has-text-weight-bold" > р.</span >
                            </div >
                        </div >
                        <div
                            class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
                        >
                    <span class="cart-summary__sum--text" >Доставка</span
                    ><span class="cart-delivery-price has-text-weight-bold"
                            >944 <span >р.</span ></span
                            >
                        </div >
                        <div
                            class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
                        >
                    <span class="cart-summary__sum--text" >Всего к оплате</span
                    ><span
                                class="cart-summary__sum--number-final has-text-weight-bold"
                            >{{ number_format($sum,0,',',' ') }}
                        <span >р.</span ></span
                            >
                        </div >
                        <button type="submit" class="button is-success is-fullwidth mt-6" >
                            Оформить
                        </button >
                </div >
                </form >



        </div >
    </section >
    <section
        class="noitems is-flex-direction-column is-justify-content-center is-align-items-center"
    >
        <h1 class="noitems-title" >Нет товаров в корзине...</h1 >
        <h2 class="has-text-grey has-text-weight-bold is-size-5 mt-6" >
            Найдите товары в нашем каталоге или воспользуйтесь поиском
        </h2 >
        <a href="/" class="button is-warning mt-6" >На главную</a >
    </section >
@endsection
