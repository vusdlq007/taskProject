<?php
session_start();
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");

$_SESSION['authNum'] = "123456";
$request = $_POST ? $_POST : $_GET;




function newPasswordChange($connect,$IsName,$IsID,$IsNewPassword){                            // ID,NAME,PHONE로 Pwd 체크하는 함수             서버에서 다시 ID 유효성 검사

    $hashNewPWD= hash("sha256",$IsNewPassword );

    $sql= "UPDATE Member SET PassWord = '".$hashNewPWD."' WHERE Name = '".$IsName."' AND ID = '".$IsID."';";


    $result = mysqli_query($connect,$sql);


    if($result){                            //  sql 성공시
        return true;
    }else{                                                 //  sql 실패시
        return false;
    }
};


function newMyInfoChange($connect,$IsName,$IsID,$IsNewPassword,$IsPhone,$IsNewEmail,$IsNewFullAddress,$IsSMSOK,$IsMailOK,$IsIDX){                            // ID,NAME,PHONE로 Pwd 체크하는 함수             서버에서 다시 ID 유효성 검사

    $hashNewPWD= hash("sha256",$IsNewPassword );

    $sql= "UPDATE Member SET PassWord = '".$hashNewPWD."', Email = '".$IsNewEmail."', Addr = '".$IsNewFullAddress."', SMSAgree = '".$IsSMSOK."', MailAgree = '".$IsMailOK."' WHERE Name = '".$IsName."' AND ID = '".$IsID."' AND phone = '".$IsPhone."' AND MemberIDX = '".$IsIDX."';";


    $result = mysqli_query($connect,$sql);


    if($result){                            //  sql 성공시
        return true;
    }else{                                                 //  sql 실패시
        return false;
    }
};





switch ($request['mode']) {


    case "newPasswordApply" :
        if($_REQUEST['newPassword']==$_REQUEST['newPasswordCheck']){
            $CheckValue = newPasswordChange($connect,$_SESSION['Name'],$_SESSION['ID'],$_REQUEST['newPassword']);                       // 여기서 session 변수의 $_SESSION['Name']는 왜 $_SESSION['UserName']이 아니냐면 $_SESSION['UserName']변수는 로그인후 
            if($CheckValue){                                                                                                            //생성하는 로그인여부를 체크하는 변수이기때문 $_SESSION['Name']은 아이디 찾기 및 비밀번호 찾을때 생성되는것

                $return = ["msg" => '비밀번호 변경 성공!',"result" => 'success'];

            }else{
                $return = ["msg" => '비밀번호 변경 실패!',"result" => 'fail'];
            }
        }else{
            $return = ["msg" => '비밀번호 입력이 정상적이지 않습니다!',"result" => 'fail'];
        }


        break;

    case "newFullInfoApply" :
        if(  !$_POST['Pwd'] || !$_POST['Email'] || !$_POST['FullAddress'] || !$_POST['SMSOK'] || !$_POST['MailOK']){       // 백핸드에서 유효성 검사 다시해주기
            $return = ["msg" => '필수입력값이 정상적이지 않거나 비었습니다!',"result" => 'fail'];
            return false;

        }else{
            $CheckValue = newMyInfoChange($connect,$_SESSION['UserName'],$_SESSION['UserID'],$_POST['Pwd'],$_SESSION['UserPhone'],$_POST['Email'],$_POST["FullAddress"],$_POST['SMSOK'],$_POST['MailOK'],$_SESSION['UserIDX']);
            if($CheckValue){

                $return = ["msg" => '내정보 변경 성공!',"result" => 'success'];
                echo "<script>alert('정보변경성공!');</script>";


            }else{
                $return = ["msg" => '내정보 변경 실패!',"result" => 'fail'];
            }
        }



        break;





}

echo json_encode($return);
?>