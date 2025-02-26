$(() => {
    $('#catalog-filter-pjax').on('keyup', '#productsearch-title', function(e) {
        if (e.key == 'Enter' || $(this).val() !== '') {
            $('#catalog-filter').submit();
        }
    })
})
