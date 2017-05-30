{include file="head.tpl"}
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="maildeliver/menu_mail.tpl"}
		<h3>メール管理</h3>
<h4>自動配信メール詳細設定</h4>

		{include file="messages.tpl"}


		<form action="" method="post"  >
		      <table class="w80 center">

			        <tr>
			          <th>サブジェクト</th>
			          <td>
						<input type="text" name="subject" value="{$input_data.subject}" size="60">
			          </td>
			        </tr>

			        <tr>
			          <th>文章ヘッダ</th>
			          <td>
						<textarea name="header_text" rows="10" cols="60">{$input_data.header_text}</textarea>
			          </td>
			        </tr>

			        <tr>
			          <th>文章フッタ</th>
			          <td>
						<textarea name="footer_text" rows="10" cols="60">{$input_data.footer_text}</textarea>
			          </td>
			        </tr>

		     </table>

 {if $login_admin.shop_no>=0}
		      <div class="mt20 tc">
		        <input type="submit"  name="submit" value="更新" class="btn-lg" />
		      </div>
{/if}
		</form>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
