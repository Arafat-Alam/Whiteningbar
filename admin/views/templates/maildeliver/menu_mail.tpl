<ul class="tab clearfix mt20">
<!--
	<li><a href="/mail/magazin/">メルマガ一斉配信</a></li>
	<li><a href="/mail/auto/">自動配信メール設定</a></li>
	<li><a href="/mail/stepmail/">ステップメール設定</a></li>
	<li><a href="/mail/sig/">署名作成</a></li>
	<li><a href="/mail/list/">メールテンプレート作成</a></li>
  -->
					<li><a class='{php}if($_SESSION['tab']=='magazin')echo"active"{/php}' href="/mail/magazin/">メルマガ一斉配信</a></li>
					{if $login_admin.shop_no<=0}
					<li><a class='{php}if($_SESSION['tab']=='auto')echo"active"{/php}' href="/mail/auto/">自動配信メール</a></li>
					<li><a class='{php}if($_SESSION['tab']=='stepmail')echo"active"{/php}' href="/mail/stepmail/">ステップメール</a></li>
					<li><a class='{php}if($_SESSION['tab']=='sig')echo"active"{/php}' href="/mail/sig/">署名作成</a></li>
					<li><a class='{php}if($_SESSION['tab']=='mailList')echo"active"{/php}' href="/mail/list/">メールテンプレート作成</a></li>
					{/if}

</ul>
<div class="clear"> </div>