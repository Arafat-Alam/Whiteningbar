{php}
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='daily';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#start").val("");
	$("#end").val("");


}

$(function(){

	$("#start").datepicker({
		dateFormat: "yy-mm-dd"
	});


	$("#end").datepicker({
		dateFormat: "yy-mm-dd"
	});


});


{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="report/menu_report.tpl"}
		<h3>売上レポート</h3>
<h4>日次売上</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上日</th>
				<td>
				<input type="text" id="start" name="start_date" size="25" value="{$search.start_date|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end" name="end_date" size="25" value="{$search.end_date|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>

				</td>
			</tr>
		</table>

		<div class="mt10 tc">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>

		</form>
	</div>
<hr>

		{* 検索結果 *}
<!--
			<div class="paging">
				<div class="left"><strong>{$total_cnt}</strong>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
			</div>
			<br/>
-->
<form action="" method="post">

<button type="submit" name="csv" class="btn-lg">CSV出力</button>&nbsp;
</form>
			<form name="fm_list" id="fm_list" method="POST" action="/report/list/">

			<table class="admins clear mt10">
			<tr>
				<th width="80">日付</th>
				<th width="80">純売上</th>
				<th width="80">総来客数</th>
				<th width="100">キャンセル</th>
				{foreach from=$courseArr item="item"}
					<th width="80">{$item.name}</th>
				{/foreach}
				<th width="80">他（金額）</th>
				<th width="80">割引合計金額</th>


			</tr>
			{foreach from=$arr item="item"}
				<tr>
					<td>{$item.dt|date_format:"%Y/%m/%d"}</td>
					<td align="right">{$item.total_fee|number_format}</td>
					<td align="right">{if $item.total_count}{$item.total_count}{else}0{/if}</td>
					<td align="right">{if $item.cancel_count}{$item.cancel_count}{else}0{/if}</td>

					{foreach from=$item.course_fee item="fee"}
					<td align="right">
						{$fee|number_format}
					</td>
					{/foreach}

					<td align="right">{$item.other_fee|number_format}</td>
					<td align="right">{$item.discount|number_format}</td>
				</tr>
			{/foreach}
				<tr>
					<td>合計</td>
					<td align="right">{$totalArr.total_fee|number_format}</td>
					<td align="right">{if $totalArr.total_count}{$totalArr.total_count}{else}0{/if}</td>
					<td align="right">{if $$totalArr.cancel_count}{$totalArr.cancel_count}{else}0{/if}</td>
					{foreach from=$totalArr.course_fee item="fee"}
					<td align="right">
						{$fee|number_format}
					</td>
					{/foreach}
					<td align="right">{$totalArr.other_fee|number_format}</td>
					<td align="right">{$totalArr.discount|number_format}</td>
				</tr>

			</table>
<!--
			<div class="paging">
				<div class="left"><strong>{$total_cnt}</strong>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>
  -->
</form>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

