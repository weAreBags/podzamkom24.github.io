$(document).ready(function() {
    // ВЫЙТИ ИЗ АККАУНТА

    $("#logout").on('click', function() {
        $.ajax({
            url: 'php/logout.php',
            type: 'POST',
            data: { action: 'deleteCookie' },
            success: function(response) {
                window.location.href = 'authorization.php'
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
    })

    // ЗАКРЫТЬ МОДАЛЬНОЕ ОКНО СЛЕВА И ЕЩЁ ВСЯКИЕ ОКНА ПРИ НАЖАТИИ НА ОВЕРЛЕЙ

    $('#closeDialog, .overlay').on('click', function() {
        $('#dialog').animate({left: -400}, 200)
        $('.overlay,  .close__modal').fadeOut('fast')
        $('body').toggleClass('no-scroll')
    })

    $('.nav__unwrap--button').on('click', function() {
        $('#dialog').animate({left: 0}, 200)
        $('.overlay').fadeIn('fast')
        $('body').toggleClass('no-scroll')
    })
})