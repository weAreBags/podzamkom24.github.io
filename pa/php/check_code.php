<?php

    $confirmationCode = $_POST['code'];

    session_start();
    require_once('db.php');

    if (isset($_SESSION['confirmation_code'])) {
        if($_SESSION['confirmation_code'] == $confirmationCode) {
            if(isset($_SESSION['registration']) && $_SESSION['registration'] === true) {
                $_SESSION['registration_accepted'] = true;
                $_SESSION['name_form'] = true;
                header("Location: ../authorization.php");
            } else {
                $_SESSION['newpswd_accepted'] = true;
                $_SESSION['newpswd_form'] = true;
                header("Location: ../authorization.php");
            }
        } else {

            $alertDescr = "КОД ДЛЯ ПОДТВЕРЖДЕНИЯ E-MAIL АДРЕСА НЕ СОВПАДАЕТ С ОТПРАВЛЕННЫМ. ПОЖАЛУЙСТА, ПЕРЕПРОВЕРЬТЕ КОД ИЛИ ПОВТОРИТЕ ПОПЫТКУ ПОЗДНЕЕ";
            require('alert_form.php');

        }
    } else {

        $alertDescr = "ОТКАЗАНО В ДОСТУПЕ. ЕСЛИ ЭТО ПРОИЗОШЛО ПО ОШИБКЕ, ТО ОБРАТИТЕСЬ В <span class='helpspan'><a href='https://t.me/podzamkom24'>ТЕХ. ПОДДЕРЖКУ</a></span>";
        require('alert_form.php');

    }

    $conn->close();