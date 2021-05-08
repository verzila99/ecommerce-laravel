@extends('layouts.default')
@section('scripts', )
     <script defer src="js/cart.js"></script>

@endsection
@section('title','Ecommerce shop')
@section('content')

 <section class="cart">
    <div class="container is-max-widescreen">
        <table class="table is-fullwidth mt-5">
            <thead>
                <tr>
                    <th><abbr title="Товар">Товар</abbr></th>
                    <th><abbr title="Цена">Цена</abbr></th>
                    <th><abbr title="Количество">Количество</abbr></th>
                    <th><abbr title="Сумма">Сумма</abbr></th>
                    <th></th>
                </tr>
            </thead>
            <tfoot></tfoot>
            <tbody>
                <tr class="cart-row">
                    <td class="cart-item">
                        <img
                            src="/images/smartphones/100.webp"
                            class="cart-item__icon"
                            alt=""
                            srcset=""
                        />
                        <a
                            href="https://en.wikipedia.org/wiki/Leicester_City_F.C."
                            title="Leicester City F.C."
                        >
                            Apple iPhone 11 64GB (чёрный)</a
                        >
                    </td>
                    <td class="price">38000</td>
                    <td>
                        <div class="quantity">
                            <button class="button is-primary decrease-quantity">
                                -
                            </button>
                            <input type="text" name="" value="1" />
                            <button class="button is-primary increase-quantity">
                                +
                            </button>
                        </div>
                    </td>
                    <td class="finalPrice"></td>
                    <td class="deleteItem"><i class="fas fa-times"></i></td>
                </tr>
                <tr class="cart-row">
                    <td class="cart-item">
                        <img
                            src="/images/smartphones/100.webp"
                            class="cart-item__icon"
                            alt=""
                            srcset=""
                        />
                        <a
                            href="https://en.wikipedia.org/wiki/Leicester_City_F.C."
                            title="Leicester City F.C."
                        >
                            Apple iPhone 11 64GB (чёрный)</a
                        >
                    </td>
                    <td class="price">38000</td>
                    <td>
                        <div class="quantity">
                            <button class="button is-primary decrease-quantity">
                                -
                            </button>
                            <input
                                class="quantity"
                                type="text"
                                name=""
                                value="1"
                            />
                            <button class="button is-primary increase-quantity">
                                +
                            </button>
                        </div>
                    </td>
                    <td class="finalPrice"></td>
                    <td class="deleteItem"><i class="fas fa-times"></i></td>
                </tr>
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
                    ><span class="has-text-weight-bold"
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
    <a href="/" class="button is-link mt-6">На главную</a>
</section>
@endsection


