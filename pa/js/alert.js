$(document).ready(function() {
    var alertElement = $('.alert')

    alertElement.on('click', closeAlert)
    alertElement.fadeIn(function () {
        setTimeout(closeAlert, 10000)
    })

    function closeAlert() {
        alertElement.fadeOut()
    }
})