{include file="head.tpl"}
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="maildeliver/menu_mail.tpl"}
		<h3>ユーザー</h3>
<h4>メルマガ一斉配信</h4>


			  <p class="mt20 tc">この画面の内容が送信されます。<br />
			  内容を変更したい場合はこの画面から直接編集することもできます。<br />ただし、変更したものは保存されません。

			  </p>

<form action="/mail/magazin/" method="post"  >
      <table class="center w80">
		<tr>
			<th>件名</th>
			<td>
				<input type="text" size="60" name="subject" value="{$template_subject}">
			</td>
		</tr>
		<tr>
			<th rowspan="4">メール本文</th>
			<td>xxxxx様 <span class="gray sm">（※自動で顧客名が入ります）</span></td>
		</tr>
		<tr>
			　
			<td>
				<textarea name="mail" rows="20" cols="60">{$template_mail_text}</textarea>
			</td>
		</tr>
		<tr>
			<td>
				※メルマガ不要な方は配信停止の設定をお願いいたします※<br />
				{$smarty.const.ROOT_URL}member/magazin_login/<br />

				↑<br />
				メルマガには必ずこの文章が入ります<br />

			</td>
		</tr>
		<tr>
			<td>
				<textarea name="sig" rows="10" cols="60">{$sigArr.sig}</textarea>
			</td>
		</tr>
     </table>


      <div class="mt20 tc">
         <input type="submit"  name="back" value="送信先変更" class="btn-gray" />
        <input type="submit"  name="send_submit" value="メール送信" class="btn-lg" />
      </div>

</form>
</div>
</div>
{include file="footer.tpl"}
</body>
</html>
