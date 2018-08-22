<?php
//header("Content-Type: text/html charset=utf-8");
header('Content-Type: application/json');
session_start();


switch ($_POST['mode']){

    case 'auth_num_send' :
        $phone = join('-', $_POST['phone']);
        $_SESSION['auth_num'] = '123456';
        $return = ["msg" => '인증번호를 발송하였습니다.', "result" => 'success'];

        break;
    case 'auth_num_check' :


        break;

}


echo json_encode($return);


//
//Header("Location:../join_step1.html");
?>