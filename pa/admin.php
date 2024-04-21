<?php
    require_once('php/db.php');

    if(isset($_COOKIE['auth_token'])) {
        $token = $_COOKIE['auth_token'];

        $sql = 'SELECT role_id FROM `users` WHERE token = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_role = $row['role_id'];
            echo $user_role;

            if($user_role == 1) {
                header('Location: personal_account.php');
                exit;
            }
        } else { 
            header('Location: 404.html');
            exit;
        }
    } else {
        header('Location: authorization.php');
        exit;
    }

    $conn->close();
?>