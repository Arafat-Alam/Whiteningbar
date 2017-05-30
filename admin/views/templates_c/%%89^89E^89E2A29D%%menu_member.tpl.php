<?php /* Smarty version 2.6.26, created on 2017-05-17 15:57:50
         compiled from member/menu_member.tpl */ ?>
<ul class="tab clearfix mt20">
	<li><a class='<?php if($_SESSION['tab']=='customer')echo"active" ?>' href="/member/list/">顧客一覧</a></li>
	<li><a class='<?php if($_SESSION['tab']=='unpaid')echo"active" ?>' href="/member/unpaid/">未払い一覧</a></li>
	<li><a class='<?php if($_SESSION['tab']=='cancel')echo"active" ?>' href="/member/cancel/">キャンセル一覧</a></li>
	<li><a class='<?php if($_SESSION['tab']=='noShowUp')echo"active" ?>' href="/member/noShowUp/">来店せず一覧</a></li>
</ul>
<div class="clear"> </div>