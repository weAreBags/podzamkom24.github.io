<?php
    require_once('php/db.php');

    if(isset($_GET['quest_link'])){
        $quest_link = $_GET['quest_link'];

        $sql = 'SELECT * FROM `reviews` WHERE quest_link = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $quest_link);
        $stmt->execute();
        $result = $stmt->get_result();

        // if($result->num_rows > 0) {
        //     $row = $result->fetch_assoc();
            
        // }

    }