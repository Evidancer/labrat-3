<?php

$err = "";

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


if (
    isset($_POST["userlogin"]) &&
    isset($_POST["userpass"])
) {

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");


    $login = $sql->real_escape_string(htmlentities($_POST["userlogin"]));
    $pass = md5(htmlentities($_POST["userpass"]));

    if ($sql == false) {
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    } else {
        $query = $sql->query("SELECT * FROM users WHERE login='" . $login . "' AND pass='" . $pass . "';");
        $res = $query->fetch_array();
        if (empty($res)) {
            $err .= "Неправильный логин или пароль";
        } else {
            $_SESSION['ch'] = $res;
            if ($res[5] == true) {
                $_SESSION['is_admin'] = true;
                setcookie("is_admin", true, time() + 3600);
            } else {
                $_SESSION['is_admin'] = false;
            }
            setcookie("userlogin", $login, time() + 3600);
            $_POST = array();
            header('Location: main.php');
            $sql->close();
        }
    }
}
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurWorks - Регестрация</title>
    <script src="/FurWorks/script.js"></script>
    <link rel="stylesheet" href="/FurWorks/style/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>
    <div class="reg-wrap">
        <div class="reg">
            <form class="reg-form" method="POST" action="auth.php">
                <h1 class="reg-header">Авторизация</h1>
                <label for="userlogin">Логин</label>
                <input required type="text" class="userlogin" name="userlogin" placeholder="Ваш логин">
                <label for="userpass">Пароль</label>
                <input required class="userpass" type="password" name="userpass" placeholder="Ваш пароль">
                <span class="wrongpass"><?php echo $err ?></span>
                <input class="subreg" type="button" value="Войти">
            </form>
            <script>
                $(".userpass").on("input", function(event) {
                    $(".wrongpass").text("");
                })
                $(".subreg").on("click", function(event) {
                    event.preventDefault();
                    if ($(".username").val() == '' ||
                        $(".userpass").val() == '') {
                        $(".wrongpass").text("Не все поля заполнены");
                    } else {
                        $(".reg-form").submit();
                    }
                })
            </script>
        </div>
    </div>
</body>

</html>