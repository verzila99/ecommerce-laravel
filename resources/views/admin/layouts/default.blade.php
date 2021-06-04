<!doctype html>
<html lang="en" >
<head >
  <meta charset="UTF-8" />
  <link rel="preconnect" href="https://fonts.gstatic.com" />
  <link
    href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700;900&display=swap"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="{{ asset('css/style.css')}}" />

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
  <script defer src="{{ asset('js/admin.js')}}" ></script >
  <title >Admin panel </title >
</head >
<body >
<div class="admin">
  <div class="admin-sidebar">
    <aside class="menu" >
      <a href="{{ route('home') }}" class="button is-success my-4" >На главную</a >
      <p class="menu-label" >
        General
      </p >
      <ul class="menu-list" >
        <li ><a href="{{ route('orders')}}" class="admin-menu__item" >Заказы</a ></li >
        <li ><a href="{{ route('createProduct')}}" class="admin-menu__item"  >Добавить товар</a ></li >
        <li ><a class="admin-menu__item">Товары</a ></li >
      </ul >
      <p class="menu-label" >
        Категории
      </p >
      <ul class="menu-list" >
@foreach($categories as $category)
        <li ><a href="{{'/'.$category->category_name}}" class="admin-menu__item is-capitalized">{{$category->category_name_ru}}</a ></li >
   @endforeach
      </ul >
      <p class="menu-label" >
        Transactions
      </p >
      <ul class="menu-list" >
        <li ><a class="admin-menu__item">Payments</a ></li >
        <li ><a class="admin-menu__item">Transfers</a ></li >
        <li ><a class="admin-menu__item">Balance</a ></li >
      </ul >
    </aside >
  </div>
  <div class="admin-modal__group">
    @yield('content')

  </div>
</div>
</body >
</html >
