<?php

$mysql_hostname = "localhost";
$mysql_username = "root";
$mysql_password = "162400";
$mysql_database = "hackers";
$mysql_port = "3307";


$connect = mysqli_connect($mysql_hostname,$mysql_username,$mysql_password,$mysql_database,$mysql_port);
//var_dump('t', $connect);
if (!$connect) {
    $error = mysqli_connect_error();

    print "$errno: $error\n";
    echo "실패";
    exit();
}
//
//print_r();
//mysqli_select_db($connect,$mysql_database) or die("DB 선택 실패");
//
//if(!$connect) die('DB연결 실패 : ' . mysqli_error());

//echo "연결성공";

?>