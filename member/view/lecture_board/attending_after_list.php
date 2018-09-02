<?php
include ($_SERVER['DOCUMENT_ROOT']."/header.php");

?>

<script>

    $.urlParam = function(name){                                            // 정규식을 사용한 GET 파라미터 뽑는 함수정의
        var results = new RegExp('[\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);

        if (results==null){
            return null;
        }
        else{
            return results[1] || 0;
        }
    }

        
    window.onload=function(){       // 페이지가 로딩된 후 실행해야 되는 코드를 추가한다.
        var ListArray;
        var pageTotalNum;            // 총 레코드 갯수
        var postValue;




        var param = {
            'mode' : 'selectList',
        };


        $.post( "/member/proc/attending_after_select.php", param , function( data ) {				// 게시물 List 가져옴
            // alert(data.msg);
            console.log(data.Result);
            ListArray = data.Result;
            postValue = decodeURIComponent($.urlParam('page'));

            pageTotalNum = ListArray.length;
            //console.log(decodeURIComponent($.urlParam('mode')));



            var list = 10;                                      // 한 페이지에 나열할 게시물 수
            var b_pageNum_list = 10;                                     //  한 블록에 표시해줄 페이지 수
            var pageNum = postValue ? postValue : 1 ;                // 현재 페이지 번호   // 현재 페이지 값이 없으면 1페이지로 세팅
            


            var block = Math.ceil(pageNum / b_pageNum_list);                         // 현재 블록
            var b_start_page = ((pageNum - 1)/ b_pageNum_list ) * b_pageNum_list + 1;               // 현재 페이지가 pageCount와 같을 때를 유의하며(page-1)을 하고 +1은 첫페이지가 0이나 10이 아니라 1이나 11로 하기 위함임
            var b_end_page = b_start_page + b_pageNum_list -1; //-1은 첫페이지가 1이나 11등과 같을때 1~10, 11~20으로 지정하기 위함임



            var total_page = Math.ceil(pageTotalNum/list);              // 총 페이지 수


            if(b_end_page > total_page){
                b_end_page = total_page;
            }

            if(total_page < pageNum){
                pageNum = total_page;
            }

            if(b_end_page > total_page){
                b_end_page = total_page;
            }



            var List2= "<a href='#'><i class='icon-first'><span class='hidden'>첫페이지</span></i></a>" +
                "<a href='#'><i class='icon-prev'><span class='hidden'>이전페이지</span></i></a>";          // 페이지 표시 값을 태그에 포함해서 담을 변수

            for(var j=b_start_page-1 ;j <= b_end_page;j++){
                List2 += "<a href='/member/view/lecture_board/attending_after_list.php?page="+j+"'>"+j+"</a>";
            }

            List2+= "<a href='#'><i class='icon-last'><span class='hidden'>마지막페이지</span></i></a>" +
                "<a href='#'><i class='icon-next'><span class='hidden'>다음페이지</span></i></a>";




            var List = "<table>";
            var indexs = 0;
           // console.log("배열길이"+RecordCount);


            $.each(data.Result,function (index,item) {                                             // 값 전달 받아서 수정중

                indexs++;                                           // 인덱스 번호
                List +="<tr class='bbs-sbj'><td>"+indexs+"</td>";
                List +="<td>"+item['LectureType']+"</td>";
                List +="<td>";
                List +="<a href='#'>";
                List +="<span class=\"tc-gray ellipsis_line\">수강 강의명 :"+item['Lecture']+" </span>";
                List +="<strong class='ellipsis_line'>"+item['Topic']+"</strong>";
                List +="</a>";
                List +="</td>";
                // List +="<td>"+item['Setisfy']+"</td>";
                List +=" <td> <span class='star-rating'> <span class='star-inner' style='width:80%'></span> </span> </td> <td class='last'>"+item['Writer']+"</td>";

                List +="<tr>";


            });



            List += "</table>"

            $('tbody:first').html(List);

            $("div[name='pageNumbers']").html(List2);

            // for(var i = 0 ; i < ListArray.length ;i++){
            //     console.log("배열값["+i+"] :"+ListArray[i]['Lecture']);
            // }

            List +="</table>"
        }, "json").error(function () {
            alert("error");
        });

    }

</script>

<div id="container" class="container">
	<?php include $_SERVER['DOCUMENT_ROOT']."/LNB.php";
    include($_SERVER['DOCUMENT_ROOT']."/member/db/dbconn.php");

    $sql = "SELECT count(boardIDX) FROM Lecture ;";

    $result = mysqli_query($connect,$sql);
    //var_dump('$connect', $connect);
    //var_dump('$sql', $sql);
//    echo "$result";
//    $IsValue = mysqli_fetch_array($result);

	?>

    <?php



    ?>


	<div id="content" class="content">
		<div class="tit-box-h3">
			<h3 class="tit-h3">수강후기</h3>
			<div class="sub-depth">
				<span><i class="icon-home"><span>홈</span></i></span>
				<span>직무교육 안내</span>
				<strong>수강후기</strong>
			</div>
		</div>

		<ul class="tab-list tab5">
			<li class="on"><a href="#">전체</a></li>
			<li><a href="#">일반직무</a></li>
			<li><a href="#">산업직무</a></li>
			<li><a href="#">공통역량</a></li>
			<li><a href="#">어학 및 자격증</a></li>
		</ul>

		<div class="search-info">
			<div class="search-form f-r">
				<select class="input-sel" style="width:158px">
					<option value="">분류</option>
				</select>
				<select class="input-sel" style="width:158px">
					<option value="">강의명</option>
					<option value="">작성자</option>
				</select>
				<input type="text" class="input-text" placeholder="강의명을 입력하세요." style="width:158px"/>
				<button type="button" class="btn-s-dark">검색</button>
			</div>
		</div>

		<table border="0" cellpadding="0" cellspacing="0" class="tbl-bbs">
			<caption class="hidden">수강후기</caption>
			<colgroup>
				<col style="width:8%"/>
				<col style="width:8%"/>
				<col style="*"/>
				<col style="width:15%"/>
				<col style="width:12%"/>
			</colgroup>

			<thead>
				<tr>
					<th scope="col">번호</th>
					<th scope="col">분류</th>
					<th scope="col">제목</th>
					<th scope="col">강좌만족도</th>
					<th scope="col">작성자</th>
				</tr>
			</thead>
	 
			<tbody>
				<!-- set -->



				<tr class="bbs-sbj">
					<td><span class="txt-icon-line">0</span></td>
					<td>CS</td>
					<td>
						<a href="#">
							<span class="tc-gray ellipsis_line">수강 강의명 : Beyond Trouble, 조직을 감동시키는 관계의 기술</span>
							<strong class="ellipsis_line">절대 후회 없는 강의 예요!</strong>
						</a>
					</td>
					<td>
						<span class="star-rating">
							<span class="star-inner" style="width:80%"></span>
						</span>
					</td>
					<td class="last">이름</td>
				</tr>
				<!-- //set -->
				<!-- set -->
				<tr class="bbs-sbj">
					<td>1</td>
					<td>CS</td>
					<td>
						<a href="#">
							<span class="tc-gray ellipsis_line">수강 강의명 : Beyond Trouble, 조직을 감동시키는 관계의 기술</span>
							<strong class="ellipsis_line">절대 후회 없는 강의 예요!</strong>
						</a>
					</td>
					<td>
						<span class="star-rating">
							<span class="star-inner" style="width:80%"></span>
						</span>
					</td>
					<td class="last">이름</td>
				</tr>
				<!-- //set -->
			</tbody>
		</table>

		<div class="box-paging" name = "pageNumbers">
<!--			<a href="#"><i class="icon-first"><span class="hidden">첫페이지</span></i></a>-->
<!--			<a href="#"><i class="icon-prev"><span class="hidden">이전페이지</span></i></a>-->
<!--			<a href="#" class="active">1</a>-->
<!--			<a href="#">2</a>-->
<!--			<a href="#">3</a>-->
<!--			<a href="#">4</a>-->
<!--			<a href="#">5</a>-->
<!--			<a href="#">6</a>-->
<!--			<a href="#"><i class="icon-next"><span class="hidden">다음페이지</span></i></a>-->
<!--			<a href="#"><i class="icon-last"><span class="hidden">마지막페이지</span></i></a>-->
		</div>

		<div class="box-btn t-r">
			<a href="/member/index.php?mode=register" class="btn-m">후기 작성</a>
		</div>
	</div>
</div>


<?php
include ($_SERVER['DOCUMENT_ROOT']."/footer.php");

?>
