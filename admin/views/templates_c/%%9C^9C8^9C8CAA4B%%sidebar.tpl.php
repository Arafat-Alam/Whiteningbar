<?php /* Smarty version 2.6.26, created on 2017-05-22 09:44:17
         compiled from sidebar.tpl */ ?>
<?php 
session_start();
 ?>
<script type="text/javascript">
<?php echo '
function winopn(){

	// sW = window.parent.screen.width;
	// sH = window.parent.screen.height;

	window.location=\'/calendar/list\';
}

'; ?>

</script>

<div id="sidebar clear">
	<ul id="jMenu">

		<li class='<?php if($_SESSION['page']=='top')echo "active" ?>'><a href="/">TOP</a></li>
		<li class='<?php if($_SESSION['page']=='calendar')echo "active" ?>'>
			<!-- <a href="javascript:void(0);" onClick="winopn();" class="btn btn-lg">予約管理カレンダーを開く</a> -->
			<a href="javascript:void(0);" onClick="winopn();">予約カレンダ</a>
		</li>

		<li class='<?php if($_SESSION['page']=='reserve')echo "active" ?>'><a href="/reserve/list/">予約一覧</a></li>

		<li class='<?php if($_SESSION['page']=='member')echo "active" ?>'><a>顧客管理</a>
			<ul>
				<li class='<?php if($_SESSION['tab']=='customer')echo "active" ?>'><a href="/member/list/">顧客一覧</a></li>
				<li class='<?php if($_SESSION['tab']=='unpaid')echo "active" ?>'><a href="/member/unpaid/">未払い一覧</a></li>
				<li class='<?php if($_SESSION['tab']=='cancel')echo "active" ?>'><a href="/member/cancel/">キャンセル一覧</a></li>
				<li class='<?php if($_SESSION['tab']=='noShowUp')echo "active" ?>'><a href="/member/noShowUp/">来店せず一覧</a></li>
			</ul>
		</li>

		<li class='<?php if($_SESSION['page']=='shop')echo "active" ?>'><a>基本設定</a>
				<ul>
				<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
					<li class='<?php if($_SESSION['tab']=='shopList')echo "active" ?>'><a href="/shop/list/">店舗一覧</a></li>
					<li class='<?php if($_SESSION['tab']=='edit')echo "active" ?>'><a href="/shop/edit/">店舗登録</a></li>
					<li class='<?php if($_SESSION['tab']=='course')echo "active" ?>'><a href="/shop/course/">コース管理</a></li>
					<li class='<?php if($_SESSION['tab']=='menu')echo "active" ?>'><a href="/shop/menu/">メニュー管理</a></li>
					<!-- <li><a href="/shop/setform/">顧客登録フォーム設定</a></li> -->
					<li class='<?php if($_SESSION['tab']=='enquete')echo "active" ?>'><a href="/shop/enquete/">アンケート設定</a></li>
				<?php else: ?>
					<li class='<?php if($_SESSION['tab']=='edit')echo "active" ?>'><a href="/shop/edit/">店舗情報</a></li>
					<li class='<?php if($_SESSION['tab']=='operate')echo "active" ?>'><a href="/shop/operate/">営業設定</a></li>
					<li class='<?php if($_SESSION['tab']=='block')echo "active" ?>'><a href="/shop/block/">ブロック設定</a></li>
				<?php endif; ?>
					<li class='<?php if($_SESSION['tab']=='staff')echo "active" ?>'><a href="/shop/staff/">店舗担当者管理</a></li>
				</ul>
		</li>
		<li class='<?php if($_SESSION['page']=='mail')echo "active" ?>'><a>メール管理</a>
				<ul>
					<li class='<?php if($_SESSION['tab']=='magazin')echo "active" ?>'><a href="/mail/magazin/">メルマガ一斉配信</a></li>
					<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
					<li class='<?php if($_SESSION['tab']=='auto')echo "active" ?>'><a href="/mail/auto/">自動配信メール</a></li>
					<li class='<?php if($_SESSION['tab']=='stepmail')echo "active" ?>'><a href="/mail/stepmail/">ステップメール</a></li>
					<li class='<?php if($_SESSION['tab']=='sig')echo "active" ?>'><a href="/mail/sig/">署名作成</a></li>
					<li class='<?php if($_SESSION['tab']=='mailList')echo "active" ?>'><a href="/mail/list/">メールテンプレート作成</a></li>
					<?php endif; ?>
				</ul>
		</li>
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<li class='<?php if($_SESSION['page']=='report')echo "active" ?>'><a>売上レポート</a>
				<ul>
					<li class='<?php if($_SESSION['tab']=='reportList')echo "active" ?>'><a href="/report/list/">売上詳細</a></li>
					<li class='<?php if($_SESSION['tab']=='daily')echo "active" ?>'><a href="/report/daily/">日次売上</a></li>
					<li class='<?php if($_SESSION['tab']=='month')echo "active" ?>'><a href="/report/month/">月次売上</a></li>
					<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
					<li class='<?php if($_SESSION['tab']=='graph')echo "active" ?>'><a href="/report/graph/">売上グラフ</a></li>
					<li class='<?php if($_SESSION['tab']=='menuTrend')echo "active" ?>'><a href="/report/menuTrend/">Menu Trend</a></li>
					<li class='<?php if($_SESSION['tab']=='saleData')echo "active" ?>'><a href="/report/saleData/">Sale Data</a></li>
					<?php endif; ?>
				</ul>
		</li>
		<?php endif; ?>
		<li class='<?php if($_SESSION['page']=='news')echo "active" ?>'><a>管理</a>
				<ul>
				<?php if ($this->_tpl_vars['login_admin']['shop_no'] == 0): ?>
					<li class='<?php if($_SESSION['tab']=='list')echo "active" ?>'><a href="/news/list/">お知らせ管理</a></li>
					<li class='<?php if($_SESSION['tab']=='category1')echo "active" ?>'><a href="/master/category1/">クーポン管理</a></li>
					<li class='<?php if($_SESSION['tab']=='category2')echo "active" ?>'><a href="/master/category2/">会員支払項目管理</a></li>
					<li class='<?php if($_SESSION['tab']=='siteConfig')echo "active" ?>'><a href="/siteConfig/">サイト表示設定</a></li>
					<li class='<?php if($_SESSION['tab']=='member_require')echo "active" ?>'><a href="/admin/member_require/">必須項目設定</a></li>
				<?php endif; ?>

				<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
					<li class='<?php if($_SESSION['tab']=='adminList')echo "active" ?>'><a href="/admin/list/">サイト管理者</a></li>
				<?php endif; ?>
				</ul>
		</li>

	</ul>
</div>