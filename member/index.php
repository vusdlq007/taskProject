<?php
 include "../header.php";
?>

<?php

//print_r($_GET);
//echo $_GET['mode'];

$modeValue = $_GET['mode'];

    $pages = [
        'step_01' => 'view/join_step1.html',
        'step_02' => 'view/join_step2.html',
        'step_03' => 'view/join_step3.html',
        'step_04' => 'view/join_step4.html',
        'pw_find' => 'view/login_pwfind.php'
    ];

    $file = $pages[$modeValue] ?? 'join_step1.html'; // ?? 은 값이 없을때 join1.php를 기본값으로 설정하는 구문

    include $file;


?>

<?php
 include "../footer.php";
?>