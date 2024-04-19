<?php

    require_once('db.php');

    function tokenValidate($auth_token, $conn) {
        $sql = "SELECT name FROM `users` WHERE token = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $auth_token);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
            $stmt->close();

            return $user_data;
        } else {
            $stmt->close();

            return false;
        }
    }

    if(isset($_COOKIE['auth_token'])) {
        $auth_token = $_COOKIE['auth_token'];
        $user_data = tokenValidate($auth_token, $conn);

        if($user_data) {
            $nickname = $user_data['name'];
            setcookie('nickname', $nickname, time() + 3600*24*10, '/');
            header('Location: personal_account.php');
        } else {
            setcookie('auth_token', '', time() - 1, '/');
            header('Location: authorization.php');
        }
    }