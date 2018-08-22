<?php
header("Content-Type: text/html charset=utf-8");

//header("Content-Type: application/json");

session_start();

$pnum1 = $_POST['pnum1'];
$pnum2 = $_POST['pnum2'];
$pnum3 = $_POST['pnum3'];
$spnum1=(string)$pnum1;
$spnum2=(string)$pnum2;
$spnum3=(string)$pnum3;

//echo $pnum1;
//
//$_SESSION['phoneNumber'] = (string)$pnum1.(string)$pnum2.(string)$pnum3;
//$_SESSION['phoneNumber'] = "010-7503-1624";
//print_r($_POST); // 휴대폰번호 받으면 DB에 주키로 insert하기
//echo $_SESSION['phoneNumber'];
echo $spnum1."-".$spnum2."-".$spnum3;
//
//Header("Location:../join_check.html");
?>