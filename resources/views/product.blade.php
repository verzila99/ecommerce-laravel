@extends('layouts.default')
@section('scripts')
    <script defer src="{{ asset('js/slider-product.js')}}" ></script >
    <script defer src="{{ asset('js/app.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')

    <div class="container is-max-widescreen" >
        <nav class="breadcrumb mt-3" aria-label="breadcrumbs" >
            <ul >
                <li ><a href="/" >Главная</a ></li >

                <li >
                    <a class="is-capitalized" href="{{'/' . $product->category_name}}"
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
                    class="stars-container is-flex is-justify-content-space-between is-align-items-center"
                >
                  <div class="stars-inactive" >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >

                  </div>
                  <div class="stars-active" style="width:50%">
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >

                  </div >

                </div >
                <div class="rating ml-2" >3</div >
                <div class="reviewers-number has-text-grey-light ml-2" >
                    (7)
                </div >

            </div >
            <div
                class="item-main mt-5 is-flex is-justify-content-space-between"
            >
                <div
                    class="item-main-gallery is-flex is-justify-content-center is-align-items-center is-flex-shrink-1
                     "
                >
                    <div class="slider-container__main my-5" >
                        <div class="slider-container" >
                            <div class="slider" >

                                @foreach ( explode(',',$product->images) as $image)
                                    <div class="slide-product" >

                                        <img src="{{ asset('storage/uploads/images/'.$product->product_id.'/700x700/'
                                         . $image )}}" alt="{{
                                    $product->title
                                    }}" />

                                    </div >

                                @endforeach
                            </div >
                        </div >
                        <a class="fullscreen-slider-button" >
                            <i class="fas fa-search-plus" ></i >
                        </a >
                        <div class="arrow-left__container" >
                            <div class="product-arrow-left" ></div >
                        </div >
                        <div class="arrow-right__container" >
                            <div class="product-arrow-right" ></div >
                        </div >
                        <div class="product-dot-container" >
                            <div class="dot-product-container" >
                                @foreach ( explode(',',$product->images) as $key=>$image)
                                    <div class="dot-product" data-index="{{$key}}" >
                                        <img src="{{ asset('storage/uploads/images/'.$product->product_id.'/45x45/' .
                                         $image )}}" alt="" >
                                    </div >
                                @endforeach
                            </div >
                        </div >

                    </div >
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

                        @foreach($props as $param)
                            @php
                                $name = $param->name

                            @endphp

                            @if($product->$name)
                                <li >
                            <span class="has-text-grey-light is-size-7 is-capitalized"
                            >{{ $param->name_ru}}: </span
                            ><span class="is-size-8" >{{$product->$name}}</span >
                                </li >
                            @endif

                        @endforeach

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

                    <a class="add-to-cart button is-primary mt-5" data-product_id="{{$product->product_id}}" >
                        Добавить в корзину
                    </a >

                </div >
            </div >
        </section >
    </div >

    <div class="modal fullscreen-slider" >
        <div class="modal-background slider-background" ></div >
        <div class="modal-content fullscreen-slider-content " >

            <div class="slider-container__main " >
                <div class="slider-container" >
                    <div class="slider" >

                        @foreach ( explode(',',$product->images) as $image)
                            <div class="slide-product" >

                                <img src="{{ asset('storage/uploads/images/'.$product->product_id.'/700x700/' . $image )}}" alt="{{
                            $product->title
                            }}" />

                            </div >

                        @endforeach
                    </div >
                </div >
                <div class="arrow-left__container" >
                    <div class="fullscreen-product-arrow-left" ></div >
                </div >
                <div class="arrow-right__container" >
                    <div class="fullscreen-product-arrow-right" ></div >
                </div >
                <div class="fullscreen-slider-dot-container" >
                    <div class="dot-product-container" >
                        @foreach ( explode(',',$product->images) as $key=>$image)
                            <div class="dot-product" data-index="{{$key}}" >
                                <img src="{{ asset('storage/uploads/images/'.$product->product_id.'/45x45/' . $image
                                )}}" alt="" >
                            </div >
                        @endforeach
                    </div >
                </div >
            </div >

        </div >
        <button class="modal-close fullscreen-slider-close is-large" aria-label="close" ></button >
    </div >


@endsection
