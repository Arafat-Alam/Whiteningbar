<?php /* Smarty version 2.6.26, created on 2017-04-19 19:53:00
         compiled from menu_admin.tpl */ ?>
<ul class="tab clearfix mt20">
<!--
	<li><a href="/news/list/">お知らせ管理</a></li>
	<li><a href="/master/category1/">クーポン管理</a></li>
	<li><a href="/master/category2/">会員支払項目管理</a></li>
	<li><a href="/siteConfig">サイト表示設定</a></li>
	<li><a href="/admin/list">サイト管理者</a></li>
	<li><a href="/report/list/">売上レポート</a></li>
 -->
				<?php if ($this->_tpl_vars['login_admin']['shop_no'] == 0): ?>
					<li><a class='<?php if($_SESSION['tab']=='list')echo"active" ?>' href="/news/list/">お知らせ管理</a></li>
					<li><a class='<?php if($_SESSION['tab']=='category1')echo"active" ?>' href="/master/category1/">クーポン管理</a></li>
					<li><a class='<?php if($_SESSION['tab']=='category2')echo"active" ?>' href="/master/category2/">会員支払項目管理</a></li>
					<li><a class='<?php if($_SESSION['tab']=='siteConfig')echo"active" ?>' href="/siteConfig/">サイト表示設定</a></li>
					<li><a class='<?php if($_SESSION['tab']=='member_require')echo"active" ?>' href="/admin/member_require/">必須項目設定</a></li>
				<?php endif; ?>

				<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
					<li><a class='<?php if($_SESSION['tab']=='adminList')echo"active" ?>' href="/admin/list">サイト管理者</a></li>

				<?php endif; ?>

</ul>
<div class="clear"> </div>