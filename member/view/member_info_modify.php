<?php
session_start();

var_dump($_SESSION);
?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

<script>

    function sample4_DaumPostcode() {																					// 다음 주소검색 API  기능
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수
                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if(fullRoadAddr !== ''){
                    fullRoadAddr += extraRoadAddr;
                }
                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('roadAddress').value = fullRoadAddr;
                document.getElementById('jibunAddress').value = data.jibunAddress;
                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    //예상되는 도로명 주소에 조합형 주소를 추가한다.
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                } else {
                    document.getElementById('guide').innerHTML = '';
                }
            }
        }).open();
    }




    function PwdCheck(){														// 비밀번호 영문숫자 조합여부 확인
        var str =  $('input[name=Pwd]').val();
        var reg1 = /^[a-z0-9]{8,15}$/;    // a-z 0-9 중에 8자리 부터 15자리만 허용 한다는 뜻
        var reg2 = /[a-z]/g;
        var reg3 = /[0-9]/g;


        return(reg1.test(str) &&  reg2.test(str) && reg3.test(str));
    }

    function EmailCheck() {																	//E-mail 입력란 유효성 검사 기능
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






    $(function(){

        $('form[name=memberInfo]').submit(function(){

            if(PwdCheck()==false){
                alert("비밀번호는 8-15의 영문자/숫자 조합이여야 합니다.");
                $('input[name=Pwd]').val('');
                $('input[name=PwdCheck]').val('');
                $('input[name=Pwd]').focus();
                return false;
            }else{
                if (!$('input[name=Pwd]').val()) {
                    alert('비밀번호를 입력해 주세요.');
                    $('input[name=Pwd]').focus();
                    return false;
                } else if ($('input[name=Pwd]').val() != $('input[name=PwdCheck]').val()) {
                    alert('비밀번호가 일치하지 않습니다.');
                    $('input[name=PwdCheck]').focus();
                    return false;
                } else if (!$('input[name=Email01]').val()) {
                    alert('E-mail을 입력해 주세요.');
                    $('input[name=Email01]').focus();
                    return false;
                } else if (!$('input[name=Email02]').val()) {
                    alert('E-mail을 입력해 주세요.');
                    $('input[name=Email02]').focus();
                    return false;
                } else if (!$('input[name=AddressPost]').val() || !$('input[name=AddressDefault]').val() || !$('input[name=AddressDetail]').val()) {
                    alert('주소를 입력해 주세요.');
                    $('input[name=AddressDetail]').focus();
                    return false;
                }


                var AddressArray = new Array();
                var EmailArray = new Array();

                EmailArray.push($('input[name=Email01]').val(),"@",$('input[name=Email02]').val());
                AddressArray.push($('input[name=AddressPost]').val(),$('input[name=AddressDefault]').val(),$('input[name=AddressDetail]').val());

                var Email=EmailArray.join("");
                var FullAddress = AddressArray.join(" ");
                $('input[name=Email]').val(Email);
                $('input[name=FullAddress]').val(FullAddress);


            }

        });


    });

</script>


<div id="container" class="container-full">
	<div id="content" class="content">
		<div class="inner">
			<div class="tit-box-h3">
				<h3 class="tit-h3">내정보수정</h3>
				<div class="sub-depth">
					<span><i class="icon-home"><span>홈</span></i></span>
					<strong>내정보수정</strong>
				</div>
			</div>

            <form method="POST" name="memberInfo" autocomplete="on" action="/member/proc/member_update.php">
                <input type="hidden" name="mode" value="newFullInfoApply">
                <input type="hidden" name="Email" value="emailDefault">
                <input type="hidden" name="FullAddress" value="addressDefault">
			<div class="section-content">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">강의정보</caption>
					<colgroup>
						<col style="width:15%"/>
						<col style="*"/>
					</colgroup>

					<tbody>
						<tr>
							<th scope="col"><span class="icons">*</span>이름</th>
							<td><?php echo $_SESSION['UserName'] ?></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>아이디</th>
							<td><input type="text" class="input-text" style="width:302px" value="<?php echo $_SESSION['UserID'] ?>" disabled/>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>비밀번호</th>
							<td><input type="password" name = "Pwd" class="input-text" style="width:302px" placeholder="8-15자의 영문자/숫자 혼합"/></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>비밀번호 확인</th>
							<td><input type="password" name = "PwdCheck" class="input-text" style="width:302px"/></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>이메일주소</th>
                            <td>
                                <input type="text" name = "Email01" class="input-text" style="width:138px" onkeyup="EmailCheck()" maxlength="12" req="required" hname="이메일주소[1]"/> @ <input type="text" name = "Email02" id="em2" value="" class="input-text" style="width:138px" req="required" hname="이메일주소[2]"/>
                                <select name = "Email03"class="input-sel" style="width:160px" onchange="EmailValue()">
                                    <option value="">직접입력</option>
                                    <option value="naver.com">naver.com</option>
                                    <option value="daum.com">daum.com</option>
                                    <option value="gmail.com">gmail.com</option>
                                    <option value="nate.com">nate.com</option>
                                </select>
                            </td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>휴대폰 번호</th>
                            <td><?php echo $_SESSION['UserPhone']?></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons"></span>일반전화 번호</th>
							<td><input type="text" name = "Tel" class="input-text" style="width:88px"/> - <input type="text"  name="Tel2" class="input-text" style="width:88px"/> - <input type="text"  name="Tel3" class="input-text" style="width:88px"/></td>
						</tr>
						<tr>
							<th scope="col"><span class="icons">*</span>주소</th>
							<td>
								<p >
									<label>우편번호 <input type="text" name="AddressPost" id = "postcode" class="input-text ml5" style="width:242px" disabled /></label><a href="#" class="btn-s-tin ml10" onclick="sample4_DaumPostcode()">주소찾기</a>
								</p>
								<p class="mt10">
									<label>기본주소 <input type="text"  name="AddressDefault"  id = "roadAddress" class="input-text ml5" style="width:719px" disabled/></label>
								</p>
								<p class="mt10">
									<label>상세주소 <input type="text"  name="AddressDetail" id = "jibunAddress" class="input-text ml5" style="width:719px"/></label>
								</p>
							</td>
						</tr>
						<tr>
                            <th scope="col"><span class="icons">*</span>SMS수신</th>
                            <td>
                                <div class="box-input">
                                    <label class="input-sp">
                                        <input type="radio" name="SMSOK" id="SMSAccept" value="1" checked="checked"/>
                                        <span class="input-txt">수신함</span>
                                    </label>
                                    <label class="input-sp">
                                        <input type="radio" name="SMSOK" id="SMSDine" value="0" />
                                        <span class="input-txt">미수신</span>
                                    </label>
                                </div>
                                <p>SMS수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col"><span class="icons">*</span>메일수신</th>
                            <td>
                                <div class="box-input">
                                    <label class="input-sp">
                                        <input type="radio" name="MailOK" id="MailAccept" checked="checked" value="1"/>
                                        <span class="input-txt">수신함</span>
                                    </label>
                                    <label class="input-sp">
                                        <input type="radio" name="MailOK" id="MailDine" value="0"/>
                                        <span class="input-txt">미수신</span>
                                    </label>
                                </div>
                                <p>메일수신 시, 해커스의 혜택 및 이벤트 정보를 받아보실 수 있습니다.</p>
                            </td>
						</tr>
					</tbody>
				</table>


				<div class="box-btn">
                    <input href="#" type="submit" class="btn-l"  style="cursor:pointer"   onclick="PwdCheck()" value="정보수정">

				</div>
                </form>
			</div>
		</div>
	</div>
</div>

