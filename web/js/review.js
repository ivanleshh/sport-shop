$(() => {
    $('#product-reviews').on('click', '.btn-add-review, .btn-add-reply', function (e) {
        e.preventDefault()
        $('#form-review').attr('action', $(this).attr('href'))
        $('#review-text').val(null)
        $('#review-stars').rating('clear');
        if ($(this).hasClass('btn-add-review')) {
            $('#review-modal-label').text("Оценка товара")
            $('#review-parent_id').val(null);
            $('#review-stars').parent().removeClass('d-none')
            $('#form-review').yiiActiveForm('add', {
                "id": "review-stars","name": "stars","container": ".field-review-stars",
                "input": "#review-stars","error": ".invalid-feedback",
                "validate": function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, {
                        "message": "Необходимо заполнить «Количество звёзд»."
                    });
                    yii.validation.string(value, messages, {
                        "message": "Значение «Количество звёзд» должно быть строкой.", "skipOnEmpty": 1
                    });
                }
            });
        } else {
            $('#review-modal-label').text("Ответ на комментарий")
            const parent_id = $(this).data('parent-id')
            $('#review-parent_id').val(parent_id)
            $('#review-stars').parent().addClass('d-none')
            $('#form-review').yiiActiveForm('remove', 'review-stars')
            $('#form-review').yiiActiveForm('remove', 'review-stars')
        }
        $('#review-modal').modal('show')
    })

    $('#form-review-pjax').on('pjax:end', function () {
        $('#review-modal').modal('hide')
        $.pjax.reload('#product-reviews-pjax')
    });
})