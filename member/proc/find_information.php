<?php
session_start();
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");

$_SESSION['authNum'] = "123456";
$request = $_POST ? $_POST : $_GET;






function phoneAuth($connect,$isName,$isPhone){                            // Id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID FROM Member where Name ='".$isName."' AND Phone = '".$isPhone."';";

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);

    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            // Id 비교 성공시
        return true;
    }else{                                                 // Id 비교 실패시
        return false;
    }
};




function emailAuth($connect,$isName,$isEmail){                            // Id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID FROM Member where Name ='".$isName."' AND Email = '".$isEmail."';";

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);

    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            // Id 비교 성공시
        return true;
    }else{                                                 // Id 비교 실패시
        return false;
    }
};






function phoneIdCheck($connect,$isName,$isPhone){                            // Id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID FROM Member where Name ='".$isName."' AND Phone = '".$isPhone."';";

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);

    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            // Id 비교 성공시
        return $IsValue["ID"];
    }else{                                                 // Id 비교 실패시
        return false;
    }
};


function emailIdCheck($connect,$isName,$isEmail){                            // Id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID FROM Member where Name ='".$isName."' AND Email = '".$isEmail."';";

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);

    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            // Id 비교 성공시
        return $IsValue["ID"];
    }else{                                                 // Id 비교 실패시
        return false;
    }
};








switch ($request['mode']) {

    case "authPhone" :
            $CheckValue = phoneAuth($connect,$_REQUEST['Names'],$_REQUEST['Phones']);
            if($CheckValue){
                $return = ["msg" => '인증번호 받기 성공!',"result" => 'success'];
            }else{
                $return = ["msg" => '인증번호 받기 실패! 관련된 정보가 없습니다.',"result" => 'fail'];
            }


        break;



    case "authEmail" :

        $CheckValue = emailAuth($connect,$_REQUEST['Names'],$_REQUEST['EMails']);
        if($CheckValue){
            $return = ["msg" => '인증번호 받기 성공!',"result" => 'success'];
        }else{
            $return = ["msg" => '인증번호 받기 실패! 관련된 정보가 없습니다.'.$_REQUEST["Names"].$_REQUEST['Emails'],"result" => 'fail'];
        }


        break;


    case "findPhone" :
                if($_REQUEST['authNum']==$_SESSION['authNum']){
                    $CheckValue = phoneIdCheck($connect,$_REQUEST['Names'],$_REQUEST['Phones']);
                    if($CheckValue){

                        $return = ["msg" => '아이디 찾기 성공!',"ID" => $CheckValue ,"result" => 'success'];
                    }else{
                        $return = ["msg" => '아이디 찾기 실패!',"result" => 'fail'];
                    }
                }else{
                    $return = ["msg" => '인증번호를 확인해주세요!',"result" => 'fail'];
                }
                

        break;

    case "findEmail" :

            if($_REQUEST['authNum']==$_SESSION['authNum']){
                $CheckValue = emailIdCheck($connect,$_REQUEST['Names'],$_REQUEST['Emails']);
                if($CheckValue){

                    $return = ["msg" => '아이디 찾기 성공!',"ID" => $CheckValue ,"result" => 'success'];
                }else{
                    $return = ["msg" => '아이디 찾기 실패!',"result" => 'fail'];
                }}else{
                    $return = ["msg" => '인증번호를 확인해주세요!',"result" => 'fail'];
                    }

        break;



}

echo json_encode($return);

?>