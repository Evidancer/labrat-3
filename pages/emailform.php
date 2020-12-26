<?php

if (isset($_POST['email'])) {
    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $res = $sql->query("INSERT INTO `emails` SET `text`='" . $_POST['email'] . "', `author`='" . $_POST['author'] . "', `date`='" . date("Y-m-d H:i:s") . "';");
    $_POST = array();
    $sql->close();
    echo $res;
}

?>
<div class="emailform">
    <h2>Написать письмо</h2>
    <div class="">Ваша почта или имя</div>
    <input type="text" class="author">
    <div class="">Письмо: </div>
    <textarea class="emailcontent" placeholder="Текст"></textarea>
    <input class="sub" type="button" value="Отправить">
</div>

<script>
    $(document).ready(() => {
        $('.sub').on("click", () => {
            if ($(".author").val() != undefined &&
                $(".emailcontent").val() != undefined) {
                $.ajax({
                    type: "POST",
                    url: "emailform.php",
                    data: {
                        author: $(".author").val(),
                        email: $(".emailcontent").val()
                    },
                    success: function(response) {
                        console.log(response);
                        $(".sub").val("Успех");
                        window.location.href = "contacts.php";
                    }
                })
            }
        })
    })
</script>

<style>
    .emailbox {
        border-radius: 10px dashed black;
        width: 100%;
    }

    textarea {
        width: 100%;
        height: 300px;
        font-size: 1.1em;
    }

    input {
        font-size: 1.1em;
    }
</style>