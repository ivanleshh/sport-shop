$(() => {
    $('#catalog-filter-pjax').on('keyup', '#productsearch-title', function(e) {
        $('#catalog-filter').submit();
    })
})
