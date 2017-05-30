{php}
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='saleData';
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
			{if $login_admin.shop_no==0}
			<tr>
				<th>ストアを選択</th>
				<td> 
					<select name="shop_no">
						<option value="0">すべての店</option>
						{php}
							$shopArr = $this->get_template_vars('shopArr');
							$shop_no = $this->get_template_vars('shop_no');
							foreach($shopArr as $key => $value){
							
						{/php}
							<option value="{php}echo $value['shop_no'];{/php}" {php}if($shop_no==$value['shop_no'])echo "selected"{/php}>{php}echo $value['name'];{/php}</option>
						{php}
							}
						{/php}
					</select>
				</td>
			</tr>
			{/if}
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

<button type="submit" name="csv" class="btn-lg">XLS出力</button>&nbsp;
</form>
			{if isset($dataArr)}
			<table>	
				{foreach from=$dataArr key=arrKey item=itemArr}
					{if $arrKey==0}
						<tr>
							<th>日付 / date</th>
							<th>曜日 / day</th>
							<th>総売上 / Weather</th>
							<th>総売上 / total sale</th>
							<th>総来客数 / total visitor</th>
							<th>招待 / cancel visit</th>
							<th>初来店</th>
							<th>6回コース</th>
							<th>12回コース</th>
							<th>ウェディングコース</th>
							<th>9回コース</th>
							<th>18回コース</th>
							<th>1回コース</th>
							<th>24回コース</th>
							<th>36回コース</th>
							<th>初来店再予約</th>
							<th>期間限定お試し3回コース</th>
							<th>1回コース 2回連続ケア</th>
							<th>初回限定3回コース</th>
							<th>オープン記念キャンペーン(500円）</th>
							<th>学割6回コース</th>
							<th>学割9回コース</th>
							<th>学割12回コース</th>
							<th>学割18回コース</th>
							<th>学割24回コース</th>
							<th>学割36回コース</th>
							<th>クリーニング1回コース</th>
							<th>ホワイトニング+クリーニング1回コース</th>
							<th>6回コース+クリーニング</th>
							<th>学割6回コース+クリーニング</th>
							<th>9回コース+クリーニング</th>
							<th>学割9回コース+クリーニング</th>
							<th>12回コース+クリーニング</th>
							<th>学割12回コース+クリーニング</th>
							<th>ウェディングコース+クリーニング</th>
							<th>学割18回コース+クリーニング</th>
							<th>18回コース+クリーニング</th>
							<th>24回コース+クリーニング</th>
							<th>学割24回コース+クリーニング</th>
							<th>36回コース+クリーニング</th>
							<th>学割36回コース+クリーニング</th>
							<th>初回限定3回コース+クリーニング</th>
							<th>社内管理用　+1</th>
							<th>コース割引合計金額 / total Discount</th>
						</tr>
					{else}
						<tr>
							<td>{$arrKey}</td>
							<td>{$itemArr.day}</td>
							<td>{$itemArr.weather}</td>
							<td>{$itemArr.totalFee}</td>
							<td>{$itemArr.totalVisitor}</td>
							<td>{$itemArr.totalCancelVisit}</td>
							<td>{$itemArr.1}</td>
							<td>{$itemArr.2}</td>
							<td>{$itemArr.3}</td>
							<td>{$itemArr.4}</td>
							<td>{$itemArr.6}</td>
							<td>{$itemArr.7}</td>
							<td>{$itemArr.11}</td>
							<td>{$itemArr.12}</td>
							<td>{$itemArr.13}</td>
							<td>{$itemArr.15}</td>
							<td>{$itemArr.18}</td>
							<td>{$itemArr.29}</td>
							<td>{$itemArr.30}</td>
							<td>{$itemArr.33}</td>
							<td>{$itemArr.34}</td>
							<td>{$itemArr.35}</td>
							<td>{$itemArr.36}</td>
							<td>{$itemArr.37}</td>
							<td>{$itemArr.40}</td>
							<td>{$itemArr.41}</td>
							<td>{$itemArr.42}</td>
							<td>{$itemArr.43}</td>
							<td>{$itemArr.44}</td>
							<td>{$itemArr.45}</td>
							<td>{$itemArr.46}</td>
							<td>{$itemArr.47}</td>
							<td>{$itemArr.48}</td>
							<td>{$itemArr.49}</td>
							<td>{$itemArr.50}</td>
							<td>{$itemArr.51}</td>
							<td>{$itemArr.52}</td>
							<td>{$itemArr.53}</td>
							<td>{$itemArr.54}</td>
							<td>{$itemArr.55}</td>
							<td>{$itemArr.56}</td>
							<td>{$itemArr.57}</td>
							<td>{$itemArr.58}</td>
							<td>{$itemArr.totalDiscount}</td>
						</tr>
					{/if}
				{/foreach}
						<tr>
							<td colspan="3">Total</td>
							<td>{$maxTotal.totalFee}</td>
							<td>{$maxTotal.totalVisitor}</td>
							<td>{$maxTotal.totalCancel}</td>
							<td>{$maxTotal.1}</td>
							<td>{$maxTotal.2}</td>
							<td>{$maxTotal.3}</td>
							<td>{$maxTotal.4}</td>
							<td>{$maxTotal.6}</td>
							<td>{$maxTotal.7}</td>
							<td>{$maxTotal.11}</td>
							<td>{$maxTotal.12}</td>
							<td>{$maxTotal.13}</td>
							<td>{$maxTotal.15}</td>
							<td>{$maxTotal.18}</td>
							<td>{$maxTotal.29}</td>
							<td>{$maxTotal.30}</td>
							<td>{$maxTotal.33}</td>
							<td>{$maxTotal.34}</td>
							<td>{$maxTotal.35}</td>
							<td>{$maxTotal.36}</td>
							<td>{$maxTotal.37}</td>
							<td>{$maxTotal.40}</td>
							<td>{$maxTotal.41}</td>
							<td>{$maxTotal.42}</td>
							<td>{$maxTotal.43}</td>
							<td>{$maxTotal.44}</td>
							<td>{$maxTotal.45}</td>
							<td>{$maxTotal.46}</td>
							<td>{$maxTotal.47}</td>
							<td>{$maxTotal.48}</td>
							<td>{$maxTotal.49}</td>
							<td>{$maxTotal.50}</td>
							<td>{$maxTotal.51}</td>
							<td>{$maxTotal.52}</td>
							<td>{$maxTotal.53}</td>
							<td>{$maxTotal.54}</td>
							<td>{$maxTotal.55}</td>
							<td>{$maxTotal.56}</td>
							<td>{$maxTotal.57}</td>
							<td>{$maxTotal.58}</td>
							<td>{$maxTotal.totalDiscount}</td>
						</tr>
			</table>
			{/if}
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

