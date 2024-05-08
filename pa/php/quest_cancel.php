<?php

    require_once('db.php');
    require_once('getUserID.php');
    require_once('client_request.php');

    if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        $code = $_POST['code'];

        $sql = 'SELECT * FROM `orders` WHERE code = ? AND user_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $code, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            $status = $row['status'];
            $date = $row['date'];
            $time = $row['time'];

            // Работа с датой

            $currentDate = date('Y-m-d H:i', strtotime('-1 hour'));
            $formattedDateTime = date('Y-m-d H:i', strtotime("$date $time"));
            $dateProcessing = ($currentDate > $formattedDateTime) ? false : true;

            if($status === 'pending' && $dateProcessing) {
                $sql = 'UPDATE `orders` SET status = "canceled" WHERE code = ?';
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('s', $code);

                if($stmt->execute()) {
                    $message = array(true, 'ЗАПИСЬ НА ВЫБРАННЫЙ КВЕСТ БЫЛА УСПЕШНО ОТМЕНЕНА. ВРЕМЯ ДЛЯ ЗАПИСИ ВНОВЬ ДОСТУПНО.');
                    sendToClient($message);
                    exit;
                } else {
                    $message = array(false, 'ПРОИЗОШЛА ОШИБКА НА СТОРОНЕ СЕРВЕРА. ПОЖАЛУЙСТА, ПЕРЕЗАГРУЗИТЕ СТРАНИЦУ И ПОВТОРИТЕ ПОПЫТКУ.');
                    sendToClient($message);
                    exit;
                }
            } else {
                $message = array(false, 'БЫЛИ ПОЛУЧЕНЫ НЕВЕРНЫЕ ДАННЫЕ, ВОЗМОЖНО КВЕСТ УЖЕ БЫЛ ОТМЕНЁН. ПОЖАЛУЙСТА, ПЕРЕЗАГРУЗИТЕ СТРАНИЦУ И ПОВТОРИТЕ ПОПЫТКУ.');
                sendToClient($message);
                exit; 
            }

        } else {
            $message = array(false, 'ДАННЫЕ ПО КВЕСТУ НЕ БЫЛИ НАЙДЕНЫ. ПОЖАЛУЙСТА, ПЕРЕЗАГРУЗИТЕ СТАРНИЦУ И ПОВТОРИТЕ ПОПЫТКУ.');
            sendToClient($message);
            exit;
        }

    }

?>