$(() => {
    let header = $('.header-bottom')

    $(window).scroll(function() {
        if ($(this).scrollTop() > 250) {
            header.addClass('header_fixed')
        } else {
            header.removeClass('header_fixed')
        }
    })
})