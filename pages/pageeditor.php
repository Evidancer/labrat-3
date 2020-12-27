<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_FILES['pic'])) {
    move_uploaded_file($_FILES['pic']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/FurWorks/pics/" . basename($_FILES['pic']['name']));
    var_dump($_FILES);
    header("Location: catalog.php");
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

<div class="form" name="form">
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
    <span class='response'></span>
    <form class='imga' name='pic' action='pageeditor.php' enctype='multipart/form-data' method='POST'>
        <input type='hidden' name='MAX_FILE_SIZE' value='30000000' /><input name='pic' type='file'>
    </form></br>
</div>


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
                    $(".imga").submit();
                    console.log(response);
                }
            });
        });
        $('.cancel').on('click', () => {
            event.preventDefault();
            window.location.href = getCookie('cur_page') + '.php';
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