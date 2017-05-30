{php}
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='stepmail';
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
<h4>ステップメール設定</h4>

		{include file="messages.tpl"}
		
		<div class="w100 center">
		<a href="/mail/stepedit/" class="btn">新規作成</a>
			<table class="admins mt10">
			<tr>
				<th>修正</th>
				<th>タイトル</th>
				<th>配信タイミング</th>
				<th>配信状況</th>
			</tr>
			{foreach from=$arr item="item"}
			<tr>
				<td class="tc"><a href="mail/stepedit/?no={$item.no}" class="btn btn-sm"><i class="fa fa-pencil fa-lg"></i>&nbsp;修正</a></a></td>
				<td>{$item.title}</td>
				<td class="tc">{$item.timing_str}</td>
				<td class="tc">
					<form action="" method="post" name="regForm">
					<label><input type="radio" name="mail_flg" value="1" {if $item.mail_flg==1}checked{/if} >配信する</label>&nbsp;&nbsp;
					<label><input type="radio" name="mail_flg" value="0" {if $item.mail_flg==0}checked{/if} >配信しない</label>&nbsp;&nbsp;
				 {if $login_admin.shop_no>=0}
					<input type="submit" name="submit" value="変更" >
					<input type="hidden" name="no" value="{$item.no}">
				{/if}
					</form>
				</td>
			</tr>
			{/foreach}
			</table>
		</div>
		</div>
	</div>
{include file="footer.tpl"}
</body>
</html>
