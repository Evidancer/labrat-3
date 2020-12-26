<?php

require_once('header.php');

$_SESSION['cur_page'] = 'contacts';
setcookie("cur_page", 'contacts', time() + 3600);

if ($_SESSION['is_admin']) {
    require_once('pageeditor.php');
    require_once('emailbox.php');
} else {
    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $res = $sql->query("SELECT * FROM pages WHERE name='contacts';");
    $sql->close();
    echo $res->fetch_array()[2];

    require_once('emailform.php');
}

?> <?php


    require_once('footer.php');

    ?>