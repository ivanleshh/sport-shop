$(() => {
    $(".category-index").on("change", "#categorysearch-parent_id", function () {
        const parentId = $(this).val();
        const title = $("#categorysearch-title").val();
        const url = `/admin-panel/category?CategorySearch[title]=${title}&CategorySearch[parent_id]=${parentId}&_pjax=#category-index-pjax`;
        $.pjax.reload({
            container: "#category-index-pjax",
            url: url,
            push: false,
            timeout: 5000,
            replace: false,
        });
    });

    $(".category-index").on("input", "#categorysearch-title", function () {
        const title = $(this).val();
        const parentId = $("#categorysearch-parent_id").val();
        const url = `/admin-panel/category?CategorySearch[title]=${title}&CategorySearch[parent_id]=${parentId}&_pjax=#category-index-pjax`;

        $.pjax.reload({
            container: "#category-index-pjax",
            url: url,
            push: false,
            timeout: 5000,
            replace: false,
        });
    });
})