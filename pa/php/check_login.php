<?php

    require_once('db.php');
    session_start();

    $email = $_POST['email'];
    $password = $_POST['pswd'];

    if (empty($email) || empty($password)) {

        $alertDescr = "ЗАПОЛНИТЕ ВСЕ ПРЕДСТАВЛЕННЫЕ ПОЛЯ В ФОРМЕ ДЛЯ АВТОРИЗАЦИИ НА САЙТЕ";
        require('alert_form.php');

    } elseif (strlen($password) > 32 || strlen($email) > 50 || strlen($password) < 6 || strlen($email) < 8) {

        $alertDescr = "ВВЕДЁННЫЕ ДАННЫЕ ИМЕЮТ МИНИМАЛЬНЫЙ/МАКСИМАЛЬНЫЙ ДОПУСТИМЫЙ РАЗМЕР. ПОЖАЛУЙСТА, ПЕРЕПРОВЕРЬТЕ ДАННЫЕ И ПОВТОРИТЕ ПОПЫТКУ";
        require('alert_form.php');

    } else {

        $sql = "SELECT pass, token FROM `users` WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $auth_token = $row['token'];
            $hashedPassword = $row['pass'];

            if (password_verify($password, $hashedPassword)) {
                setcookie("auth_token", $auth_token, time() + 3600*24*10, '/');
                header('Location: ../authorization.php'); // ЕСЛИ ВСЁ НОРМ
            } else {

                $alertDescr = "ВЫ ВВЕЛИ НЕВЕРНЫЙ ЛОГИН ИЛИ ПАРОЛЬ. ПОЖАЛУЙСТА, ПОПРОБУЙТЕ ПОВТОРИТЬ ВХОД ИЛИ ПРОЙДИТЕ ПРОЦЕДУРУ ВОССТАНОВЛЕНИЯ ПАРОЛЯ";
                require('alert_form.php');

            }
        } else {
            
            $alertDescr = "ПОЛЬЗОВАТЕЛЬ С E-MAIL <span>".strtoupper($email)."</span> НЕ БЫЛ НАЙДЕН В БАЗЕ ДАННЫХ. ПОЖАЛУЙСТА, ПРОВЕРЬТЕ ДАННЫЕ И ПОПРОБУЙТЕ ЕЩЁ РАЗ";
            require('alert_form.php');
            
        }
    }

    $conn->close();