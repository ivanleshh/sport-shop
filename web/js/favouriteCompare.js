$(() => {
    $("#favourite-pjax, #compare-pjax").on("click", ".btn-favourite, .btn-compare", function (e) {
        e.preventDefault();
        const a = $(this);
        category_id = a.data('category')
        $.ajax({
            url: a.attr("href"),
            type: "POST",
            data: {
                id: a.data("id")
            },
            success() {
                if ($('#compare-pjax').length > 0) {
                    $.pjax.reload('#compare-pjax');
                }
                if ($('#favourite-pjax').length > 0) {
                    $.pjax.reload('#favourite-pjax');
                }
            },
        });
    });

    $('#compare-pjax').on('pjax:end', function () {
        if (typeof category_id !== 'undefined') {
            $('.active').removeClass('active show')
            $(`#content-${category_id}`).addClass('active show')
            $(`#category-${category_id}`).addClass('active show')
        }
    })
});