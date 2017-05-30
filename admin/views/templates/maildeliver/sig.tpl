{php}
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='sig';
{/php} 

{include file="head.tpl"}
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="maildeliver/menu_mail.tpl"}
		<h3>メール管理</h3>
<h4>署名作成</h4>

		{include file="messages.tpl"}


		<form action="" method="post"  >
		      <table class="center">
			        <tr>
			          <th>署名</th>
			          <td>
						<textarea name="sig" rows="10" cols="60">{$input_data.sig}</textarea>


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
