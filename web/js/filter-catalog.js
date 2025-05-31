$(() => {
    let scrollPosition = '';
    let searchTimeout;

    $('.category-view').on('input', "#productsearch-title, #productsearch-brand_id", function (e) {
        scrollPosition = $(window).scrollTop();
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const title = $("#productsearch-title").val();
            const brand = $("#productsearch-brand_id").val();
            const id = (new URL(document.location)).searchParams.get('id');
            const url = `/catalog/view?id=${id}&ProductSearch[title]=${title}&ProductSearch[brand_id]=${brand}&_pjax=#catalog-pjax`;
            $.pjax.reload({container: "#catalog-pjax", url: url, push: false, timeout: 5000, replace: false});
        }, 500)
    });

    $('#catalog-pjax').on('pjax:end', function () {
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