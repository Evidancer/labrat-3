<?php

require_once('header.php');

$_SESSION['cur_page'] = 'services';
setcookie("cur_page", 'services', time() + 3600);

if ($_SESSION['is_admin']) {
    require_once('pageeditor.php');
} else {
    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $res = $sql->query("SELECT * FROM pages WHERE name='services';");
    $sql->close();
    echo $res->fetch_array()[2];
}


require_once('footer.php');
