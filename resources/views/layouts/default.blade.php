<!DOCTYPE html>
<html lang="ru">

    <head>
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
        @yield("scripts")
        <title>App Name - @yield('title')</title>
    </head>

    <body>

        <nav
        class="navbar container is-max-widescreen"
        role="navigation"
        aria-label="main navigation"
    >
        <div class="navbar-brand">
            <a class="navbar-item mr-5 has-text-weight-bold is-size-3" href="/"
                ><img src="/images/logo.png" alt="" srcset="" />
            </a>
            <a
                role="button"
                class="navbar-burger"
                aria-label="menu"
                aria-expanded="false"
                data-target="navbarBasicExample"
            >
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start is-flex is-align-items-center">
                <a class="mr-5 has-text-weight-bold"> 8-800-888-87-78 </a>

                <a class="mr-5"> Москва </a>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div
                        class="is-3 is-flex is-justify-content-space-between is-align-items-center"
                    >
                        <a class="mr-5"> Бонусные Рубли </a>
                        <a class="mr-5"> Доставка </a>
                        <a class=""> Акции </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <main class="py-5">
        <div
            class="container is-max-widescreen second-bar is-flex is-align-items-center is-justify-content-space-between"
        >
            <div class="dropdown is-hoverable">
                <div class="dropdown-trigger">
                    <button
                        class="button is-warning mr-3 is-inverted"
                        aria-haspopup="true"
                        aria-controls="dropdown-menu4"
                    >
                        <span class="icon">
                            <i class="fas fa-bars"></i>
                        </span>
                        <span>Каталог</span>
                    </button>
                </div>
                <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                    <div class="dropdown-content">
                        <div class="dropdown-item">

                            <div class="menu">
                                <p class="menu-label"><a href="/"></a></p>
                                <ul class="menu-list">
                                    <li><a href="/"></a></li>
                                    <li><a>Customers</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="control search mr-3">
                <input class="input" type="text" placeholder="Loading input" />
            </div>
            <button class="button is-warning login menu-btn  is-inverted">
                <span>Войти</span>
                <span class="icon">
                    <i class="far fa-user"></i>
                </span>
            </button>
            <a href="/cart" class="button menu-btn is-warning is-inverted">
                <span>Корзина</span>
                <span class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </span>
            </a>
            <button class="button is-warning menu-btn  is-inverted">
                <span>Избранное</span>
                <span class="icon">
                    <i class="far fa-heart"></i>
                </span>
            </button>
        </div>
    </main>
    <div class="modal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <button class="delete" aria-label="close"></button>

            <section class="modal-card-body">
                <div class="tabs is-centered i is-medium">
                    <ul>
                        <li class="is-active login-tab">
                            <a>
                                <span>Войти</span>
                            </a>
                        </li>
                        <li class="register-tab">
                            <a>
                                <span>Зарегистрироваться</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div
                    class="login-modal is-flex-direction-column is-justify-content-space-around is-align-items-center"
                >
                    <div class="field">
                        <p class="control has-icons-left has-icons-right">
                            <input class="input" type="email" placeholder="Email" />
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="icon is-small is-right">
                                <i class="fas fa-check"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left">
                            <input
                                class="input"
                                type="password"
                                placeholder="Password"
                            />
                            <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control">
                            <button class="button is-success">Войти</button>
                        </p>
                    </div>
                </div>
                <div
                    class="register-modal is-flex-direction-column is-justify-content-space-around is-align-items-center"
                >
                    <div class="field">
                        <label class="label">Имя</label>
                        <p class="control">
                            <input class="input" type="text" placeholder="Имя" />
                        </p>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left has-icons-right">
                            <input class="input" type="email" placeholder="Email" />
                            <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                            </span>
                            <span class="icon is-small is-right">
                                <i class="fas fa-check"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left">
                            <input
                                class="input"
                                type="password"
                                placeholder="Пароль"
                            />
                            <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control has-icons-left">
                            <input
                                class="input"
                                type="confirmpassword"
                                placeholder="Подтвердите пароль"
                            />
                            <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                            </span>
                        </p>
                    </div>
                    <div class="field">
                        <p class="control">
                            <button class="button is-success">Регистрация</button>
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
           @yield('content')



        <footer class="pagefooter-top py-6">
    <div
        class="container is-max-widescreen is-flex is-justify-content-space-between"
    >
        <nav>
            <h2>Маркетплэйс</h2>
            <ul>
                <li><a href="#">О компании</a></li>
                <li><a href="#">Контакты</a></li>
                <li><a href="#">Вакансии</a></li>
                <li><a href="#">Реквизиты</a></li>
                <li><a href="#">Партнерская программа</a></li>
                <li><a href="#">Настоящий маркетплэйс</a></li>
            </ul>
        </nav>
        <nav>
            <h2>Покупателю</h2>
            <ul>
                <li><a href="#">Помощь покупателю</a></li>
                <li><a href="#">Доставка</a></li>
                <li><a href="#">Примерка</a></li>
                <li><a href="#">Оплата</a></li>
                <li><a href="#">Возврат</a></li>
                <li><a href="#">Рассрочка</a></li>
                <li><a href="#">Акции</a></li>
                <li><a href="#">Промокоды</a></li>
            </ul>
        </nav>
        <nav>
            <h2>Магазинам</h2>
            <ul>
                <li><a href="#">Помощь магазинам</a></li>
                <li><a href="#">Приглашение к сотрудничеству</a></li>
                <li><a href="#">Вход в личный кабинет</a></li>
            </ul>
        </nav>
        <nav>
            <h2>Правовая информация</h2>
            <ul>
                <li><a href="#">Условия использования сайта</a></li>
                <li><a href="#">Политика обраотки персональных данных</a></li>
                <li><a href="#">Условия заказа и доставки</a></li>
                <li><a href="#">Правиля сервиса "закажи и забери"</a></li>
            </ul>
        </nav>
    </div>
</footer>

        <script
            src="https://kit.fontawesome.com/7aee5635f6.js"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
