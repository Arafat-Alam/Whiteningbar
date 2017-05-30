{php}
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='reportList';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#year").val("");
	$("#month").val("");
	$("#day").val("");
	$("#course").val("");
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
<h4>売上詳細</h4>
	<div class="w70 center">
		{include file="messages.tpl"}
		{if $result_messages}
			<center><span class="red">{$result_messages}</span></center>
		{/if}

		<form method="post" name="fm_search" action="/report/list/">
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
			{php}
				$arr = $this->get_template_vars('arr'); 
				if(isset($arr)){
					foreach($arr as $key => $val){
						$totalPrice += $val['price'];
					}	
				}
				$i=1;
				$this->assign('i',$i);
			{/php}
			<table>
				<tr>
					<th width="180">Total Price =</th>
					<td width="100" align="center">{php}echo $totalPrice;{/php} 円</td>
				</tr>
			</table>
			<table class="admins clear mt10">
			<tr>
				<th width="80">sl</th>
				<th width="80">日付</th>
				<th width="80">お名前</th>
				<th width="80">来店時間</th>
				<th width="80">使用コース</th>
				<th width="80">コース消費何回目</th>
				<th width="100">コース購入</th>
				<th width="100">クーポン利用</th>
				<th width="80">その他</th>
				<th width="80">price</th>
			</tr>
			{foreach from=$arr item="item"}
				<tr>
					<td>{$i++}</td>
					<td>{$item.dt|date_format:"%Y/%m/%d"}</td>
					<td>{if $item.name_kana}{$item.name_kana}{else}{$item.name}{/if}<br>{$item.member_no}</td>
					<td>{$item.start_time|date_format:'%H:%M'}</td>
					<td>{$item.use_course_name}</td>
					<td>{if $item.c_cnt}{$item.c_cnt}回目{/if}</td>
					<td>{$item.course_name}</td>
					<td>{$item.coupon_name}</td>
					<td>{$item.other_fee}</td>
					<td>{$item.price} 円</td>

				</tr>
			{/foreach}
			<tr>
				<td colspan="9" align="right">Total Price =</td>
				<td >{php}echo $totalPrice;{/php} 円</td>
			</tr>
			</table>
</form>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

