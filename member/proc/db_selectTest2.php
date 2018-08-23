<?php
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");
//echo $_SERVER['PHP_SELF'];
//$sql = "SET NAMES utf8;";
//
//$result = mysqli_query($connect,$sql);

$sql = "SELECT * FROM Member where ID = 'vusdlq007';";



$result = mysqli_query($connect,$sql);

$row = mysqli_fetch_array($result);
//$_POST['Name1'] ;
//$test2 = iconv("UTF-8", "EUC-KR", $row['Name']);
//
print_r($row);

//echo $test2;
echo "hi";

mysqli_free_result($result);
mysqli_close($connect);


?>