{include file="head.tpl"}
<script type="text/javascript">
{literal}

function editcancel()
{
	document.regForm.action="master/category1/";
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
		<h3>クーポン管理</h3>


{if $exec=="middle"}
	<h4>中カテゴリ追加</h4>

{elseif $exec=="sub"}
	<h4>小カテゴリ追加</h4>

{elseif $exec=="main"}
	<h4>メインカテゴリ追加</h4>
{else}
	<h4>カテゴリ編集</h4>
{/if}

<div class="w60 center">

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
<form name="regForm" method="post" action="master/category1edit">
<input type="hidden" name="ctitle" value="{$ctitle}" />
<input type="hidden" name="id" value="{$id}" />
<input type="hidden" name="parentid" value="{$parentid}" />
<input type="hidden" name="exec" value="{$exec}" />
<input type="hidden" name="cflag" value="{$cflag}" />
<table class="w100 mt10">
</td>
</tr>
<tr>
<th>クーポン名<span class="red">※</span></th>
<td>
						{if $result_messages.category}
							<span class="red"> {$result_messages.category}</span><br />
						{/if}
<input type="text" name="name" value="{$name}" style="ime-mode:active;width:350px" />
</td>
</tr>
{if $exec=="middle"|| $itemObj.cflag==2}
<tr>
	<th>ふりがな</th>
	<td>
		{if $result_messages.name_kana}<span class="red"> {$result_messages.name_kana}</span><br />{/if}
		<input type="text" name="name_kana" value="{$name_kana}" style="ime-mode:active;width:350px" />
		<br><font size=1>※お客様からは見えませんので、ご自由にソートしたい順番（あいうえお順）でご入力ください</font>
	</td>
</tr>
<tr>
<th>クーポン種類</th>

<td>

<label><input type="radio" name="kind_flg" value="0" {if $kind_flg==0} checked {/if}  />金額の値引き</label><br />
<label><input type="radio" name="kind_flg" value="1" {if $kind_flg==1} checked {/if}  />それ以外</label>
</td>
</tr>

<tr>
<th>割引金額</th>

<td>
						{if $result_messages.fee}
							<span class="red"> {$result_messages.fee}</span><br />
						{/if}
クーポン種類が金額の値引きの場合は、値引きする金額を入力してください。<br />
<input type="text" name="fee" value="{$fee}" style="ime-mode:active;width:50px" />円
</td>
</tr>
{else}
<tr>
<th>月報集計用フラグ</th>

<td>

<label><input type="radio" name="report_flg" value="1" {if $report_flg==1} checked {/if}  />デコログ</label>
<label><input type="radio" name="report_flg" value="2" {if $report_flg==2} checked {/if}  />ブログ掲載</label>
<label><input type="radio" name="report_flg" value="0" {if $report_flg==0} checked {/if}  />その他</label>

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

{/if}
{include file="footer.tpl"}
</body>
</html>
