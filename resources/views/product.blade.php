
   @extends('layouts.default')
   @section('scripts', )
        <script defer src="/js/app.js"></script>

   @endsection
   @section('title','Ecommerce shop')
   @section('content')

        <div class="container is-max-widescreen">
            <nav class="breadcrumb mt-3" aria-label="breadcrumbs">
                <ul>
                    <li><a href="#">Главная</a></li>

                    <li class="is-active">
                        <a href="#" aria-current="page">Смартфоны</a>
                    </li>
                </ul>
            </nav>
            <section class="item">
                <h1 class="item-name has-text-left is-size-3 mt-5">
                    {{ $productItem->title}}
                </h1>
                <div class="item-art is-flex is-align-items-center mt-5">
                    <div class="vendorcode has-text-grey-light">
                        Артикул {{ $productItem->vendorcode }}
                    </div>
                    <div
                        class="stars is-flex is-justify-content-space-between is-align-items-center"
                    >
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="rating ml-2">3</div>
                    <div class="reviewers-number has-text-grey-light ml-2">
                        (7)
                    </div>
                </div>
                <div
                    class="item-main mt-5 is-flex is-justify-content-start"
                >
                    <div
                        class="item-main-gallery is-flex is-justify-content-center is-align-items-center"
                    >
                        <img
                            src="{{ asset('storage/uploads/' . explode(',',$productItem->images)[0]) }}"
                            alt=""
                            srcset=""
                        />
                    </div>
                    <div
                        class="item-main__specs mt-3  is-flex is-flex-direction-column is-justify-content-space-between is-align-items-end"
                    >
                        <ul>
                            @if($productItem->vendorcode)
                            <li>
                                <span class="has-text-grey-light is-size-7"
                                    >Артикул: </span
                                ><span>{{$productItem->vendorcode}}</span>
                            </li>
                            @endif

                            @if($productItem->manufacturer)
                            <li>
                                <span class="has-text-grey-light is-size-7"
                                    >Производитель: </span
                                ><span>{{$productItem->manufacturer}}</span>
                            </li>
                            @endif

                            @if($productItem->diagonal)
                            <li>
                                <span class="has-text-grey-light is-size-7"
                                    >Диагональ экрана, в дюймах: </span
                                ><span>{{$productItem->diagonal}}</span>
                            </li>
                            @endif

                            @if($productItem->ram)
                            <li>
                                <span class="has-text-grey-light is-size-7"
                                    >Встроенная память, в Гб: </span
                                ><span>{{$productItem->ram}}</span>
                            </li>
                            @endif


                            @if($productItem->camera)
                            <li>
                                <span class="has-text-grey-light is-size-7"
                                    >Фотокамера, Мп: </span
                                ><span>{{$productItem->camera }}</span>
                            </li>
                            @endif


                            <li>
                                <a class="is-size-7" href="/"
                                    >Все характеристики</a
                                >
                            </li>
                        </ul>
                    </div>
                    <div
                        class="item-main__addtocart mt-1  is-flex is-flex-direction-column is-justify-content-start is-align-items-end"
                    >
                        <div class="oldprice has-text-grey is-size-4">
                            <?php  $percent = rand(5,15);
                            $discount = $percent*(int)$productItem->price/100;
                            $discount = round($discount);

                            ?>
                            <span class="oldprice-item">{{number_format(round((int)$productItem->price + $discount), 0, ',', ' ')}} р.</span>

                            <span class="tag is-success discount"
                                >-{{number_format(round($discount), 0, ',', ' ')}} р.</span>
                        </div>

                        <div class="price has-text-weight-bold is-size-3">
                            {{number_format(round((int)$productItem->price + $discount), 0, ',', ' ')}} р.
                        </div>

                        <button class="button is-primary mt-5">
                            Добавить в корзину
                        </button>
                    </div>
                </div>
            </section>
        </div>
        @endsection


