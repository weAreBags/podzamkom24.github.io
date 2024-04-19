<?php

    require_once('db.php');

    // Always start by checking if there's an AJAX request
    if ($_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
       
        $availableTimes = array_fill(0, 7, false);
        $times = array("10:00:00", "12:00:00", "14:00:00", "16:00:00", "18:00:00", "20:00:00", "22:00:00");
        $date = $_POST['date'];

        $sql = "SELECT time FROM `orders` WHERE date = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $date);
        $stmt->execute();

        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $index = array_search($row['time'], $times);
            $availableTimes[$index] = true;
        }

        echo json_encode(["result" => $availableTimes]);
    }
    
    $conn->close();

    // Always stop the script after sending the response
    exit;