<!DOCTYPE html>
<html lang="ru" >

<head >
    <meta charset="UTF-8" />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap"
        rel="stylesheet"
    />
    <link rel="stylesheet" href="/css/style.css" />

    <!-- Useful meta tags -->
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="robots" content="index, follow" />
    <meta name="google" content="notranslate" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="description" content="" />

    <script
        defer
        src="{{ asset('js/fontawesome.js')}}"
        crossorigin="anonymous"
    ></script >
    <script defer src="{{ asset('js/axios.min.js')}}" ></script >
    @yield("scripts")
    <title >App Name - @yield('title')</title >
</head >

<body >

<nav
    class="navbar container is-max-widescreen"
    role="navigation"
    aria-label="main navigation"
>
    <div class="navbar-brand" >
        <a class="navbar-item mr-5 has-text-weight-bold is-size-3" href="/"
        ><img src="/images/logo.png" alt="" srcset="" />
        </a >
        <a
            role="button"
            class="navbar-burger"
            aria-label="menu"
            aria-expanded="false"
            data-target="navbarBasicExample"
        >
            <span aria-hidden="true" ></span >
            <span aria-hidden="true" ></span >
            <span aria-hidden="true" ></span >
        </a >
    </div >

    <div id="navbarBasicExample" class="navbar-menu" >
        <div class="navbar-start is-flex is-align-items-center" >
            <a class="mr-5 has-text-weight-bold" > 8-800-888-87-78 </a >

            <a class="mr-5" > Москва </a >
        </div >

        <div class="navbar-end" >
            <div class="navbar-item" >
                <div
                    class="is-3 is-flex is-justify-content-space-between is-align-items-center"
                >
                    <a class="mr-5" > Бонусные Рубли </a >
                    <a class="mr-5" > Доставка </a >
                    <a class="" > Акции </a >
                </div >
            </div >
        </div >
    </div >
</nav >
<main class="py-5" >
    <div
        class="container is-max-widescreen second-bar is-flex is-align-items-center is-justify-content-space-between"
    >
        <div class="dropdown is-hoverable" >
            <div class="dropdown-trigger" >
                <button
                    class="button is-success mr-3 "
                    aria-haspopup="true"
                    aria-controls="dropdown-menu4"
                >
                        <span class="icon" >
                            <i class="fas fa-bars" ></i >
                        </span >
                    <span >Каталог</span >
                </button >
            </div >
            <div class="dropdown-menu" id="dropdown-menu4" role="menu" >
                <div class="dropdown-content" >
                    <div class="dropdown-item" >

                        <div class="menu" >
                            <p class="menu-label" ><a href={{ url("/smartphones") }}>Смартфоны</a ></p >
                            <ul class="menu-list" >
                                <li ><a href="/" ></a ></li >
                                <li ><a ></a ></li >
                            </ul >
                            <p class="menu-label" ><a href="{{ url("/smartwatches") }}" >Умные Часы</a ></p >
                            <ul class="menu-list" >
                                <li ><a href="/" ></a ></li >
                                <li ><a ></a ></li >
                            </ul >
                        </div >

                    </div >
                </div >
            </div >
        </div >

        <div class="control search mr-3" >
            <input class="input" type="text" placeholder="Loading input" />
        </div >
        @if ( auth()->check())
            <div class="dropdown  is-hoverable" >
                <div class="dropdown-trigger" >
                    <button class="button is-success   ml-3"
                            aria-haspopup="true" aria-controls="dropdown-menu" >
                        <span >{{auth()->user()->name}}</span >
                        <span class="icon" >
                    <i class="far fa-user" ></i >
                            </span >
                    </button >
                </div >
                <div class="dropdown-menu" id="dropdown-menu" role="menu" >
                    <div class="dropdown-content" >
                        <a href="#" class="dropdown-item" >
                            Dropdown item
                        </a >
                        <a class="dropdown-item" >
                            Other dropdown item
                        </a >
                        <a href="#" class="dropdown-item " >
                            Active dropdown item
                        </a >
                        <a href="#" class="dropdown-item" >
                            Other dropdown item
                        </a >
                        <hr class="dropdown-divider" >
                        <a href="{{ url('/logout') }}"
                           class="dropdown-item" >
                            Выйти
                        </a >
                    </div >
                </div >
            </div >


        @else
            <button class="button is-success login  ml-3" >
                <span >Войти</span >
                <span class="icon" >
                    <i class="far fa-user" ></i >
                </span >
            </button >
        @endif
        <a id="cart-navbar" href="/cart" class="button  is-success ml-3" >
            <span class="cart-text">Корзина</span >
            <span class="icon" >
                    <i class="fas fa-shopping-cart" ></i >
                </span >
        </a >
        <a
            @if ( auth()->check())
            href="/favorites"
            data-status="user"
            @else
            data-status="quest"
            @endif
            id="favorites-link"
            class="button  is-success  ml-3" >
            <span >Избранное</span >
            <span class="icon" >
                    <i class="far fa-heart" ></i >
                </span >
        </a >
    </div >
