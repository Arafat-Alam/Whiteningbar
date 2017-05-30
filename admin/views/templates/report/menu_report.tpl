<ul class="tab clearfix mt20">
			<li><a class='{php}if($_SESSION['tab']=='reportList')echo"active"{/php}' href="/report/list/">売上詳細</a></li>
			<li><a class='{php}if($_SESSION['tab']=='daily')echo"active"{/php}' href="/report/daily/">日次売上</a></li>
			<li><a class='{php}if($_SESSION['tab']=='month')echo"active"{/php}' href="/report/month/">月次売上</a></li>
			{if $login_admin.shop_no <=0}
			<li><a class='{php}if($_SESSION['tab']=='graph')echo"active"{/php}' href="/report/graph/">売上グラフ</a></li>
			<li><a class='{php}if($_SESSION['tab']=='menuTrend')echo"active"{/php}' href="/report/menuTrend/">Menu Trend</a></li>
			<li><a class='{php}if($_SESSION['tab']=='saleData')echo"active"{/php}' href="/report/saleData/">Sale Data</a></li>
			{/if}
</ul>
<div class="clear"> </div>