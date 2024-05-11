<?php
    require_once('php/db.php');
    require_once('php/check_au-token.php');
    require_once('php/getUserData.php');

    // УСИЛЕННАЯ ПРОВЕРКА (ТОКЕН + ID_ROLE ПОЛЬЗОВАТЕЛЯ)

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
            header('Location: 404.html');
            exit;
        }
    } else { 
        header('Location: 404.html');
        exit;
    }

    $conn->close();
?>