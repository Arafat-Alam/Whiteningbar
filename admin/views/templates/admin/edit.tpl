{include file="head.tpl"}
<script type="text/javascript">
{literal}

// 入力チェック
function validate() {
	var msg = "";

	// ユーザーID
	if ($("#user_id").val() == "") {
		msg += "・ユーザーIDを入力してください\n";
	}
	// 管理者種別
	if ($("#manager_type").val() == "") {
		msg += "・管理者種別を選択してください\n";
	}
	// 名前
	if ($("#user_name").val() == "") {
		msg += "・名前を入力してください\n";
	}

	if ($("#mode").val() == "add") {
		if ($("#password").val() == "") {
			msg += "・パスワードを入力してください\n";
		}
	}
	else {
		if ($("#password").val() != "" && $("#mode").val() != "add") {
			if (!confirm("パスワードを変更してもよろしいですか？")) {
				return false;
			}
		}
	}

	if (msg != "") {
		alert(msg);
		return false;
	}

	$("#fm").submit();
	return true;
}

function validateList() {
	$("#fm_list").submit();
}

function clickDisableChk(obj) {
	var id = $(obj).attr("id").replace("disabled_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#disabled_" + id).val("t");
	}
	else {
		$("#disabled_" + id).val("f");
	}
}

function clickDeleteChk(obj) {
	var id = $(obj).attr("id").replace("delete_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#delete_" + id).val("t");
	}
	else {
		$("#delete_" + id).val("f");
	}
}

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="menu_admin.tpl"}
		<h3>サイト管理者登録</h3>
		{include file="messages.tpl"}

		<form id="fm" name="fm" method="post" action="">
		<input type="hidden" id="mode" name="mode" value="{$mode}"/>
		<input type="hidden" id="admin_no" name="admin_no" value="{$admin_obj.admin_no}" />
		<input type="hidden" id="admin_type" name="admin_type" value="{$admin_obj.admin_type}"/>
		<table class="center">
		<tr>
			<th>ログインID</th>
			<td>
				{if $mode=="update"}
					<span class="read_only"><b>{$admin_obj.user_id}</b></span>
					<input type="hidden" id="user_id" name="user_id" value="{$admin_obj.user_id}" />
				{else}
					<input type="text" id="user_id" name="user_id" size="20" value="{$admin_obj.user_id}" style="ime-mode:disabled;"/>
				{/if}
			</td>
		</tr>
		<tr>
			<th>パスワード</th>
			<td>
				<input type="password" id="password" name="password"  size="20" value="" maxlength="20"/>
				<br />
				※変更する場合のみ入力してください。
			</td>
		</tr>
		<tr>
			<th>お名前</th>
			<td>
				<input type="text" id="user_name" name="user_name" size="20" value="{$admin_obj.user_name}" maxlength="20"/>
			</td>
		</tr>
		<tr>
			<th>予約情報権限</th>
			<td>
				{html_radios name="reserve_auth_type" options=$admintypeArr selected=$admin_obj.reserve_auth_type }
			</td>
		</tr>
		<tr>
			<th>お客様情報権限</th>
			<td>
				{html_radios name="member_auth_type" options=$admintypeArr selected=$admin_obj.member_auth_type }
			</td>
		</tr>
		<tr>
			<th>店舗</th>
			<td>
				{html_options name="shop_no" options=$shopArr selected=$input_data.shop_no}
			</td>
		</tr>


		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_save" onClick="return validate();" class="btn-lg">登録</button>
		</div>
		</form>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

