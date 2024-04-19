<?php

    $password = $_POST['pswd'];
    $reppassword = $_POST['reppswd'];

    require_once('db.php');
    session_start();

    if (isset($_SESSION['newpswd_accepted']) && $_SESSION['newpswd_accepted'] === true) {
        if (empty($password) || empty($reppassword)) {
            
            $alertDescr = "ЗАПОЛНИТЕ ВСЕ ПРЕДСТАВЛЕННЫЕ ПОЛЯ В ФОРМЕ ДЛЯ ВОССТАНОВЛЕНИЯ ПАРОЛЯ НА САЙТЕ";
            require('alert_form.php');

        } elseif ($password != $reppassword) {
            
            $alertDescr = "ВВЕДЁННЫЕ ВАМИ ПАРОЛИ НЕ СОВПАДАЮТ. ПОЖАЛУЙСТА, УБЕДИТЕСЬ, ЧТО ВЫ ВВЕЛИ ОДИНАКОВЫЕ ЗНАЧЕНИЯ И ПОВТОРИТЕ ПОПЫТКУ";
            require('alert_form.php');

        } else {
            $email = $_SESSION['email_session'];

            // Подготовленный запрос для вставки данных в базу данных
            $sql = "UPDATE `users` SET pass = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);

            // Генерация хеша пароля
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Привязка параметров и выполнение запроса
            $stmt->bind_param("ss", $hashedPassword, $email);
            $stmt->execute();

            // Перенаправление на страницу завершения сессии
            header("Location: killthesession.php");
            exit();
        }
    } else {

        $alertDescr = "ОТКАЗАНО В ДОСТУПЕ. ЕСЛИ ЭТО ПРОИЗОШЛО ПО ОШИБКЕ, ТО ОБРАТИТЕСЬ В <span class='helpspan'><a href='https://t.me/podzamkom24'>ТЕХ. ПОДДЕРЖКУ</a></span>";
        require('alert_form.php');
        
    }

    // Закрытие соединения с базой данных
    $conn->close();
