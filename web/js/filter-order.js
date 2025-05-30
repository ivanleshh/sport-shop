$(() => {
    let scrollPosition = '';

    $('.orders-index').on('change', "#orderssearch-pick_up_id, #orderssearch-status_id, #orderssearch-date_delivery", function (e) {
        scrollPosition = $(window).scrollTop();
        const pick_up = $("#orderssearch-pick_up_id").val();
        const status = $("#orderssearch-status_id").val();
        const date = $("#orderssearch-date_delivery").val();
        const url = `/personal/orders?OrdersSearch[pick_up_id]=${pick_up}&OrdersSearch[status_id]=${status}&OrdersSearch[date_delivery]=${date}&_pjax=#personal-orders-pjax`;
        $.pjax.reload({
            container: "#personal-orders-pjax",
            url: url,
            push: false,
            timeout: 5000,
            replace: false,
        });
    });

    $('#personal-orders-pjax').on('pjax:end', function () {
        if (typeof(scrollPosition) == 'number') {
            $(window).scrollTop(scrollPosition);
        }
    })
})