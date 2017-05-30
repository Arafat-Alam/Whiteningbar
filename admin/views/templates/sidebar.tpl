{php}
session_start();
{/php}
<script type="text/javascript">
{literal}
function winopn(){

	// sW = window.parent.screen.width;
	// sH = window.parent.screen.height;

	window.location='/calendar/list';
}

{/literal}
</script>

<div id="sidebar clear">
	<ul id="jMenu">

		<li class='{php}if($_SESSION['page']=='top')echo "active"{/php}'><a href="/">TOP</a></li>
		<li class='{php}if($_SESSION['page']=='calendar')echo "active"{/php}'>
			<!-- <a href="javascript:void(0);" onClick="winopn();" class="btn btn-lg">予約管理カレンダーを開く</a> -->
			<a href="javascript:void(0);" onClick="winopn();">予約カレンダ</a>
		</li>

		<li class='{php}if($_SESSION['page']=='reserve')echo "active"{/php}'><a href="/reserve/list/">予約一覧</a></li>

		<li class='{php}if($_SESSION['page']=='member')echo "active"{/php}'><a>顧客管理</a>
			<ul>
				<li class='{php}if($_SESSION['tab']=='customer')echo "active"{/php}'><a href="/member/list/">顧客一覧</a></li>
				<li class='{php}if($_SESSION['tab']=='unpaid')echo "active"{/php}'><a href="/member/unpaid/">未払い一覧</a></li>
				<li class='{php}if($_SESSION['tab']=='cancel')echo "active"{/php}'><a href="/member/cancel/">キャンセル一覧</a></li>
				<li class='{php}if($_SESSION['tab']=='noShowUp')echo "active"{/php}'><a href="/member/noShowUp/">来店せず一覧</a></li>
			</ul>
		</li>

		<li class='{php}if($_SESSION['page']=='shop')echo "active"{/php}'><a>基本設定</a>
				<ul>
				{if $login_admin.shop_no<=0}
					<li class='{php}if($_SESSION['tab']=='shopList')echo "active"{/php}'><a href="/shop/list/">店舗一覧</a></li>
					<li class='{php}if($_SESSION['tab']=='edit')echo "active"{/php}'><a href="/shop/edit/">店舗登録</a></li>
					<li class='{php}if($_SESSION['tab']=='course')echo "active"{/php}'><a href="/shop/course/">コース管理</a></li>
					<li class='{php}if($_SESSION['tab']=='menu')echo "active"{/php}'><a href="/shop/menu/">メニュー管理</a></li>
					<!-- <li><a href="/shop/setform/">顧客登録フォーム設定</a></li> -->
					<li class='{php}if($_SESSION['tab']=='enquete')echo "active"{/php}'><a href="/shop/enquete/">アンケート設定</a></li>
				{else}
					<li class='{php}if($_SESSION['tab']=='edit')echo "active"{/php}'><a href="/shop/edit/">店舗情報</a></li>
					<li class='{php}if($_SESSION['tab']=='operate')echo "active"{/php}'><a href="/shop/operate/">営業設定</a></li>
					<li class='{php}if($_SESSION['tab']=='block')echo "active"{/php}'><a href="/shop/block/">ブロック設定</a></li>
				{/if}
					<li class='{php}if($_SESSION['tab']=='staff')echo "active"{/php}'><a href="/shop/staff/">店舗担当者管理</a></li>
				</ul>
		</li>
		<li class='{php}if($_SESSION['page']=='mail')echo "active"{/php}'><a>メール管理</a>
				<ul>
					<li class='{php}if($_SESSION['tab']=='magazin')echo "active"{/php}'><a href="/mail/magazin/">メルマガ一斉配信</a></li>
					{if $login_admin.shop_no<=0}
					<li class='{php}if($_SESSION['tab']=='auto')echo "active"{/php}'><a href="/mail/auto/">自動配信メール</a></li>
					<li class='{php}if($_SESSION['tab']=='stepmail')echo "active"{/php}'><a href="/mail/stepmail/">ステップメール</a></li>
					<li class='{php}if($_SESSION['tab']=='sig')echo "active"{/php}'><a href="/mail/sig/">署名作成</a></li>
					<li class='{php}if($_SESSION['tab']=='mailList')echo "active"{/php}'><a href="/mail/list/">メールテンプレート作成</a></li>
					{/if}
				</ul>
		</li>
		{if $login_admin.shop_no>=0}
		<li class='{php}if($_SESSION['page']=='report')echo "active"{/php}'><a>売上レポート</a>
				<ul>
					<li class='{php}if($_SESSION['tab']=='reportList')echo "active"{/php}'><a href="/report/list/">売上詳細</a></li>
					<li class='{php}if($_SESSION['tab']=='daily')echo "active"{/php}'><a href="/report/daily/">日次売上</a></li>
					<li class='{php}if($_SESSION['tab']=='month')echo "active"{/php}'><a href="/report/month/">月次売上</a></li>
					{if $login_admin.shop_no<=0}
					<li class='{php}if($_SESSION['tab']=='graph')echo "active"{/php}'><a href="/report/graph/">売上グラフ</a></li>
					<li class='{php}if($_SESSION['tab']=='menuTrend')echo "active"{/php}'><a href="/report/menuTrend/">Menu Trend</a></li>
					<li class='{php}if($_SESSION['tab']=='saleData')echo "active"{/php}'><a href="/report/saleData/">Sale Data</a></li>
					{/if}
				</ul>
		</li>
		{/if}
		<li class='{php}if($_SESSION['page']=='news')echo "active"{/php}'><a>管理</a>
				<ul>
				{if $login_admin.shop_no==0}
					<li class='{php}if($_SESSION['tab']=='list')echo "active"{/php}'><a href="/news/list/">お知らせ管理</a></li>
					<li class='{php}if($_SESSION['tab']=='category1')echo "active"{/php}'><a href="/master/category1/">クーポン管理</a></li>
					<li class='{php}if($_SESSION['tab']=='category2')echo "active"{/php}'><a href="/master/category2/">会員支払項目管理</a></li>
					<li class='{php}if($_SESSION['tab']=='siteConfig')echo "active"{/php}'><a href="/siteConfig/">サイト表示設定</a></li>
					<li class='{php}if($_SESSION['tab']=='member_require')echo "active"{/php}'><a href="/admin/member_require/">必須項目設定</a></li>
				{/if}

				{if $login_admin.shop_no>=0}
					<li class='{php}if($_SESSION['tab']=='adminList')echo "active"{/php}'><a href="/admin/list/">サイト管理者</a></li>
				{/if}
				</ul>
		</li>

	</ul>
</div>
