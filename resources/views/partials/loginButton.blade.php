<a href="{{ route('cart') }}" class="navbar-item cart-navbar button  is-success ml-3">
  <span class="cart-text">{{__('Cart')}}</span >
  <span class="icon">
                    <i class="fas fa-shopping-cart"></i >
                </span >
</a >
<a
  @if ( auth()->check())
  href="{{route('favorites')}}"
  data-status="user"
  @else
  data-status="quest"
  @endif
  id="favorites-link"
  class="button is-success  ml-3 is-block-desktop is-hidden-tablet"
>
  <span >{{__('Favorite')}}</span >
  <span class="icon">
                    <i class="far fa-heart"></i >
                </span >
</a >
