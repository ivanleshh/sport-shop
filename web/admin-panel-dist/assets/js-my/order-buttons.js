$(() => {
    $("#admin-orders-pjax").on("click", ".btn-confirm, .btn-work", function (e) {
        e.preventDefault();
        const a = $(this);
        $.ajax({
            url: a.attr("href"),
            method: 'POST',
            success() {
                $.pjax.reload({
                    container: '#admin-orders-pjax'
                })
            },
        });
    });

    $("#admin-orders-pjax").on("pjax:end", function () {
        $.pjax.reload({
            container: '#toast-pjax'
        })
    })

})