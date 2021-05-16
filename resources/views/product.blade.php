@extends('layouts.default')
@section('scripts')
    <script defer src="/js/app.js" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')

    <div class="container is-max-widescreen" >
        <nav class="breadcrumb mt-3" aria-label="breadcrumbs" >
            <ul >
                <li ><a href="/" >Главная</a ></li >

                <li >
                    <a href="{{'/' . $product->category_name}}"
                       aria-current="page" >{{ $product->category_name_ru }}</a >
                </li >
            </ul >
        </nav >
        <section class="item" >
            <h1 class="item-name has-text-left is-size-3 mt-5" >
                {{ $product->title}}
            </h1 >
            <div class="item-art is-flex is-align-items-center mt-5" >
                <div class="vendorcode has-text-grey-light" >
                    Артикул {{ $product->vendorcode }}
                </div >
                <div
                    class="stars is-flex is-justify-content-space-between is-align-items-center"
                >
                    <i class="fas fa-star" ></i >
                    <i class="fas fa-star" ></i >
                    <i class="fas fa-star" ></i >
                    <i class="far fa-star" ></i >
                    <i class="far fa-star" ></i >
                </div >
                <div class="rating ml-2" >3</div >
                <div class="reviewers-number has-text-grey-light ml-2" >
                    (7)
                </div >

            </div >
            <div
                class="item-main mt-5 is-flex is-justify-content-start"
            >
                <div
                    class="item-main-gallery is-flex is-justify-content-center is-align-items-center"
                >
                    <img
                        src="{{ asset('storage/uploads/' . explode(',',$product->images)[0]) }}"
                        alt=""
                        srcset=""
                    />
                </div >
                <div
                    class="item-main__specs mt-5  is-flex
                    is-flex-direction-column is-justify-content-space-between
                     is-align-items-flex-start"
                >
                    <ul >
                        @if($product->vendorcode)
                            <li >
                                <span class="has-text-grey-light is-size-7"
                                >Артикул: </span
                                ><span
                                    class="is-size-8" >{{$product->vendorcode}}</span >
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

                        @if($product->diagonal)
                            <li >
                                <span class="has-text-grey-light is-size-7"
                                >Диагональ экрана, в дюймах: </span
                                ><span
                                    class="is-size-8" >{{$product->diagonal}}</span >
                            </li >
                        @endif

                        @if($product->memory)
                            <li >
                                <span class="has-text-grey-light is-size-7"
                                >Встроенная память, в Гб: </span
                                ><span class
                                       ="is-size-8" >{{$product->memory}}</span >
                            </li >
                        @endif


                        @if($product->camera)
                            <li >
                                <span class="has-text-grey-light is-size-7"
                                >Фотокамера, Мп: </span
                                ><span
                                    class="is-size-8" >{{$product->camera }}</span >
                            </li >
                        @endif

                        <li >
                            <a class="is-size-7 mt-6 dark-link" href="/"
                            >Все характеристики ></a
                            >
                        </li >
                    </ul >
                    @auth
                        @if($favoritesStatus===0)
                            <a class="favorites favorites-item is-flex
                    is-align-items-center " data-category="{{
                    $product->category_name }}"
                               data-productId="{{$product->product_id}}"
                               data-status="{{ $favoritesStatus }}" >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="far fa-heart" ></i >
                        </span >
                                <p class=" has-text-grey-lighter is-size-6
                        has-text-weight-bold ml-3"
                                >В избранное</p >
                            </a >
                        @else
                            <a class="favorites favorites-item is-flex
                    is-align-items-center " data-category="{{
                    $product->category_name }}"
                               data-productId="{{$product->product_id}}"
                               data-status="{{ $favoritesStatus }}" >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="fas fa-heart" ></i >

                        </span >
                                <p class=" has-text-grey-lighter is-size-6
                        has-text-weight-bold ml-3"
                                >В избранном</p >
                            </a >

                        @endif
                    @endauth
                    @guest
                        <a id="favorite-guest" class="favorites favorites-item is-flex
                    is-align-items-center " >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="far fa-heart" ></i >
                        </span >
                            <p class=" has-text-grey-lighter is-size-6
                        has-text-weight-bold ml-3"
                            >В
                             избранное</p >
                        </a >
                    @endguest

                </div >
                <div
                    class="item-main__addtocart mt-4  is-flex
                        is-flex-direction-column is-justify-content-start
                        is-align-items-flex-start"
                >
                    <div class="oldprice has-text-grey is-size-5" >
                        @php
                            $oldPrice=(round((int)
                                    $product->price + round((random_int
                                    (5,15) *  ((int)$product->price /
                                    100)))))
                        @endphp

                        <span class="oldprice-item" >{{
                                    number_format($oldPrice, 0,',', ' ')}} р.</span >
                        <span class="tag is-success discount"
                        >-{{ number_format(((int)$oldPrice - (int)
                                $product->price), 0, ',', ' ')}} р.</span >
                    </div >

                    <div class="price has-text-weight-bold is-size-3 mt-3" >
                        {{ number_format(round((int)
                               $product->price), 0, ',', ' ')}} р.
                    </div >

                    <button class="button is-primary mt-5" data-product_id="{{$product->product_id}}">
                        Добавить в корзину
                    </button >

                </div >
            </div >
        </section >
    </div >
@endsection
