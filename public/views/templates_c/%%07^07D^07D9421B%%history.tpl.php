<?php /* Smarty version 2.6.26, created on 2016-09-06 22:13:41
         compiled from member/history.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'member/history.tpl', 47, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head_under.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<body>
	<div id="wrap">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TNFNQV"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'//www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\'GTM-TNFNQV\');</script>
<!-- End Google Tag Manager -->

'; ?>



		<div class="content">
		<h1><?php echo $this->_tpl_vars['login_member']['name']; ?>
&nbsp;様&nbsp;予約状況</h1>
			<h2>予約の履歴</h2>
<!--
			<div class="content-inner">
				<select name="">
					<option>選択してください</option>
					<option value="渋谷店" selected>渋谷店</option>
					<option value="自由が丘店">自由が丘店</option>
				</select>
				<input type="button" class="btn btn-search" value="表示する"><br>
				<p class="txt-sm">※選択した店舗のサイトへ移動します。</p>
			</div>
-->
			<div class="content-inner mt50">


		<?php $_from = $this->_tpl_vars['buyCourseArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			【<?php echo $this->_tpl_vars['item']['name']; ?>
】
			予約店舗：<?php echo $this->_tpl_vars['item']['shop_name']; ?>
　
			購入日：<?php if ($this->_tpl_vars['item']['buy_date'] == "0000-00-00"): ?>未払い<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['buy_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%G/%m/%d") : smarty_modifier_date_format($_tmp, "%G/%m/%d")); ?>
<?php endif; ?>　
			期限：<?php if ($this->_tpl_vars['item']['limit_date'] == "0000-00-00"): ?>-<?php else: ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['limit_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%G/%m/%d") : smarty_modifier_date_format($_tmp, "%G/%m/%d")); ?>
<?php endif; ?>　
			クーポン：<?php echo $this->_tpl_vars['item']['coupon_name']; ?>

				<div class="table-scroll">
				<table class="table-appointment mt5 mb20">
					<tr>
						<th>予約番号</th>
						<th>予約日時</th>
						<th>メニュー</th>
						<th>ご来店状況</th>
					</tr>
					<?php $_from = $this->_tpl_vars['item']['reserve']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['res']):
?>
						<tr>
							<td><?php echo $this->_tpl_vars['res']['reserve_no']; ?>
</td>
							<td>
								<?php echo $this->_tpl_vars['res']['reserve_date']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['res']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['res']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>

							</td>
							<td><?php echo $this->_tpl_vars['res']['menu_name']; ?>
</td>
							<td>
								<?php if ($this->_tpl_vars['res']['visit_flg'] == 1): ?>
									ご来店
								<?php elseif ($this->_tpl_vars['res']['visit_flg'] == 99): ?>
									キャンセル
								<?php else: ?>
									ご予約中
								<?php endif; ?>
							</td>

						</tr>
					<?php endforeach; endif; unset($_from); ?>
					</table>
					</div>
		<?php endforeach; else: ?>
表示する履歴一覧はありません
		<?php endif; unset($_from); ?>

				<div class="tc mt35"><a href="/member/" class="btn btn-lg">マイページへ</a></div>
			</div>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastApi.js?pbeldad"></script>

<?php echo '

<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
    tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=07eYmz4";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>

<noscript>
<iframe src="//b.yjtag.jp/iframe?c=07eYmz4" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>

'; ?>

</body>
</html>