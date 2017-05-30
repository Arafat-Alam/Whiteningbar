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
		<h2>法人会員様　パスワードを忘れた方</h2>
		<div>ご登録のメールアドレス入力してください。<br />仮パスワードを発行して、ご登録のメールアドレスに送信致します。</div>
		{if $resMsg}
			<div class="header_msg_warn">
				<div>{$resMsg}</div>
			</div>
		{/if}
		</div>
		<form name="fm" method="post" action="">
		<table style="margin-left:auto; margin-right:auto; margin-bottom:10px;">
		<tr>
			<th>メールアドレス：</th>
			<td><input type="text" name="email" id="user_id" size="60" value="{$email}" /></td>
		</tr>
		</table>
		{if $result==0}
		<div class="center">
			<button type="submit" name="sbm_login" onclick="return validate()">送信</button>
		</div>
		{/if}

		<a href="/manager/login">ログイン画面へ戻る</a>
		<input type="hidden" name="mode" value="sys" />
		<input type="hidden" name="command" value="cert" />
		</form>
	</div>


</div>
{include file="footer.tpl"}
</body>
</html>
