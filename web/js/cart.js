// Список Pjax-контейнеров
const pjaxContainers = [
    '#catalog-pjax',
    '#recently-viewed-pjax',
    '#favourite-pjax',
    '#compare-pjax',
    '#order-pjax',
    '#product-buttons-pjax',
];

// Функция для перезагрузки pjax контейнера по его id
const pjaxReload = (id) => {
    $.pjax.reload({
        container: id,
        timeout: 5000,
        push: false,
        replace: false
    })
}

// Функция для обновления счетчика корзины
const cartItemCount = () => {
    $.pjax.reload({
        container: '#cart-item-count',
        url: $('#cart-item-count').data('url'),
        method: 'POST',
        timeout: 5000,
        push: false,
        replace: false
    });
};

// Функция для обновления уведомлений
const toastReload = () => {
    pjaxReload('#toast-pjax')
};

$(() => {
    // Функция для последовательного обновления Pjax-контейнеров
    const reloadPjaxContainers = () => {
        pjaxContainers.forEach(container => {
            if ($(container).length) {
                pjaxReload(container)
            }
        });
    };

    // Обработчик клика по кнопке открытия корзины
    $('#btn-cart').on('click', (e) => {
        e.preventDefault();
        $.pjax.reload({
            container: '#cart-pjax',
            url: $('#btn-cart').attr('href'),
            push: false,
            replace: false,
            timeout: 5000
        });
    });

    // Обработчик действий в модальном окне корзины
    $('#cart-modal').on('click', '.btn-cart-item-dec, .btn-cart-item-inc, .btn-cart-item-remove, .btn-cart-clear', (e) => {
        e.preventDefault();
        const btn = $(e.currentTarget);
        $.ajax({
            url: btn.attr('href'),
            method: 'POST',
            success: (data) => {
                if (data && data.status) {
                    $.pjax.reload({
                        container: '#cart-pjax',
                        url: $('#btn-cart').attr('href'),
                        push: false,
                        replace: false,
                        timeout: 5000
                    });
                } else {
                    toastReload();
                }
            },
        });
    });

    // Обработчик завершения Pjax для корзины
    $('#cart-pjax').on('pjax:end', () => {
        const cartModal = $('#cart-modal');
        const isCartEmpty = $('#cart-pjax').find('.cart-empty').length > 0;
        cartModal.find('.btn-cart-manger, .cart-panel-top').toggleClass('d-none', isCartEmpty);
        if (!cartModal.hasClass('show')) {
            cartModal.modal('show');
        } else {
            reloadPjaxContainers(); // Обновляем все Pjax-контейнеры последовательно
        }
    });

    // Обработчик для добавления товаров в корзину и удаления
    $("#catalog-pjax, #favourite-pjax, #product-buttons-pjax, #compare-pjax, #recently-viewed-pjax")
        .on("click", ".btn-cart-add, .btn-cart-item-dec, .btn-cart-item-inc", function (e) {
            e.preventDefault();
            const btn = $(this);
            $.ajax({
                url: btn.attr("href"),
                method: 'POST',
                success(data) {
                    if (data) {
                        if (data.status) {
                            pjaxReload(btn.data('pjx'))
                        } else {
                            toastReload()
                        }
                    }
                },
            });
        });

    // Обработчик для избранного и сравнения
    $("#catalog-pjax, #product-buttons-pjax, #recently-viewed-pjax")
        .on("click", ".btn-favourite, .btn-compare", function (e) {
            e.preventDefault();
            const btn = $(this);
            $.ajax({
                url: btn.attr("href"),
                type: "POST",
                data: {
                    id: btn.data("id")
                },
                success(data) {
                    if (typeof (btn.data('pjx')) !== 'undefined') {
                        pjaxReload(btn.data('pjx'))
                    } else {
                        if (btn.hasClass('btn-favourite')) {
                            btn.html(`<i class="bi bi-suit-heart-fill ${data.status ? 'text-danger' : 'text-secondary'}"></i>`)
                        } else if (btn.hasClass('btn-compare')) {
                            btn.html(`<i class="bi bi-bar-chart-line-fill ${data.status ? 'text-warning' : 'text-secondary'}"></i>`)
                        }
                        toastReload()
                    }
                }
            })
        });

    // Обновление счетчика корзины после обновления уведомлений
    $('#toast-pjax').on('pjax:end', () => {
        cartItemCount();
    });

    // Обновление уведомлений после завершения Pjax для любых контейнеров
    $(pjaxContainers.join(',')).on('pjax:end', () => {
        toastReload();
    });
});