{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#year").val("");
	$("#month").val("");
	$("#day").val("");
	$("#start").val("");
	$("#end").val("");
	$("#r_start").val("");
	$("#r_end").val("");
	$("#reserve_no").val("");
}


$(function(){

	$("#start").datepicker({
		dateFormat: "yy/mm/dd"
	});


	$("#end").datepicker({
		dateFormat: "yy/mm/dd"
	});

	$("#r_start").datepicker({
		dateFormat: "yy/mm/dd"
	});


	$("#r_end").datepicker({
		dateFormat: "yy/mm/dd"
	});

});




{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	<div id="main_content">
		<h3>アフィリエイト管理</h3>

	<div class="w80 center">
		{include file="messages.tpl"}
		{if $result_messages}
			<center><span class="red">{$result_messages}</span></center>
		{/if}

		<form method="post" name="fm_search" action="/affiliate/list/">
		<table class="search center">
			<tr>
				<th>施術日</th>
				<td>
				<input type="text" id="start" name="start_date" size="25" value="{$search.start_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end" name="end_date" size="25" value="{$search.end_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
				</td>
			</tr>
			<tr>
				<th>予約を行った日</th>
				<td>
				<input type="text" id="r_start" name="r_start_date" size="25" value="{$search.r_start_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
				～
				<input type="text" id="r_end" name="r_end_date" size="25" value="{$search.r_end_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
				</td>
			</tr>
			<tr>
				<th>予約番号</th>
				<td><input type="text" name="d_reserve_no" value="{$search.d_reserve_no}" id="reserve_no"></td>
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
				<th width="80">予約番号</th>
				<th width="80">予約を行った日時</th>
				<th width="80">施術日時</th>
				<th width="80">名前</th>
				<th width="100">来店状況</th>
				<th width="80">初回</th>
				<th width="80">店舗</th>
			</tr>
			{foreach from=$arr item="item"}
				<tr>
					<td>{$item.reserve_no}</td>
					<td>{$item.insert_date|date_format:"%Y-%m-%d %H:%M"}</td>
					<td>{$item.reserve_date}　{$item.start_time|date_format:"%H:%M"}</td>
					<td align="right">{$item.name}</td>
					<td align="right">
						{if $item.visit_flg==0}
							予約中
						{elseif $item.visit_flg==1}
							来店
						{else}
							キャンセル
						{/if}
					</td>
					<td align="right">
						{$item.kind_flg}
					</td>
					<td>
						{$item.shop_name}
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="7">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			{/foreach}
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
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
{include file="footer.tpl"}
</body>
</html>