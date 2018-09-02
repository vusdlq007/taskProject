<?php session_start();
var_dump($_SESSION) ?>
<script>
    $(function(){
        //전역변수선언
        var editor_object = [];

        nhn.husky.EZCreator.createInIFrame({
            oAppRef: editor_object,
            elPlaceHolder: "smarteditor1",
            sSkinURI: "/member/smarteditor/SmartEditor2Skin.html",
            htParams : {
                // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseToolbar : true,
                // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
                bUseVerticalResizer : true,
                // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
                bUseModeChanger : true,
            }
        });

        //전송버튼 클릭이벤트
        $("#savebutton").click(function(){
            //id가 smarteditor인 textarea에 에디터에서 대입
            editor_object.getById["smarteditor1"].exec("UPDATE_CONTENTS_FIELD", []);

            // 이부분에 에디터 validation 검증

            //폼 submit
            $("#frm").submit();
        })
    })

</script>

<div id="container" class="container">
    <?php include "../LNB.php"; ?>

	<div id="content" class="content">
		<div class="tit-box-h3">
			<h3 class="tit-h3">수강후기</h3>
			<div class="sub-depth">
				<span><i class="icon-home"><span>홈</span></i></span>
				<span>직무교육 안내</span>
				<strong>수강후기</strong>
			</div>
		</div>

		<div class="user-notice">
			<strong class="fs16">유의사항 안내</strong>
			<ul class="list-guide mt15">
				<li class="tc-brand">수강후기는 신청하신 강의의 학습진도율 25%이상 달성시 작성가능합니다. </li>
				<li>욕설(욕설을 표현하는 자음어/기호표현 포함) 및 명예훼손, 비방,도배글, 상업적 목적의 홍보성 게시글 등 사회상규에 반하는 게시글 및 강의내용과 상관없는 서비스에 대해 작성한 글들은 삭제 될 수 있으며, 법적 책임을 질 수 있습니다.</li>
			</ul>
		</div>

		<table border="0" cellpadding="0" cellspacing="0" class="tbl-col">
			<caption class="hidden">강의정보</caption>
			<colgroup>
				<col style="width:15%"/>
				<col style="*"/>
			</colgroup>
            <form action="/member/proc/attending_after_sign.php" method="post" id="frm">
                <input type="hidden" name="mode" value="register">
			<tbody>
				<tr>
					<th scope="col">강의</th>
					<td>
						<select class="input-sel" name="LectureType" style="width:160px">
							<option value="">분류</option>
                            <option value="일반직무">일반직무</option>
                            <option value="산업직무">산업직무</option>
                            <option value="공통역량">공통역량</option>
                            <option value="어학 및 자격증">어학 및 자격증</option>
						</select>
						<select class="input-sel ml5" name="Lecture" style="width:454px">
							<option value="">강의명</option>
                            <option value="Beyond Trouble, 조직을 감동시키는 관계의 기술">Beyond Trouble,조직을 감동시키는 관계의 기술</option>
                            <option value="신입사원 OT">신입사원 OT</option>
                            <option value="Jquery 입문">Jquery 입문</option>
                            <option value="SQL 기초교육">SQL 기초교육</option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="col">제목</th>
					<td><input type="text" class="input-text" name="Topic" style="width:611px"/></td>
				</tr>
				<tr>
					<th scope="col">강의만족도</th>
					<td>
						<ul class="list-rating-choice">
							<li>
								<label class="input-sp ico">
									<input type="radio" name="Setisfy" id=""  checked="checked" value=5 />
									<span class="input-txt">만점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:100%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="Setisfy" id=""  value=4 />
									<span class="input-txt">만점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:80%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="Setisfy" id=""  value=3 />
									<span class="input-txt">만점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:60%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="Setisfy" id=""  value=2 />
									<span class="input-txt">만점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:40%"></span>
								</span>
							</li>
							<li>
								<label class="input-sp ico">
									<input type="radio" name="Setisfy" id=""  value=1 />
									<span class="input-txt">만점</span>
								</label>
								<span class="star-rating">
									<span class="star-inner" style="width:20%"></span>
								</span>
							</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="editor-wrap">
            <textarea name="smarteditor" id="smarteditor1" rows="10" cols="100" style="width:766px; height:412px;" ></textarea>


		</div>
	
		<div class="box-btn t-r">
			<a href="/member/view/lecture_board/attending_after_list.php?page=1" class="btn-m-gray">목록</a>
			<button type="submit" id="savebutton" class="btn-m ml5" value="저장" style="cursor: pointer"/>저장
		</div>
        </form>


		
	</div>
</div>


