<?php
    require_once('db.php');

    function sendToClient($message) {
        echo json_encode(["request" => $message]);
    }

    function serverError($error_text) {
        echo json_encode(['error' => $error_text]);
    }

    function checkDropdown($value, $array) {
        return in_array($value, $array);
    }

    if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        $token = $_COOKIE['auth_token'];
        $quest = $_POST['quest'];
        $day = $_POST['day'];
        $time = $_POST['time'];
        $players = $_POST['players'];
        $age = $_POST['age'];
        $actors = $_POST['actors'];
        $promocode = $_POST['promocode'];
        $ageArray = ['child', 'teens', 'adult', 'mixed'];
        $actorsArray = ['wa', 'as', 'ac'];

        if (empty($day) || empty($time) || empty($players) || empty($age) || empty($actors)) {
            $message = '● Некоторые поля пустые. Пожалуйста, заполните все поля.';
            sendToClient($message);
            exit;
        }

        // ПОЛУЧЕНИЕ USER_ID

        $sql = 'SELECT user_id FROM `users` WHERE token = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
        }

        // ЕСТЬ ЛИ УЖЕ ЗАКАЗ НА ПОЛЬЗОВАТЕЛЯ

        $sql = 'SELECT date, time FROM `orders` WHERE user_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $row = array();
            $currentDateTime = date('Y-m-d H:i:s', strtotime('-1 hour'));

            while ($tempVal = $result->fetch_assoc()) {
                $row[] = array('date' => $tempVal['date'], 'time' => $tempVal['time']);
            }

            // Разбиение даты и времени, полученные из БД

            foreach ($row as $rows) {
                $dateTime = $rows['date'] . ' ' . $rows['time'];
                if ($dateTime > $currentDateTime) {
                    // Дата и время из массива больше текущих
                    // Здесь можно выполнить необходимые действия
                    echo json_encode(['request' => 'низя']);
                    exit;
                } else {
                    // Дата и время из массива меньше или равны текущим
                    // Здесь можно выполнить другие действия
                    $val = true;
                }
            }

            // echo json_encode(['request' => $val]);
            // exit;
        }

        // ЗАПРОС ДАТЫ

        $sql = "SELECT date, time FROM `orders` WHERE date = ? AND time = ? AND quest_link = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $day, $time, $quest);
        $stmt->execute();
        $result = $stmt->get_result();

        // ДАТА

        if ($result->num_rows > 0) {
            $message = '● Запись на данную дату уже имеется. Пожалуйста, выберите другое число и время.';
            sendToClient($message);
            exit;            
        } else {
            $currentDate = date('Y-m-d'); // текущий месяц
            $currentDateLastDay = date('Y-m-t');
            $nextDate = date('Y-m-01', strtotime('+1 month', strtotime(date('Y-m-d'))));
            $nextDateLastDay = date('Y-m-t', strtotime('+1 month', strtotime(date('Y-m-d')))); // следующий месяц

            if (!($day >= $currentDate && $day <= $currentDateLastDay || $day >= $nextDate && $day <= $nextDateLastDay)) {
                $message = '● Была введена неверная дата. Пожалуйста, повторите попытку.';
                sendToClient($message);
                exit;
            }
        }

        // ЗАПРОС КОЛИЧЕСТВА ЛЮДЕЙ

        $sql = "SELECT quest_min, quest_max FROM `quests` WHERE quest_link = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $quest);
        $stmt->execute();
        $result = $stmt->get_result();

        // КОЛИЧЕСТВО ЛЮДЕЙ

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $quest_min = $row['quest_min'];
            $quest_max = $row['quest_max'];
            
            if($players < $quest_min || $players > $quest_max) {
                $message = '● Указано неверное количество участников. Пожалуйста, повторите попытку.';
                sendToClient($message);
                exit;
            }
        }

        // DROPDOWN's

        if (!checkDropdown($age, $ageArray) || !checkDropdown($actors, $actorsArray)) {
            $message = '● Выбран некорректный возраст и/или неверная группа актёров. Пожалуйста, повторите попытку.';
            sendToClient($message);
            exit;
        }

        // ПРОВЕРКА НА НОМЕР

        $sql = 'SELECT number FROM `users` WHERE user_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if($row['number'] == null) {
            $numberStatus = false;
            sendToClient($numberStatus);
            exit;
        }

        // if ($user_id)

        // ДОБАВЛЕНИЕ КВЕСТА В ЗАКАЗЫ

        $sql = "INSERT INTO `orders` (user_id, quest_link, date, time, players, age, actors, promocode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $user_id, $quest, $day, $time, $players, $age, $actors, $promocode);

        if ($stmt->execute()) {
            echo json_encode(['request' => 'данные внесены']);
            exit;
        } else {
            echo json_encode(['request' => $user_id . ' ' . $quest . ' ' . $day . ' ' . $time . ' ' . $players . ' ' . $age . ' ' . $actors . ' ' . $promocode]);
            exit;
        }

        echo json_encode(["request" => 'ДАННЫЕ УСПЕШНО ПОЛУЧЕНЫ']);
        exit;
    }

    $conn->close();