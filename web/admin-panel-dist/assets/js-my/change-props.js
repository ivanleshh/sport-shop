$(() => {
    let blockProps = $('#block-props');

    function updateProps(category_id, product_id) {
        $.ajax({
            url: '/admin-panel/product/get-category-properties',
            type: 'GET',
            data: {
                category_id: category_id,
                product_id: product_id
            },
            success: function (data) {
                if (data.length > 0) {
                    $.each(data, function (index, prop) {
                        let html = '<div class="px-3 py-1 border rounded-4 product-props h-auto" data-index="' + index + '">' +
                            '<input type="hidden" name="ProductProperty[' + index + '][property_id]" value="' + prop.property_id + '">' +
                            '<div class="mb-3">' +
                            '<label class="form-label">' + prop.property_title + '</label>' +
                            '<input type="text" value="' + prop.property_value + '" name="ProductProperty[' + index + '][value]" class="form-control" id="productproperty-' + index + '-value" maxlength="255">' +
                            '</div>' +
                            '</div>';
                        blockProps.append(html);
                    });
                } else {
                    blockProps.html('<span class="text-center">Категория не выбрана или у неё отсутствуют характеристики.</span>');
                }
            },
            error: function () {
                blockProps.html('<span class="text-center">Ошибка загрузки характеристик.</span>');
            }
        });
    }

    $('document').ready(function() {
        let categoryId = $('#product-category_id').val()
        let productId = $('#product-id').val() || 0;

        updateProps(categoryId, productId)
    })

    $('#product-category_id').on('change', function () {
        let categoryId = $(this).val();
        let productId = $('#product-id').val() || 0;

        blockProps.empty();
        if (categoryId) {
            updateProps(categoryId, productId)
        } else {
            blockProps.html('<p>Выберите категорию, чтобы отобразить характеристики.</p>');
        }
    });
})