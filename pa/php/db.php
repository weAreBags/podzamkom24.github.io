<?php

    $dbhost = "136.243.14.123"; // localhost
    $dblogin = "podza400_admin"; // root
    $dbpass = "XTHYFRJDNFOTH1"; // пусто
    $dbname = "podza400_database";

    $conn = new mysqli($dbhost, $dblogin, $dbpass, $dbname);

    // if ($conn->connect_error) {
    //     die("Ошибка подключения к базе данных: " . $conn->connect_error);
    // } else {
    //     echo "Подключение к базе данных успешно!";
    // }

    $conn->set_charset("utf8");
