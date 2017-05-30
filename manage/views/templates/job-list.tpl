{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#user_id").val("");
	$("#user_name").val("");
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
		<h3>求人票管理</h3>
		<font color="red">
		{include file="messages.tpl"}
		</font>

		<form method="post" name="fm_search" action="company/job_edit/">
			<input type="submit" value="求人票の新規作成">
		</form>

		{* 検索結果 *}

			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
				<!--<div class="end"></div>-->
			</div>
			<br />
			<form name="fm_list" id="fm_list" method="POST" action="company/job/">
			<table class="admins">
			<tr>
				<th width="20">求人No</th>
				<th width="100">キャッチコピー</th>
				<th width="100">募集期間</th>
				<th width="20">削除</th>
			</tr>
			{foreach from=$company item="item" name=name}
				<input type="hidden" name="company_id[]" value="{$item.company_id}"/>

				<tr>
					<td><a href="company/job_edit/?job_no={$item.job_no}">{$item.job_no}</a></td>
					<td><a href="company/job_edit/?job_no={$item.job_no}">{$item.promo}</a></td>
					<td>{$item.view_start|date_format:"%Y/%m/%d"}～{$item.view_end|date_format:"%Y/%m/%d"}</td>
					<td><input type="checkbox" name="delete_dummy[]" value="{$item.job_no}" /></td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="7">データがありませんでした。</td>
				</tr>
			{/foreach}
			</table>
			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>
			<div class="center">
				<input type="submit" name="submit" value="一覧を更新する" onclick="return confirm('求人情報および関連情報を削除します。');">
			</div>
			</form>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

