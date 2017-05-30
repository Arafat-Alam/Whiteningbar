<ul class="tab clearfix mt20">
<!--
	<li><a href="/shop/list/">店舗一覧</a></li>
	<li><a href="/shop/edit/">店舗登録</a></li>
	<li><a href="/shop/course/">コース管理</a></li>
	<li><a href="/shop/menu/">メニュー管理</a></li>
	<li><a href="/shop/enquete/">アンケート設定</a></li>
  -->
				{if $login_admin.shop_no<=0}
					<li><a class='{php}if($_SESSION['tab']=='shopList')echo"active"{/php}' href="/shop/list/">店舗一覧</a></li>
					<li><a class='{php}if($_SESSION['tab']=='edit')echo"active"{/php}' href="/shop/edit/">店舗登録</a></li>
					<li><a class='{php}if($_SESSION['tab']=='course')echo"active"{/php}' href="/shop/course/">コース管理</a></li>
					<li><a class='{php}if($_SESSION['tab']=='menu')echo"active"{/php}' href="/shop/menu/">メニュー管理</a></li>
					<!-- <li><a href="/shop/setform/">顧客登録フォーム設定</a></li> -->
					<li><a class='{php}if($_SESSION['tab']=='enquete')echo"active"{/php}' href="/shop/enquete/">アンケート設定</a></li>
				{else}
					<li><a class='{php}if($_SESSION['tab']=='edit')echo"active"{/php}' href="/shop/edit/">店舗情報</a></li>
					<li><a class='{php}if($_SESSION['tab']=='operate')echo"active"{/php}' href="/shop/operate/">営業設定</a></li>
					<li><a class='{php}if($_SESSION['tab']=='block')echo"active"{/php}' href="/shop/block/">ブロック設定</a></li>
				{/if}
					<li><a class='{php}if($_SESSION['tab']=='staff')echo"active"{/php}' href="/shop/staff/">店舗担当者管理</a></li>

</ul>
<div class="clear"> </div>