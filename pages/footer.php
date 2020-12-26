<?php
$sql = mysqli_connect("localhost", "root");
$sql->query("USE furworks");

$res = $sql->query("SELECT * FROM pages WHERE name='footer';");
$sql->close();
echo $res->fetch_array()[2];
