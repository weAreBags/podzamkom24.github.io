$(document).ready(function() {

    var targetDiv = $('.input__info--default')

    targetDiv.on('mouseenter', function() {
        var id = $(this).data('id')
        var hoverDiv = $('#popup--' + id)
        hoverDiv.stop().fadeIn(300).css('display', 'flex')
    })

    targetDiv.on('mouseleave', function() {
        var id = $(this).data('id')
        var hoverDiv = $('#popup--' + id)
        hoverDiv.stop().fadeOut(300)
    })

})