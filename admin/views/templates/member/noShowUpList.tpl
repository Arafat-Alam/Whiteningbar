{php}
session_start();
$_SESSION['page']='member';
$_SESSION['tab']='noShowUp';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#member_no").val("");
	$("#user_name").val("");
}


function getList(no){

	target1 = $("#coupon"+no);
	//$(".category_m_id").remove();
	$("#coupon_id").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});

	$.ajax({
		type: "POST",
		url: "/member/getCouponList/",
		cache : false,
		dataType: "json",
		data : {
			p_coupon_id: $("#p_coupon_id"+no).val()
		},
		success: function(data, dataType) {
			target1.after(data.html);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

$(function(){
	$(".datepicker").datepicker({
		dateFormat: "yy-mm-dd"
	});



});
$(document).ready(function(){
	var user_name = $('#user_name').val();
	var member_no = $('#member_no').val();
		// $('#sbmBtn').attr('disabled','disabled');
		// $('#sbmBtn').attr('style','color:red;');
		// $('#vldMsg').show();

	if (user_name != '' || member_no != '') {
	/*	$('#vldMsg').hide();
		$('#sbmBtn').removeAttr('disabled');
		$('#sbmBtn').removeAttr('style');*/
	}
});

function validate() {
	var msg = "";

	// お名前
	if ($("#user_name").val() == "" && $("#member_no").val() == "") {
		msg += "ユーザー名またはユーザーIDを入力してください";
	}
	// フォームタイプ
	// if ($("#member_no").val() == "") {
	// 	msg += "・フォームタイプを選択してください\n";
	// }
	if (msg != "") {
		alert(msg);
		return false;
	}

	// $("#fm").submit();
	return true;
}

function valueValidate(){
	
	var user_name = $('#user_name').val();
	var member_no = $('#member_no').val();
		// $('#sbmBtn').attr('disabled','disabled');
		// $('#sbmBtn').attr('style','color:red;');
		// $('#vldMsg').show();

	if (user_name != '' || member_no != '') {
		// $('#vldMsg').hide();
		// $('#sbmBtn').removeAttr('disabled');
		// $('#sbmBtn').removeAttr('style');
	}

}

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="member/menu_member.tpl"}
		<h3>来店せず一覧</h3>
{include file="messages.tpl"}

		<form method="post" name="fm_search" action="">
		<table class="search center">
		<tr>
		<!-- <span style="color: red;" id="vldMsg">Please Enter User Name Or Id</span> -->
			<th>名前</th>
			<td>
				<input type="text" name="name" id="user_name"  value="{$search.name}" size="20" onclick="valueValidate()" onkeyup="valueValidate()"/>
			</td>
			<th>会員番号</th>
			<td>
				<input type="text" name="member_no" id="member_no"  value="{$search.member_no}" size="20" onclick="valueValidate()" onkeyup="valueValidate()"/>
			</td>

		</tr>
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_search" class="btn-lg" id="sbmBtn" onclick="return validate();">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray" >クリア</button>
		</div>
		</form>
<hr>

		{* 検索結果 *}

件数：{$total_count}件
			<table class="admins clear mt10 unpaid">
			<tr>
				<th width="100">会員No</th>
				<th width="150">お名前</th>
				<th>購入店舗</th>
				<th>予約メニュー</th>
				<th>ご購入コース料金</th>
				<!-- <th>クーポン</th>
				<th>購入</th> -->
				<th>DB削除</th>

			</tr>

			{foreach from=$arr key=key item="member"}
				<tr>
					<td>{$member.member_no}</td>
					<td>{$member.name}<br />{$member.name_kana}<br />{$member.tel}</td>
					<td>
							{$member.shop_name}
					</td>
					<td>
						{$member.menu_name}
					</td>
					<td>{$member.fee|number_format}円<br />({$member.course_name})</td>
				<form method="POST" action="">
					<!-- <td>
					<select name="p_coupon_id" id=p_coupon_id{$key}  onChange="getList('{$key}')">
			          {html_options  options=$couPaArr selected=$input_data.coupon_id }
					</select>

			          <div id=coupon{$key}>
			          </div>

					</td>
					<td class="tc">
							<font size=1>売上計上日</font><br>
							<input type="text" class="datepicker" id="start{$key}" name="buy_date" size="10" value="{$buy_date|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>
							<input type="submit" name="submit" value="料金受取済" onClick="return confirm('料金を受け取り済みにします。良いですか？');" class="btn-delete btn-sm">
					</td> -->
					<td class="tc">
							<input type="submit" name="del_submit" value="削除" onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');" class="btn-delete btn-sm"><!-- onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');"  by arafat-->
					</td>
				<input type="hidden" name="buy_no" value="{$member.buy_no}">
				</form>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="11">予約済みで未払いの検索該当会員様はいません</td>
				</tr>
			{/foreach}

			</table>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

