<script>
    function PwdCheck(){														// 비밀번호 영문숫자 조합여부 확인
        var str =  $('input[name=newPassword]').val();
        var reg1 = /^[a-z0-9]{8,15}$/;    // a-z 0-9 중에 8자리 부터 15자리만 허용 한다는 뜻
        var reg2 = /[a-z]/g;
        var reg3 = /[0-9]/g;


        return(reg1.test(str) &&  reg2.test(str) && reg3.test(str));
    }



    function applyNewPassword(){
        if($('input[name=newPassword]').val()==$('input[name=newPasswordCheck]').val()){                //새로운 비밀번호와 새로운 비밀번호 확인란이 같으면 통신
            var param = {
                "mode" : "newPasswordApply",
                "newPassword" : $('input[name=newPassword]').val(),
                "newPasswordCheck" : $('input[name=newPasswordCheck]').val()
            }

            $.post("/member/proc/member_update.php",param,function (data) {
                if(data.result == "success"){
                    alert(data.msg);
                    $(location).attr('href', '/member/login.php');

                }else{
                    alert(data.msg);
                    $('input[name=authCheck]').focus();
                }
            })
        }
    }


    $(function(){
        $('form[name=confimButton]').click(function(){
            if(!$('input[name=newPassword').val()){
                alert("변경할 비밀번호를 입력하세요.");
                $('input[name=newPassword]').focus();
                return false;
            }else if(!$('input[name=newPasswordCheck').val()){
                alert("변경할 비밀번호 확인란을 입력 하세요.");
                $('input[name=newPassword]').focus();
                return false;
            }else{
                if(PwdCheck()==false){
                    alert("비밀번호는 8-15의 영문자/숫자 조합이여야 합니다.");
                    $('input[name=newPassword]').val('');
                    $('input[name=newPasswordCheck]').val('');
                    $('input[name=newPassword]').focus();
                    return false;
                }
            }





         })
    })



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
				<li><a href="/member/index.php?mode=id_find">아이디 찾기</a></li>
				<li class="on"><a href="#">비밀번호 찾기</a></li>
			</ul>

			<div class="tit-box-h4">
				<h3 class="tit-h4">비밀번호 재설정</h3>
			</div>

			<div class="section-content mt30">
				<table border="0" cellpadding="0" cellspacing="0" class="tbl-col-join">
					<caption class="hidden">비밀번호 재설정</caption>
					<colgroup>
						<col style="width:17%"/>
						<col style="*"/>
					</colgroup>


					<tbody>
<!--                    <input type="hidden" name="mode" value="newPasswordApply">-->
						<tr>
							<th scope="col">신규 비밀번호 입력</th>
							<td><input type="text" name="newPassword" class="input-text" placeholder="영문자로 시작하는 4~15자의 영문소문자,숫자" style="width:302px" /></td>
						</tr>
						<tr>
							<th scope="col">신규 비밀번호 재확인</th>
							<td><input type="text" name="newPasswordCheck" class="input-text" style="width:302px" /></td>
						</tr>
					</tbody>

				</table>
				<div class="box-btn">
					<input type="submit" href="#" name = "confimButton" class="btn-l" value="확인" style="cursor: pointer" onclick="applyNewPassword()"/>

				</div>
			</div>
		</div>
	</div>
</div>

