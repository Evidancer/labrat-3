<?php
if (isset($_POST['page'])) {

    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");

    $res = $sql->query("SELECT * FROM goods WHERE id>" . (($_POST['page'] - 1) * 10) . " AND id <= " . ($_POST["page"] * 10) . ";");
    $sql->close();

    $arr = array();

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

    $sql->query("INSERT INTO orders SET user_id='" . $userid . "', good_id='" . $_POST['goodid'] . "', time='" . $today . "';");
    $sql->close();

    echo true;
} else {

    echo json_encode(array("bobik" => 22));
}
