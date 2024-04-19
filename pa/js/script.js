$(document).ready(function() {

    // скрыть/показать текст над инпутами

    function inputText(form,text_name) {
        $(form).on('input', function() {
            if ($(this).val().length > 0) {
                $(text_name).stop().animate({opacity: 1}, 200)
            } else {
                $(text_name).stop().animate({opacity: 0}, 200)
            }
        })
    }

    inputText('#age','.quest__title--age')
    inputText('#email','.text_email')
    inputText('#pswd','.text_pswd')
    inputText('#reppswd','.text_reppswd')
    inputText('#code','.text_code')
    inputText('#name','.name')

    // СМЕНА НА РЕГИСТРАЦИЮ

    $(document).on('click', '.register_button', function() {
        $('.lost_pswd').css('transition', '0s')
        $('.lost_pswd').fadeOut(200)
        $('.auth_title, .button_text').html("РЕГИСТРАЦИЯ")
        $('.mainForm').attr('action', 'php/check_reg.php')
        $('.help_buttons').animate({paddingTop: 210}, 200)
        $('.reppswd_position').css('display', 'block')
        $('.regFade').animate({opacity: 1}, 200)
        $('.auth_body').animate({height: 600}, 200)
        $(this).html('ЕСТЬ АККАУНТ?')
        $(this).removeClass('register_button').addClass('login_button')
        $('#reppswd').prop('required',true)
    })

    // СМЕНА НА ЛОГИН

    $(document).on('click', '.login_button', function() {
        $('.lost_pswd').fadeIn(200)
        $('.auth_title').html("ВОЙТИ В КАБИНЕТ")
        $('.pswd_position').fadeIn(200)
        $('.button_text').html("ВОЙТИ")
        $('.mainForm').attr('action', 'php/check_login.php')
        $('.help_buttons').animate({paddingTop: 140}, 200).css('gap', '205px')
        $('.reppswd_position').css('display', 'none')
        $('.regFade').animate({opacity: 0}, 200)
        $('.auth_body').animate({height: 530}, 200)
        $(this).html('НЕТ АККАУНТА?')
        $(this).removeClass('login_button').addClass('register_button')
        $('#reppswd').prop('required',false)
        $('.lost_pswd').css('transition', '.3s')
    })

    // СМЕНА НА ВОССТАНОВЛЕНИЕ ПАРОЛЯ

    $(document).on('click', '.lost_pswd', function() {
        $('.lost_pswd, .pswdinput').css('transition', '0s')
        $('.lost_pswd').fadeOut(200)
        $('.pswd_position').css('display', 'none')
        $('.auth_title').html("ВОССТАНОВЛЕНИЕ")
        $('.button_text').html("ВОССТАНОВИТЬ")
        $('.mainForm').attr('action', 'php/check_pswd.php')
        $('.help_buttons').animate({paddingTop: 70}, 200).css('gap', '180px')
        $('.auth_body').animate({height: 460}, 200)
        $('.register_button').html('ВЕРНУТЬСЯ НАЗАД?')
        $('#pswd').prop('required',false)
        $('.register_button').removeClass('register_button').addClass('login_button')
    })

    // УБИЙСТВО СЕССИИ

    $('.prev_button').on('click', function() {
        $.ajax({
            url: 'php/killthesession.php',
            type: 'POST',
            success: function(response) {
                // Обработка успешного ответа от killsession.php
                window.open('authorization.php', '_self') // _blank для нового окна, '_self' для текущего окна
            },
            error: function(error) {
                // Обработка ошибки

                console.error('Произошла ошибка:', error)
            }
        })
    })

    $('.mainForm').validate() // НАСТРОИТЬ [ВАЖНО!!!!!!!!!]

    // [!] PERSONAL ACCOUNT [!] //
    // ДАЛЬШЕ ИДУТ ИСКЛЮЧИТЕЛЬНО НАСТРОЙКИ ПЕРСОНАЛЬНОГО АККАУНТА //
    // [!] PERSONAL ACCOUNT [!] //

})