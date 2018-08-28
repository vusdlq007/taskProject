<?php
session_start();
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");

$_SESSION['authNum'] = "123456";
$request = $_POST ? $_POST : $_GET;




function phoneIdCheck($connect,$isName,$isPhone){                            // NAME.Email로 Id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID,Name FROM Member where Name ='".$isName."' AND Phone = '".$isPhone."';";

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);

    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            // Id 비교 성공시
        $_SESSION['ID'] = $IsValue["ID"];
        $_SESSION['Name'] = $IsValue["Name"];
        return $IsValue["ID"];
    }else{                                                 // Id 비교 실패시
        return false;
    }
};


function emailIdCheck($connect,$isName,$isEmail){                            // NAME.Email로 id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID,Name FROM Member where Name ='".$isName."' AND Email = '".$isEmail."';";

    $result = mysqli_query($connect,$sql);


    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            // Id 비교 성공시
        $_SESSION['ID'] = $IsValue["ID"];
        $_SESSION['Name'] = $IsValue["Name"];
        return $IsValue["ID"];
    }else{                                                 // Id 비교 실패시
        return false;
    }
};



function phoneIdCheckPW($connect,$isName,$IsId,$isPhone){                            // ID,NAME,PHONE로 Pwd체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID,Name,PassWord FROM Member where Name ='".$isName."' AND Phone = '".$isPhone."' AND ID = '".$IsId."';";
  //  var_dump($sql);
    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);

    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            //  비교 성공시
        $_SESSION['ID'] = $IsValue["ID"];
        $_SESSION['Name'] = $IsValue["Name"];

        return true;
    }else{                                                 //  비교 실패시
        return false;
    }
};


function emailIdCheckPW($connect,$isName,$IsId,$isEmail){                            // ID,NAME,PHONE로 Pwd 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT ID,Name,PassWord FROM Member where Name ='".$isName."' AND Email = '".$isEmail."' AND ID = ''.$IsId.'';";

    $result = mysqli_query($connect,$sql);


    $IsValue = mysqli_fetch_array($result);

    if($IsValue){                            //  비교 성공시
        $_SESSION['ID'] = $IsValue["ID"];
        $_SESSION['Name'] = $IsValue["Name"];
        return true;
    }else{                                                 //  비교 실패시
        return false;
    }
};







switch ($request['mode']) {



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
                }
            }else{
                    $return = ["msg" => '인증번호를 확인해주세요!',"result" => 'fail'];
            }

        break;



    case "findPhone_pw" :
        if($_REQUEST['authNum']==$_SESSION['authNum']){
            $CheckValue = phoneIdCheckPW($connect,$_REQUEST['Names'],$_REQUEST['ID'],$_REQUEST['Phones']);
            if($CheckValue){

                $return = ["msg" => '비밀번호 찾기 성공!',"result" => 'success'];
            }else{
                $return = ["msg" => '비밀번호 찾기 실패! ',"sql" => $CheckValue ,"result" => 'fail'];
            }
        }else{
            $return = ["msg" => '인증번호를 확인해주세요!',"result" => 'fail'];
        }


        break;



    case "findEmail_pw" :

        if($_REQUEST['authNum']==$_SESSION['authNum']){
            $CheckValue = emailIdCheckPW($connect,$_REQUEST['Names'],$_REQUEST['ID'],$_REQUEST['Emails']);
            if($CheckValue){

                $return = ["msg" => '비밀번호 찾기 성공!',"ID" => $CheckValue ,"result" => 'success'];
            }else{
                $return = ["msg" => '비밀번호 찾기 실패!',"result" => 'fail'];
            }
        }else{
            $return = ["msg" => '인증번호를 확인해주세요!',"result" => 'fail'];
        }

        break;


}

echo json_encode($return);

?>