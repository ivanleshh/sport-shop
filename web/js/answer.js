$(() => {
    $('.btn-answer').on('click', function() {
        $('#comment-text').removeClass('is-invalid')
        let answ = $('.answer-show')
        $(this).closest('.comment').next('.answer-form').toggleClass('answer-show');
        $(this).closest('.comment').next('.answer-form').toggleClass('answer-hide');
        if (answ.hasClass('answer-show')) {
            answ.removeClass('answer-show');
            answ.addClass('answer-hide');
        }
    })
})