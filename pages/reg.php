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


$err = "";

if (
    isset($_POST["userlogin"]) &&
    isset($_POST["useremail"]) &&
    isset($_POST["userpass"])
) {

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");


    $login = $sql->real_escape_string(htmlentities($_POST["userlogin"]));
    $pass = md5(htmlentities($_POST["userpass"]));
    $email = $sql->real_escape_string(htmlentities($_POST["useremail"]));
    $name = $sql->real_escape_string(htmlentities($_POST["username"]));

    if ($sql == false) {
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
    if (!preg_match("/^[a-zA-Z0-9]+$/", $_POST['userlogin'])) {
        $err = "Логин может состоять только из букв английского алфавита и цифр";
    }
    if (strlen($_POST['userlogin']) < 3 or strlen($_POST['userlogin']) > 30) {
        $err .= "Логин должен быть не меньше 3-х символов и не больше 30";
    } else {
        $query = $sql->query("SELECT * FROM users WHERE login='" . $login . "'");
        $res = $query->fetch_row();
        if ($res[0] != "") {
            $err .= "Логин занят.";
            var_dump($res);
        } else {
            $sql->query("INSERT INTO users SET login='" . $login . "', email='" . $email . "', pass='" . $pass . "';");
            setcookie("userlogin", $login, time() + 60);
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
            <form class="reg-form" method="POST" action="reg.php">
                <h1 class="reg-header">Регистрация</h1>
                <label for="userlogin">Логин</label>
                <input required type="text" class="userlogin" name="userlogin" placeholder="Ваш логин">
                <label for="useremail">E-mail</label>
                <input required type="email" class="useremail" name="useremail" placeholder="Адрес e-mail">
                <label for="username">ФИО (необязательно)</label>
                <input type="text" name="username" placeholder="Ваше имя">
                <label for="userpass">Пароль</label>
                <input required class="userpass" type="password" name="userpass" placeholder="Ваш пароль">
                <label for="passcheck">Повторите пароль</label>
                <input required class="passcheck" type="password" name="passcheck" placeholder="Повторите пароль">
                <span class="wrongpass"><?php echo $err ?></span>
                <input class="subreg" type="button" value="Зарегистрироваться">
            </form>
            <script>
                function validateEmail(email) {
                    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
                    return reg.test(String(email).toLowerCase());
                }



                var letsgo = false;
                $(".passcheck").on('input', function() {
                    if ($(".userpass").val() != $(".passcheck").val()) {
                        $(".wrongpass").text("Пароли не совпадают");
                        letsgo = false;
                    } else {
                        $(".wrongpass").text("");
                        letsgo = true;
                    }
                });
                $(".subreg").on("click", function(event) {
                    event.preventDefault();
                    if ($(".username").val() == '' ||
                        $(".useremail").val() == '' ||
                        $(".userpass").val() == '' ||
                        !validateEmail($(".useremail").val())) {
                        $(".wrongpass").text("Не все поля заполнены правильно!");
                    } else
                    if (letsgo) {
                        $(".reg-form").submit();
                    }
                })
            </script>
        </div>
    </div>
</body>

</html>