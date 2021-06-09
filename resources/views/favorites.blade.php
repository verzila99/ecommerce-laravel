@extends('layouts.default')
@section('scripts')
    <script defer src="{{ asset('js/app.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')
    <div class="container is-max-widescreen">
@if (isset($productList))
        <div class="category-filter__total is-flex
                is-align-items-center is-size-4
                has-text-grey-light
                " >Найдено товаров: {{$totalItems}}</div >
        @foreach( $productList as $product)
            <div class="category-list__item box is-flex mt-3" >
                <a href="/{{ $product->category . "/" .
                        $product->id
                         }}"
                   class="category-list__item-image is-flex" >

                    <img
                        src="{{ asset('storage/uploads/images/'.$product->id.'/225x225/' . explode(',',$product->images)
                [0]) }}"
                        alt=""
                        srcset=""
                    />
                </a >
                <div
                    class="category-list__item-props is-flex
                            is-flex-direction-column is-align-content-flex-end  is-justify-content-flex-start"
                >
                    <h2 class="is-size-6 mt-5" >
                        {{ $product->title}}
                    </h2 >
                    <div class="is-flex is-align-items-center mt-2" >
                        <div
                            class="category-list__item-props-review is-flex is-justify-content-space-between is-align-items-center"
                        >
                            <i class="fas fa-star" ></i >
                            <i class="fas fa-star" ></i >
                            <i class="fas fa-star" ></i >
                            <i class="far fa-star" ></i >
                            <i class="far fa-star" ></i >
                        </div >
                        <div
                            class="category-list__item-props-review rating ml-2"
                        >
                            {{  $product->product_views ?? 0 }}
                        </div >
                        <div
                            class="category-list__item-props-review reviewers-number has-text-grey-light ml-2"
                        >
                            (7)
                        </div >
                        <div
                            class="category-list__item-props-review has-text-grey-light ml-2"
                        >
                            Артикул {{ $product->vendorcode }}
                        </div >
                    </div >
                    <div
                        class="item-main-specs is-flex
                                is-flex-direction-column
                                is-justify-content-space-between
                                is-align-items-flex-start mt-2"
                    >
                        <ul >
                            @if($product->vendorcode)
                                <li >
                            <span class="has-text-grey-light is-size-7"
                            >Артикул: </span
                            ><span >{{$product->vendorcode}}</span >
                                </li >
                            @endif

                            @if($product->manufacturer)
                                <li >
                            <span class="has-text-grey-light is-size-7"
                            >Производитель: </span
                            ><span
                                        class="is-size-8" >{{$product->manufacturer}}</span >
                                </li >
                            @endif
                              @foreach($product->properties  as $param)

                                @if($param->name)
                                  <li >
                            <span class="has-text-grey-light is-size-7 is-capitalized"
                            >{{ $param->name_ru}}: </span
                            ><span class="is-size-8" >{{$param->pivot->value}}</span >
                                  </li >
                                @endif

                              @endforeach
                        </ul >

                    </div >
                </div >
                <div class="category-list__item-price my-5 " >
                    <div
                        class="item-main-addtocart ml-6 is-flex
                                is-flex-direction-column
                                is-justify-content-flex-start
                                is-align-items-flex-start"
                    >
                        <div
                            class="oldprice has-text-grey is-size-5 is-flex is-justify-content-space-between" >

                            @php
                                $oldPrice=(round((int)
                                        $product->price + round(
                                        (random_int
                                        (5,15) *  ((int)
                                        $product->price /
                                        100)))))
                            @endphp

                            <span class="oldprice-item" >{{
                                    number_format($oldPrice, 0,  ',', ' ')}}
                                        р.</span >
                            <span class="tag is-success discount"
                            >-{{ number_format(((int)$oldPrice - (int)
                                $product->price), 0, ',', ' ')}} р.</span >
                        </div >

                        <div
                            class="price has-text-weight-bold
                                    is-size-3 mt-3" >
                            {{ number_format(round((int)
                                   $product->price), 0, ',', ' ')}}
                            р.
                        </div >
                        <button class="button is-primary mt-5
                                add-to-cart"
                                data-id="{{$product->id}}" >
                            Добавить в корзину
                        </button >
                        @auth
                            @if( !str_contains($favoritesStatusList,$product->id))
                                <a class="favorites favorites-list light-link is-flex
                    is-align-items-center " data-category="{{
                    $product->category }}"
                                   data-productId="{{$product->id}}"
                                   data-status="0" >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="far fa-heart" ></i >
                        </span >
                                    <p class=" has-text-grey-lighter is-size-7
                        has-text-weight-bold ml-3"
                                    >В избранное</p >
                                </a >
                            @else
                                <a class="favorites favorites-list light-link is-flex
                    is-align-items-center " data-category="{{
                    $product->category }}"
                                   data-productId="{{$product->id}}"
                                   data-status="1" >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="fas fa-heart" ></i >

                        </span >
                                    <p class=" has-text-grey-lighter is-size-7
                        has-text-weight-bold ml-3"
                                    >В избранном</p >
                                </a >

                            @endif
                        @endauth
                        @guest
                            <a id="favorite-guest" class="favorites favorites-list light-link is-flex
                    is-align-items-center" >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="far fa-heart" ></i >
                        </span >
                                <p class=" has-text-grey-lighter is-size-7
                        has-text-weight-bold ml-3"
                                >В
                                 избранное</p >
                            </a >
                        @endguest
                    </div >
                </div >
            </div >
        @endforeach

        {{$paginator->appends(request()->query())->links('paginate.paginate')}}
@else
            <section
                class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center order-success"
            >
                <h1 class="noitems-title" >Здесь пока пусто...</h1 >
                <h2 class="has-text-grey has-text-weight-bold is-size-5 mt-6" >
                    Добавьте товары в избранное.
                </h2 >
                <a href="/" class="button is-warning mt-6" >На главную</a >
            </section >
    </div>



@endif
@endsection
