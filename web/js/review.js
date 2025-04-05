$(() => {
    $('#product-reviews').on('click', '.btn-add-review', function (e) {
        e.preventDefault()
        $('#form-review').attr('action', $(this).attr('href'))
        $('#review-stars').rating('refresh', { disabled: false });
        $('#review-stars').rating('clear');
        $('#review-text').removeClass('is-valid')
        $('#review-text').val(null)
        $('#review-modal').modal('show')
    })

    $('#product-reviews').on('click', '.btn-add-reply', function (e) {
        e.preventDefault()
        const parent_id = $(this).data('parent-id')
        $('#parent_id').val(parent_id)
        $('#review-stars').rating('clear');
        $('#review-text').removeClass('is-valid')
        $('#review-stars').rating('refresh', { disabled: true });
        $('#form-review').attr('action', $(this).attr('href'))
        console.log($('#review-stars').prev())
        $('#review-text').val(null)
        $('#review-modal').modal('show')
    })

    $('#form-review-pjax').on('click', '.btn-modal-close', function (e) {
        e.preventDefault()
        $('#review-modal').modal('hide')
    })

    $('#form-review-pjax').on('pjax:end', function () {
        $('#review-modal').modal('hide')
        $.pjax.reload('#product-reviews-pjax')
    });
})