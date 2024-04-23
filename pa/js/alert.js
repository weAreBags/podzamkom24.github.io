$(document).ready(function() {
    window.workWithAlert = function() {
        var alertElement = $('.notification__block')

        alertElement.on('click', function() {
            alertElement.fadeOut()
        })
        
        if (showNotification) {
            alertElement.fadeIn(function () { 
                setTimeout(function() {
                    alertElement.fadeOut()
                }, 10000)
            })
        }
    }
})
