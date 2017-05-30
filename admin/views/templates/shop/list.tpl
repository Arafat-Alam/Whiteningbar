{php}
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='shopList';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#owner_id").val("");
	$("#owner_name").val("");
	$("#email").val("");
}


function clickDisableChk(obj) {
	var id = $(obj).attr("id").replace("disabled_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#disabled_" + id).val("t");
	}
	else {
		$("#disabled_" + id).val("f");
	}
}

function clickDeleteChk(obj) {
	var id = $(obj).attr("id").replace("delete_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#delete_" + id).val("t");
	}
	else {
		$("#delete_" + id).val("f");
	}
}

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="shop/menu_shop.tpl"}
		<h3>基本設定</h3>
<h4>店舗一覧</h4>
{include file="messages.tpl"}


		{* 検索結果 *}
<!--
			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
			</div>
  -->
			<form name="fm_list" id="fm_list" method="POST" action="shop/list/">
<div class="w80 center">
ユーザー側表示とは：<br />チェックされている店舗のみがユーザー側に表示されます。管理画面は全て表示されます。<br /><br />
			<table class="admins clear">
			<tr>
				<th >基本情報</th>
				<th >営業設定</th>
				<th >予約ブロック設定</th>
				<th width="100">店名</th>
				<th width="50">店舗ID</th>
				<th>ユーザー側表示</th>
				<th>削除</th>
			</tr>
			{foreach from=$shopArr item="item"}
				<tr>
					<td class="tc"><a href="/shop/edit/?sn={$item.shop_no}" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
					<td class="tc"><a href="/shop/operate/?sn={$item.shop_no}" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
					<td class="tc"><a href="/shop/block/?sn={$item.shop_no}" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
					<td>{$item.name}</td>
					<td>{$item.spid}</td>
					<td class="tc"><input type="checkbox" name="view_flg[]" value="{$item.shop_no}" {if $item.view_flg==1}checked{/if} /></td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="{$item.shop_no}" /></td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="8">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			{/foreach}
			</table>

 {if $login_admin.shop_no>=0}
			<div class="tc">
				<input type="submit" name="submit" value="更新する" onClick="return confirm('チェックされた内容を更新します。削除にチェックを入れてる場合には店舗を削除します');" class="btn-delete">
			</div>
{/if}
			</form>
</div>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

