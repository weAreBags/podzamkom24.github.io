$(document).ready(function() {
    $('#phone__form').submit(function(event) {
        event.preventDefault()

        var number = $('#phone').val()
        var firstTwoDigits = number.substring(0, 2)

        if (number.length != 11 || firstTwoDigits != 79) {
            alert('Введён некорректный номер телефона. Пожалуйста, повторите попытку.')
        } else {
            $.ajax({
                url: 'php/set_phone.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    number: number
                },
                success: function(responce) {
                    (responce.request) ? location.reload() : alert('Внутренняя ошибка сервера. Пожалуйста, повторите попытку.')
                },
                error: function(xhr) {
                    var errorMessage = 'Произошла ошибка при выполнении запроса.'
                    if (xhr.status === 500) {
                        errorMessage += ' Ошибка сервера: ' + xhr.statusText
                    } else if (xhr.status === 404) {
                        errorMessage += ' Страница не найдена.'
                    } else {
                        errorMessage += ' Статус ошибки: ' + xhr.status
                    }
                    console.error(errorMessage)
                    alert(errorMessage)
                }
            })
        }
    })
})