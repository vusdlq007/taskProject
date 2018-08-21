

<?php
header("Content-Type: application/json");

session_start();

$pnum1 = $_POST['pnum1'];
$pnum2 = $_POST['pnum2'];
$pnum3 = $_POST['pnum3'];


echo $pnum1;



print_r($_POST); // 휴대폰번호 받으면 DB에 주키로 insert하기


//
//Header("Location:../join_check.html");
?>