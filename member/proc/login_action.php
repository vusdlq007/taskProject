<?php
session_start();
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");


$request = $_POST ? $_POST : $_GET;


    function LoginCheck($connect, $isId, $isPwd){

        $sql = "SELECT ID,PassWord,Name FROM Member where ID ='".$isId."'";

        $result = mysqli_query($connect,$sql);
        //var_dump('$connect', $connect);
        //var_dump('$sql', $sql);

       // var_dump($sql);
        $sqlResult = mysqli_fetch_array($result);

        $comPwd = hash("SHA256",$isPwd);



        if($sqlResult['ID'] && $sqlResult['PassWord']){                            // Id 비교 성공시

            if($comPwd ==$sqlResult['PassWord']){
//                echo "비밀번호 일치!\n";
//                echo "입력 비밀번호 : ".$isPwd;

                $_SESSION['UserID'] = $sqlResult['ID'];                         // 로그인 성공시 세션변수에 정보 담음
                $_SESSION['UserName'] = $sqlResult['Name'];

                return true;
            }else{                                  // Id 비교는 성공 하지만 비밀번호 not 일치
//                echo "비밀번호 불일치!";
                return false;
            }

        }else{                                                 // Id 비교 실패시
            return false;
        }
    };



switch ($request['mode']) {

    case 'Login' :
        $CheckLogin = LoginCheck($connect, $request['IdValue'],$request['PwdValue']);       // 여기에 중복 확인값 넣기 (콜백함수하나 만들어서 호출하기(디비에서 셀렉트해서 넘겨받은 값이랑 비교해보기))  true OR false
//
//        var_dump('$CheckToId', $CheckToId);
        if ($CheckLogin == true) {

            $return = ["msg" => '성공적으로 로그인 하였습니다.', "result" => 'loginsuccess'];

        } else {

            $return = ["msg" => '비밀번호나 패스워드가 틀렸습니다.', "result" => 'loginfail'];
        }

        break;

    case "IdFind" :
        $CheckJoin = MemberJoining($connect);
        $successCheck = false;
        // var_dump('$CheckJoin',$CheckJoin);
        if ($CheckJoin) {

            $return = ["msg" => 'ID 찾기에 성공 했습니다.', "result" => 'success'];
        } else {

            $return = ["msg" => 'ID 찾기에 실패 했습니다.', "result" => 'fail'];
        }

        break;

    case "PwdFind" :

        break;

    case "logout" :
                session_destroy();
                header("Location: ../../index.html");
        break;

}

echo json_encode($return);

//$refererValue = $_SESSION['org_referer'];

//if($successCheck){
//    header("Location: ".$refererValue);
//}
//var_dump($_SESSION);

?>