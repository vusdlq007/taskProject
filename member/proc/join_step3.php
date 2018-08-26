<?php
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");
session_start();




$request = $_POST ? $_POST : $_GET;



    function MemberJoining($connect){                     // 회원가입 정보 insert 하는함수             서버에서 다시 받은값 유효성 검사


        echo "Email02체크:".$_POST['Email02'];
        if($_POST['Email02']){
            $Emailarray = array($_POST['Email01'],"@",$_POST["Email02"]);
            $Email=implode($Emailarray);
        }else{
            $Emailarray = array($_POST['Email01'],"@",$_POST["Email03"]);
            $Email=implode($Emailarray);
        }
//
//        $Addressarray = array($_POST['AddressPost'],$_POST['AddressDefault'],$_POST['AddressDetail']);
//        $Address=implode($Addressarray);

        $sql = "insert into Member(Name, ID, PassWord, Email, Phone, Tel, Addr, SMSAgree, MailAgree, MemberIDX) values('".$_POST['Name']."','".$_POST['Id']."','".$_POST['Pwd']."','".$Email."','".$_SESSION['phoneNum']."','".$_POST['Tel']."','".$_POST['FullAddress']."',"
                .$_POST['SMSOK'].",".$_POST['MailOK'].",NULL);";

        $result = mysqli_query($connect,$sql);
//        var_dump('$connect', $connect);
//        var_dump($sql)
        var_dump('$sql:', $sql);
        //var_dump('$result', $result);

//        var_dump($sql) ;

        if(!$_POST['Name'] || !$_POST['Id'] || !$_POST['Pwd'] || empty($Email) || empty($_SESSION['phoneNum']) || empty($_POST['FullAddress']) || !$_POST['SMSOK'] || !$_POST['MailOK']){
            return false;
        }else{
            if($result){                      // Id 비교 성공시
                return true;
            }else{                                      // Id 비교 실패시
                return false;
            }
        }


  




    };
//echo $sql;

    function IdCheck($connect,$isId){                     // Id 체크하는 함수             서버에서 다시 ID 유효성 검사
        $sql = "SELECT ID FROM Member where ID ='".$isId."'";

        $result = mysqli_query($connect,$sql);
        //var_dump('$connect', $connect);
        //var_dump('$sql', $sql);


        $IdValue = mysqli_fetch_array($result);


        if($IdValue['ID'] == $isId){                      // Id 비교 성공시
            return true;
        }else{                                      // Id 비교 실패시
            return false;
        }
    };

switch ($request['mode']) {

    case 'IdChecking' :
        $CheckToId = IdCheck($connect, $request['IdValue']);       // 여기에 중복 확인값 넣기 (콜백함수하나 만들어서 호출하기(디비에서 셀렉트해서 넘겨받은 값이랑 비교해보기))  true OR false
//
//        var_dump('$CheckToId', $CheckToId);
        if ($CheckToId == false) {
            $return = ["msg" => '사용 가능한 아이디 입니다.', "result" => 'success'];
        } else {
            $return = ["msg" => '중복된 아이디가 있습니다.', "result" => 'fail'];
        }

        break;

    case "MemberJoin" :
        //echo "MemberJoin케이스 진입";
        $CheckJoin = MemberJoining($connect);
       // var_dump('$CheckJoin',$CheckJoin);

        if ($CheckJoin) {
            echo "회원가입 성공!";
            $return = ["msg" => '회원가입에 성공 했습니다.', "result" => 'success'];
        } else {
            echo "회원가입 실패!" ;
            $return = ["msg" => '회원가입에 실패 했습니다.', "result" => 'fail'];
        }

//        if ($CheckToId == false) {
//            $return = ["msg" => '회원가입에 성공 했습니다.', "result" => 'success'];
//        } else {
//            $return = ["msg" => '회원가입에 실패 했습니다.', "result" => 'fail'];
//        }
//
        break;

}

echo json_encode($return);

if($request['mode']=='MemberJoin'){                                                         //모드에 따라 이동페이지 정함
    header("Location: http://test.hackers.com/member/index.php?mode=step_04");

}


?>