$(() => {
    // let searchTimeout

    // $('.category-index').on('keyup', "#categorysearch-title", function(e) {
    //     clearTimeout(searchTimeout);
    //     searchTimeout = setTimeout(() => {
    //         $('#admin-category-filter').submit();
    //     }, 1000);
    // })

    // $('.category-index').on('change', "#categorysearch-parent_id", function(e) {
    //     clearTimeout(searchTimeout);
    //     searchTimeout = setTimeout(() => {
    //         $('#admin-category-filter').submit();
    //     }, 1000);
    // })

    $("#categorysearch-parent_id").on("change", function () {
        const parentId = $(this).val();
        const title = $("#categorysearch-title").val();
        const url = `/admin-lte/category?CategorySearch[title]=${encodeURIComponent(title)}&CategorySearch[parent_id]=${parentId}&_pjax=#category-index-pjax`;
        $.pjax.reload({
            container: "#category-index-pjax",
            url: url,
            timeout: 5000
        });
    });

    $("#categorysearch-title").on("input", function () {
        const title = $(this).val();
        const parentId = $("#categorysearch-parent_id").val();
        const url = `/admin-lte/category?CategorySearch[title]=${encodeURIComponent(title)}&CategorySearch[parent_id]=${parentId}&_pjax=#category-index-pjax`;
        $.pjax.reload({
            container: "#category-index-pjax",
            url: url,
            timeout: 5000
        });
    });
})