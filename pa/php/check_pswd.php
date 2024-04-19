<?php

    $email = $_POST['email'];

    require_once('db.php');
    session_start();

    $sql = "SELECT email FROM `users` WHERE email = '$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {

        session_start();
        function generateConfirmationCode() {
            $code = mt_rand(100000, 999999);
            return $code;
        }
        $confirmationCode = generateConfirmationCode();

        $alertDescr = "НА ПОЧТУ <span>".strtoupper($email)."</span> БЫЛ ВЫСЛАН ПРОВЕРОЧНЫЙ КОД, ВВЕДИТЕ ЕГО В ПОЛЕ НИЖЕ ДЛЯ ПРОДОЛЖЕНИЯ РЕГИСТРАЦИИ";
        require('alert_form.php');

        $_SESSION['email_session'] = $email;
        $_SESSION['confirmation_code'] = $confirmationCode;
        $_SESSION['code_success'] = true;
    } else {

        $alertDescr = "ПОЛЬЗОВАТЕЛЬ С E-MAIL <span>".strtoupper($email)."</span> НЕ БЫЛ НАЙДЕН В БАЗЕ ДАННЫХ. ПОЖАЛУЙСТА, ПРОВЕРЬТЕ ДАННЫЕ И ПОПРОБУЙТЕ ЕЩЁ РАЗ";
        require('alert_form.php');

    }

    $conn->close();