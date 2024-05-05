$(document).ready(function() {
    $('#button__check--moreinfo').click(function(e) {
        e.preventDefault()

        var history_block = $(this).closest('.history__block')
        var code = history_block.attr('data-history')
        console.log(code)

        $.ajax({
            url: 'php/check_info.php',
            method: 'POST',
            dataType: 'json',
            data: {
                code: code
            },
            success: function(responce) {
                var statusResponce = responce.request[0]
                alert(statusResponce)

                if(!statusResponce) {
                    var errorMessage = responce.request[1]
                    alertInteraction(false, errorMessage)
                }
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    errorMessage = 'Страница обработки запроса не найдена. Пожалуйста, обновите страницу или обратитесь в техническую поддержку.'
                } else {
                    errorMessage = 'Статус ошибки: ' + xhr.status + '. Пожалуйста, обновите страницу или обратитесь в тех. поддержку.'
                }

                alertInteraction(false, errorMessage)
            }
        })
    })
})