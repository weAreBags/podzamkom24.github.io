<?php
    session_start();
    $_SESSION['alert'] = true;
    $_SESSION['alert_descr'] = $alertDescr;
    header("Location: ../authorization.php");