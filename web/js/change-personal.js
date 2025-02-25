$(() => {
    $('#personal-pjax').on('click', '.btn-change-personal', function(e) {
        e.preventDefault()
        $('#form-personal').attr('action', $(this).attr('href'))
        $('#user-password').val('')
        $('#user-password_repeat').val('')
        $('#change-personal-modal').modal('show')
    })

    $('#form-personal-pjax').on('click', '.btn-modal-close', function(e) {
        e.preventDefault()
        $('#change-personal-modal').modal('hide')
    })

    $('#form-personal-pjax').on('pjax:end', function() {
        $('#change-personal-modal').modal('hide')
        $.pjax.reload('#personal-pjax')
    })
})