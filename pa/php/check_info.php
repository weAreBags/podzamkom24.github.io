<?php
    require_once('db.php');
    require_once('getUserID.php');
    require_once('client_request.php');

    if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {

        $code = $_POST['code'];

        if(isset($code) && $code != null && strlen($code) == 5) {
            $sql = 'SELECT * FROM `orders` WHERE user_id = ? AND code = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ss', $user_id, $code);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                $message = array(false, 'Заказ не найден. Пожалуйста, обновите страницу и повторите попытку.');
                sendToClient($message);
                exit;
            }
        }

    }

?>