$(() => {
    $('#product-reviews').on('click', '.btn-add-review', function (e) {
        e.preventDefault()
        $('#review-modal-label').text("Оценка товара")
        $('#form-review').attr('action', $(this).attr('href'))
        $('#review-stars').rating('refresh', {
            disabled: false
        });
        $('#review-parent_id').val(null);
        $('#review-stars').parent().removeClass('d-none')
        $('#review-stars').rating('clear');
        $('#review-text').removeClass('is-valid')
        $('#review-text').val(null)

        $('#form-review').yiiActiveForm('add', {
            "id": "review-stars",
            "name": "stars",
            "container": ".field-review-stars",
            "input": "#review-stars",
            "error": ".invalid-feedback",
            "validate": function (attribute, value, messages, deferred, $form) {
                yii.validation.required(value, messages, {
                    "message": "Необходимо заполнить «Количество звёзд»."
                });
                yii.validation.string(value, messages, {
                    "message": "Значение «Количество звёзд» должно быть строкой.",
                    "skipOnEmpty": 1
                });
            }
        });

        $('#review-modal').modal('show')
    })

    $('#product-reviews').on('click', '.btn-add-reply', function (e) {
        e.preventDefault()
        $('#review-modal-label').text("Ответ на комментарий")
        const parent_id = $(this).data('parent-id')
        $('#review-parent_id').val(parent_id)
        $('#review-stars').rating('clear');
        $('#review-text').removeClass('is-valid')
        $('#review-stars').removeClass('is-invalid')
        $('#review-stars').parent().addClass('d-none')
        $('#form-review').attr('action', $(this).attr('href'))
        $('#review-text').val(null)

        $('#form-review').yiiActiveForm('remove', 'review-stars')
        $('#form-review').yiiActiveForm('remove', 'review-stars')

        $('#review-modal').modal('show')
    })

    $('#form-review-pjax').on('pjax:end', function () {
        $('#review-modal').modal('hide')
        $.pjax.reload('#product-reviews-pjax')
    });
})