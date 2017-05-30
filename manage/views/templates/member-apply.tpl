{include file="head.tpl"}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<script type="text/javascript">
{literal}

function disp(no){

	window.open("/member/sub/?apply_no="+no, "window_name", "width=350,height=250,scrollbars=yes");
}

jQuery(document).ready(function($) {


	$('#allCheck01').click(function() {
		var items = $(this).closest('.allCheck').next().find('input');
		if($(this).is(':checked')){
			$(items).attr ('checked','checked');//アイテムを全部checkedにする
		}
		else{//全選択・全解除がcheckedじゃなかったら
			$(items).removeAttr ('checked'); //アイテムを全部checkedはずす
		}
	});


});

{/literal}
</script>

<body>
<div id="wrapper">
	{include file="header.tpl"}
{include file="sidebar.tpl"}
	<div id="main_content">
		<h3>応募管理</h3>

			{if $submit_msg}<font color="red">{$submit_msg}</font>{/if}
			<div class="paging">
				<div class="left"><b>応募者は{$total_cnt}</b>人です</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>
			<br class="clear" />

			<form name="fm_list" id="fm_list" method="POST" action="/member/">
			<div class="allCheck">
			<input type="checkbox" id="allCheck01">このページの全ての応募者を選択<br />
			選考状況を
			{html_options name="all_sellct_flg" options=$selectArr selected=$input_data.all_sell_flg}
			に<input type="submit" name="all_change" value="変更する"value="選考状況を変更する" onclick="return confirm('応募者の選考状況を変更しますが、よろしいですか？');">
			</div>

			<div>
			<table class="admins">
			<tr>
				<th width=10></th>
				<th width="20">応募日時</th>
				<th width="100">氏名/生年月日</th>
				<th width="100">選考状況</th>
				<th width="100">選考結果報告</th>
				<th width="50">詳細へ</th>
			</tr>

			{foreach from=$memberArr item="item"}
				{assign var="status" value=$item.apply_status}
				{assign var="ano" value=$item.apply_no}
				<tr>
					<td><input type="checkbox" name="apply_no[]" value="{$item.apply_no}" id="check01"></td>
					<td>{$statusArr.$status}<br />{$item.insert_date|date_format:"%G/%m/%d"}</td>
					<td>{$item.name}<br />{$item.age}歳({$item.birth_year}/{$item.birth_month}/{$item.birth_day}</td>
					<td>{html_options name="sellct_flg[$ano]" options=$selectArr selected=$item.select_flg}</td>
					<td>
						{if $item.apply_status<=1}
							<input type="submit" name="apply_ng[{$item.apply_no}]" value="不採用" onClick="return confirm('不採用としますが、よろしいですか？');">
							<input type="button" value="採用" onClick="disp({$item.apply_no})">
						{elseif $item.apply_status==99}
							不採用
						{else}
							{$item.employ_str}として内定済み
						{/if}
					</td>
					<td><a href="/member/detail/?apn={$item.apply_no}">詳細へ</a></td>

				</tr>
			{foreachelse}
				<tr>
					<td colspan="7">応募者はまだいません。</td>
				</tr>
			{/foreach}
			</table>
			</div>
			<br />
			<div class="paging">
				<div class="left"><b>応募者は{$total_cnt}</b>人です</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>
			<div class="center">
				<input type="submit" name="submit" value="選考状況を変更する" onclick="return confirm('応募者の選考状況を変更しますが、よろしいですか？');">
			</div>
			</form>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

