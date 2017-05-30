<?php /* Smarty version 2.6.26, created on 2017-04-24 13:43:49
         compiled from maildeliver/menu_mail.tpl */ ?>
<ul class="tab clearfix mt20">
<!--
	<li><a href="/mail/magazin/">メルマガ一斉配信</a></li>
	<li><a href="/mail/auto/">自動配信メール設定</a></li>
	<li><a href="/mail/stepmail/">ステップメール設定</a></li>
	<li><a href="/mail/sig/">署名作成</a></li>
	<li><a href="/mail/list/">メールテンプレート作成</a></li>
  -->
					<li><a class='<?php if($_SESSION['tab']=='magazin')echo"active" ?>' href="/mail/magazin/">メルマガ一斉配信</a></li>
					<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
					<li><a class='<?php if($_SESSION['tab']=='auto')echo"active" ?>' href="/mail/auto/">自動配信メール</a></li>
					<li><a class='<?php if($_SESSION['tab']=='stepmail')echo"active" ?>' href="/mail/stepmail/">ステップメール</a></li>
					<li><a class='<?php if($_SESSION['tab']=='sig')echo"active" ?>' href="/mail/sig/">署名作成</a></li>
					<li><a class='<?php if($_SESSION['tab']=='mailList')echo"active" ?>' href="/mail/list/">メールテンプレート作成</a></li>
					<?php endif; ?>

</ul>
<div class="clear"> </div>