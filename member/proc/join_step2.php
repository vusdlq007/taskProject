<?php
//header("Content-Type: text/html charset=utf-8");
header('Content-Type: application/json');
session_start();


switch ($_POST['mode']){

    case 'auth_num_send' :
        //$phone = join('-', $_POST['phone']);
        $phone = implode("-",$_POST['phone']);
        $_SESSION['auth_num'] = '123456';
        $return = ["msg" => '인증번호를 발송하였습니다.', "authNum" => '123456' ,"result" => 'success'];

        break;
    case 'auth_num_check' :
      // $phone = join('-', $_POST['phone']);
        $phone = implode("-",$_POST['phone']);

        $confirmNum = $_POST['confirmNum'];
        $_SESSION['auth_num'] = '123456';
        if($_POST['confirmNum']==$_SESSION['auth_num']){
            $return = ["msg" => '인증번호 확인이 완료되었습니다.', "result" => 'success', "phoneTest" => $phone];
            $_SESSION['phoneNum'] = $phone;
        }else {
            $return = ["msg" => '인증번호가 맞지않습니다.', "result" => 'fail'];
        }

        break;
        

}


echo json_encode($return);


//
//Header("Location:../join_step1.html");
?>