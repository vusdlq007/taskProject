<?php

$mysql_hostname = "192.168.56.105";
$mysql_username = "root";
$mysql_password = "162400";
$mysql_database = "hackers";
$mysql_port = "3306";


$connect = mysqli_connect($mysql_hostname,$mysql_username,$mysql_password,$mysql_database,$mysql_port);

if (!$connect) {
    $error = mysqli_connect_error();
    $errno = mysqli_connect_errno();
    print "$errno: $error\n";
    exit();
}

print_r();
//mysqli_select_db($connect,$mysql_database) or die("DB 선택 실패");
//
//if(!$connect) die('DB연결 실패 : ' . mysqli_error());



?>