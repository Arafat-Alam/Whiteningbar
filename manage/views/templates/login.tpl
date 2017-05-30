{include file="head.tpl"}
<script type="text/javascript">
{literal}
/**
 * 入力チェック
 **/
function validate(){
	var msg = "";

	if ($("#user_id").val() == "") {
		msg += "\n・メールアドレスが入力されていません";
	}
	if ($("#password").val() == "") {
		msg += "\n・パスワードが入力されていません";
	}

	if (msg != "") {
		alert(msg);
		return false;
	}

	return true;
}

{/literal}
</script>
</head>
<body>
<div id="wrapper">
	<div class="center">
		<h2>{$smarty.const.STR_SITE_TITLE}へのログイン</h2>
		<div>メールアドレスとパスワードを入力して「ログイン」ボタンをクリックしてください。<br />
		※<a href="/manager/password/">パスワードを忘れた方</a><br /><br /></div>
		{if $msg}
			<div class="header_msg_warn">
				<div>{$msg}</div>
			</div>
		{/if}
		</div>
		<form name="fm" method="post" action="manager/login">
		<table style="margin-left:auto; margin-right:auto; margin-bottom:10px;">
		<tr>
			<th>メールアドレス：</th>
			<td><input type="text" name="email" id="user_id" size="50" value="{$email}" /></td>
		</tr>
		<tr>
			<th>パスワード：</th>
			<td><input type="password" name="password" id="password" size="20" value="" /></td>
		</tr>
		</table>
		<div class="center">
			<button type="submit" name="sbm_login" onclick="return validate()">ログイン</button>
		</div>
		<input type="hidden" name="mode" value="sys" />
		<input type="hidden" name="command" value="cert" />
		</form>
	</div>


</div>
{include file="footer.tpl"}
</body>
</html>
