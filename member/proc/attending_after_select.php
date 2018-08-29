<?php
session_start();
header('Content-Type: application/json');
include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");


$request = $_POST ? $_POST : $_GET;


function allLists($connect){                            // NAME.Email로 Id 체크하는 함수             서버에서 다시 ID 유효성 검사
    $sql = "SELECT * FROM Lecture ;";

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);
    $IsResult = Array();

    while($row = $result->fetch_assoc()) {
        array_push($IsResult,$row);

    }

//    $IsValue = mysqli_fetch_array($result);

    if($IsResult){                            // Id 비교 성공시
         return $IsResult;
    }else{                                                 // Id 비교 실패시
        return false;
    }
};



switch ($request['mode']) {



    case "selectList" :

            $CheckValue = allLists($connect);
            if($CheckValue){

                $return = ["msg" => '불러오기 성공!',"result" => 'success',"Result" => $CheckValue ];
//                $return = ["msg" => '불러오기 성공!',"result" => 'success',"boardIDX" => $CheckValue['boardIDX'],"Topic" => $CheckValue['Topic'],"Writer" => $CheckValue['Writer'],"Setisfy" => $CheckValue['Setisfy'],
//                        "LectureType" => $CheckValue['LectureType'], "Lecture" => $CheckValue['Lecture'], "LectureEvaluation" => $CheckValue['LectureEvaluation'],"Teacher" => $CheckValue['Teacher'], "Difficulty" => $CheckValue['Difficulty'],
//                        "LectureTime" => $CheckValue['LectureTime'], "LectureLength" => $CheckValue['LectureLength'] ];
            }else{
                $return = ["msg" => '불러오기 실패!',"result" => 'fail'];
            }



        break;




}

echo json_encode($return);


?>
