<div
  class="category-filter__price accordion-group mt-3 is-flex is-flex-direction-column
                    is-align-items-end is-justify-content-space-between"
>
  <div
    class="category-filter__title is-flex is-justify-content-space-between is-align-items-flex-end"
  >
    <h4 >{{__('Price')}}</h4 >
    <div class="category-filter__arrow"></div >
  </div >
  <div class="accordion-price  is-flex
                        is-justify-content-space-between is-align-items-center"
  >
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
        <label for="price_from">{{__('from')}}</label >
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
        <label for="price_to">{{__('to')}}</label >
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

@foreach($filterInputs as $filter=>$variants)
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
      <h4 class="is-capitalized">{{  explode('|',$filter)[1]}}</h4 >
      <div class="category-filter__arrow"></div >
    </div >
    <div class="accordion">
      <div class="accordion-item">
        <div class="measuring">
          @if($filterItem==='manufacturer')
            @foreach($variants as
            $variant)
              @if($variant->$filterItem)
                <label class="checkbox">
                  <input type="checkbox"
                         class="manufacturer checkbox-filter"
                         data-parameter='{{$filterItem}}'
                         data-value="{{ $variant->$filterItem }}"
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
                                 ml-3"
                  >{{$variant->count}}</span >
                </label >
              @endif
            @endforeach
          @else
            @foreach($variants as
            $variant)
              @if($variant->value)
                <label class="checkbox">
                  <input type="checkbox"
                         class="manufacturer checkbox-filter"
                         data-parameter='{{$filterItem}}'
                         data-value="{{ $variant->value }}"
                  @foreach($explodedQueryString as $elem)
                    @php
                      $var = explode('=',$elem)
                    @endphp
                    @if( str_contains($var[0],$filterItem) && $var[1]===$variant->value )
                      {{'checked'}}
                      @endif
                    @endforeach
                  >
                  {{$variant->value}}
                  <span
                    class="input_count has-text-grey-light
                                 ml-3"
                  >{{$variant->count}}</span >
                </label >
              @endif
            @endforeach
          @endif
        </div >
      </div >
      <p class="show-more mt-3">{{__('Show more')}}</p >
    </div >
  </div >
@endforeach
