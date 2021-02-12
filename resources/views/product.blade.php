@extends('layout')

@section('title', $product->name)

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')

@component('components.breadcrumbs')
<a href="/">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<a href="{{ route('shop.index') }}">Shop</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>{{ $product->name }}</span>
@endcomponent

<div class="container">
    @include('partials.notification')</div>

<div class="product-section container">
    <div>
        <div class="product-section-image">
            <img src="{{ productImage($product->image) }}" alt="product" class="active" id="currentImage">
        </div>
        <div class="product-section-images">
            <div class="product-section-thumbnail select">
                <img src="{{  productImage($product->image)  }}" alt="product">  
            </div>
            @if ($product->images)
                    @foreach (json_decode($product->images, true) as $image)
                        <div class="product-section-thumbnail">
                            <img src="{{  productImage($image)  }}" alt="product">  
                        </div>
                    @endforeach
            @endif
        </div> 
    </div>
    <div class="product-section-information">
        <h1 class="product-section-title">{{ $product->name }}</h1>
        <div class="product-section-subtitle">{{ $product->details }}</div>
        <div>{!! $stockLevel !!}</div>
        <div class="product-section-price">{{ $product->presentPrice() }}</div>

        <p>
            {!! $product->description !!}
        </p>

        <p>&nbsp;</p>
        @if ($product->quantity > 0)
            <form action="{{ route('cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <button type="submit" class="button button-plain">Add to Cart</button>
            </form>    
        @endif

    </div>
</div> <!-- end product-section -->

@include('partials.might-like')
@endsection

@section('extra-js')
        <!-- Include AlgoliaSearch JS Client v3 and autocomplete.js library -->
        <script src="https://cdn.jsdelivr.net/npm/algoliasearch@3/dist/algoliasearchLite.min.js"></script>
        <script src="https://cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js"></script>
        <script src="{{ asset('js/algolia.js') }}"></script>
    <script>
        (function() {
            const currentImage = document.querySelector('#currentImage');
            const images = document.querySelectorAll('.product-section-thumbnail'); 
            images.forEach((element) => element.addEventListener('click', thumbnailClick));
            function thumbnailClick(e) {

                currentImage.classList.remove('active');

                currentImage.addEventListener('transitionend', () => {
                    currentImage.src = this.querySelector('img').src;
                    currentImage.classList.add('active');
                });

                images.forEach((element) => element.classList.remove('selected'))
                this.classList.add('selected');
            }
        })();
    </script>
@endsection


