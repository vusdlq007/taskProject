<?php
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");

$request = $_POST ? $_POST : $_GET;



    function MemberJoining($connect){                     // 회원가입 정보 insert 하는함수             서버에서 다시 받은값 유효성 검사
        $sql = "insert into Member(Name, ID, PassWord, Email, Phone, Tel, Addr, SMSAgree, MailAgree, MemberIDX) values('".$_POST['Name']."','".$_POST['Id']."','".$_POST['Pwd']."','".$_POST['Email']."','".$_POST['Phone']."','".$_POST['Tel']."','".$_POST['Address']."',"
                .$_POST['SMSAgree'].",".$_POST['MailAgree'].",NULL);";

        $result = mysqli_query($connect,$sql);
//        var_dump('$connect', $connect);
//        var_dump($sql)
        var_dump('$sql', $sql);
        //var_dump('$result', $result);

        $IdValue = mysqli_fetch_array($result);
        var_dump($sql) ;
  


        if($IdValue){                      // Id 비교 성공시
            return true;
        }else{                                      // Id 비교 실패시
            return false;
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
        $CheckJoin = MemberJoining($connect);
       // var_dump('$CheckJoin',$CheckJoin);
        if ($CheckToId == false) {
            $return = ["msg" => '회원가입에 성공 했습니다.', "result" => 'success'];
        } else {
            $return = ["msg" => '회원가입에 실패 했습니다.', "result" => 'fail'];
        }
        
        break;

}

echo json_encode($return);




?>