<?php

    session_start();
    session_unset();
    session_destroy();

    require_once('checkAuthorization.php');

    header("Location: ../authorization.php");