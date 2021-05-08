
   @extends('layouts.default')
   @section('scripts', )
        <script defer src="/js/app.js"></script>
        <script defer src="/js/sliderTop.js"></script>
        <script defer src="/js/sliderBottom.js"></script>
   @endsection
   @section('title','Ecommerce shop')
   @section('content')

 <div class="top-promotions">
    <div class="container is-max-widescreen">
        <div class="slider-container__main my-5">
            <div class="slider-container">
                <div class="slider">
                    <div class="slide">
                        <!-- <h2>Something</h2>
                        <h4>$199</h4> -->
                        <img src="{{ asset('storage/uploads/10.jpg') }}" alt="" />

                        <!-- <a class="btn button is-light" href="#">Купить</a> -->
                    </div>
                    <div class="slide">
                        <img src="{{ asset('storage/uploads/18.jpg') }}" alt="" />
                    </div>
                    <div class="slide">
                        <img src="{{ asset('storage/uploads/26.jpg') }}" alt="" />
                    </div>
                    <div class="slide">
                        <img src="{{ asset('storage/uploads/25.jpg') }}" alt="" />
                    </div>
                    <div class="slide">
                        <img src="{{ asset('storage/uploads/27.jpg') }}" alt="" />
                    </div>
                </div>
            </div>

            <div class="arrow-left__container">
                <div class="arrow-left"></div>
            </div>
            <div class="arrow-right__container">
                <div class="arrow-right"></div>
            </div>

            <div class="dot-container"></div>
        </div>
    </div>
</div>
<section class="smartphones-section container is-max-widescreen mt-5">
    <h2 class="has-text-left has-text-weight-bold is-size-3">Смартфоны</h2>
    <div class="columns is-multiline my-4">
        @foreach ($smartphones as $smartphone)

        <div class="column is-one-fifth">
            <div class="card">
                <a href="{{  $smartphone->category . "/" . $smartphone->id}}">
                    <div class="card-image">
                        <img
                            src="{{ asset('storage/uploads/' . explode(',',$smartphone->images)[0]) }}"
                            alt="Placeholder image"
                        />

                    </div>

                    <div class="card-content p-1">
                        <p
                            class="is-6 card-content__title has-text-weight-semibold has-text-centered"
                        >
                            {{ $smartphone->title}}
                        </p>
                        <p
                            class="price has-text-weight-bold has-text-centered is-4 my-3"
                        >
                        {{ number_format($smartphone->price, 0, ',', ' ')}} ₽
                        </p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
<section class="earphones-section container is-max-widescreen">
    <h2 class="has-text-left has-text-weight-bold is-size-3">Умные часы</h2>
    <div class="columns is-multiline my-4">
        @foreach ($smartwatches as $smartwatch)
        <div class="column is-one-fifth">
            <div class="card">
                <a href="{{  $smartwatch->category . "/" . $smartwatch->id}}">
                    <div class="card-image">
                        <img
                            src="{{ asset('storage/uploads/' . explode(',',$smartwatch->images)[0]) }}"
                            alt="{{ $smartwatch->title }}"
                        />
                    </div>
                    <div class="card-content p-1">
                        <p class="is-6 card-content__title has-text-weight-semibold has-text-centered">
                            {{ $smartwatch->title}}
                        </p>
                        <p
                            class="price has-text-weight-bold has-text-centered is-4 my-3"
                        >
                        {{ number_format($smartwatch->price, 0, ',', ' ')}} ₽
                        </p>
                    </div>
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>
<section class="bottom-promotions">
    <div class="container is-max-widescreen">
        <div class="slider-container__main my-5">
            <div class="slider-container">
                <div class="slider">
                    <div class="slide">
                        <img src="/images/10.jpg" alt="" />
                    </div>
                    <div class="slide">
                        <img src="/images/18.jpg" alt="" />
                    </div>
                    <div class="slide">
                        <img src="/images/26.jpg" alt="" />
                    </div>
                    <div class="slide">
                        <img src="/images/25.jpg" alt="" />
                    </div>
                    <div class="slide">
                        <img src="/images/27.jpg" alt="" />
                    </div>
                </div>
            </div>

            <div class="arrow-left__container">
                <div class="arrow-left"></div>
            </div>
            <div class="arrow-right__container">
                <div class="arrow-right"></div>
            </div>

            <div class="dot-container"></div>
        </div>
    </div>
</section>
<section class="brands container is-max-widescreen mt-5">
    <h2 class="has-text-left has-text-weight-bold is-size-3">Брэнды</h2>
    <div class="columns is-multiline my-4">
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">Apple</div>
        </div>
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">Huawei</div>
        </div>
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">Xiaomi</div>
        </div>
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">Samsung</div>
        </div>
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">LG</div>
        </div>
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">Sony</div>
        </div>
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">Oppo</div>
        </div>
        <div class="column is-3">
            <div class="box is-size-2 has-text-centered">Realme</div>
        </div>
    </div>
</section>
<section class="advantages has-background-light is-flex is-align-items-center">
    <div
        class="container is-max-widescreen is-flex is-flex-wrap-wrap is-justify-content-space-between is-align-items-center"
    >
        <div
            class="advantages-block is-flex is-justify-content-left is-align-items-center"
        >
            <i class="fas fa-coins"></i>
            <h4 class="has-text-grey-light has-text-weight-bold">
                Бонусные рубли за покупки
            </h4>
        </div>
        <div
            class="advantages-block is-flex is-justify-content-left is-align-items-center"
        >
            <i class="fas fa-tags"></i>
            <h4 class="has-text-grey-light has-text-weight-bold">
                Самые выгодные цены
            </h4>
        </div>
        <div
            class="advantages-block is-flex is-justify-content-left is-align-items-center"
        >
            <i class="fas fa-truck"></i>
            <h4 class="has-text-grey-light has-text-weight-bold">
                Товары разных продавцов одной доставкой
            </h4>
        </div>
        <div
            class="advantages-block is-flex is-justify-content-left is-align-items-center"
        >
            <i class="fas fa-check-circle"></i>
            <h4 class="has-text-grey-light has-text-weight-bold">
                2000 проверенных продавцов на одной площадке
            </h4>
        </div>
    </div>
</section>
<section class="subscription">
    <div class="container is-max-widescreen is-flex">
        <div class="subscription-block is-flex">
            <div
                class="subscription-block__text text is-flex is-flex-direction-column is-justify-content-center is-align-items-end"
            >
                <h3 class="has-text-weight-bold is-size-4">
                    подпишись и узнавай
                </h3>
                <h5 class="is-size-6">о выгодных акциях и суперпредложениях</h5>
            </div>
            <img src="/images/svg/mails.svg" alt="" srcset="" />
        </div>
        <div
            class="subscription-form is-flex is-flex-direction-column is-justify-content-center is-align-items-end"
        >
            <form action="" method="post" class="is-flex">
                <input class="input" type="text" placeholder="Введите Email" />

                <a type="submit" class="button is-info"> Подписаться </a>
            </form>

            <div class="subscription-form__text mt-1">
                <p>
                    Нажимая кнопку «Подписаться» вы соглашаетесь с условиями
                    использования сайта и политикой обработки персональных
                    данных.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection


