$(() => {
    $('.category-form').on('click', '.btn-clear', function () {
        $('#category-parent_id').val('').trigger('change')
    })

    // Функция для генерации списка <option> из propertyOptions
    const generateOptions = () => {
        let options = '<option value="">Выбрать характеристику</option>';
        for (let id in propertyOptions) {
            options += `<option value="${id}">${propertyOptions[id]}</option>`;
        }
        return options;
    };

    let itemCount = $('#block-props').find('.category-props').length
    let startItemCount = itemCount

    const block = (index) => `<div class="border p-3 my-3 category-props col-lg-6 w-100" data-index="${index}">
    <div class="d-flex justify-content-end">
        <div class="btn-group d-flex" role="group">
            <button type="button" class="btn btn-danger btn-remove">-</button>
            <button type="button" class="btn btn-success btn-add">+</button>
        </div>
    </div>
    <div class="d-flex gap-3 mt-2 flex-wrap">
        <div class="field-categoryproperty-${index}-property_id w-220">
            <label class="form-label" for="categoryproperty-${index}-property_id">Выбрать характеристику</label>
            <select id="categoryproperty-${index}-property_id" class="form-control property-select" 
            name="CategoryProperty[${index}][property_id]">
                ${generateOptions()}
            </select>
            <div class="invalid-feedback"></div>
        </div>
        <div class="field-categoryproperty-${index}-property_title">
            <label class="form-label" for="categoryproperty-${index}-property_title">Создать новую</label>
            <input type="text" id="categoryproperty-${index}-property_title" class="form-control props-title"
                name="CategoryProperty[${index}][property_title]" maxlength="255">

            <div class="invalid-feedback"></div>
        </div>
        <div class="mb-3 field-categoryproperty-${index}-id">
            <input type="hidden" id="categoryproperty-${index}-id" class="form-control" name="CategoryProperty[${index}][id]">
            <div class="invalid-feedback"></div>
        </div>
    </div>
</div>`


    $('#block-props').on('click', '.btn-add', () => {

        const $newBlock = $(block(itemCount));
        $('#block-props .category-props:last').after($newBlock);

        const $newSelect = $newBlock.find('.property-select');
        $newSelect.select2({
            placeholder: 'Выбрать характеристику',
            allowClear: true,
            width: '100%',
        });

        const title = `categoryproperty-${itemCount}-property_id`;

        $('#form-category').yiiActiveForm('add', {
            "id": title,
            "name": `[${itemCount}]property_id`,
            "container": `.field-${title}`,
            "input": `#${title}`,
            "error": ".invalid-feedback",
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {
                    "message": "Необходимо заполнить характеристику."
                });
                yii.validation.number(value, messages, {
                    "pattern": /^[+-]?\d+$/,
                    "message": "Значение должно быть целым числом.",
                    "skipOnEmpty": 1
                });
            }
        });
        $('#form-category').yiiActiveForm('validateAttribute', title);

        const itemProp = `categoryproperty-${itemCount}-property_title`;

        $('#form-category').yiiActiveForm('add', {
            "id": itemProp,
            "name": `[${itemCount}]property_title`,
            "container": `.field-${itemProp}`,
            "input": `#${itemProp}`,
            "error": ".invalid-feedback",
            "validate": function (
                attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {
                    "message": "Необходимо заполнить значение."
                });
                yii.validation.string(value, messages, {
                    "message": "Значение должно быть строкой.",
                    "max": 255,
                    "tooLong": "Значение должно содержать максимум 255 символа.",
                    "skipOnEmpty": 1
                });
            }
        })
        $('#form-category').yiiActiveForm('validateAttribute', itemProp);

        itemCount++;
    })

    $('#block-props').on('click', '.btn-remove', function () {
        if ($('#block-props .category-props').length > 1) {
            itemCount--
            const parent = $(this).parents('.category-props')
            const index = parent.data('index')
            $('#form-category').yiiActiveForm('remove', `categoryproperty-${index}-property_id`)
            $('#form-category').yiiActiveForm('remove', `categoryproperty-${index}-property_title`)
            parent.remove();
        }
    })

    $('#block-props').on('input', '.props-title', function () {
        const select = $(this).closest('.category-props').find('.property-select');
        const index = select.closest('.category-props').data('index');

        if (index > startItemCount - 1) {
            const propId = `categoryproperty-${index}-property_id`;
            if ($(this).val().length > 0) {
                select.val(null).trigger('change');
                $('#form-category').yiiActiveForm('remove', propId);
                $(`#${propId}`).removeClass('is-invalid')
            } else {
                $('#form-category').yiiActiveForm('add', {
                    id: propId,
                    name: `CategoryProperty[${index}][property_id]`,
                    container: `.field-categoryproperty-${index}-property_id`,
                    input: `#${propId}`,
                    error: '.invalid-feedback',
                    validate: function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {
                            message: "Необходимо заполнить Свойство."
                        });
                        yii.validation.number(value, messages, {
                            pattern: /^[+-]?\d+$/,
                            message: "Значение «Свойство» должно быть целым числом.",
                            skipOnEmpty: 1
                        });
                    }
                });
                $(`#${propId}`).removeClass('is-valid')
                $('#form-category').yiiActiveForm('validateAttribute', propId);
            }
        }
    });

    $('#block-props').on('change', '.property-select', function () {
        const input = $(this).closest('.category-props').find('.props-title');
        const index = $(this).closest('.category-props').data('index');

        if (index > startItemCount - 1) {
            const titleId = `categoryproperty-${index}-property_title`;
            if ($(this).val()) {
                input.val('');
                $('#form-category').yiiActiveForm('remove', titleId);
                const formData = $('#form-category').data('yiiActiveForm');
                if (formData && formData.attributes) {
                    formData.attributes = formData.attributes.filter(attr => attr.id !== titleId);
                }
                input.removeClass('is-invalid')
                    .closest('.field-categoryproperty-' + index + '-property_title')
                    .find('.invalid-feedback')
                    .text('');
                $(`#${titleId}`).addClass('is-valid')
            } else {
                $('#form-category').yiiActiveForm('add', {
                    id: titleId,
                    name: `[${index}]property_title`,
                    container: `.field-categoryproperty-${index}-property_title`,
                    input: `#${titleId}`,
                    error: '.invalid-feedback',
                    validate: function (attribute, value, messages, deferred, form) {
                        yii.validation.required(value, messages, {
                            message: "Необходимо заполнить «Значение»."
                        });
                        yii.validation.string(value, messages, {
                            message: "Значение должно быть строкой.",
                            max: 255,
                            tooLong: "Значение должно содержать максимум 255 символа.",
                            skipOnEmpty: 1
                        });
                    }
                });
                $('#form-category').yiiActiveForm('validateAttribute', titleId);
            }
        }
    });
})