<?php

    session_start();
    require_once("db.php");

    // Проверка, что пришли данные из формы
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Проверка, что сессия о регистрации была успешной
        if (isset($_SESSION['registration_accepted']) && $_SESSION['registration_accepted'] === true) {
            // Получение данных из формы
            $username = $_POST['name'];

            $auth_token = bin2hex(random_bytes(16));
            
            // Проверка, что имя не пустое и не слишком длинное
            if (empty($username)) {

                $alertDescr = "ВЫ ЗАПОЛНИЛИ НЕ ВСЕ ПОЛЯ. ПОЖАЛУЙСТА, ПЕРЕПРОВЕРЬТЕ ПРЕДОСТАВЛЕННУЮ ФОРМУ И ЗАПОЛНИТЕ ВСЕ НЕОБХОДИМЫЕ ПОЛЯ";
                require('alert_form.php');

            } elseif (mb_strlen($username, 'utf-8') > 15) {

                $alertDescr = "ИМЯ, КОТОРОЕ ВЫ ВВЕЛИ В СТРОКУ ЯВЛЯЕТСЯ СЛИШКОМ БОЛЬШИМ. ЕСЛИ ЭТО ПРОИЗОШЛО ПО ОШИБКЕ, ТО ОБРАТИТЕСЬ В <span class='helpspan'><a href='https://t.me/podzamkom24'>ТЕХ. ПОДДЕРЖКУ</a></span>";
                require('alert_form.php');

            } else {
                // Получение данных из сессии
                $email = $_SESSION['email_session'];
                $password = $_SESSION['pswd_session'];

                // Подготовленный запрос для вставки данных в базу данных
                $sql = "INSERT INTO `users` (email, pass, name, token) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $email, $password, $username, $auth_token);

                // Выполнение запроса
                if ($stmt->execute()) {
                    setcookie('auth_token', $auth_token, time() + 3600*24*10, '/');
                    header("Location: killthesession.php");
                } else {
                    
                    $alertDescr = "ВНУТРЕННЯЯ ОШИБКА СЕРВЕРА. ПОЖАЛУЙСТА, ПОПРОБУЙТЕ ПОЗЖЕ ИЛИ ОБРАТИТЕСЬ В <span class='helpspan'><a href='https://t.me/podzamkom24'>ТЕХ. ПОДДЕРЖКУ</a></span>";
                    require('alert_form.php');

                }

                // Закрытие подготовленного запроса
                $stmt->close();
            }
        } else {
            
            $alertDescr = "ОТКАЗАНО В ДОСТУПЕ. ЕСЛИ ЭТО ПРОИЗОШЛО ПО ОШИБКЕ, ТО ОБРАТИТЕСЬ В <span class='helpspan'><a href='https://t.me/podzamkom24'>ТЕХ. ПОДДЕРЖКУ</a></span>";
            require('alert_form.php');

        }
    } else {
        
        $alertDescr = "ОТКАЗАНО В ДОСТУПЕ. ЕСЛИ ЭТО ПРОИЗОШЛО ПО ОШИБКЕ, ТО ОБРАТИТЕСЬ В <span class='helpspan'><a href='https://t.me/podzamkom24'>ТЕХ. ПОДДЕРЖКУ</a></span>";
        require('alert_form.php');

    }

    // Закрытие соединения с базой данных
    $conn->close();