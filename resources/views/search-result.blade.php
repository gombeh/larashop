@extends('layout')

@section('title', 'Search Results')

@section('content')

@component('components.breadcrumbs')
<a href="/">Home</a>
<i class="fa fa-chevron-right breadcrumb-separator"></i>
<span>Search</span>
@endcomponent
<div class="container">
    @include('partials.notification')</div>

<div class="search-results-container container">
    <h1>Search Results</h1>
    <p class="search-results-count">{{ $products->total() }} result(s) for '{{ request()->input('query') }}'</p>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Details</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <th><a href="{{ route('shop.show', $product->slug) }}">{{ $product->name }}</a></th>
                    <th>{{ $product->details }}</th>
                    <th>{{ Str::words($product->description, 15, '...')}}</th>
                    <th>{{ $product->presentPrice() }}</th>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $products->appends(request()->input())->links() }}
</div> <!-- end search-container -->

@endsection


