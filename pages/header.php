<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["logged"])) {

    $_SESSION["logged"] = true;

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $today = date("Y-m-d H:i:s");

    $sql->query("INSERT INTO sessions SET client_ip='" . $_SERVER["REMOTE_ADDR"] . "', start_time='" . $today . "'");
    $sql->close();
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurWorks</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="pages/style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="/ratlab-3/script.js"></script>
    <script src="das-lab-1/ratlab-3/script.js"></script>
    <script src="/das-lab-1/ratlab-3/script.js"></script>
    <script src="script.js"></script>
</head>

<body>
    <div class="page">
        <header class="header">
            <div class="logo"></div>
            <nav class="nav">
                <ul class="nav-list">
                    <a href="main.php">
                        <li class="nav-link">ГЛАВНАЯ</li>
                    </a>
                    <a href="about.php">
                        <li class="nav-link">О НАС</li>
                    </a>
                    <a href="catalog.php">
                        <li class="nav-link">КАТАЛОГ</li>
                    </a>
                    <a href="services.php">
                        <li class="nav-link">УСЛУГИ</li>
                    </a>
                    <a href="contacts.php">
                        <li class="nav-link">КОНТАКТЫ</li>
                    </a>
                    <li class="nav-link auth-link">ВХОД</li>
                    <li class="nav-link reg-link">РЕГИСТРАЦИЯ</li>
                </ul>
            </nav>
        </header>
        <div class="wrap">
            <div class="content">