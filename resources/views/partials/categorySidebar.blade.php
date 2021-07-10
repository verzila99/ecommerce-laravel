<div class="category-filter__price accordion-group mt-3 is-flex is-flex-direction-column
                    is-align-items-end is-justify-content-space-between" >
  <div class="category-filter__title is-flex is-justify-content-space-between is-align-items-flex-end" >
    <h4 >{{__('Price')}}</h4 >
    <div class="category-filter__arrow" ></div >
  </div >
  <div class="accordion-price accordion is-flex
                        is-justify-content-space-between is-align-items-center" >
    <div class="accordion-price accordion-item category-filter__price-input
                        columns is-multiline is-mobile is-centered mt-5" >

      <div class="price-input__from column is-half is-flex is-flex-direction-column
                            is-align-items-flex-start is-justify-content-space-between pl-3" >
        <label for="price_from" >{{__('from')}}</label >
          <input class="input-number mt-4"
                 type="text"
                 ondrop="return false;"
                 id='price_from'
                 placeholder="{{floor($minMaxPrice[0]/100)}}"
                 data-value="{{floor($minMaxPrice[0]/100)}}"
                 autocomplete="off"
                 @foreach($appliedFilters as $filter)@if($filter[0]==='price')value="{{explode(':',$filter[1])[0]/100}}"
              @endif
              @endforeach
          />
      </div >
        <div class="price-input__to column is-half is-flex is-flex-direction-column
        is-align-items-flex-start is-justify-content-space-between " >
            <label for="price_to" >{{__('to')}}</label >
            <input class="input-number mt-4"
                   type="text"
                   ondrop="return false;"
                   id="price_to"
                   placeholder="{{ceil($minMaxPrice[1]/100)}}"
                   data-value="{{ceil($minMaxPrice[1]/100)}}"
                   autocomplete="off"
                   @foreach($appliedFilters as $filter)@if($filter[0]==='price')value="{{explode(':',$filter[1])
                   [1]/100}}"
                @endif
                @endforeach
            />
      </div >
      <div id="range-slider"
           class="column my-5 is-half" ></div >
    </div >
  </div >
</div >

@foreach($filterInputs as $filter=>$variants)
  @php
    $filterItem =explode('|',$filter)[0];
  @endphp
  <div class="category-filter__brands accordion-group mt-3
                        is-flex is-flex-direction-column is-align-items-flex-start is-justify-content-space-between" >
    <div class="category-filter__title is-flex is-justify-content-space-between is-align-items-flex-end my-4" >
      <h4 class="is-capitalized" >{{  explode('|',$filter)[1]}}</h4 >
      <div class="category-filter__arrow" ></div >
    </div >
    <div class="accordion" >
      <div class="accordion-item"

          style="height:
              @if(count($variants)>8){{206}}px
              @else{{count($variants) * 26 }}px
              @endif
              ;" >

        <div class="measuring" >
          @if($filterItem==='manufacturer')
            @foreach($variants as
            $variant)
              @if($variant->$filterItem)
                <label class="checkbox" >
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
                  <span class="input_count has-text-grey-light
                                 ml-3" >{{$variant->count}}</span >
                </label >
              @endif
            @endforeach
          @else
            @foreach($variants as
            $variant)
              @if($variant->value)
                <label class="checkbox" >
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
                  <span class="input_count has-text-grey-light
                                 ml-3" >{{$variant->count}}</span >
                </label >
              @endif
            @endforeach
          @endif
        </div >
      </div >
      @if(count($variants)>8)
      <p class="show-more mt-3" >{{__('Show more')}}</p >
      @endif
    </div >
  </div >
@endforeach
