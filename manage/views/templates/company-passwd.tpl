{include file="head.tpl"}

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
		<h3>法人会員ログイン情報編集</h3>

		{if $msg}<font color="red">{$msg}</font>{/if}

		<form method="post" name="fm_search" action="company/passwd">
		<table class="search">
		<tr>
			<th>旧パスワード</th>
			<td>
						{if $result_messages.oldpsssword}
							<font color="red"> {$result_messages.oldpsssword}</font><br />
						{/if}
				<input type="password" name="oldpassword" id="user_name"  value="{$input_data.oldpassword}" size="40" />
			</td>
		</tr>
		<tr>
			<th>新パスワード</th>
			<td>
						{if $result_messages.psssword}
							<font color="red"> {$result_messages.psssword}</font><br />
						{/if}
				<input type="password" name="password" id="user_name"  value="{$input_data.password}" size="40" />
			</td>
		</tr>
		<tr>
			<th>新パスワード確認</th>
			<td>
				<input type="password" name="password2" id="user_name"  value="{$input_data.password2}" size="40" />
			</td>
		</tr>


		</table>
		<div>
			<input type="submit" name="modify" value="変更">&nbsp;
			<input type="reset"  value="クリア">
			<input type="hidden" name="company_id" value="{$company.company_id}">

		</div>
		</form>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

