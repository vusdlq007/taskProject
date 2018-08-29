<?php
 include "../header.php";
?>

<?php

//print_r($_GET);
//echo $_GET['mode'];

$modeValue = $_GET['mode'];



    if($_SESSION['adminCode']=="1"){
        $pages = [
            'step_01' => 'view/join_step1.html',
            'step_02' => 'view/join_step2.html',
            'step_03' => 'view/join_step3.html',
            'step_04' => 'view/join_step4.html',
            'id_find' => 'view/login_idfind.php',
            'id_find_complete' => 'view/id_find_complete.php',
            'pw_find' => 'view/login_pwfind.php',
            'pw_find_complete' => 'view/pw_find_complete.php',
            'member_info_modify' => 'view/member_info_modify.php',
            'list' => 'view/lecture_board/attending_after_list.php',
            'admin_page' => 'admin/index.php'
        ];
    }else{
        $pages = [
            'step_01' => 'view/join_step1.html',
            'step_02' => 'view/join_step2.html',
            'step_03' => 'view/join_step3.html',
            'step_04' => 'view/join_step4.html',
            'id_find' => 'view/login_idfind.php',
            'id_find_complete' => 'view/id_find_complete.php',
            'pw_find' => 'view/login_pwfind.php',
            'pw_find_complete' => 'view/pw_find_complete.php',
            'member_info_modify' => 'view/member_info_modify.php',
            'list' => 'view/lecture_board/attending_after_list.php',
        ];
    }

    $file = $pages[$modeValue] ?? 'join_step1.html'; // ?? 은 값이 없을때 join1.php를 기본값으로 설정하는 구문

    include $file;


?>

<?php
 include "../footer.php";
?>