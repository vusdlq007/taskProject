<?php
include("dbconn.php");

$sql = "SELECT * FROM Member";

$result = mysqli_query($connect,$sql);

$row = mysqli_fetch_array($result);
//$_POST['Name1'] ;
$test2 = iconv("UTF-8", "EUC-KR", $row['Name']);
print_r($test2);

echo $test2;
echo "hi";

mysqli_free_result($result);
mysqli_close($connect);


?>