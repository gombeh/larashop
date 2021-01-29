@extends('layout')

@section('title', 'Shopping Cart')

@section('content')

<div class="breadcrumbs">
    <div class="breadcrumbs-container container">
        <div>
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shopping Cart</span>
        </div>
    </div>
</div> <!-- end breadcrumbs -->

<div class="cart-section container">
    <div>

        @include('partials.notification')
        @if (Cart::count() > 0)
            
            <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>

            <div class="cart-table">
                @foreach (Cart::content() as $item)
                    <div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <a href="{{ route('shop.show', $item->model->slug) }}">
                                <img src="{{ productImage($item->model->image) }}" alt="item" class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item">
                                    <a href="{{ route('shop.show', $item->model->slug) }}">
                                        {{ $item->model->name }}
                                    </a>
                                </div>
                                <div class="cart-table-description">{{ $item->model->details }}</div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-options">Remove</button>
                                </form>

                                <form action="{{ route('cart.switchToSaveForLater', $item->rowId) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cart-options">Save for Later</button>
                                </form>
                            </div>
                            <div>
                                <select class="quantity" data-id="{{ $item->rowId }}">
                                    @for ($i = 1; $i < 5 + 1; $i++)
                                        <option {{ $item->qty == $i ?'selected' :'' }}>{{ $i }}</option>  
                                    @endfor
                                </select>
                            </div>
                            <div>{{ presentPrice($item->subtotal()) }}</div>
                        </div>
                    </div> <!-- end cart-table-row -->
                @endforeach

            </div> <!-- end cart-table -->

            @if (!session()->has('coupon'))
                <a href="#" class="have-code">Have a Code?</a>

                <div class="have-code-container">
                    <form action="{{ route('coupons.store') }}" method="POST">
                        @csrf
                        <input type="text" name="coupon_code" id="coupon_code">
                        <button type="submit" class="button button-plain">Apply</button>
                    </form>
                </div> <!-- end have-code-container -->     
            @endif

            <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like
                    figuring out :).
                </div>

                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        @if (session()->has('coupon'))
                            Discount <br>({{ session()->get('coupon')['name'] }}) : 
                            <br><hr>
                            New Subtotal<br>               
                        @endif
                        Tax (13%)<br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        {{ presentPrice(Cart::subtotal()) }} <br>

                        @if (session()->has('coupon'))
                            -{{ presentPrice($discount) }}
                            <br>
                            <form action="{{ route('coupons.destroy') }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" style="font-size: 14px">Remove</button>
                            </form>
                            <br><hr>
                            {{ presentPrice($newSubtotal) }}<br>       
                        @endif
                        {{ presentPrice($newTax) }} <br>
                        <span class="cart-totals-total">{{ presentPrice($newTotal) }}</span>
                    </div>
                </div>
            </div> <!-- end cart-totals -->

            <div class="cart-buttons">
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <a href="{{ route('checkout.index') }}" class="button-primary">Proceed to Checkout</a>
            </div>
        @else
            <h3>No items in Cart!</h3>    
            <div class="spacer"></div>
            <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
            <div class="spacer"></div>
        @endif




        @if (Cart::instance('saveForLater')->count() > 0)
    
            <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For Later</h2>

            
            <div class="saved-for-later cart-table">
                @foreach (Cart::instance('saveForLater')->content() as $item)
                    <div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <a href="{{ route('shop.show', $item->model->slug) }}">
                                <img src="{{ productImage($item->model->image) }}" alt="item" class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item">
                                    <a href="{{ route('shop.show', $item->model->slug) }}">
                                    {{ $item->model->name }}
                                    </a>
                                </div>
                                <div class="cart-table-description">                                        
                                    {{ $item->model->details }}
                                </div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="cart-options">Remove</button>
                                </form>

                                <form action="{{ route('saveForLater.switchToCart', $item->rowId) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cart-options">Move to Cart</button>
                                </form>
                            </div>

                            <div>{{ $item->model->presentPrice() }}</div>
                        </div>
                    </div> <!-- end cart-table-row -->
                @endforeach
            </div> <!-- end saved-for-later -->
        @else
            <h3>You have no items Saved for Later.</h3>
        @endif    




    </div>

</div> <!-- end cart-section -->

@include('partials.might-like')

@endsection

@section('extra-js')
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        (function() {

            const className = document.querySelectorAll('.quantity');
            Array.from(className).forEach(function(element) {
                const id = element.getAttribute('data-id');
                element.addEventListener('change', function() {

                    axios.patch(`/cart/${id}`, {
                            quantity: this.value,
                    }).then(function(response) {
                        window.location.href = '{{ route('cart.index') }}';
                    }).catch(function($error) {
                        window.location.href = '{{ route('cart.index') }}';
                    });

                });
            });

        })();
    </script>
@endsection