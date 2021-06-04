@extends('layouts.default')
@section('scripts')
  <script defer src="{{ asset('/js/app.js')}}" ></script >
  <script defer src="{{ asset('/js/category.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')


  <div class="container is-max-widescreen" >
    <nav class="breadcrumb mt-3" aria-label="breadcrumbs" >
      <ul >
        <li ><a class="light-link" href="/" >Главная</a ></li >

        <li class="is-active" >
          <a href="#" aria-current="page" >Смартфоны</a >
        </li >
      </ul >
    </nav >
    <h1 class="has-text-weight-bold is-size-4 is-capitalized" >{{
        $productList->first()->category_name_ru }}</h1 >
    <div class="category-container is-flex" >
      <aside
        class="category-filter is-flex is-flex-direction-column is-justify-content-flex-start is-align-items-end"
      >
        <div class="category-filter__total is-flex
                is-align-items-center is-size-5
                has-text-grey-light
                " >Найдено товаров: {{$productList->total()}}</div >
        <div
          class="category-filter__price accordion-group mt-3 is-flex is-flex-direction-column
                    is-align-items-end is-justify-content-space-between"
        >
          <div
            class="category-filter__title is-flex is-justify-content-space-between is-align-items-flex-end"
          >
            <h4 >Цена</h4 >
            <div class="category-filter__arrow" ></div >
          </div >
          <div class="accordion-price  is-flex
                        is-justify-content-space-between is-align-items-center" >
            <form
              class="accordion-price category-filter__price-input
                        is-flex
                        is-justify-content-space-between is-align-items-center mt-5"
              method="get"
            >
              @csrf

              <div
                class="price-input__from is-flex
                            is-align-items-center is-justify-content-space-between pl-2"
              >
                <label for="price_from" >от</label >
                <input
                  class="ml-4"
                  type="text"
                  id="price_from"

                  placeholder="400"
                  autocomplete="off"
                />
              </div >
              <div
                class="price-input__to is-flex is-align-items-center is-justify-content-space-between pl-2"
              >
                <label for="price_to" >до</label >
                <input
                  class="ml-4"
                  type="text"
                  id="price_to"

                  placeholder="400000"
                  autocomplete="off"
                />
              </div >

            </form >
          </div >

        </div >
        {{--@dd($filterInputs)--}}
        @foreach($filterInputs as $filter=>$variants)
          {{--                                                    @dd(explode('|',$filter)[0])--}}
          @php
            $filterItem =explode('|',$filter)[0];
          @endphp
          <div
            class="category-filter__brands accordion-group mt-3
                        is-flex is-flex-direction-column is-align-items-flex-start is-justify-content-space-between"
          >
            <div
              class="category-filter__title is-flex is-justify-content-space-between is-align-items-flex-end my-4"
            >
              <h4 class="is-capitalized" >{{  explode('|',$filter)[1]}}</h4 >
              <div class="category-filter__arrow" ></div >
            </div >

            <div class="accordion" >
              <div class="accordion-item" >
                <div class="measuring" >
                  @foreach($variants as
                  $variant)
                    @if($variant->$filterItem)
                      <label class="checkbox" >
                        <input type="checkbox"
                               class="manufacturer checkbox-filter"
                               data-parameter='{{$filterItem}}'
                               data-value="{{$variant->$filterItem}}"
                        @foreach($explodedQueryString as $elem)
                          @php
                            $var = explode('=',$elem)
                          @endphp
                            @if( str_contains($var[0],$filterItem) && $var[1]===$variant->$filterItem )
                              {{'checked'}}
                            @endif
                          @endforeach
                        >
                        {{$variant->$filterItem}}
                        <span
                          class="input_count has-text-grey-light
                                 ml-3
                                        " >{{$variant->some_count}}</span >
                      </label >
                    @endif
                  @endforeach
                </div >
              </div >
              <p class="show-more mt-3" >Показать ещё</p >
            </div >

          </div >
        @endforeach
        {{--                <div--}}
        {{--                    class="category-filter__brands accordion-group mt-3--}}
        {{--                    is-flex is-flex-direction-column is-align-items-flex-start is-justify-content-space-between"--}}
        {{--                >--}}
        {{--                    <div--}}
        {{--                        class="category-filter__title is-flex is-justify-content-space-between is-align-items-flex-end my-4"--}}
        {{--                    >--}}
        {{--                        <h4>Производители</h4>--}}
        {{--                        <div class="category-filter__arrow"></div>--}}
        {{--                    </div>--}}

        {{--                    <div class="accordion">--}}
        {{--                        <div class="accordion-item">--}}
        {{--                            <div class="measuring">--}}
        {{--                                @foreach($filterInputs['manufacturers'] as--}}
        {{--                                $manufacturer)--}}
        {{--                                    <label class="checkbox">--}}
        {{--                                        <input type="checkbox"--}}
        {{--                                               class="manufacturer checkbox-filter"--}}
        {{--                                               data-parameter='manufacturer'--}}
        {{--                                               data-value="{{$manufacturer->manufacturer}}"--}}
        {{--                                        @foreach($explodedQueryString as $elem)--}}
        {{--                                            @if( ($elem ===--}}
        {{--                                            $manufacturer->manufacturer ))--}}
        {{--                                                {{'checked'}}--}}
        {{--                                                @endif--}}
        {{--                                            @endforeach--}}
        {{--                                        >--}}
        {{--                                        {{$manufacturer->manufacturer}}--}}
        {{--                                        <span--}}
        {{--                                            class="input_count has-text-grey-light--}}
        {{--                                 ml-3--}}
        {{--                                        ">{{$manufacturer->manufacturer_count}}</span>--}}
        {{--                                    </label>--}}
        {{--                                @endforeach--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <p class="show-more mt-3">Показать ещё</p>--}}
        {{--                    </div>--}}

        {{--                </div>--}}
        {{--                <div--}}
        {{--                    class="category-filter__memory accordion-group mt-3 is-flex--}}
        {{--                    is-flex-direction-column is-align-items-flex-start  is-justify-content-space-between"--}}
        {{--                    id='memory'--}}
        {{--                >--}}
        {{--                    <div--}}
        {{--                        class="category-filter__title  is-flex is-justify-content-space-between is-align-items-flex-end  my-4"--}}
        {{--                    >--}}
        {{--                        <h4>Память</h4>--}}
        {{--                        <div class="category-filter__arrow"></div>--}}

        {{--                    </div>--}}
        {{--                    <div class="accordion">--}}
        {{--                        <div class="accordion-item">--}}
        {{--                            <div class="measuring">--}}
        {{--                                @foreach($filterInputs['memorySize'] as--}}
        {{--                                $memorySize)--}}
        {{--                                    <label class="checkbox">--}}
        {{--                                        <input type="checkbox"--}}
        {{--                                               class="memory checkbox-filter"--}}
        {{--                                               data-parameter='memory'--}}
        {{--                                               data-value="{{$memorySize->memory}}"--}}
        {{--                                        @foreach($explodedQueryString as $elem)--}}
        {{--                                            @if($elem === $memorySize->memory )--}}

        {{--                                                {{'checked'}}--}}
        {{--                                                @endif--}}
        {{--                                            @endforeach--}}
        {{--                                        >--}}
        {{--                                        {{$memorySize->memory}}--}}
        {{--                                        <span--}}
        {{--                                            class="input_count has-text-grey-light--}}
        {{--                                 ml-3">{{$memorySize->memory_count}}--}}
        {{--                                    </span>--}}
        {{--                                    </label>--}}
        {{--                                @endforeach--}}
        {{--                            </div>--}}
        {{--                        </div>--}}
        {{--                        <p class="show-more mt-3">Показать ещё</p>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
      </aside >
      <main
        class="category-list ml-4 is-flex is-flex-direction-column is-justify-content-flex-start"
      >
        <div
          class="category-list__sorting is-flex is-justify-content-flex-start is-align-items-center mt-3"
        >
          <p >Сортировать по:</p >
          @php
            if(preg_match('/\?$/',url($requestUri))){
                    $query = url($requestUri);
            }
            elseIf(preg_match('/&$/',url($requestUri))){
                $query = url($requestUri);
            }elseif(!preg_match('/[\?&]/',url($requestUri))){
                $query = url($requestUri) . '?';
            }else{
                    $query = url($requestUri).'&';
            }
          @endphp
          <a href="{{ $query  . "sort_by=" .
                    "popularity"}}"
             class="button sort-button is-inverted is-primary ml-5"
             data-sort="popularity" >
            Популярности
          </a >

          <a href="{{ $query  . "sort_by=" . "price"}}"
             class="button sort-button is-inverted  ml-3  is-flex is-align-content-center"
             data-sort="price" >Цене
            <span class="arrow arrow-up ml-3" >
                       <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            x="0px" y="0px"
                            viewBox="0 0 49.656 49.656"

                            xml:space="preserve" >
<g >
	<polygon style="fill:#00AD97;"
           points="48.242,35.122 45.414,37.95 24.828,17.364 4.242,37.95 1.414,35.122 24.828,11.707 	" />
	<path style="fill:#00AD97;" d="M45.414,39.363L24.828,18.778L4.242,39.363L0,35.121l24.828-24.828l24.828,24.828L45.414,39.363z
		 M24.828,15.95l20.586,20.585l1.414-1.414l-22-22l-22,22l1.414,1.414L24.828,15.95z" />
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
</svg >


                    </span >
          </a >

          <a href="{{$query . "sort_by=" . "-price"}}"
             class="button sort-button is-inverted  ml-3 is-flex is-align-content-center"
             data-sort="-price" >Цене
            <span class="arrow arrow-down ml-3" >
                        <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                             x="0px" y="0px"
                             viewBox="0 0 49.656 49.656"

                             xml:space="preserve" >
<g >
	<polygon style="fill:#00AD97;"
           points="48.242,35.122 45.414,37.95 24.828,17.364 4.242,37.95 1.414,35.122 24.828,11.707 	" />
	<path style="fill:#00AD97;" d="M45.414,39.363L24.828,18.778L4.242,39.363L0,35.121l24.828-24.828l24.828,24.828L45.414,39.363z
		 M24.828,15.95l20.586,20.585l1.414-1.414l-22-22l-22,22l1.414,1.414L24.828,15.95z" />
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
<g >
</g >
</svg >


                    </span >
          </a >

          <a href="{{ $query  . "sort_by=" . "rating"}}"
             class="button sort-button is-inverted ml-3"
             data-sort="rating" >Рейтингу</a >

          <a href="{{ $query  . "sort_by=" . "newness"}}"
             class="button sort-button is-inverted  ml-3"
             data-sort="newness" >Новизне</a >

        </div >
        @foreach( $productList as $product)
          <div class="category-list__item box is-flex mt-3" >
            <a href="/{{$product->category_name . "/" .
                        $product->product_id
                         }}"
               class="category-list__item-image is-flex" >

              <img
                src="{{ asset('storage/uploads/images/'.$product->product_id.'/225x225/' . explode(',',$product->images)[0]) }}"
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
                  class="stars-container is-flex is-justify-content-space-between is-align-items-center"
                >
                  <div class="stars-inactive" >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >
                    <i class="far fa-star" aria-hidden="true" ></i >

                  </div >
                  <div class="stars-active" style="width:50%" >
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >
                    <i class="fas fa-star" aria-hidden="true" ></i >

                  </div >

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
                  @foreach($props as $param)
                    @php
                      $name = $param->name;

                    @endphp

                    @if($product->$name)
                      <li >
                            <span class="has-text-grey-light is-size-7 is-capitalized"
                            >{{ $param->name_ru}}: </span
                            ><span class="is-size-8" >{{$product->$name}}</span >
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

                <a class="button is-primary mt-5
                                add-to-cart"
                   data-price="{{  $product->price }}"
                   data-category="{{ $product->category_name }}"
                   data-product_id="{{ $product->product_id}}" >
                  Добавить в корзину
                </a >
                @can('updateProduct',App\Models\Product::class)
                  <a
                    href="{{'/product/'. $product->category_name .'/'.$product->product_id .'/edit'}}"
                    class="button is-primary mt-5
                                " >
                    Редактировать
                  </a >
                @endcan
                @auth
                  @if( !str_contains($favoritesStatusList,$product->product_id))
                    <a class="favorites favorites-list light-link is-flex
                    is-align-items-center " data-category="{{
                    $product->category_name }}"
                       data-productId="{{$product->product_id}}"
                       data-status="0" >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="far fa-heart" ></i >
                        </span >
                      <p class=" has-text-grey-lighter is-size-8
                        has-text-weight-bold ml-3"
                      >В избранное</p >
                    </a >
                  @else
                    <a class="favorites favorites-list light-link is-flex
                    is-align-items-center " data-category="{{
                    $product->category_name }}"
                       data-productId="{{$product->product_id}}"
                       data-status="1" >
                        <span class="icon is-size-4 has-text-grey-lighter" >
                    <i class="fas fa-heart" ></i >

                        </span >
                      <p class=" has-text-grey-lighter is-size-8
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
                    <p class=" has-text-grey-lighter is-size-8
                        has-text-weight-bold ml-3"
                    >В
                     избранное</p >
                  </a >
                @endguest
              </div >
            </div >
          </div >
        @endforeach

        {{$productList->appends(request()->query())->links('paginate.paginate')}}

      </main >

    </div >

@endsection
