$(document).ready(function() {

    alertInteraction = function(status, content) { // status: 0 - error | 1 - alert
        var alertBlock = $('.notification__block')
        var alertTitle = $('.notification__title')
        var alertDescr = $('.notification__descr')

        if (status) {
            alertBlock.removeClass('notification__error').addClass('notification__alert')
            alertTitle.html('УВЕДОМЛЕНИЕ')
        } else {
            alertBlock.removeClass('notification__alert').addClass('notification__error')
            alertTitle.html('ВНУТРЕННЯЯ ОШИБКА')
        }

        alertDescr.html(content)

        alertBlock.fadeIn(function () {            
            var timerID = setTimeout(function() {
                alertBlock.fadeOut()
            }, 10000)

            alertBlock.on('click', function() {
                clearTimeout(timerID)
                alertBlock.fadeOut()
            })
        })
    }
    
})
