$(() => {
    $("#product-index-pjax").on("click", ".btn-remove", function (e) {
        e.preventDefault();
        const btn = $(this)
        $('#product-delete').find('.btn-agree').attr('href', btn.attr('href'))
        $('#product-delete').find('.modal-title').html(`Вы уверены что хотите удалить товар? <div class='fw-semibold'>${btn.data('title')}</div>`)
        $('#product-delete').modal('show')
    });

    $("#product-delete").on("click", ".btn-agree", function (e) {
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

    $("#product-delete").on("click", ".btn-disagree", function (e) {
        e.preventDefault()
        $('#product-delete').modal('hide')
    });

    $("#product-index-pjax").on("pjax:end", function () {
        $('#product-delete').modal('hide')
        $.pjax.reload({
            container: '#toast-pjax'
        })
    })
})