</main >
<div class="modal" >
    <div class="modal-background" ></div >
    <div class="modal-card" >

        <section class="modal-card-body login-form" >
            <button class="delete is-large" aria-label="close" ></button >
            <div class="tabs is-centered i is-medium" >
                <ul >
                    <li class="is-active login-tab" >
                        <a >
                            <span >Войти</span >
                        </a >
                    </li >
                    <li class="register-tab" >
                        <a >
                            <span >Зарегистрироваться</span >
                        </a >
                    </li >
                </ul >
            </div >
            <div

                class="login-modal is-flex-direction-column is-justify-content-space-around is-align-items-center"
            >

                <div class="field" >
                    <label for="login-email" class="label" >Email</label >
                    <p class="control has-icons-left has-icons-right" >
                        <input id="login-email" name="email" class="input"
                               type="email"
                               placeholder="Email" />
                        <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
                        <span class="icon is-small is-right" >
                                <i class="fas fa-check" ></i >
                            </span >
                    </p >
                </div >
                <div class="field" >
                    <label for="login-password" class="label" >Пароль</label >
                    <p class="control has-icons-left" >
                        <input
                            id="login-password"
                            name="password"
                            class="input"
                            type="password"
                            placeholder="Пароль"
                        />
                        <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
                    </p >
                </div >
                <div class="field" >
                    <div id
                         ="login-error" class=" has-text-danger mb-3" ></div >
                    <p class="control" >
                        <a id="login-button" class="button is-success send-form" >Войти</a >
                    </p >
                </div >
            </div >
            <div

                class="register-modal is-flex-direction-column is-justify-content-space-around is-align-items-center"
            >

                <div class="field" >
                    <label for="register-name" class="label" >Имя</label >
                    <p class="control has-icons-left" >
                        <input id="register-name" class="input" name="name"
                               type="text"
                               placeholder="Имя" />
                        <span class="icon is-small is-left" >
                                <i class="fas fa-user" ></i >
                            </span >
                    </p >
                </div >

                <div class="field" >
                    <label for="register-email" class="label" >Email</label >
                    <p class="control has-icons-left " >
                        <input id="register-email" class="input"
                               name="email" type="email"
                               placeholder="Email" />
                        <span class="icon is-small is-left" >
                                <i class="fas fa-envelope" ></i >
                            </span >
                    </p >
                </div >
                <div class="field" >
                    <label for="register-password" class="label" >Пароль</label >
                    <p class="control has-icons-left" >
                        <input
                            id="register-password"
                            name="password"
                            class="input"
                            type="password"
                            placeholder="Пароль"
                        />
                        <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
                    </p >
                </div >
                <div class="field" >
                    <label for="register-confirmation" class="label" >
                        Подтвердите пароль</label >
                    <p class="control has-icons-left" >
                        <input
                            id="register-confirmation"
                            name="password_confirmation"
                            class="input"
                            type="password"
                            placeholder="Подтвердите пароль"
                        />
                        <span class="icon is-small is-left" >
                                <i class="fas fa-lock" ></i >
                            </span >
                    </p >
                </div >
                <div class="field" >
                    <div id
                         ="register-error" class="mb-3" ></div >
                    <p class="control" >

                        <a id="register" class="button is-success send-form" >Регистрация</a >
                    </p >
                </div >
            </div >
        </section >
    </div >
</div >
@yield('content')

<footer class="pagefooter-top py-6" >
    <div
        class="container is-max-widescreen is-flex is-justify-content-space-between"
    >
        <nav >
            <h2 >Маркетплэйс</h2 >
            <ul >
                <li ><a href="#" >О компании</a ></li >
                <li ><a href="#" >Контакты</a ></li >
                <li ><a href="#" >Вакансии</a ></li >
                <li ><a href="#" >Реквизиты</a ></li >
                <li ><a href="#" >Партнерская программа</a ></li >
                <li ><a href="#" >Настоящий маркетплэйс</a ></li >
            </ul >
        </nav >
        <nav >
            <h2 >Покупателю</h2 >
            <ul >
                <li ><a href="#" >Помощь покупателю</a ></li >
                <li ><a href="#" >Доставка</a ></li >
                <li ><a href="#" >Примерка</a ></li >
                <li ><a href="#" >Оплата</a ></li >
                <li ><a href="#" >Возврат</a ></li >
                <li ><a href="#" >Рассрочка</a ></li >
                <li ><a href="#" >Акции</a ></li >
                <li ><a href="#" >Промокоды</a ></li >
            </ul >
        </nav >
        <nav >
            <h2 >Магазинам</h2 >
            <ul >
                <li ><a href="#" >Помощь магазинам</a ></li >
                <li ><a href="#" >Приглашение к сотрудничеству</a ></li >
                <li ><a href="#" >Вход в личный кабинет</a ></li >
            </ul >
        </nav >
        <nav >
            <h2 >Правовая информация</h2 >
            <ul >
                <li ><a href="#" >Условия использования сайта</a ></li >
                <li ><a href="#" >Политика обраотки персональных данных</a ></li >
                <li ><a href="#" >Условия заказа и доставки</a ></li >
                <li ><a href="#" >Правиля сервиса "закажи и забери"</a ></li >
            </ul >
        </nav >
    </div >
</footer >

</body >
</html >
