<?php
    require_once('php/db.php');

    if(isset($_GET['quest_link'])){
        $quest_link = $_GET['quest_link'];

        $sql_raiting = 'SELECT `raiting` FROM `reviews` WHERE quest_link = ?';
        $sql_comment = 'SELECT `comment` FROM `reviews` WHERE quest_link = ?';
        $sql_publicated = 'SELECT `publicated` FROM `reviews` WHERE quest_link = ?';
        $sql_userID = 'SELECT `user_id` FROM `reviews` WHERE quest_link = ?';
        $sql_userName = 'SELECT `name` FROM `users` WHERE user_id = ?';

        $stmt = $conn->prepare($sql_raiting);
        $stmt->bind_param('s', $quest_link);
        $stmt->execute();
        $raiting = $stmt->get_result();//Оценка

        $stmt = $conn->prepare($sql_comment);
        $stmt->bind_param('s', $quest_link);
        $stmt->execute();
        $comment = $stmt->get_result();//Комментарий

        $stmt = $conn->prepare($sql_publicated);
        $stmt->bind_param('s', $quest_link);
        $stmt->execute();
        $publicated = $stmt->get_result();//Дата публикации

        $stmt = $conn->prepare($sql_userID);
        $stmt->bind_param('s', $quest_link);
        $stmt->execute();
        $result = $stmt->get_result();//ID пользователя 
        if($result->num_rows()>0){
            $row = $result->fetch_assoc();
            $userID = $row['user_id'];
        }

        $stmt = $conn->prepare($sql_userName);
        $stmt->bind_param('s', $userID);
        $stmt->execute();
        $userID = $stmt->get_result();//Имя пользователя



        
        

        
    }