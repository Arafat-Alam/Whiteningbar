{include file="head.tpl"}
<script type="text/javascript">
{literal}

function editcancel()
{
	document.regForm.action="master/category2/";
	document.regForm.submit();
}

{/literal}
</script>

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="menu_admin.tpl"}
		<h3>会員支払項目管理</h3>


{if $exec=="middle"}
	<h4>中カテゴリ追加</h4>

{elseif $exec=="sub"}
	<h4>小カテゴリ追加</h4>

{elseif $exec=="main"}
	<h4>メインカテゴリ追加</h4>
{else}
	<h4>カテゴリ編集</h4>
{/if}

{if $msg }

	{if $exec=="middle"}
		中カテゴリを追加しました。
	{elseif $exec=="sub"}
		小カテゴリを追加しました。
	{elseif $exec=="main"}
		大カテゴリを追加しました。
	{else}
		カテゴリを編集しました。
	{/if}

{else}
<form name="regForm" method="post" action="master/category2edit">
<input type="hidden" name="ctitle" value="{$ctitle}" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="parentid" value="{$parentid}" />
<input type="hidden" name="exec" value="{$exec}" />
<input type="hidden" name="cflag" value="{$cflag}" />
<table class="w60 center">
</td>
</tr>
<tr>
<th>※支払項目名</th>
<td>
						{if $result_messages.category}
							<span class="red"> {$result_messages.category}</span><br />
						{/if}
<input type="text" name="name" value="{$itemObj.name}" style="ime-mode:active;width:350px" />
</td>
</tr>
<tr>
<th>金額</th>

<td>
						{if $result_messages.fee}
							<span class="red"> {$result_messages.fee}</span><br />
						{/if}<br />
<input type="text" name="fee" value="{$itemObj.fee}" style="ime-mode:active;width:50px" />円
</td>
</tr>
{/if}
</table>
<p class="mt20 tc">
	<input type="submit" name="regist" value="OK" class="btn-lg" />
	<input name="cancel" type="button" value="キャンセル" onClick="editcancel();" class="btn-gray" />
</p>
</form>

</div>
</div>

{include file="footer.tpl"}
</body>
</html>
