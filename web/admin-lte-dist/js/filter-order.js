$(() => {
    let searchTimeout
    
    $('.orders-index').on('keyup', "#orderssearch-email", function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            $('#admin-orders-filter').submit();
        }, 1000);
    })

    $('.orders-index').on('change', "#orderssearch-pick_up_id, #orderssearch-status_id, #orderssearch-date_delivery", function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            $('#admin-orders-filter').submit();
        }, 1000);
    })
})