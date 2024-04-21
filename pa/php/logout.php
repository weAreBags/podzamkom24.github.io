<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deleteCookie') {
    // Задайте имя cookie, которое вы хотите удалить
    $cookieName = "auth_token";

    // Установите срок действия cookie в прошлое, чтобы удалить его
    setcookie($cookieName, "", time() - 1, "/");
}