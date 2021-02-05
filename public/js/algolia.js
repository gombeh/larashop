(function(){

    const client = algoliasearch('YWR175RYNA', '2c97d4057cc91500a72f2de094ae3c20');
    const products = client.initIndex('products');
    var enterPressed = false;

    // console.log(products);
    autocomplete(
        '#aa-search-input',
        {
            debug: true,
            hint: false
        },
        {
            source: autocomplete.sources.hits(products, {hitsPerPage: 10}),
            displayKey: 'name',
            // name: 'player',
            templates: {
              suggestion(suggestion) {
                return `
                        <div class="algolia-result">
                            <span>
                                <img src="${window.location.origin}/storage/${suggestion.image}" alt="img" class="algolia-thumb">
                                ${suggestion._highlightResult.name.value}
                            </span>
                            <span>$${(suggestion.price / 100).toFixed(2)}</span> 
                        </div>
                        <div class="algolia-details">
                            <span>${suggestion._highlightResult.details.value}</span>
                        </div>
                `;
              },
              empty: function (result) {
                return 'Sorry, we did not find any results for "' + result.query + '"';
            }
            },
        }
    ).on('autocomplete:selected', function (event, suggestion, dataset) {
        window.location.href = window.location.origin + '/shop/' + suggestion.slug;
        enterPressed = true;
    }).on('keyup',function(event){
        if(event.keyCode == 13 && !enterPressed){
            window.location.href = window.location.origin + '/search-algolia?q=' + document.getElementById('aa-search-input').value;
        }
    });


})();
