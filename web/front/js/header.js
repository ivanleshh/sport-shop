$(() => {
    let header = $('.header-bottom')

    $(window).scroll(function() {
        if ($(this).scrollTop() > 175) {
            header.addClass('header_fixed')
        } else {
            header.removeClass('header_fixed')
        }
    })
})