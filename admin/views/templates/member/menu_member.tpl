<ul class="tab clearfix mt20">
	<li><a class='{php}if($_SESSION['tab']=='customer')echo"active"{/php}' href="/member/list/">顧客一覧</a></li>
	<li><a class='{php}if($_SESSION['tab']=='unpaid')echo"active"{/php}' href="/member/unpaid/">未払い一覧</a></li>
	<li><a class='{php}if($_SESSION['tab']=='cancel')echo"active"{/php}' href="/member/cancel/">キャンセル一覧</a></li>
	<li><a class='{php}if($_SESSION['tab']=='noShowUp')echo"active"{/php}' href="/member/noShowUp/">来店せず一覧</a></li>
</ul>
<div class="clear"> </div>