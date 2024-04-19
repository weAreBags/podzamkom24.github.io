<?php
    require_once('php/checkAuthorization.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="css/style.min.css">

    <title>Авторизация | podzamkom</title>
</head>

<body>
    <section class="authorization">
        <div class="container">
            <form class="mainForm" action="php/check_login.php" method="POST">
                <div class="auth_body">
                    <div class="auth_title">ВОЙТИ В КАБИНЕТ</div>
                    <div class="auth_form">
                        
                        <div class="email_position">
                            <div class="input_title text_email noselect">АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ</div>
                            <input name="email" required placeholder="АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ" type="email" id="email" minlength="8" maxlength="50">
                        </div>
                        
                        <div class="pswd_position">
                            <div class="input_title text_pswd noselect">ПАРОЛЬ</div>
                            <input name="pswd" required placeholder="ПАРОЛЬ" type="password" id="pswd" minlength="6" maxlength="32">
                        </div>
                        
                        <div class="reppswd_position">
                            <div class="input_title text_reppswd title_fade noselect">ПОВТОРИТЕ ПАРОЛЬ</div>
                            <input name="reppswd" class="reppswd regFade" placeholder="ПОВТОРИТЕ ПАРОЛЬ" type="password" id="reppswd" minlength="6" maxlength="32">
                        </div>
                        
                        <div class="help_buttons">
                            <div class="register_button">НЕТ АККАУНТА?</div>
                            <div class="lost_pswd">ЗАБЫЛИ ПАРОЛЬ?</div>
                        </div>
                        <div class="captcha"></div>
                        <div class="button__wrapper">
                            <div class="button__wrapper--text">ВОЙТИ</div>
                            <button type="submit" class="button__wrapper--blur"></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </section>        

    <script src="https://kit.fontawesome.com/c18eb15ed3.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/maskedinput.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/script.js"></script>

    <?php
        session_start();

        // ПОДТВЕРЖДЕНИЕ КОДА

        if (isset($_SESSION['code_success']) && $_SESSION['code_success'] === true) {
            echo "  <script>
                        $('.mainForm').attr('action', 'php/check_code.php');
                        $('.auth_body').css('height','370px');
                        $('.auth_title').html('ПОДТВЕРЖДЕНИЕ');
                        $('.register_button').html('ИЗМЕНИТЬ ДАННЫЕ?').addClass('prev_button').removeClass('register_button');
                        $('.email_position').remove();
                        $('.lost_pswd').remove();
                        $('.captcha').remove();
                        $('#pswd').attr('placeholder','ПРОВЕРОЧНЫЙ КОД').attr('maxlength', '6').attr('minlength', '6').attr('name','code').attr('type','text').attr('id','code');
                        $('.text_pswd').addClass('text_code').removeClass('text_pswd').html('ПРОВЕРОЧНЫЙ КОД');
                        $('.pswd_position').removeClass('pswd_position').addClass('code_position').css('top','110px');
                        $('.help_buttons').css('padding-top','70px');
                        $('.button_text').html('ПОДТВЕРДИТЬ');
                    </script>";
        }

        // СОЗДАНИЕ ФОРМЫ ДЛЯ НОВОГО ПАРОЛЯ

        if (isset($_SESSION['newpswd_form']) && $_SESSION['newpswd_form'] === true) {
            unset($_SESSION['confirmation_code']);
            echo "  <script>
                        $('.reppswd_position').css('display','block');
                        $('.regFade').css('opacity','1');
                        $('.mainForm').attr('action', 'php/setpassword.php');
                        $('.auth_body').css('height','450px');
                        $('.auth_title').html('СОЗДАНИЕ ПАРОЛЯ');
                        $('.text_code').addClass('text_pswd').removeClass('text_code').html('ПАРОЛЬ');
                        $('#code').attr('placeholder','ПАРОЛЬ').attr('minlength', '6').attr('maxlength', '32').attr('type','password').attr('name','pswd').attr('id','pswd');
                        $('.reppswd_position').css('top','180px');
                        $('#reppswd').attr('type','password');
                        $('.help_buttons').css('padding-top','140px');
                    </script>";

        // СОЗДАНИЕ ФОРМЫ ДЛЯ ВВОДА ИМЕНИ

        } elseif(isset($_SESSION['name_form']) && $_SESSION['name_form'] === true) {
            unset($_SESSION['confirmation_code']);
            echo "  <script>
                        $('.mainForm').attr('action', 'php/regdatabase.php');
                        $('.auth_body').css('height','370px');
                        $('.auth_title').html('ПОСЛЕДНИЙ ШАГ');
                        $('.text_code').addClass('text_name').removeClass('text_code').html('ВАШЕ НАСТОЯЩЕЕ ИМЯ');
                        $('#code').attr('placeholder','ВАШЕ НАСТОЯЩЕЕ ИМЯ').attr('minlength', '2').attr('maxlength', '15').attr('name','name').attr('id','name');
                        $('.help_buttons').css('padding-top','70px');
                    </script>";
        }

        if(isset($_SESSION['alert']) && $_SESSION['alert'] === true) {
            $alertDescr = $_SESSION['alert_descr'];
            echo "  <div class='alert'>
                        <div class='alert_title noselect'>УВЕДОМЛЕНИЕ</div>
                        <div class='alert_descr noselect'>".$alertDescr."</div>
                        <div class='alert_xmark noselect'><i class='fa-solid fa-xmark'></i></div>
                    </div>
                    <script>
                    var alertElement = $('.alert');

                    function closeAlert() {
                        alertElement.fadeOut();
                    }

                    alertElement.on('click', closeAlert);
                    alertElement.fadeIn(function () {
                        setTimeout(closeAlert, 10000);
                    });
                    </script>";
            unset($_SESSION['alert']);
        }
        echo $_SESSION['confirmation_code'];
        
        $conn->close();
    ?>
</body>
</html>