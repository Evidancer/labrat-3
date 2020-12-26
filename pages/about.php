<?php

require_once('header.php');

$_SESSION['cur_page'] = 'about';
setcookie("cur_page", 'about', time() + 3600);

if ($_SESSION['is_admin']) {
    require_once('pageeditor.php');
} else {

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $res = $sql->query("SELECT * FROM pages WHERE name='about';");
    $sql->close();
    echo $res->fetch_array()[2];
}

?>
<?php

require_once('footer.php');

?>