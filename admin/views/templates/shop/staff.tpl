{php}
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='staff';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}


// 入力チェック
function validate() {
	var msg = "";

	// 名前
	if ($("#user_name").val() == "") {
		msg += "・お名前を入力してください\n";
	}

	if (msg != "") {
		alert(msg);
		return false;
	}

	$("#fm").submit();
	return true;
}

function validateList() {



	$("#flist").submit();
}




{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="shop/menu_shop.tpl"}
		<h3>担当者管理</h3>
		{include file="messages.tpl"}

		<form id="fm" name="fm" method="post" action="">
		<input type="hidden" id="mode" name="mode" value="{$mode}"/>
		<input type="hidden" id="admin_no" name="staff_no" value="{$admin_obj.staff_no}" />

		<table class="center">
		<tr>
			<th>お名前</th>
			<td>
				<input type="text" id="user_name" name="name" size="20" value="{$admin_obj.name}" maxlength="20"/>
			</td>
		</tr>
		<tr>
			<th>店舗</th>
			<td>
				{html_options name="shop_no" options=$shopArr selected=$input_data.shop_no}
			</td>
		</tr>
		<tr>
			<th>表示/非表示</th>
			<td>
				<label><input type="radio"  name="view_flg" value="1" {if $admin_obj.view_flg=="1"}checked{/if} >表示</label>&nbsp;&nbsp;
				<label><input type="radio"  name="view_flg" value="0" {if $admin_obj.view_flg=="0"}checked{/if} >非表示</label>

			</td>
		</tr>

		</table>
		{if $login_admin.shop_no>=0}
		<div class="mt20 tc">
			<button type="submit" name="sbm_save" onClick="return validate();" class="btn-lg">更新</button>
		</div>
		{/if}
		</form>

<a href="/shop/staff/" class="btn mt20">新規作成</a>
		<form method="POST" action="/shop/staff/" >
			<table class="admins clear mt10">
		<tr>
			<th>お名前</th>
			<th>店舗</th>
			<th>表示/非表示</th>
			<th>削除</th>
		</tr>
		{foreach from=$admins item="admin"}
			<tr>
				<td><a href="/shop/staff/?s={$admin.staff_no}&ss={$admin.shop_no}" >{$admin.name}</a></td>
				<td>{$admin.shop_name}</td>
				<td>
				<label><input type="radio"  name="modi_view_flg[{$admin.staff_no}]" value="1" {if $admin.view_flg=="1"}checked{/if} >表示</label>&nbsp;&nbsp;
				<label><input type="radio"  name="modi_view_flg[{$admin.staff_no}]" value="0" {if $admin.view_flg=="0"}checked{/if} >非表示</label>
				</td>
				<td class="tc"><input type="checkbox" name="delete_dummy[]" id="delete_dummy_{$admin.staff_no}" value="{$admin.staff_no}" /></td>
			</tr>
		{/foreach}
		</table>
		{if $login_admin.shop_no>=0 && $admins}
		<div class="tc">
			<input type="submit" name="modify" value="一覧を更新する" onClick="return confirm('更新します。良いですか？')">
		</div>
		{/if}
		</form>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

