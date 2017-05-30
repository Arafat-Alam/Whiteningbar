{php}
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='month';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#f_year").val("");
	$("#f_month").val("");
	$("#t_year").val("");
	$("#t_month").val("");
	$("input#mon1").attr('checked',false);
	$("input#mon2").attr('checked',false);
	$("input#mon3").attr('checked',false);


}

$(function(){


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
<h4>月次売上</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上月</th>
				<td>
		          	{html_options name="f_year" options=$yearArr selected=$search.f_year id=f_year}
		            年
		            {html_options name="f_month" options=$monthArr selected=$search.f_month id=f_month}
		            月
		            ～
		          	{html_options name="t_year" options=$yearArr selected=$search.t_year id=t_year}
		            年
		            {html_options name="t_month" options=$monthArr selected=$search.t_month id=t_month}
		            月

				</td>
			</tr>
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
				<td colspan="2" align="center">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>

				</td>
			</tr>
		</table>

		<table class="search center">
		<tr>
			<th>月選択</th>
			<td>
				<input type="radio" name="mon" value="0" {if $search.mon==0}checked{/if} id=mon1 />今月　
				<input type="radio" name="mon" value="1" {if $search.mon==1}checked{/if} id=mon2 />先月　
				<input type="radio" name="mon" value="2" {if $search.mon==2}checked{/if} id=mon3 />先々月

			</td>
		</tr>
		{if $login_admin.shop_no==0}
		<tr>
				<th>ストアを選択</th>
				<td> 
					<select name="shop_no1">
						<option value="0">すべての店</option>
						{php}
							$shopArr = $this->get_template_vars('shopArr');
							$shop_no1 = $this->get_template_vars('shop_no1');
							foreach($shopArr as $key => $value){
							
						{/php}
							<option value="{php}echo $value['shop_no'];{/php}" {php}if($shop_no1==$value['shop_no'])echo "selected"{/php} >{php}echo $value['name'];{/php}</option>
						{php}
							}
						{/php}
					</select>
				</td>
			</tr>
			{/if}
			<tr>
				<td colspan="2" align="center">
			<button type="submit" name="sbm_search2" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>

				</td>
			</tr>
		</table>
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
					<td align="right">{if $totalArr.cancel_count}{$totalArr.cancel_count}{else}0{/if}</td>
					{foreach from=$totalArr.course_fee item="fee"}
					<td align="right">
						{$fee}
						{* $fee|number_format *}
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

