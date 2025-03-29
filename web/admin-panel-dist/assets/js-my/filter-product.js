$(() => {
    $(".product-index").on("change", "#productsearch-category_id, #productsearch-brand_id", function () {
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
    });

    $(".product-index").on("input", "#productsearch-title", function () {
        const title = $(this).val();
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
    });
})