<?php

    function sendToClient($message) {
        echo json_encode(["request" => $message]);
    }

?>