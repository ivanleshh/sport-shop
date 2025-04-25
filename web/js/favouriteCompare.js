$(() => {
    $("#favourite-pjax, #compare-pjax").on("click", ".btn-favourite, .btn-compare", function (e) {
        e.preventDefault();
        const a = $(this);
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
});