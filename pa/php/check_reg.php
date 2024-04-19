<?php

    require_once('db.php');
    session_start();

    $email = $_POST['email'];
    $password = $_POST['pswd'];
    $reppassword = $_POST['reppswd'];

    if (empty($email) || empty($password)) {

        $alertDescr = "ЗАПОЛНИТЕ ВСЕ ПРЕДСТАВЛЕННЫЕ ПОЛЯ В ФОРМЕ ДЛЯ ПРОДОЛЖЕНИЯ РЕГИСТРАЦИИ НА САЙТЕ";
        require('alert_form.php');

    } elseif ($password != $reppassword) {

        $alertDescr = "ВВЕДЁННЫЕ ВАМИ ПАРОЛИ НЕ СОВПАДАЮТ. ПОЖАЛУЙСТА, УБЕДИТЕСЬ, ЧТО ВЫ ВВЕЛИ ОДИНАКОВЫЕ ЗНАЧЕНИЯ И ПОВТОРИТЕ ПОПЫТКУ";
        require('alert_form.php');

    } elseif (strlen($password) > 32 || strlen($reppassword) > 32 || strlen($password) < 6 || strlen($reppassword) < 6) {

        $alertDescr = "ПАРОЛЬ ДОЛЖЕН БЫТЬ НЕ МЕНЕЕ 6 СИМВОЛОВ И НЕ БОЛЕЕ 32. ПОЖАЛУЙСТА, УБЕДИТЕСЬ, ЧТО ВЫ ВВЕЛИ ДОПУСТИМОЕ КОЛИЧЕСТВО СИМВОЛОВ";
        require('alert_form.php');

    } else {
        // Подготовка SQL-запроса с использованием подготовленного выражения
        $sql = "SELECT email FROM `users` WHERE email = ?";
        $stmt = $conn->prepare($sql);

        // Привязка параметра и выполнение запроса
        $stmt->bind_param("s", $email);
        $stmt->execute();

        // Получение результата
        $stmt->store_result();

        if ($stmt->num_rows > 0) {

            $alertDescr = "E-MAIL АДРЕС <span>".strtoupper($email)."</span> УЖЕ ЗАРЕГИСТРИРОВАН НА САЙТЕ. ПОПРОБУЙТЕ АВТОРИЗОВАТЬСЯ, ЛИБО ВОССТАНОВИТЬ ПАРОЛЬ";
            require('alert_form.php');

        } else {

            function generateConfirmationCode() {
                $code = mt_rand(100000, 999999);
                return $code;
            }
            
            // Генерация кода подтверждения
            $confirmationCode = generateConfirmationCode();

            $alertDescr = "НА ПОЧТУ <span>".strtoupper($email)."</span> БЫЛ ВЫСЛАН ПРОВЕРОЧНЫЙ КОД, ВВЕДИТЕ ЕГО В ПОЛЕ НИЖЕ ДЛЯ ПРОДОЛЖЕНИЯ РЕГИСТРАЦИИ";

            // Сохранение данных в сессии
            $_SESSION['email_session'] = $email;
            $_SESSION['pswd_session'] = password_hash($password, PASSWORD_DEFAULT); // Используем password_hash для хеширования пароля
            $_SESSION['confirmation_code'] = $confirmationCode;
            $_SESSION['registration'] = true;
            $_SESSION['code_success'] = true;
            
            require('alert_form.php');

            exit();
        }
    }

    // Закрытие соединения с базой данных
    $conn->close();