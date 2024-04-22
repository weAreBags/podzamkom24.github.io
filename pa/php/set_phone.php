<?php
    require_once('db.php');

    if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {

        $token = $_COOKIE['auth_token'];
        $number = $_POST['number'];
        $firstTwoDigits = substr($number, 0, 2);

        if(strlen($number) != 11 || $firstTwoDigits != 79) {
            $message = 'Введён некорректный номер телефона. Пожалуйста, повторите попытку.';
            echo json_encode(['request' => $message]);
            exit;
        }

        $sql = 'UPDATE `users` SET number = ? WHERE token = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $number, $token);

        $request = ($stmt->execute()) ? true : false;
        echo json_encode(['request' => $request]);

    }
    
    $conn->close();

?>