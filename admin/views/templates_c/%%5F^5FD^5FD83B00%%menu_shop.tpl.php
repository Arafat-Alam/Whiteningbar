<?php /* Smarty version 2.6.26, created on 2017-04-20 17:53:58
         compiled from shop/menu_shop.tpl */ ?>
<ul class="tab clearfix mt20">
<!--
	<li><a href="/shop/list/">店舗一覧</a></li>
	<li><a href="/shop/edit/">店舗登録</a></li>
	<li><a href="/shop/course/">コース管理</a></li>
	<li><a href="/shop/menu/">メニュー管理</a></li>
	<li><a href="/shop/enquete/">アンケート設定</a></li>
  -->
				<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
					<li><a class='<?php if($_SESSION['tab']=='shopList')echo"active" ?>' href="/shop/list/">店舗一覧</a></li>
					<li><a class='<?php if($_SESSION['tab']=='edit')echo"active" ?>' href="/shop/edit/">店舗登録</a></li>
					<li><a class='<?php if($_SESSION['tab']=='course')echo"active" ?>' href="/shop/course/">コース管理</a></li>
					<li><a class='<?php if($_SESSION['tab']=='menu')echo"active" ?>' href="/shop/menu/">メニュー管理</a></li>
					<!-- <li><a href="/shop/setform/">顧客登録フォーム設定</a></li> -->
					<li><a class='<?php if($_SESSION['tab']=='enquete')echo"active" ?>' href="/shop/enquete/">アンケート設定</a></li>
				<?php else: ?>
					<li><a class='<?php if($_SESSION['tab']=='edit')echo"active" ?>' href="/shop/edit/">店舗情報</a></li>
					<li><a class='<?php if($_SESSION['tab']=='operate')echo"active" ?>' href="/shop/operate/">営業設定</a></li>
					<li><a class='<?php if($_SESSION['tab']=='block')echo"active" ?>' href="/shop/block/">ブロック設定</a></li>
				<?php endif; ?>
					<li><a class='<?php if($_SESSION['tab']=='staff')echo"active" ?>' href="/shop/staff/">店舗担当者管理</a></li>

</ul>
<div class="clear"> </div>