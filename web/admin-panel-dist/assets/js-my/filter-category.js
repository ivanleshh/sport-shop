$(() => {
    let scrollPosition = '';
    let searchTimeout;

    $('.category-index').on('input', "#categorysearch-parent_id, #categorysearch-title", function () {
        scrollPosition = $(window).scrollTop();

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const parentId = $("#categorysearch-parent_id").val();
            const title = $("#categorysearch-title").val();
            const url = `/admin-panel/category?CategorySearch[title]=${title}&CategorySearch[parent_id]=${parentId}&_pjax=#category-index-pjax`;
            $.pjax.reload({
                container: "#category-index-pjax",
                url: url,
                push: false,
                timeout: 5000,
                replace: false,
            });
        }, 500);
    });

    $('#category-index-pjax').on('pjax:end', function () {
        if (typeof(scrollPosition) == 'number') {
            $(window).scrollTop(scrollPosition)
            let title = $('#categorysearch-title')
            const input = title.get(0); // Получаем нативный DOM-элемент
            const length = input.value.length; // Длина текста
            input.setSelectionRange(length, length); // Устанавливаем курсор в конец
            title.focus();
        }
    })
})