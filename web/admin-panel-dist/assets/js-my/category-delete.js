$(() => {
    $("#category-index-pjax").on("click", ".btn-remove", function (e) {
        e.preventDefault();
        const btn = $(this)
        $('#category-delete').find('.btn-agree').attr('href', btn.attr('href'))
        $('#category-delete').find('.modal-title').html(`Вы уверены что хотите удалить категорию? <div class='fw-semibold'>${btn.data('title')}</div>`)
        $('#category-delete').modal('show')
    });

    $("#category-delete").on("click", ".btn-agree", function (e) {
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

    $("#category-delete").on("click", ".btn-disagree", function (e) {
        e.preventDefault()
        $('#category-delete').modal('hide')
    });

    $("#category-index-pjax").on("pjax:end", function () {
        $('#category-delete').modal('hide')
        $.pjax.reload({
            container: '#toast-pjax'
        })
    })
})