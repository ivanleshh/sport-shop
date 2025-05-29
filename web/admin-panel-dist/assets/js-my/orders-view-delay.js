$(() => {
    $('#admin-orders-view-pjax').on('click', '.btn-delay', function(e) {
        e.preventDefault()
        $('#form-delay').attr('action', $(this).attr('href'))
        $('#orders-delay_reason').val('')
        $('#orders-new_date_delivery').val('')
        $('#orders-view-delay-modal').modal('show')
    })

    $('#form-delay-pjax').on('click', '.btn-modal-close', function(e) {
        e.preventDefault()
        $('#orders-view-delay-modal').modal('hide')
    })

    $('#form-delay-pjax').on('pjax:end', function() {
        $('#orders-view-delay-modal').modal('hide')
        $.pjax.reload('#admin-orders-view-pjax')
    });
})