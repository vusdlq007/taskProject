<?php
session_start();

include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");


$request = $_POST ? $_POST : $_GET;


function boardRegister($connect){                            // NAME.Email로 Id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "INSERT INTO Lecture(Topic,Writer,Setisfy,Lecture,LectureType,LectureEvaluation) value ('".$_POST['Topic']."','".$_SESSION['UserName']."',".$_POST['Setisfy'].",'".$_POST['Lecture']."','".$_POST['LectureType']."','".$_POST['smarteditor']."');";

    $result = mysqli_query($connect,$sql);


    if($result){                            // Id 비교 성공시
        return $result;
    }else{                                                 // Id 비교 실패시
        return false;
    }
};



switch ($request['mode']) {


    case "register" :

        $CheckValue = boardRegister($connect);
        if($CheckValue){
            header("Location: ../index.php?mode=list");
        }else{
            echo "Insert 실패";
        }



        break;

    case "edit" :

        $CheckValue = boardEditor($connect);                                // 안에들어가서 세션 변수와 게시물 등록 변수와 맞는지 동일인물인지 확인
        if($CheckValue){
            header("Location: ../index.php?mode=list");
        }else{
            echo "Insert 실패";
        }



        break;


}




?>
