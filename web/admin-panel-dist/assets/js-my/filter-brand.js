$(() => {
    let scrollPosition = '';
    let searchTimeout;

    $(".brand-index").on("input", "#brandsearch-title", function () {
        scrollPosition = $(window).scrollTop();

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const title = $(this).val();
            const url = `/admin-panel/brand?BrandSearch[title]=${title}&_pjax=#brand-index-pjax`;

            $.pjax.reload({
                container: "#brand-index-pjax",
                url: url,
                push: false,
                timeout: 5000,
                replace: false,
            });
        }, 500);
    })

    $('#brand-index-pjax').on('pjax:end', function () {
        $(window).scrollTop(scrollPosition)
        let title = $('#brandsearch-title')
        const input = title.get(0); // Получаем нативный DOM-элемент
        const length = input.value.length; // Длина текста
        input.setSelectionRange(length, length); // Устанавливаем курсор в конец
        title.focus();
    })
})