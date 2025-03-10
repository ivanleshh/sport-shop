$(() => {
    let searchTimeout;

    $('.category-view').on("input", "#productsearch-title", function () {
        const title = $(this).val();
        const id = (new URL(document.location)).searchParams.get('id');
        const url = `/catalog/view?id=${id}&ProductSearch[title]=${title}&_pjax=#catalog-pjax`;

        clearTimeout(searchTimeout)
        searchTimeout = setTimeout(() => {
            $.pjax.reload({
                container: "#catalog-pjax",
                url: url,
                push: false,
                timeout: 5000,
                replace: false,
            });
        }, 1000)
    });
})