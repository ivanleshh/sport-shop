$(() => {
    $(document).ready(function () {
        console.log('Скрипт запущен');

        $('#product-form').off('beforeSubmit').on('beforeSubmit', function (e) {
            console.log('Событие beforeSubmit сработало');
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    console.log('Успешный ответ от сервера:', response);
                    if (response.success) {
                        console.log('Обновляем product_id:', response.product_id);
                        $('#product-id').val(response.product_id);
                        var fileCount = $('#product-file-input').fileinput('getFilesCount');
                        console.log('Количество файлов для загрузки:', fileCount);
                        if (fileCount > 0) {
                            console.log('Запускаем загрузку FileInput');
                            $('#product-file-input').fileinput('upload');
                        } else {
                            console.log('Файлы не выбраны, перенаправляем');
                            window.location = '/admin-panel/product/view?id=' + response.product_id;
                        }
                    } else {
                        console.log('Сервер вернул неуспешный ответ:', response);
                    }
                },
                error: function (xhr, status, error) {
                    console.log('Ошибка AJAX:', status, error);
                    console.log('Ответ сервера:', xhr.responseText);
                }
            });
            return false;
        });
    });
})