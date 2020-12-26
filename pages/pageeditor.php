<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['code'])) {
    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");
    $res = $sql->query("UPDATE pages SET code='" . $_POST['code'] . "' WHERE name='" . $_SESSION['cur_page'] . "';");
    $_POST = array();
    $sql->close();


    echo $res;
}

?>

<form class="form" name="form" action="pageeditor.php" method="POST">
    <textarea class="textarea"><?php
                                $sql = mysqli_connect("localhost", "root");
                                $sql->query("USE furworks");
                                $res = $sql->query("SELECT * FROM pages WHERE name='" . $_SESSION['cur_page'] . "';");
                                $res = $res->fetch_array();
                                $sql->close();
                                echo $res[2];
                                ?></textarea>
    <button class="submit">Подтвердить</button>
    <button class="cancel">Отмена</button>
    <button class="upload">Загрузить изображение</button>
    <span class='response'></span>
</form>


<script>
    $(document).ready(() => {
        $(".submit").on("click", () => {
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "pageeditor.php",
                data: {
                    code: $(".textarea").val()
                },
                success: function(response) {
                    $(".response").text('Успех');
                    console.log(response);
                }
            });
        });
        $('.cancel').on('click', () => {
            event.preventDefault();
            window.location.href = getCookie('cur_page') + '.php';
        });
        $('.upload').on('click', () => {
            event.preventDefault();

        });
    });
</script>

<style>
    .form {
        width: 100%;
        height: 500px;
        margin-bottom: 10px;
    }

    .textarea {
        width: 100%;
        height: 100%;
    }

    button {
        margin-bottom: 10px;
    }
</style>