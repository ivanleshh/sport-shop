$(() => {
    $(document).ready(function () {
        $('#product-form').off('beforeSubmit').on('beforeSubmit', function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#product-id').val(response.product_id);
                    var fileCount = $('#product-file-input').fileinput('getFilesCount');
                    if (fileCount > 0) {
                        $('#product-file-input').fileinput('upload');
                    } else {
                        window.location = '/admin-panel/product';
                    }
                },
            });
            return false;
        });
    });
})