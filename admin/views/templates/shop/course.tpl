{php}
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='course';
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


function mainup( id, val )
{

	document.fm_list.action = "/shop/course/";
	document.fm_list.id.value = id;
	document.fm_list.value.value = val;
	document.fm_list.exec.value = "mainup";
	document.fm_list.submit();
}
function maindown( id, val )
{
	document.fm_list.action = "/shop/course/";
	document.fm_list.id.value = id;
	document.fm_list.value.value = val;
	document.fm_list.exec.value = "maindown";
	document.fm_list.submit();
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
<h4>コース一覧</h4>
{include file="messages.tpl"}

<p>
購入コースの一覧になります。
<br />各コースのメニューは<a href="/shop/menu/">「メニュー管理」から設定</a>してください。

</p>

		{* 検索結果 *}
<!--
			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
			</div>
  -->
 {if $login_admin.shop_no>=0}
  <a href="/shop/courseEdit/" class="btn">コースの新規作成</a>
{/if}
			<form name="fm_list" id="fm_list" method="POST" action="/shop/course/">
<input type="hidden" name="id"  />
<input type="hidden" name="exec"/>
<input type="hidden" name="value" />

			<table class="admins clear mt10">
			<tr>
				<th width="100">コース名</th>
				<th width="25">料金</th>
				<th width="50">編集</th>
				<th width="50">コピー</th>
				<th width="8" >表示順</th>
				<th width="8" >表示順</th>
				<th width="20">削除</th>
			</tr>
			{foreach from=$shopArr name=name item="item"}
				<tr>
					<td>{$item.name}</td>
					<td class="tr">{$item.fee}&nbsp;円</td>
					<td class="tc"><a href="/shop/courseEdit/?sn={$item.course_no}" class="btn btn-sm"><i class="fa fa-pencil fa-lg"></i>&nbsp;修正</a></td>
					<td class="tc"><a href="/shop/courseEdit/?copy&sn={$item.course_no}" class="btn btn-sm"><i class="fa fa-files-o fa-lg"></i>&nbsp;コピー</a></td>
					<td class="tc">{if $smarty.foreach.name.index!=0}<a href="javascript:void( 0 );" onClick="mainup({$item.course_no}, {$item.v_order} )" class="btn btn-sm">▲</a>{/if}</td>
					<td class="tc">
						{if $smarty.foreach.name.iteration!=count($shopArr)}
							<a href="javascript:void( 0 );" onClick="maindown({$item.course_no}, {$item.v_order} )" class="btn btn-sm">▼</a>{/if}
					</td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="{$item.course_no}" /></td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="8">コース未設定</td>
				</tr>
			{/foreach}
			</table>
<!--
			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>
 -->
  {if $login_admin.shop_no>=0}
			<div class="tc">
				<input type="submit" name="upsubmit" value="削除" onClick="return confirm('チェックされたコースを削除します。良いですか？');" class="btn-delete">
			</div>
{/if}
			</form>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

