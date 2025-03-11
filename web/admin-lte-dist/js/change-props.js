$(() => {
    $('#product-category_id').on('change', function () {
        var categoryId = $(this).val();
        var blockProps = $('#block-props');
        blockProps.empty();

        if (categoryId) {
            $.ajax({
                url: '/admin-lte/product/get-category-properties',
                type: 'GET',
                data: {
                    category_id: categoryId
                },
                success: function (data) {
                    if (data.length > 0) {
                        $.each(data, function (index, prop) {
                            var html = '<div class="border p-3 my-3 product-props" data-index="' + index + '">' +
                                '<input type="hidden" name="ProductProperty[' + index + '][property_id]" value="' + prop.property_id + '">' +
                                '<div class="mb-3">' +
                                '<label class="form-label">' + prop.property_title + '</label>' +
                                '<input type="text" name="ProductProperty[' + index + '][value]" class="form-control" id="productproperty-' + index + '-value" maxlength="255">' +
                                '</div>' +
                                '</div>';
                            blockProps.append(html);
                        });
                    } else {
                        blockProps.html('<p>У этой категории нет характеристик.</p>');
                    }
                },
                error: function () {
                    blockProps.html('<p>Ошибка загрузки характеристик.</p>');
                }
            });
        } else {
            blockProps.html('<p>Выберите категорию, чтобы отобразить характеристики.</p>');
        }
    });
})