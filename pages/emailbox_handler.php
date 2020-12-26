<?php
if (isset($_POST['getmail'])) {
    $sql = mysqli_connect("localhost", "root");
    $sql->query("USE furworks");
    $res = $sql->query("SELECT * FROM emails;");
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
}
