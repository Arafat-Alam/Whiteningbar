{php}
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='mailList';
{/php} 

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function edit_submit(no){

	document.regForm.action = "./mail/edit/";
	document.regForm.template_no.value = no
	document.regForm.submit();

}

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="maildeliver/menu_mail.tpl"}
		<h3>メール管理</h3>
<h4>メールテンプレート作成</h4>

<div class="w50 center">
		{include file="messages.tpl"}
 {if $login_admin.shop_no>=0}
			<div class="submit mt20">
				<form action="/mail/edit/" method="post">
					<input type="submit" value="メールテンプレート新規作成">
				</form>
			</div>
{/if}

<h5>メールテンプレート一覧</h5>
			<form action="" method="post" name="regForm">
			<input type="hidden" name="template_no">
			{$page_navi}

			<table class="w100">
			<tr>
				<th>タイトル</th>
				<th>編集</th>
				<th>削除</th>
			</tr>
			{foreach from=$arr item="item"}
			<tr>
				<td>{$item.title}</td>
				<td class="tc">
				 {if $login_admin.shop_no>=0}
					<input type="button" value="編集" onClick="edit_submit({$item.template_no})">
				{/if}
				</td>
				<td class="tc">
					<input type="checkbox" name="delete[]" value="{$item.template_no}">
				</td>

			</tr>
			{/foreach}


			</table>
			{$page_navi}

 {if $login_admin.shop_no>=0}
			<div class="mt20 tc">
				<input type="submit" name="sbm_delete" value="削除" onClick="confirm('メールテンプレートを削除します。');" class="btn-delete">
			</div>
{/if}
			</form>
		</div>
		</div>
	</div>
{include file="footer.tpl"}
</body>
</html>
