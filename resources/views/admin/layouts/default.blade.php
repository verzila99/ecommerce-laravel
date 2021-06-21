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
<div class="admin" >
  <div class="admin-sidebar" >
    <aside class="menu" >
      <a href="{{ route('home') }}" class="button is-success my-4" >{{__('Home')}}</a >
      <p class="menu-label" >
        {{__('Orders')}}
      </p >
      <ul class="menu-list" >
        <li >
          <a href="{{ route('orders')}}" data-path="/orders" class="admin-menu__item" >{{__('Orders list')}}</a >
        </li >
        <li >
          <a href="{{ route('createProduct')}}" data-path="/product/create" class="admin-menu__item" >{{__('Add a
          product')}}</a >
        </li >
      </ul >
      <p class="menu-label" >
        {{__('Categories')}}
      </p >
      <ul class="menu-list" >
        @foreach($categories as $category)
          <li ><a href="{{'/'.$category->category_name}}" data-path="{{'/'.$category->category_name}}"
                  class="admin-menu__item
        is-capitalized" >{{$category->category_name}}</a ></li >
        @endforeach
      </ul >
      <p class="menu-label" >
        {{__('Banners')}}
      </p >
      <ul class="menu-list" >
        <li ><a href="{{ route('indexBanner') }}" data-path="/banner" class="admin-menu__item" >{{__('Banners list')
        }}</a
          ></li >
        <li ><a href="{{ route('createBanner') }}" data-path="/banner/create" class="admin-menu__item" >{{__('Add a
        banner')}}</a >
        </li >
      </ul >
      <p class="menu-label" >
        {{__('Users')}}
      </p >
      <ul class="menu-list" >
        <li ><a href="{{ route('indexUser') }}" data-path="/user" class="admin-menu__item" >{{__('Users list')}}</a
          ></li >

      </ul >
    </aside >
  </div >
  <div class="admin-modal__group" >
    @yield('content')
  </div >
</div >
</body >
</html >
