<?php /* Smarty version 2.6.26, created on 2017-05-22 09:44:17
         compiled from report/menu_report.tpl */ ?>
<ul class="tab clearfix mt20">
			<li><a class='<?php if($_SESSION['tab']=='reportList')echo"active" ?>' href="/report/list/">売上詳細</a></li>
			<li><a class='<?php if($_SESSION['tab']=='daily')echo"active" ?>' href="/report/daily/">日次売上</a></li>
			<li><a class='<?php if($_SESSION['tab']=='month')echo"active" ?>' href="/report/month/">月次売上</a></li>
			<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
			<li><a class='<?php if($_SESSION['tab']=='graph')echo"active" ?>' href="/report/graph/">売上グラフ</a></li>
			<li><a class='<?php if($_SESSION['tab']=='menuTrend')echo"active" ?>' href="/report/menuTrend/">Menu Trend</a></li>
			<li><a class='<?php if($_SESSION['tab']=='saleData')echo"active" ?>' href="/report/saleData/">Sale Data</a></li>
			<?php endif; ?>
</ul>
<div class="clear"> </div>