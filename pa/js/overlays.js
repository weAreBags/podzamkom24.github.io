$(document).ready(function() {
    // Используем делегирование событий для обработки кликов на '.overlay--transparent'
    $(document).on('click', '.overlay--transparent, #history__button--back', function() {
        $('.history__cancellation--block, .overlay--transparent').fadeOut('fast', function() {
            $(this).remove();
        });
        $('.history__info--block').fadeIn('fast');
    });
});
