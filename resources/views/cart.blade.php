@extends('layouts.default')
@section('scripts', )

     <script defer src="{{ asset('js/app.js')}}"></script>
     <script defer src="{{ asset('js/cart.js')}}"></script>

@endsection
@section('title','Ecommerce shop')
@section('content')

 <section class="cart">
     <div class="container is-max-widescreen">
        <table class="table is-fullwidth mt-5">
            <thead>
                <tr>
                    <th ><abbr id="table-title" title="Товар">Товар</abbr></th>
                    <th><abbr title="Цена">Цена</abbr></th>
                    <th><abbr title="Количество">Количество</abbr></th>
                    <th><abbr title="Сумма">Сумма</abbr></th>
                    <th></th>
                </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
            @foreach($productList as $product)
                <tr class="cart-row" data-price="{{ $product->price}}" data-product_id="{{
                    $product->product_id}}">
                    <td class="cart-item">
                        <div class="cart-item__icon">
                        <img
                            src="{{ asset('storage/uploads/' . explode(',',$product->images)[0])}}"

                            alt=""
                            srcset=""
                        />
                        </div >
                        <a
                            href="https://en.wikipedia.org/wiki/Leicester_City_F.C."
                            title="Leicester City F.C."
                        >
                            {{ $product->title}}</a
                        >
                    </td>
                    <td class="price"> {{ $product->price}}</td>
                    <td>
                        <div class="quantity">
                            <button class="button is-primary decrease-quantity">
                                -
                            </button>
                            <input class="quantity-of-products" type="text" name="" value="1" />
                            <button class="button is-primary increase-quantity">
                                +
                            </button>
                        </div>
                    </td>
                    <td ><span class
                        ="finalPrice"></span></td>
                    <td  class="delete-item"  ><i class="fas fa-times"></i></td>
                </tr>
               @endforeach
            </tbody>
        </table>
        <div class="cart-continue mt-5 is-flex is-justify-content-flex-end">
            <div
                class="cart-summary is-flex is-flex-direction-column is-justify-content-space-around is-align-items-center"
            >
                <h2 class="cart-summary__title has-text-weight-bold is-size-4">
                    Итого
                </h2>
                <div class="cart-summary__divider"></div>
                <div
                    class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
                >
                    <span class="cart-summary__sum--text">Товаров на</span>
                    <div>
                        <span
                            class="cart-summary__sum--number has-text-weight-bold"
                        ></span>
                        <span class="has-text-weight-bold"> р.</span>
                    </div>
                </div>
                <div
                    class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
                >
                    <span class="cart-summary__sum--text">Доставка</span
                    ><span class="cart-delivery-price has-text-weight-bold"
                        >944 <span>р.</span></span
                    >
                </div>
                <div
                    class="cart-summary__sum is-flex is-justify-content-space-between is-align-items-center"
                >
                    <span class="cart-summary__sum--text">Всего к оплате</span
                    ><span
                        class="cart-summary__sum--number-final has-text-weight-bold"
                    >
                        <span>р.</span></span
                    >
                </div>
                <button class="button is-success is-fullwidth mt-6">
                    Оформить
                </button>
            </div>
        </div>
    </div>
</section>
<section
    class="noitems is-flex-direction-column is-justify-content-center is-align-items-center"
>
    <h1 class="noitems-title">Нет товаров в корзине...</h1>
    <h2 class="has-text-grey has-text-weight-bold is-size-5 mt-6">
        Найдите товары в нашем каталоге или воспользуйтесь поиском
    </h2>
    <a href="/" class="button is-warning mt-6">На главную</a>
</section>
@endsection
