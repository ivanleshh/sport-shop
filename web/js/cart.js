$(() => {
    $('#btn-cart').on('click', (e) => {
        e.preventDefault();
        $.pjax.reload('#cart-pjax', {
            url: $('#btn-cart').attr('href'),
            push: false,
            replace: false,
            timeout: 5000,
        })
    })

    $('#cart-modal').on('click',
        '.btn-cart-item-dec, .btn-cart-item-inc, .btn-cart-item-remove, .btn-cart-clear',
        function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr("href"),
                method: 'POST',
                success(data) {
                    if (data) {
                        if (data.status) {
                            $.pjax.reload("#cart-pjax", {
                                url: $('#btn-cart').attr('href'),
                                push: false,
                                replace: false,
                                timeout: 5000,
                            });
                        } else {
                            error_modal(data.message);
                        }
                    }
                },
            });
        })

    $('#cart-pjax').on('pjax:end', () => {
        if ($('#cart-pjax').find('.cart-empty').length) {
            $('#cart-modal')
                .find('.btn-cart-manger, .cart-panel-top')
                .addClass('d-none')
        } else {
            $('#cart-modal')
                .find('.btn-cart-manger, .cart-panel-top')
                .removeClass('d-none')
        }
        cartItemCount()
        if ($(".toast-container").length) {
            $('.toast').fadeOut('slow', function () {
                $(this).remove();
            });
        }
        pjax_reload()
        $('#cart-modal').modal('show');
    })
})