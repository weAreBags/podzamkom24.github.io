<?php
    require_once('db.php');
    require_once('getUserID.php');
    require_once('client_request.php');

    if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {

        $code = $_POST['code'];
        $monthArr = [
            'ЯНВАРЯ',
            'ФЕВРАЛЯ',
            'МАРТА',
            'АПРЕЛЯ',
            'МАЯ',
            'ИЮНЯ',
            'ИЮЛЯ',
            'АВГУСТА',
            'СЕНТЯБРЯ',
            'ОКТЯБРЯ',
            'НОЯБРЯ',
            'ДЕКАБРЯ'
        ];
        $weekArr = [
            'ПОНЕДЕЛЬНИК',
            'ВТОРНИК',
            'СРЕДА',
            'ЧЕТВЕРГ',
            'ПЯТНИЦА',
            'СУББОТА',
            'ВОСКРЕСЕНЬЕ'
        ];
        

        if(isset($code) && $code != null && strlen($code) == 5) {
            $sql = 'SELECT * FROM `orders` WHERE user_id = ? AND code = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $user_id, $code);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                $date = $row['date'];
                $time = $row['time'];

                $day = date('j', strtotime($date));
                $month = date('m', strtotime($date));
                $week = date('w', strtotime($date));

                $formattedTime = date('H:i', strtotime($time));
                $formattedMonth = $monthArr[$month - 1];
                $formattedWeek = $weekArr[$week - 1];

                $formattedDate = $day . ' ' . $formattedMonth . ' - ' . $formattedWeek . ' - ' . $formattedTime;

                unset($row['order_id'], $row['user_id'], $row['quest_link'], $row['date'], $row['time'], $row['user_id'], $row['promocode']);
                array_unshift($row, true);
                
                $row['date_time'] = $formattedDate;
                sendToClient($row);
                exit;
            } else {
                $message = array(false, 'Заказ не найден. Пожалуйста, обновите страницу и повторите попытку.');
                sendToClient($message);
                exit;
            }
        } else {
            $message = array(false, 'Получен неверный код заказа. Пожалуйста, обновите страницу и повторите попытку.');
            sendToClient($message);
            exit;
        }

    }

?>