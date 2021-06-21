<!DOCTYPE html>
<html lang="ru" >

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
  <meta name="csrf-token" content="{{ csrf_token() }}" >
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
<div id="close-modal" ></div >
<div class="field">
  <div
    class="container top-bar is-max-widescreen is-flex is-justify-content-space-between py-2 px-2 is-hidden-mobile"

  >
    <div class="is-flex is-align-items-center is-justify-content-space-between" >
      <a class="logo-m mr-5 has-text-weight-bold is-size-3 is-flex is-align-items-center" href="/"
      ><img src="{{asset('storage/uploads/logo/logo.gif')}}" alt="" srcset="" />
      </a >

      <div class="navbar-start is-flex is-align-items-center " >
        <a class="mr-5 has-text-weight-bold" > 8-800-888-87-78 </a >

        <a class="mr-5" > {{__('City')}} </a >
      </div >
    </div >
    <div class="navbar-item is-flex  is-align-items-center " >
      <div
        class="is-3 is-flex is-justify-content-space-between is-align-items-center"
      >
        <a class="mr-5" > {{__('Bonuses')}}</a >
        <a class="mr-5" > {{__('Delivery')}} </a >
        <a class="" > {{__('Deals')}} </a >
      </div >
    </div >
  </div >
</div >
{{--<div class="" style="height: 76px;">--}}
<nav class="navbar field py-3 px-2"
     role="navigation"
     aria-label="main navigation" >
  <div
    class="container is-max-widescreen  second-bar is-flex is-align-items-center is-justify-content-space-between"
  >
    <div class="dropdown is-hoverable catalog " >
      <div class="dropdown-trigger catalog-trigger" >

        <button
          class="button is-success mr-3 "
          aria-haspopup="true"
          aria-controls="dropdown-menu4"
        >
                        <span >
                            <i class="fas fa-bars catalog-icon" ></i >
                        </span >
          <span class="is-hidden-mobile ml-3" >{{__('Catalog')}}</span >
        </button >
      </div >

      <div class="dropdown-menu" id="dropdown-menu4" role="menu" >
        <div class="dropdown-content is-flex is-flex-direction-column p-3" >
          <div class="catalog-menu-buttons is-flex is-align-items-center is-justify-content-space-between
          is-hidden-tablet m-3" >
            @if ( auth()->check())

              <a href="{{ route('profile') }}" class="dropdown-item" >
                {{auth()->user()->name}}
              </a >
              @can ( 'updateRole',App\Models\User::class)
                <a href="{{ route('orders') }}" class="dropdown-item " >
                  {{__('Admin panel')}}
                </a >
              @endcan
              <a href="{{ route('userOrders') }}" class="dropdown-item" >
                {{__('My orders')}}
              </a >
              <hr class="dropdown-divider" >
              <a href="{{ url('/logout') }}"
                 class="dropdown-item" >
                {{__('Log out')}}
              </a >

            @else
              <button class=" button is-success login  ml-3" >
                <span >{{__('Log in')}}</span >
                <span class="icon" >
                    <i class="far fa-user" ></i >
                </span >
              </button >
            @endif
            @include('partials.loginButton')
          </div >
          <div class="is-flex catalog-menu" >
            @foreach ($categories as $key=>$category)
              <div class="px-5" >
                <p class="menu-label catalog-label is-capitalized" ><a href={{ url('/'. explode(',',$key)[0])
                         }}>{{
                        explode(',',$key)[1]
                             }}</a ></p >
                <ul class="menu-list catalog-list" >
                  @foreach($category as $subcategory)
                    <li ><a class="dropdown-item is-capitalized" href="{{ url('/'. explode(',',$key)[0])
                                .'/?manufacturer[]=' . $subcategory->manufacturer }}"
                      >{{ $subcategory->manufacturer}}
                      </a >
                    </li >
                  @endforeach
                </ul >
              </div >
            @endforeach
          </div >
        </div >
      </div >
    </div >

    <a class="logo-mr mr-5 has-text-weight-bold is-size-3 is-flex is-align-items-center is-hidden-tablet" href="/"
    >
      <img src="{{asset('storage/uploads/logo/logo.gif')}}" alt="" srcset="" />
    </a >
    <form id="search-parent" class="control search mr-3 is-flex is-flex-direction-column" method="get"
          action="{{ route('search')}}" >
      <div class="search-field is-flex" >
        <label for="main-search" ></label >
        <input id="main-search" class="input" type="text" autocomplete="off" name="search_string"
               placeholder="Поиск товаров..." />
        <button type="submit" class="button is-success search-submit" >{{__('Search')}}</button >
      </div >
    </form >
    <div class="is-flex is-justify-content-space-between is-align-items-center is-hidden-mobile" >
      @if ( auth()->check())
        <div class=" dropdown  is-hoverable " >
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
              <a href="{{ route('profile') }}" class="dropdown-item" >
                {{__('Profile')}}
              </a >
              @can ( 'updateRole',App\Models\User::class)
                <a href="{{ route('orders') }}" class="dropdown-item " >
                  {{__('Admin panel')}}
                </a >
              @endcan
              <a href="{{ route('userOrders') }}" class="dropdown-item" >
                {{__('My orders')}}
              </a >
              <a href="{{route('favorites')}}" class="dropdown-item" >
                {{__('Favorite')}}
              </a >
              <hr class="dropdown-divider" >
              <a href="{{ url('/logout') }}"
                 class="dropdown-item" >
                {{__('Log out')}}
              </a >
            </div >
          </div >
        </div >


      @else
        <button class=" button is-success login  ml-3 " >
          <span >{{__('Log in')}}</span >
          <span class="icon" >
                    <i class="far fa-user" ></i >
                </span >
        </button >
      @endif
      @include('partials.loginButton')
    </div >

    <div class="search-results" >
    </div >
  </div >
