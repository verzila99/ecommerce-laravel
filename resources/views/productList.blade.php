
   @extends('layouts.default')
   @section('scripts')
        <script defer src="{{ asset('js/app.js')}}"></script>
        <script defer src="{{ asset('js/category.js')}}"></script>
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
    <h1 class="has-text-weight-bold is-size-4 is-capitalized">{{ $currentCategory->name_ru }}</h1>
    <div class="category-container is-flex">
        <aside
            class="category-filter is-flex is-flex-direction-column is-justify-content-flex-start is-align-items-end"
        >
            <div class="category-filter__total mt-3"></div>
            <div
                class="category-filter__price mt-3 is-flex is-flex-direction-column is-align-items-end is-justify-content-space-between"
            >
                <div
                    class="category-filter__title is-flex is-justify-content-space-between is-align-items-center"
                >
                    <h4>Цена</h4>
                    <div class="category-filter__arrow"></div>
                </div>
                <div
                    class="category-filter__price-input is-flex is-justify-content-space-between is-align-items-center mt-5"
                >
                    <div
                        class="price-input__from is-flex is-align-items-center is-justify-content-space-between pl-2"
                    >
                        <label for="begin-price">от</label>
                        <input
                            class="ml-4"
                            type="text"
                            id="begin-price"

                            placeholder="400"
                            autocomplete="off"
                        />
                    </div>
                    <div
                        class="price-input__to is-flex is-align-items-center is-justify-content-space-between pl-2"
                    >
                        <label for="end-price">до</label>
                        <input
                            class="ml-4"
                            type="text"
                            id="end-price"

                            placeholder="400000"
                            autocomplete="off"
                        />
                    </div>
                </div>
            </div>
            <div
                class="category-filter__brands accordion-group mt-3 is-flex is-flex-direction-column is-align-items-end is-justify-content-space-between"
            >
            <div
            class="category-filter__title is-flex is-justify-content-space-between is-align-items-center my-4"
        >
            <h4>Производители</h4>
            <div class="category-filter__arrow"></div>
        </div>
        <div class="accordion">
        <label class="checkbox">
            <input type="checkbox">
            iPhone
          </label>
          <label class="checkbox">
            <input type="checkbox">
            Huawei
          </label>
          <label class="checkbox">
            <input type="checkbox">
            Xiaomi
          </label>
        </div>
    </div>
            <div
                class="category-filter__ram accordion-group mt-3 is-flex is-flex-direction-column is-align-items-end is-justify-content-space-between" id='ram'
            >
            <div
            class="category-filter__title  is-flex is-justify-content-space-between is-align-items-center  my-4"
        >
            <h4>Оперативная память</h4>
            <div class="category-filter__arrow"></div>

        </div>
        <div class="accordion">
        <label class="checkbox">
          <input type="checkbox" class="ram">
          1 GB
        </label>
        <label class="checkbox">
            <input type="checkbox" class="ram">
            2 GB
          </label>
          <label class="checkbox">
            <input type="checkbox" class="ram">
            4 GB
          </label>
          <label class="checkbox">
            <input type="checkbox" class="ram">
            6 GB
          </label>
          <label class="checkbox">
            <input type="checkbox" class="ram">
            8 GB
          </label>

        </div>
    </div>
        </aside>
        <main
            class="category-list ml-4 is-flex is-flex-direction-column is-justify-content-flex-start"
        >
            <div
                class="category-list__sorting is-flex is-justify-content-flex-start is-align-items-center mt-3"
            >
                <p>Сортировать по:</p>
                <button class="button is-inverted is-primary ml-5">
                    Популярности
                </button>
                <button class="button is-inverted is-dark">Цене</button>
                <button class="button is-inverted is-dark">Рейтингу</button>
                <button class="button is-inverted is-dark">Новизне</button>
            </div>
            @foreach( $productList as $product)
            <div class="category-list__item box is-flex mt-3">
                <a href="/{{$currentCategory->name . "/" . $product->id  }}" class="category-list__item-image is-flex">

                        <img
                            src="{{ asset('storage/uploads/' . explode(',',$product->images)[0]) }}"
                            alt=""
                            srcset=""
                    />
                </a>
                <div
                    class="category-list__item-props is-flex is-flex-direction-column is-align-content-end is-justify-content-flex-start"
                >
                    <h2 class="is-size-6 mt-5" >
                        {{ $product->title}}
                    </h2>
                    <div class="is-flex is-align-items-center mt-2">
                        <div
                            class="category-list__item-props-review is-flex is-justify-content-space-between is-align-items-center"
                        >
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <div
                            class="category-list__item-props-review rating ml-2"
                        >
                            3
                        </div>
                        <div
                            class="category-list__item-props-review reviewers-number has-text-grey-light ml-2"
                        >
                            (7)
                        </div>
                        <div
                            class="category-list__item-props-review has-text-grey-light ml-2"
                        >
                            Артикул {{ $product->vendorcode }}
                        </div>
                    </div>
                    <div
                        class="item-main-specs is-flex is-flex-direction-column is-justify-content-space-between is-align-items-end mt-2"
                    >
                    <ul>
                        @if($product->vendorcode)
                        <li>
                            <span class="has-text-grey-light is-size-7"
                                >Артикул: </span
                            ><span>{{$product->vendorcode}}</span>
                        </li>
                        @endif

                        @if($product->manufacturer)
                        <li>
                            <span class="has-text-grey-light is-size-7"
                                >Производитель: </span
                            ><span>{{$product->manufacturer}}</span>
                        </li>
                        @endif

                        @if($product->diagonal)
                        <li>
                            <span class="has-text-grey-light is-size-7"
                                >Диагональ экрана, в дюймах: </span

                            ><span>{{$product->diagonal}}</span>
                        </li>
                        @endif

                        @if($product->ram)
                        <li>
                            <span class="has-text-grey-light is-size-7"
                                >Встроенная память, в Гб: </span
                            ><span>{{$product->ram}}</span>
                        </li>
                        @endif


                        @if($product->camera)
                        <li>
                            <span class="has-text-grey-light is-size-7"
                                >Фотокамера, Мп: </span
                            ><span>{{$product->camera }}</span>
                        </li>
                        @endif
                    </ul>
                    </div>
                </div>
                <div class="category-list__item-price my-5">
                    <div
                        class="item-main-addtocart ml-6 is-flex is-flex-direction-column is-justify-content-start is-align-items-end"
                    >
                    <div class="oldprice has-text-grey is-size-4">
                        <?php  $percent = random_int(5,15);
                        $discount = $percent * (int)$product->price / 100;
                        $discount = round($discount);

                        ?>
                        <span class="oldprice-item">{{number_format(round((int)$product->price + $discount), 0, ',', ' ')}} р.</span>

                        <span class="tag is-success discount"
                            >-{{number_format(round($discount), 0, ',', ' ')}} р.</span>
                    </div>

                    <div class="price has-text-weight-bold is-size-3">
                        {{number_format(round((int)$product->price + $discount), 0, ',', ' ')}} р.
                    </div>
                        <button class="button is-primary mt-5">
                            Добавить в корзину
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </main>
    </div>

@endsection
