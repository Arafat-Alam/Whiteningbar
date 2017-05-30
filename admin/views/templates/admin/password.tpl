
{include file="head.tpl"}

<body>
<div id="wrapper">
	<div>

	<h2 class="tc">パスワードを忘れた方</h2>
		<p class="mt20 tc">パスワードをお忘れの場合、仮パスワードを発行いたします。<br>
				必要事項をご入力の上、「送信する」ボタンを押して下さい。</p>
			<div class="sm-box tc">

{include file="messages.tpl"}

			<form action=""  method="post">

		<table style="margin-left:auto; margin-right:auto; margin-bottom:10px;">
		<tr>
			<th>ログインID：</th>
			<td><input type="text" name="user_id" id="user_id" size="20" value="{$user_id}" /></td>
		</tr>
		<tr>
			<th>ご登録のメールアドレス：</th>
			<td><input type="text" name="email" id="email" size="20" value="{$email}" /></td>
		</tr>
		</table>


				<div class="submit">

					<input type="submit" value="送信する" />
				</div>
			</form>
			</dl>

	</div>
</div>


	{include file="footer.tpl"}
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
</body>
</html>