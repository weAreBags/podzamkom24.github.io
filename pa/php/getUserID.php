<?php
    $token = $_COOKIE['auth_token'];

    $sql = 'SELECT user_id FROM `users` WHERE token = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
    }

?>