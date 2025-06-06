$(() => {
    let category_id;
    $("#compare-pjax").on("click", ".btn-compare, .btn-favourite", function (e) {
            e.preventDefault();
            const a = $(this);
            category_id = a.data('category-id')
            $.ajax({
                url: a.attr("href"), type: "POST", data: {id: a.data("id")},
                success(data) {
                    if (a.hasClass('btn-favourite')) {
                        a.html(`<i class="bi bi-suit-heart-fill ${data.status ? 'text-danger' : 'text-secondary'}"></i>`)
                        toastReload()
                    } else if (a.hasClass('btn-compare') && data.status) {
                        $.pjax.reload({container: '#compare-pjax'})
                    }
                },
            });
        });
    $("#favourite-pjax").on("click", ".btn-compare, .btn-favourite", function (e) {
            e.preventDefault();
            const a = $(this);
            $.ajax({url: a.attr("href"), type: "POST", data: {id: a.data("id")},
                success(data) {
                    if (a.hasClass('btn-compare')) {
                        a.html(`<i class="bi bi-bar-chart-line-fill ` + (data.status ? 'text-warning' : 'text-secondary') + `"></i>`)
                        toastReload()
                    } else if (a.hasClass('btn-favourite') && data.status) {
                        $.pjax.reload({container: '#favourite-pjax'})
                    }
                },
            });
        });
    $('#compare-pjax').on('pjax:end', function () {
        if (typeof category_id !== 'undefined' && $(`#content-${category_id}`).find('.compare-items').children().length) {
            $('.tab-pane.active').removeClass('active show')
            $('.nav-link.active').removeClass('active')
            $(`#content-${category_id}`).addClass('active show')
            $(`#category-${category_id}`).addClass('active')
        }
    })
});