</nav >


@include('partials.loginModal')

@yield('content')

@if (count($viewed) >= 1)
  <div class="container is-max-widescreen px-3" >
    <h2 class="has-text-left has-text-weight-bold is-size-4 mt-4" >{{__('You have recently watched')}}</h2 >
    <div class="columns is-centered is-mobile is-multiline my-4" >
      @foreach ($viewed as $viewedItem)
        @if($loop->index < 5)
          <div class="column is-one-fifth-desktop is-one-quarter-tablet is-half-mobile" >
            <div class="card" >
              <a href="{{  url('/' .$viewedItem->category . "/" . $viewedItem->id)}}" >
                <div class="card-image" >
                  <img
                    src="{{ asset('storage/uploads/images/'.$viewedItem->id.'/225x225/' .
                                explode(',',$viewedItem->images)[0]) }}"
                    alt="{{ $viewedItem->title }}"
                  />
                </div >
                <div class="card-content p-1" >
                  <p class="is-6 card-content__title has-text-weight-semibold has-text-centered" >
                    {{ $viewedItem->title}}
                  </p >
                  <p
                    class="price has-text-weight-bold has-text-centered is-4 my-3"
                  >
                    {{ number_format($viewedItem->price, 0, ',', ' ')}} ₽
                  </p >
                </div >
              </a >
            </div >
          </div >
        @endif
      @endforeach
    </div >
  </div >
@endif
<footer class="pagefooter-top container  is-max-widescreen  py-6 px-6" >
  <div
    class="columns is-centered is-multiline is-flex is-justify-content-space-between px-6"
  >
    <nav class="column is-one-quarter-desktop is-half-tablet is-full-mobile" >
      <h2 >{{__('Marketplace')}}</h2 >
      <ul >
        <li ><a href="#" >{{__('About company')}}</a ></li >
        <li ><a href="#" >{{__('Contacts')}}</a ></li >
        <li ><a href="#" >{{__('Vacancies')}}</a ></li >
        <li ><a href="#" >{{__('Requisites')}}</a ></li >
        <li ><a href="#" >{{__('Affiliate program')}}</a ></li >
        <li ><a href="#" >{{__('Real marketplace')}}</a ></li >
      </ul >
    </nav >
    <nav class="column is-one-quarter-desktop is-half-tablet is-full-mobile" >
      <h2 >{{__('To customer')}}</h2 >
      <ul >
        <li ><a href="#" >{{__('Help to customer')}}</a ></li >
        <li ><a href="#" >{{__('Delivery')}}</a ></li >
        <li ><a href="#" >{{__('Payment')}}</a ></li >
        <li ><a href="#" >{{__('Refund')}}</a ></li >
        <li ><a href="#" >{{__('Installing')}}</a ></li >
        <li ><a href="#" >{{__('Deals')}}</a ></li >
        <li ><a href="#" >{{__('Promotional codes')}}</a ></li >
      </ul >
    </nav >
    <nav class="column is-one-quarter-desktop is-half-tablet is-full-mobile" >
      <h2 >{{__('To markets')}}</h2 >
      <ul >
        <li ><a href="#" >{{__('Help to stores')}}</a ></li >
        <li ><a href="#" >{{__('Invitation to cooperation')}}</a ></li >
        <li ><a href="#" >{{__('Your Personal Area')}}</a ></li >
      </ul >
    </nav >
    <nav class="column is-one-quarter-desktop is-half-tablet is-full-mobile" >
      <h2 >{{__('Legal information ')}}</h2 >
      <ul >
        <li ><a href="#" >{{__('Terms of use of the site')}}</a ></li >
        <li ><a href="#" >{{__('Personal data processing policy')}}</a ></li >
        <li ><a href="#" >{{__('Conditions for ordering and delivery')}}</a ></li >
        <li ><a href="#" >{{__('Rules of service "Order and take"')}}</a ></li >
      </ul >
    </nav >
  </div >
</footer >

</body >
</html >
