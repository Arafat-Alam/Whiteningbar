{php}
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='auto';
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

<h4>自動配信メール</h4>
		{include file="messages.tpl"}


			<table class="center">
			<tr>
				<th>修正</th>
				<th>タイトル</th>
				<th>配信タイミング</th>
				<th>配信状況</th>
			</tr>
			{foreach from=$arr item="item"}
			<tr>
				<td><a href="mail/autoedit/?no={$item.no}" class="btn btn-sm"><i class="fa fa-pencil fa-lg"></i>&nbsp;修正</a></a></td>
				<td>{$item.title}</td>
				<td class="tc">{$item.comment}</td>
				<td class="tc">
					<form action="" method="post" name="regForm">
					<label><input type="radio" name="mail_flg" value="1" {if $item.mail_flg==1}checked{/if} >配信する</label>&nbsp;&nbsp;
					<label><input type="radio" name="mail_flg" value="0" {if $item.mail_flg==0}checked{/if} >配信しない</label>
				 {if $login_admin.shop_no>=0}
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value="変更" class="btn btn-sm" >
					<input type="hidden" name="no" value="{$item.no}">
				{/if}
					</form>
				</td>
			</tr>
			{/foreach}
			</table>
		</div>
	</div>
{include file="footer.tpl"}
</body>
</html>
