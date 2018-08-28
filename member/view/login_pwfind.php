<script>
    var isValied03=false;

    function FindAuthNum() {                                                            // 인증번호 받을 정보 입력칸 빈칸체크
        var Checked = false;

        if($('input[name=Name]').val()){
            if($('input[type=radio][name^=radio]:checked').val()=="phoneSelect"){
                $('input[name^=Pnum]').each(function (index, PhoneNum) {
                    if(PhoneNum.value){
                        Checked = true;
                        return true;
                    }else{
                        Checked = false;
                        return false;
                    }
                });
            }else{
                $('input[name^=Email]').each(function (index, EmailNum) {
                    if(EmailNum.value){
                        Checked = true;
                        return true;
                    }else{
                        Checked = false;
                        return false;
                    }
                });
            }
            if(!$('#id').val()){
                Checked = false;
            }

        }


        if(Checked==true){
            <?php session_start(); $_SESSION['authNum'] ="123456"?>
            alert(<?php  echo $_SESSION['authNum']; ?>);
            isValied03=true;
        }else{
            alert("인증받을 정보를 입력해 주세요.");
        }

    }





    function findAjaxFinal() {                                                  //인중번호 확인 후 비밀번호 찾기 기능

        var Phones = new Array();
        var Emails = new Array();
        Phones.push($('#pnum01').val());
        Phones.push($('#pnum02').val());
        Phones.push($('#pnum03').val());
        Phones=Phones.join('-');

        Emails.push($('input[name=Email01]').val());
        Emails.push($('input[name=Email02]').val());

        Emails=Emails.join("@");

        var authNum = $('input[name=authCheck]').val();
        var Names = $('input[name=Name]').val();
        var Id = $('#id').val();


        if($('input[type=radio][name^=radio]:checked').val()=="phoneSelect"){                           // 휴대폰인증인지 이메일 인증인지 mode설정부문
            var mode = "findPhone_pw";
        }else{
            var mode = "findEmail_pw";
        }

        var param = {
            "mode" : mode,
            "authNum" : authNum,
            "Names" : Names,
            "Phones" : Phones,
            "Emails" : Emails,
            "ID" : Id
        }

        if(isValied03==true){
            $.post("/member/proc/find_information.php",param,function (data) {
                if(data.result == "success"){
                    alert(data.msg);
                    $('input[name=authCheck]').focus();
                     $(location).attr('href', '/member/index.php?mode=pw_find_complete');

                }else{
                    alert(data.msg);
                    $('input[name=authCheck]').focus();
                }
            })
        }else{
            alert("인증번호받기를 먼저 수행해주세요!");
        }


    }



    function CheckSolution() {                                                          // 인증방법
        if($('input[type=radio][name^=radio]:checked').val()=="phoneSelect"){
            $('.tr-email-info').hide();
            $('.tr-phone-info').show()
        }else{
            $('.tr-phone-info').hide();
            $('.tr-email-info').show()
        }
    }

    function EmailCheck() {																	//이메일 입력란 유효성 검사 기능
        var regId = /^[a-zA-Z0-9]+$/;
        var regId = /^[a-z0-9][a-z0-9]*$/;
        if(!regId.test($('input[name=Email01]').val()) && !$('input[name=Email01]').val()=="") {				// 공백이아닐때 정규식 조건에 안맞으면 경고
            alert('Email 형식에 맞게 입력해 주세요.');
            $('input[name=Email01]').val('');
            $('input[name=Email01]').focus();
            return false;
        }
        return true;
    }

    function EmailValue(){																	// E-mail Selectbox로 설정에 맞게 값 넣어주는 기능
        var email03 = $("select[name='Email03']").val();
        if($('select[name=Email03]').val()==""){
            $('#em2').val("");
            $('#em2').attr("disabled",false);
            $('input[name=Email02]').focus();
        }else{
            $('#em2').val(email03).attr("disabled",true);;
        }
    }

</script>


<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">
			<div class="tit-box-h3">
				<h3 class="tit-h3">아이디/비밀번호 찾기</h3>
				<div class="sub-depth">
					<span><i class="icon-home"><span>홈</span></i></span>
					<strong>아이디/비밀번호 찾기</strong>
				</div>
			</div>

			<ul class="tab-list">
				<li><a href="#">아이디 찾기</a></li>
				<li class="on"><a href="#">비밀번호 찾기</a></li>
			</ul>

			<div class="tit-box-h4">
				<h3 class="tit-h4">비밀번호 찾기 방법 선택</h3>
			</div>

            <dl class="find-box">
                <dt>휴대폰 인증</dt>
                <dd>
                    고객님이 회원 가입 시 등록한 휴대폰 번호와 입력하신 휴대폰 번호가 동일해야 합니다.
                    <label class="input-sp big">
                        <input type="radio" name="radio" id = "PhoneId" checked="checked" value="phoneSelect" onclick="CheckSolution()"/>
                        <span class="input-txt"></span>
                    </label>
                </dd>
            </dl>

            <dl class="find-box">
                <dt>이메일 인증</dt>
                <dd>
                    고객님이 회원 가입 시 등록한 이메일 주소와 입력하신 이메일 주소가 동일해야 합니다.
                    <label class="input-sp big">
                        <input type="radio" name="radio" id = "EmailId" value="emailSelect" onclick="CheckSolution()"/>
                        <span class="input-txt"></span>
                    </label>
                </dd>
            </dl>

			<div class="section-content mt30">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">아이디/비밀번호 찾기 개인정보입력</caption>
					<colgroup>
						<col style="width:15%"/>
						<col style="*"/>
					</colgroup>

					<tbody>
						<tr>
							<th scope="col">성명</th>
							<td><input type="text"  name="Name" class="input-text" style="width:302px" /></td>
						</tr>
						<tr>
							<th scope="col">아이디</th>
							<td>
                                <input type="text" id="id" class="input-text" style="width:138px" value="<?php echo $_GET['id'] ?>"/>
							</td>
						</tr>
                        <tr class="tr-email-info" style="display:none;">
                            <th scope="col">이메일주소</th>
                            <td>
                                <input type="text" class="input-text" id="em1" name="Email01" style="width:138px" onkeyup="EmailCheck()"/> @ <input type="text" class="input-text" id="em2" name="Email02" style="width:138px" onkeyup="EmailCheck()"/>
                                <select class="input-sel" id="em3" name="Email03" style="width:160px"  onchange="EmailValue()">
                                    <option value="">직접입력</option>
                                    <option value="naver.com">naver.com</option>
                                    <option value="gmail.com">gmail.com</option>
                                    <option value="daum.com">daum.com</option>
                                    <option value="nate.com">nate.com</option>
                                </select>
                                <a href="#" class="btn-s-tin ml10" onclick="FindAuthNum()">인증번호 받기</a>
                            </td>

                        </tr>
                        <tr class="tr-phone-info" >
                            <th scope="col">휴대폰번호</th>
                            <td>
                                <input type="text" name="Pnum01" id="pnum01" class="input-text" style="width:138px"/>-
                                <input type="text" name="Pnum02" id="pnum02" class="input-text" style="width:138px"/>-
                                <input type="text" name="Pnum03" id="pnum03" class="input-text" style="width:138px"/>
                                <a href="#" class="btn-s-tin ml10" onclick="FindAuthNum()">인증번호 받기</a>
                            </td>

                        </tr>
						<tr>
							<th scope="col">인증번호</th>
							<td><input type="text" name="authCheck" class="input-text" style="width:478px" /><a href="#" class="btn-s-tin ml10" onclick="findAjaxFinal()">인증번호 확인</a></td>
						</tr>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>


