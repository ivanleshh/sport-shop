$(() => {
    let scrollPosition = '';
    let searchTimeout;

    $('.orders-index').on('input', "#orderssearch-pick_up_id, #orderssearch-status_id, #orderssearch-date_delivery, #orderssearch-email", function (e) {
        scrollPosition = $(window).scrollTop();

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const email = $("#orderssearch-email").val();
            const pick_up = $("#orderssearch-pick_up_id").val();
            const status = $("#orderssearch-status_id").val();
            const date = $("#orderssearch-date_delivery").val();
            const url = `/admin-panel/orders?OrdersSearch[email]=${email}&OrdersSearch[pick_up_id]=${pick_up}&OrdersSearch[status_id]=${status}&OrdersSearch[date_delivery]=${date}&_pjax=#admin-orders-pjax`;
            $.pjax.reload({
                container: "#admin-orders-pjax",
                url: url,
                push: false,
                timeout: 5000,
                replace: false,
            });
        }, 500)
    });

    $('#admin-orders-pjax').on('pjax:end', function () {
        if (typeof(scrollPosition) == 'number') {
            $(window).scrollTop(scrollPosition)
            let email = $('#orderssearch-email')
            const input = email.get(0); // Получаем нативный DOM-элемент
            const length = input.value.length; // Длина текста
            input.setSelectionRange(length, length); // Устанавливаем курсор в конец
            email.focus();
        }
    })
})