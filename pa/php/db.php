<?php

    $dbhost = "localhost";
    $dblogin = "root";
    $dbpass = "";
    $dbname = "podzamkom";

    $conn = new mysqli($dbhost, $dblogin, $dbpass, $dbname);

    // if ($conn->connect_error) {
    //     die("Ошибка подключения к базе данных: " . $conn->connect_error);
    // } else {
    //     echo "Подключение к базе данных успешно!";
    // }

    $conn->set_charset("utf8");
