$(() => {
    $('.orders-index').on('keyup', "#orderssearch-email", function(e) {
        $('#admin-orders-filter').submit();
    })

    $('.orders-index').on('change', 
        "#orderssearch-pick_up_id, #orderssearch-status_id, #orderssearch-date_delivery"
        , function(e) {
        $('#admin-orders-filter').submit();
    })
})