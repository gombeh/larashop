<!-- HTML Markup -->
<algolia-autocomplete app-id="YWR175RYNA" api-key="2c97d4057cc91500a72f2de094ae3c20" index-name="products" placeholder="search wtih algolia..."></algolia-autocomplete>



<form action="{{ route('search') }}" method="GET" class="search-form">
    <i class="fa fa-search search-icon"></i>
    <input type="text" name="query" id="query" value="{{ request()->input('query') }}" class="search-box" placeholder="Search for product" required>
</form>
