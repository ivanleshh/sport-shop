$(() => {
    $('.brand-index').on('click', '.btn-brand-create, .btn-brand-update', function (e) {
        e.preventDefault()
        $('#form-brand').attr('action', $(this).attr('href'))
        if ($(e.currentTarget).hasClass('btn-brand-create')) {
            $('#form-brand').yiiActiveForm('add', {
                "id": "brand-imagefile",
                "name": "imageFile",
                "container": ".field-brand-imagefile",
                "input": "#brand-imagefile",
                "error": ".invalid-feedback",
                "validate": function (attribute, value, messages, deferred, $form) {
                    yii.validation.required(value, messages, {
                        "message": "Необходимо заполнить «Логотип»."
                    });
                    yii.validation.file(attribute, messages, {
                        "message": "Загрузка файла не удалась.",
                        "skipOnEmpty": true,
                        "mimeTypes": [],
                        "wrongMimeType": "Разрешена загрузка файлов только со следующими MIME-типами: .",
                        "extensions": ["png", "jpg"],
                        "wrongExtension": "Разрешена загрузка файлов только со следующими расширениями: png, jpg.",
                        "maxFiles": 1,
                        "tooMany": "Вы не можете загружать более 1 файла."
                    });
                }
            });
            $('#brand-uploaded-image').html(null)
            $('#brand-modal-label').html('Добавление производителя')
            $('#brand-title').val(null)
        } else {
            $('#form-brand').yiiActiveForm('remove', 'brand-imagefile')
            $('#form-brand').yiiActiveForm('remove', 'brand-imagefile')
            $('#brand-uploaded-image').html(`<img class='w-50' src='${$(this).data('image')}'>`)
            $('#brand-modal-label').html('Редактирование производителя')
            $('#brand-imagefile').removeClass('is-invalid')
            $('#brand-title').removeClass('is-invalid')
            $('#brand-title').val($(this).data('title'))
        }
        $('#brand-modal').modal('show')
    })

    $('#form-brand').on('click', '.btn-modal-close', function (e) {
        e.preventDefault()
        $('#brand-modal').modal('hide')
    })

    $('#form-brand-pjax').on('pjax:end', function () {
        $('#brand-modal').modal('hide')
        $.pjax.reload('#brand-index-pjax')
    });
})