<?php
    session_start();
    unset($_SESSION['name']);
    unset($_SESSION['user_id']);
    unset($_SESSION['email']);
    session_destroy();
    header("Location: login.php");
