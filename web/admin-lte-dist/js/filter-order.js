$(() => {
    let searchTimeout;

    $('.orders-index').on('change', "#orderssearch-pick_up_id, #orderssearch-status_id, #orderssearch-date_delivery", function (e) {
        const email = $("#orderssearch-email").val();
        const pick_up = $("#orderssearch-pick_up_id").val();
        const status = $("#orderssearch-status_id").val();
        const date = $("#orderssearch-date_delivery").val();
        const url = `/admin-lte/orders?OrdersSearch[email]=${email}&OrdersSearch[pick_up_id]=${pick_up}&OrdersSearch[status_id]=${status}&OrdersSearch[date_delivery]=${date}&_pjax=#admin-orders-pjax`;
        $.pjax.reload({
            container: "#admin-orders-pjax",
            url: url,
            push: false,
            timeout: 5000,
            replace: false,
        });
    });

    $('.orders-index').on('input', "#orderssearch-email", function (e) {
        const email = $(this).val();
        const pick_up = $("#orderssearch-pick_up_id").val();
        const status = $("#orderssearch-status_id").val();
        const date = $("#orderssearch-date_delivery").val();
        const url = `/admin-lte/orders?OrdersSearch[email]=${email}&OrdersSearch[pick_up_id]=${pick_up}&OrdersSearch[status_id]=${status}&OrdersSearch[date_delivery]=${date}&_pjax=#admin-orders-pjax`;

        clearTimeout(searchTimeout)
        searchTimeout = setTimeout(() => {
            $.pjax.reload({
                container: "#admin-orders-pjax",
                url: url,
                push: false,
                timeout: 5000,
                replace: false,
            })
        }, 1000)
    });
})