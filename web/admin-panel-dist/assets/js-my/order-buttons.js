$(() => {
    $("#admin-orders-pjax, #admin-orders-view-pjax").on("click", ".btn-confirm, .btn-work", function (e) {
        e.preventDefault();
        const btn = $(this)
        $('#orders-actions').find('.btn-agree').attr('href', btn.attr('href'))
        $('#orders-actions').find('.modal-title').html(`${btn.html()}? <div class='fw-semibold'>Заказ № ${btn.data('id')}</div>`)
        $('#orders-actions').modal('show')
    });

    $("#orders-actions").on("click", ".btn-agree", function (e) {
        e.preventDefault()
        const a = $(this);
        $.ajax({
            url: a.attr("href"),
            method: 'POST',
            success(data) {
                if (data) {
                    $.pjax.reload({container: a.data('pjx')})
                }
            },
        });
    });

    $("#orders-actions").on("click", ".btn-disagree", function (e) {
        e.preventDefault()
        $('#orders-actions').modal('hide')
    });

    $("#admin-orders-pjax, #admin-orders-view-pjax").on("pjax:end", function () {
        $('#orders-actions').modal('hide')
        $.pjax.reload({
            container: '#toast-pjax'
        })
    })
})