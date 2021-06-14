@extends('layouts.default')
@section('scripts')
  <script defer src="{{ asset('/js/app.js')}}" ></script >
  <script defer src="{{ asset('/js/category.js')}}" ></script >
@endsection
@section('title','Ecommerce shop')
@section('content')

  <aside
    aria-label="category filter on mobile devices "
    class="category-filter__sidebar " >

    @include('partials.categorySidebar')
  </aside >
  <div class="container is-max-widescreen" >
    <nav class="breadcrumb mt-3" aria-label="breadcrumbs" >
      <ul >
        <li ><a class="light-link" href="/" >Главная</a ></li >

        <li class="is-active" >
          <a href="#" aria-current="page" >Смартфоны</a >
        </li >
      </ul >
    </nav >

    @if ($productList->total()>0)
    <h1 class="has-text-weight-bold is-size-4 is-capitalized" >{{
        $productList->first()->categories->category_name_ru }}</h1 >
    <div class="category-container is-flex is-justify-content-center px-3" >
      <aside class
      ="category-filter is-hidden-touch   is-flex is-flex-direction-column
      is-justify-content-flex-start is-align-items-end
       mr-3" aria-label="category filter"
      >
      <div class="category-filter__total is-flex
                is-align-items-center is-size-5
                has-text-grey-light
                " >Найдено товаров: {{$productList->total()}}</div >
        @include('partials.categorySidebar')
      </aside >

      <main
        class="category-list ml-4 is-flex is-flex-direction-column is-justify-content-flex-start"
      >


        <div
          class="parent-category-list__sorting is-flex is-justify-content-flex-start is-align-items-center mt-3 px-4"
        >
          <p >Сортировать:</p >
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
          <a class=" button is-inverted sorting-button-touch is-hidden-desktop ml-3" >{{$sortingType}}</a >
          <div class="category-list__sorting " >
            <a href="{{ $query  . "sort_by=" .
                    "popularity"}}"
               class="button sort-button is-inverted @if($sortingType==='По популярности') is-primary @endif "
               data-sort="popularity" >
              По популярности
            </a >

            <a href="{{ $query  . "sort_by=" . "price"}}"
               class="button sort-button is-inverted    is-flex is-align-content-center
                @if($sortingType==='Сначала дешевле') is-primary @endif"
               data-sort="price" > По цене
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
               class="button sort-button is-inverted   is-flex is-align-content-center
                      @if($sortingType==='Сначала дороже') is-primary @endif"
               data-sort="-price" >По цене
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
               class="button sort-button is-inverted @if($sortingType==='По рейтингу') is-primary @endif"
               data-sort="rating" >По рейтингу</a >

            <a href="{{ $query  . "sort_by=" . "newness"}}"
               class="button sort-button is-inverted @if($sortingType==='По новизне') is-primary @endif"
               data-sort="newness" >По новизне</a >
          </div >
        </div >
        @foreach( $productList as $product)
          <div class="category-list__item box is-flex is-align-items-center is-flex-wrap-wrap mt-3 columns" >
            <a href="/{{$product->category . "/" .
                        $product->id
                         }}"
               class="category-list__item-image is-flex column is-one-third-desktop is-half-tablet" >

              <img
                src="{{ asset('storage/uploads/images/'.$product->id.'/225x225/' . explode(',',$product->images)
                [0]) }}"
                alt=""
                srcset=""
              />
            </a >
            <div
              class="category-list__item-props column is-one-third-desktop is-half-tablet is-flex
                            is-flex-direction-column is-align-content-flex-end  is-justify-content-flex-start"
            >
              <h2 class="is-size-5 mt-5 has-text-weight-bold" >
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
                  {{  $product->views ?? 0 }}
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
                                is-align-items-flex-start "
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
            <div class="category-list__item-price my-5 column is-one-third-desktop is-full-tablet is-flex-touch" >
              <div
                class="item-main-addtocart  field
                                "
              >
                <div
                  class="oldprice has-text-grey is-size-5 is-flex is-justify-content-space-between is-hidden-touch
                 " >

                  @php
                    $oldPrice=(round((int)
                            $product->price + round(
                            (random_int
                            (5,15) *  ((int)
                            $product->price /
                            100)))))
                  @endphp

                  <span class="oldprice-item " >{{
                                    number_format($oldPrice, 0,  ',', ' ')}}
                                        р.</span >
                  <span class="tag is-success discount "
                  >-{{ number_format(((int)$oldPrice - (int)
                                $product->price), 0, ',', ' ')}} р.</span >
                </div >

                <div
                  class="price has-text-weight-bold
                                    is-size-3" >
                  {{ number_format(round((int)
                         $product->price), 0, ',', ' ')}}
                  р.
                </div >

                <a class="button is-primary mt-5
                                add-to-cart"
                   data-price="{{  $product->price }}"
                   data-category="{{ $product->category }}"
                   data-id="{{ $product->id}}" >
                  Добавить в корзину
                </a >
                @can('updateProduct',App\Models\Product::class)
                  <a
                    href="{{'/product/'. $product->category .'/'.$product->id .'/edit'}}"
                    class="button is-primary mt-5
                                " >
                    Редактировать
                  </a >
                @endcan
                @auth
                  @if(!in_array($product->id,explode(',',$favoritesStatusList)))
                    <a class="favorites favorites-list light-link is-flex
                    is-align-items-center " data-category="{{
                    $product->category_name }}"
                       data-productId="{{$product->id}}"
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
                       data-productId="{{$product->id}}"
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
        @else
          <section
            class="is-flex is-flex-direction-column is-justify-content-center is-align-items-center order-success"
          >
            <h1 class="noitems-title" >Ни одного товара не найдено</h1 >

            <a href="/" class="button is-warning mt-6" >На главную</a >
          </section >
    </div >



      @endif

@endsection