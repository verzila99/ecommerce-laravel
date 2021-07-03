@extends('layouts.default')
@section('scripts')
  <script defer
          src="{{ asset('js/app.js')}}" ></script >
  <script defer
          src="{{ asset('js/sliderTop.js')}}" ></script >

@endsection
@section('title','Ecommerce shop')
@section('content')
  @foreach ($errors->all() as $error)
    <li >{{ $error }}</li >
  @endforeach

  <div class="container is-max-widescreen has-text-centered" >

    @if (session('status'))
      <div class="message is-dark" >
        <div class="message-body" >
          {{ session('status') }}
        </div >
      </div >
    @endif
  </div >
  <div class="top-promotions" >
    <div class="container is-max-widescreen" >
      <div class="slider-container__main my-5" >
        <div class="slider-container__homepage" >
          <div class="slider" >
            @foreach($topSlider as $slide)
              <a href="{{$slide->url}}"
                 target="_blank"
                 class="slide" >
                <!-- <h2>Something</h2>
                <h4>$199</h4> -->
                <img src="{{ asset('storage/uploads/banners/1152x300/' . $slide->image)  }}"
                     alt="" />

                <!-- <a class="btn button is-light" href="#">Купить</a> -->
              </a >
            @endforeach

          </div >
        </div >

        <div class="arrow-left__container" >
          <div class="arrow-left" ></div >
        </div >
        <div class="arrow-right__container" >
          <div class="arrow-right" ></div >
        </div >

        <div class="dot-container" ></div >
      </div >
    </div >
  </div >
  <section class="smartphones-section container is-max-widescreen mt-5 px-3" >
    <h2 class="has-text-left has-text-weight-bold is-size-3" >{{__('Smartphones')}}</h2 >
    <div class="columns is-mobile is-multiline is-centered my-4" >
      @foreach ($smartphones as $smartphone)

        <div class="column is-one-fifth-desktop is-one-quarter-tablet is-half-mobile" >
          <div class="card" >
            <a href="{{  $smartphone->category . "/" . $smartphone->id}}" >
              <div class="card-image" >
                <img src="{{ asset('storage/uploads/images/'.$smartphone->id.'/225x225/' . explode(',',$smartphone->images)[0]) }}"
                     alt="Placeholder image" />

              </div >

              <div class="card-content p-1" >
                <p class="is-6 card-content__title has-text-weight-semibold has-text-centered" >
                  {{ $smartphone->title}}
                </p >
                <p class="price has-text-weight-bold has-text-centered is-4 my-3" >
                  $ {{ number_format($smartphone->price/100, 2, '.', ',')}}
                </p >
              </div >
            </a >
          </div >
        </div >
      @endforeach
    </div >
  </section >
  <section class="earphones-section container is-max-widescreen px-3" >
    <h2 class="has-text-left has-text-weight-bold is-size-3" >{{__('Smartwatches')}}</h2 >
    <div class="columns is-mobile is-multiline is-centered my-4" >
      @foreach ($smartwatches as $smartwatch)
        <div class="column is-one-fifth-desktop is-one-quarter-tablet is-half-mobile" >
          <div class="card" >
            <a href="{{  $smartwatch->category . "/" . $smartwatch->id}}" >
              <div class="card-image" >
                <img src="{{ asset('storage/uploads/images/'.$smartwatch->id.'/225x225/' . explode(',',$smartwatch->images)[0]) }}"
                     alt="{{ $smartwatch->title }}" />
              </div >
              <div class="card-content p-1" >
                <p class="is-6 card-content__title has-text-weight-semibold has-text-centered" >
                  {{ $smartwatch->title}}
                </p >
                <p class="price has-text-weight-bold has-text-centered is-4 my-3" >
                  $ {{ number_format($smartwatch->price/100, 2, '.', ',')}}
                </p >
              </div >
            </a >
          </div >
        </div >
      @endforeach
    </div >
  </section >
  <section class="bottom-promotions" >
    <div class="container is-max-widescreen" >
      <div class="slider-container__main my-5" >
        <div class="slider-container__homepage" >
          <div class="slider" >
            @foreach($bottomSlider as $slide)
              <a href="{{$slide->url}}"
                 target="_blank"
                 class="slide" >
                <!-- <h2>Something</h2>
                <h4>$199</h4> -->
                <img src="{{ asset('storage/uploads/banners/1152x300/' . $slide->image)  }}"
                     alt="" />

                <!-- <a class="btn button is-light" href="#">Купить</a> -->
              </a >
            @endforeach
          </div >
        </div >

        <div class="arrow-left__container" >
          <div class="arrow-left" ></div >
        </div >
        <div class="arrow-right__container" >
          <div class="arrow-right" ></div >
        </div >

        <div class="dot-container" ></div >
      </div >
    </div >
  </section >
  <section class="brands container is-max-widescreen mt-5 px-3 is-hidden-mobile" >
    <h2 class="has-text-left has-text-weight-bold is-size-3" >Brands</h2 >
    <div class="columns is-mobile is-centered is-multiline my-4" >
      <div class="column  is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >Apple</div >
      </div >
      <div class="column is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >Huawei</div >
      </div >
      <div class="column is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >Xiaomi</div >
      </div >
      <div class="column is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >Samsung</div >
      </div >
      <div class="column is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >LG</div >
      </div >
      <div class="column is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >Sony</div >
      </div >
      <div class="column is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >Oppo</div >
      </div >
      <div class="column is-3-desktop is-4-tablet is-6-mobile" >
        <div class="box is-size-2 has-text-centered" >Realme</div >
      </div >
    </div >
  </section >
  <section class="advantages has-background-light is-flex is-align-items-center is-hidden-mobile px-6" >
    <div class="container is-max-widescreen is-flex is-flex-wrap-wrap is-justify-content-space-between is-align-items-center" >
      <div class="advantages-block is-flex is-justify-content-left is-align-items-center" >
        <i class="fas fa-coins" ></i >
        <h4 class="has-text-grey-light has-text-weight-bold" >
          {{__('Shopping bonuses')}}
        </h4 >
      </div >
      <div class="advantages-block is-flex is-justify-content-left is-align-items-center" >
        <i class="fas fa-tags" ></i >
        <h4 class="has-text-grey-light has-text-weight-bold" >
          {{__('Best prices')}}
        </h4 >
      </div >
      <div class="advantages-block is-flex is-justify-content-left is-align-items-center" >
        <i class="fas fa-truck" ></i >
        <h4 class="has-text-grey-light has-text-weight-bold" >
          {{__('Products of various sellers of one delivery')}}
        </h4 >
      </div >
      <div class="advantages-block is-flex is-justify-content-left is-align-items-center" >
        <i class="fas fa-check-circle" ></i >
        <h4 class="has-text-grey-light has-text-weight-bold" >
          {{__('2000 proven sellers on the same site')}}
        </h4 >
      </div >
    </div >
  </section >
  <section class="subscription  is-flex is-justify-content-center is-align-items-center px-6" >
    <div class="container columns is-max-widescreen is-flex" >
      <div class="column subscription-block is-flex is-half-desktop is-hidden-touch" >
        <div class="subscription-block__text text is-flex is-flex-direction-column is-justify-content-center
                is-align-items-flex-start" >
          <h3 class="has-text-weight-bold is-size-4" >
            {{__('Subscribe and find out')}}
          </h3 >
          <h5 class="is-size-6" >{{__('about best deals and promotions')}}</h5 >
        </div >
        <img src="{{ asset('storage/uploads/svg/mails.svg') }}"
             alt=""
             srcset="" />
      </div >
      <div class="column subscription-form is-flex is-flex-direction-column is-justify-content-center
            is-align-items-end
               is-half-desktop  is-full-tablet" >
        <div  class="is-flex field" >
          <label for="email-news-subscription"
                 style="display:none" >{{__('Enter your email')}}</label >
          <input class="input"
                 id="email-news-subscription"
                 type="email"
                 name="email"
                 placeholder="{{__('Enter your email')}}" />
          <a id="submit-news-subscription"
             class="button is-warning ml-3" > {{__('Subscribe')}} </a >
        </div>

        <div class="subscription-form__text mt-1" >
          <p >
            {{__("Press the Subscribe button you agree to the conditions use of the site and personal processing policies data.")}}
          </p >
        </div >
      </div >
    </div >
  </section >
@endsection
