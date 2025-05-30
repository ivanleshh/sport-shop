$(() => {
    let scrollPosition = '';
    let searchTimeout;

    $(".product-index").on("input", "#productsearch-category_id, #productsearch-brand_id, #productsearch-title", function () {
        scrollPosition = $(window).scrollTop();

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const title = $("#productsearch-title").val();
            const category = $("#productsearch-category_id").val();
            const brand = $("#productsearch-brand_id").val();
            const url = `/admin-panel/product?ProductSearch[title]=${title}&ProductSearch[category_id]=${category}&ProductSearch[brand_id]=${brand}&_pjax=#product-index-pjax`;
            $.pjax.reload({
                container: "#product-index-pjax",
                url: url,
                push: false,
                timeout: 5000,
                replace: false,
            });
        }, 500)
    });

    $('#product-index-pjax').on('pjax:end', function () {
        if (typeof(scrollPosition) == 'number') {
            $(window).scrollTop(scrollPosition)
            let title = $('#productsearch-title')
            const input = title.get(0); // Получаем нативный DOM-элемент
            const length = input.value.length; // Длина текста
            input.setSelectionRange(length, length); // Устанавливаем курсор в конец
            title.focus();
        }
    })
})