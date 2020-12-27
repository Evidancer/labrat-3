<?php
if (isset($_POST['page'])) {


    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $res = $sql->query("SELECT * FROM goods WHERE id>" . (($_POST['page'] - 1) * 10) . " AND id <= " . ($_POST["page"] * 10) . ";");
    $sql->close();

    $arr = array();

    $_POST = array();

    for ($i = 0;; ++$i) {
        $row = mysqli_fetch_array($res);
        if (empty($row)) {
            break;
        }
        $arr[$i] = $row;
    }

    echo json_encode($arr);
} else if (isset($_POST['goodid'])) {



    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $user = $sql->query("SELECT * FROM users WHERE login ='" . $_COOKIE['userlogin'] . "';");

    $user = mysqli_fetch_array($user);

    $userid = $user[0];

    $today = date("Y-m-d H:i:s");

    $sql->query("INSERT INTO orders SET user_id='" . $userid . "', good_id='" . $_POST['goodid'] . "', time='" . $today . "', phone='" . $_POST['phone'] . "', amount='" . $_POST['amount'] . "', adress='" . $_POST['adress'] . "';");
    $sql->close();

    $_POST = array();

    setcookie("just_bought", true, time() + 60);
    echo true;
} else if (isset($_POST['gname'])) {

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");
    $res = $sql->query("UPDATE goods SET lable='" . $_POST['gname'] . "', description='" . $_POST['gdesc'] . "', picture='" . $_POST['gpic'] . "', availability='" . $_POST['gavail'] . "', price='" . $_POST['gprice'] . "' WHERE id='" . $_POST['gid'] . "';");
    $_POST = array();
    $sql->close();

    echo $res;
} else if (isset($_POST['cgname'])) {

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");
    $res = $sql->query("INSERT INTO goods SET lable='" . $_POST['cgname'] . "', description='" . $_POST['cgdesc'] . "', picture='" . $_POST['cgpic'] . "', availability='" . $_POST['cgavail'] . "', price='" . $_POST['cgprice'] . "';");
    $_POST = array();
    $sql->close();
    echo $res;
} else if (isset($_POST['getorders'])) {

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");
    $res = $sql->query("SELECT * FROM orders;");
    $_POST = array();
    $arr = array();

    for ($i = 0;; ++$i) {
        $arr[$i] = array();
        $row = mysqli_fetch_array($res);
        if (empty($row)) {
            break;
        }
        $arr[$i][0] = $row;

        $user = $sql->query("SELECT * FROM users WHERE id='" . $arr[$i][0][2] . "';");
        $arr[$i][1] = $user->fetch_array();
    }



    $sql->close();
    echo json_encode($arr);
} else if (isset($_FILES['pic'])) {

    move_uploaded_file($_FILES['pic']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "/FurWorks/goods/" . basename($_FILES['pic']['name']));
    header('Location: catalog.php');
} else {
    header('Location: catalog.php');
}
