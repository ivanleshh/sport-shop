$(() => {
    $(".brand-index").on("input", "#brandsearch-title", function () {
        const title = $(this).val();
        const url = `/admin-panel/brand?BrandSearch[title]=${title}&_pjax=#brand-index-pjax`;

        $.pjax.reload({
            container: "#brand-index-pjax",
            url: url,
            push: false,
            timeout: 5000,
            replace: false,
        });
    });
})