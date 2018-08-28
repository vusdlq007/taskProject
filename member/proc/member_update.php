<?php
session_start();
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");

$_SESSION['authNum'] = "123456";
$request = $_POST ? $_POST : $_GET;


function newPasswordChange($connect,$IsName,$IsID,$IsNewPassword){                            // ID,NAME,PHONE로 Pwd 체크하는 함수             서버에서 다시 ID 유효성 검사

    $hashNewPWD= hash("sha256",$IsNewPassword );

    $sql= "UPDATE Member SET PassWord = '".$hashNewPWD."' WHERE Name = '".$IsName."' AND ID = '".$IsID."';";

//    var_dump($sql);

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);


    if($result){                            //  sql 성공시
        return true;
    }else{                                                 //  sql 실패시
        return false;
    }
};



switch ($request['mode']) {


    case "newPasswordApply" :
        if($_REQUEST['newPassword']==$_REQUEST['newPasswordCheck']){
            $CheckValue = newPasswordChange($connect,$_SESSION['Name'],$_SESSION['ID'],$_REQUEST['newPassword']);
            if($CheckValue){

                $return = ["msg" => '비밀번호 변경 성공!',"result" => 'success'];

            }else{
                $return = ["msg" => '비밀번호 변경 실패!',"result" => 'fail'];
            }
        }else{
            $return = ["msg" => '비밀번호 입력이 정상적이지 않습니다!',"result" => 'fail'];
        }


        break;

    case "findEmail" :



        break;



    case "findPhone_pw" :



        break;



    case "findEmail_pw" :



        break;


}

echo json_encode($return);
?>