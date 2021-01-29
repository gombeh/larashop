<header>
    <div class="top-nav container">
        <div class="top-nav-right">
            <div class="logo"><a href="/">Larashop</a></div>
            @if (!(request()->is('checkout') OR request()->is('guestCheckout')))
                {{ menu('main', 'partials.menus.main') }}   
            @endif
        </div>
        <div class=top-nav-right">
            @if (! (request()->is('checkout') OR request()->is('guestCheckout')))
                @include('partials.menus.main-right')
            @endif
        </div>   
    </div> <!-- end top-nav -->
</header>
