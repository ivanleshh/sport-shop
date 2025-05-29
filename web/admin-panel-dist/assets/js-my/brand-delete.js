$(() => {
    $("#brand-index-pjax").on("click", ".btn-remove", function (e) {
        e.preventDefault();
        const btn = $(this)
        $('#brand-delete').find('.btn-agree').attr('href', btn.attr('href'))
        $('#brand-delete').find('.modal-title').html(`Вы уверены что хотите удалить производителя? <div class='fw-semibold'>${btn.data('title')}</div>`)
        $('#brand-delete').modal('show')
    });

    $("#brand-delete").on("click", ".btn-agree", function (e) {
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

    $("#brand-delete").on("click", ".btn-disagree", function (e) {
        e.preventDefault()
        $('#brand-delete').modal('hide')
    });

    $("#brand-index-pjax").on("pjax:end", function () {
        $('#brand-delete').modal('hide')
    })
})