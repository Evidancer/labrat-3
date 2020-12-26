<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['break'])) {
    $_SESSION['is_admin'] = false;
    setcookie("is_admin", false, time() + 0);
    echo true;
} else {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION["logged"])) {

        $_SESSION["logged"] = true;

        $sql = mysqli_connect("localhost", "root");
        $sql->query("USE furworks");

        $today = date("Y-m-d H:i:s");

        $sql->query("INSERT INTO sessions SET client_ip='" . $_SERVER["REMOTE_ADDR"] . "', start_time='" . $today . "';");
        $sql->close();
    }

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $res = $sql->query("SELECT * FROM pages WHERE name='header';");
    $sql->close();
    echo $res->fetch_array()[2];
}
