<?php

require_once('header.php');

$_SESSION['cur_page'] = 'main';
setcookie("cur_page", 'main', time() + 3600);

if ($_SESSION['is_admin']) {
    require_once('pageeditor.php');
} else {
    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");
    $res = $sql->query("SELECT * FROM pages WHERE name='main';");
    $sql->close();
    echo $res->fetch_array()[2];
}



require_once('footer.php');
