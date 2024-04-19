$(document).ready(function() {
    $('#alert').on('click', function() {
        $('.quest__wrapper').fadeOut('fast')
        $('.quest__legend--block').fadeIn('fast').addClass('is__show')
    })

    $('#legend--xmark').on('click', function() {
        $('.quest__wrapper').fadeIn('fast')
        $('.quest__legend--block').fadeOut('fast').removeClass('is__show')        
    })
})