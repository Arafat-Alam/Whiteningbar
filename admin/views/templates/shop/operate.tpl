{php}
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='operate';
{/php}

{include file="head.tpl"}

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="shop/menu_shop.tpl"}
		<h3>基本設定</h3>
<h4>営業設定</h4>

<div class="w60 center">
{if $login_admin.shop_no<=0}
		<a href="/shop/list" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;店舗一覧</a>
{/if}

{include file="messages.tpl"}

		<form method="post" name="fm_search" action="">
		<table class="search w100">
		<tr>
			<th>店の営業曜日</th>
			<td>
				{html_checkboxes name='days' options=$weekArr selected=$input_data.days }
			</td>
		</tr>
		<tr>
			<th>店の営業時間</th>
			<td>
						{if $result_messages.from_def_h}
							<span class="red"> {$result_messages.from_def_h}</span><br />
						{/if}
						{if $result_messages.from_def_m}
							<span class="red"> {$result_messages.from_def_m}</span><br />
						{/if}
						{if $result_messages.to_def_h}
							<span class="red"> {$result_messages.to_def_h}</span><br />
						{/if}
						{if $result_messages.to_def_m}
							<span class="red"> {$result_messages.to_def_m}</span><br />
						{/if}

				<p><div class="operation">通常<span class="red">※</span></div>{html_options name='from_def_h' options=$hourArr selected=$input_data.from_def_h}:{html_options name='from_def_m' options=$minuArr selected=$input_data.from_def_m}
				～{html_options name='to_def_h' options=$hourArr selected=$input_data.to_def_h}:{html_options name='to_def_m' options=$minuArr selected=$input_data.to_def_m}
</p>
				<p class="mt10"><div class="operation">月</div>{html_options name='from_1_h' options=$hourArr selected=$input_data.from_1_h}:{html_options name='from_1_m' options=$minuArr selected=$input_data.from_1_m}
				～{html_options name='to_1_h' options=$hourArr selected=$input_data.to_1_h}:{html_options name='to_1_m' options=$minuArr selected=$input_data.to_1_m}
</p>
				<p class="mt10"><div class="operation">火</div>{html_options name='from_2_h' options=$hourArr selected=$input_data.from_2_h}:{html_options name='from_2_m' options=$minuArr selected=$input_data.from_2_m}
				～{html_options name='to_2_h' options=$hourArr selected=$input_data.to_2_h}:{html_options name='to_2_m' options=$minuArr selected=$input_data.to_2_m}
</p>
				<p class="mt10"><div class="operation">水</div>{html_options name='from_3_h' options=$hourArr selected=$input_data.from_3_h}:{html_options name='from_3_m' options=$minuArr selected=$input_data.from_3_m}
				～{html_options name='to_3_h' options=$hourArr selected=$input_data.to_3_h}:{html_options name='to_3_m' options=$minuArr selected=$input_data.to_3_m}
</p>
				<p class="mt10"><div class="operation">木</div>{html_options name='from_4_h' options=$hourArr selected=$input_data.from_4_h}:{html_options name='from_4_m' options=$minuArr selected=$input_data.from_4_m}
				～{html_options name='to_4_h' options=$hourArr selected=$input_data.to_4_h}:{html_options name='to_4_m' options=$minuArr selected=$input_data.to_4_m}
</p>
				<p class="mt10"><div class="operation">金</div>{html_options name='from_5_h' options=$hourArr selected=$input_data.from_5_h}:{html_options name='from_5_m' options=$minuArr selected=$input_data.from_5_m}
				～{html_options name='to_5_h' options=$hourArr selected=$input_data.to_5_h}:{html_options name='to_5_m' options=$minuArr selected=$input_data.to_5_m}
</p>
				<p class="mt10"><div class="operation">土</div>{html_options name='from_6_h' options=$hourArr selected=$input_data.from_6_h}:{html_options name='from_6_m' options=$minuArr selected=$input_data.from_6_m}
				～{html_options name='to_6_h' options=$hourArr selected=$input_data.to_6_h}:{html_options name='to_6_m' options=$minuArr selected=$input_data.to_6_m}
</p>
				<p class="mt10"><div class="operation">日</div>{html_options name='from_7_h' options=$hourArr selected=$input_data.from_7_h}:{html_options name='from_7_m' options=$minuArr selected=$input_data.from_7_m}
				～{html_options name='to_7_h' options=$hourArr selected=$input_data.to_7_h}:{html_options name='to_7_m' options=$minuArr selected=$input_data.to_7_m}
</p>

			</td>
		</tr>
		<tr>
			<th>ブース数</th>
			<td>
						{if $result_messages.booth}
							<font color="red"> {$result_messages.booth}</font><br />
						{/if}
				<input type="text" name="booth" id="booth"  value="{$input_data.booth}" size="10" />
			</td>
		</tr>
	</table>

{if $login_admin.shop_no>=0}
		<div class="mt20 tc">
			<input type="submit" name="submit" value="更新" class="btn-lg">&nbsp;
<!-- 			<input type="reset"  value="クリア"> -->
			<input type="hidden" name="shop_no" value="{$input_data.shop_no}">

		</div>
{/if}
		</form>

</div>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

