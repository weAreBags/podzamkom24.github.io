<?php

    // ПРОВЕРКА НА АВТОРИЗАЦИЮ ПОЛЬЗОВАТЕЛЯ ЧЕРЕЗ КУКИ

    if(isset($_COOKIE['auth_token'])) {
        $token = $_COOKIE['auth_token'];

        $sql = 'SELECT * FROM `users` WHERE token = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 0) {
            setcookie('auth_token', "", time() - 1, "/");
            header('Location: authorization.php');
            exit;
        }
    } else {
        header('Location: authorization.php');
        exit;
    }

?>