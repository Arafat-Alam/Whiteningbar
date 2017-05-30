<?php /* Smarty version 2.6.26, created on 2016-09-06 20:27:47
         compiled from member/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'member/list.tpl', 71, false),)), $this); ?>
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
			<h2>予約の確認</h2>

			<?php if ($this->_tpl_vars['msg']): ?>
			<div class="content-inner">
				<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['msg']; ?>
</span>
			</div>
			<?php endif; ?>
			<?php if ($this->_tpl_vars['errmsg']): ?>
				<div class="box-warning">
					<p class="txt-sm"><i class="fa fa-warning fa-lg"></i>&nbsp;<?php echo $this->_tpl_vars['errmsg']; ?>
</p>
				</div>
			<?php endif; ?>

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
				<div class="table-scroll">
				<table class="table-appointment">
					<tr>
						<th>予約番号</th>
						<th>予約店舗</th>
						<th>予約日時</th>
						<th>回数</th>
						<th>コース名<br />(メニュー)</th>
						<th>コース<br />ご利用期限</th>
						<th>予約変更</th>
						<th>キャンセル</th>
					</tr>
					<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['item']['reserve_no']; ?>
</td>
						<td><nobr><?php echo $this->_tpl_vars['item']['shop_name']; ?>
</nobr></td>
						<td><span class="nowrap"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['reserve_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
(<?php echo $this->_tpl_vars['item']['youbi']; ?>
)</span></br><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</td>
						<td><nobr><?php echo $this->_tpl_vars['item']['zan']; ?>
回目</nobr></td>
						<td><?php echo $this->_tpl_vars['item']['course_name']; ?>
<br />(<?php echo $this->_tpl_vars['item']['menu_name']; ?>
)</td>
						<td>
							<?php if ($this->_tpl_vars['item']['limit_date'] == "0000-00-00"): ?>
								-<!-- 料金未払いの為、まだ使用期限が決定していない -->
							<?php else: ?>
								<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['limit_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>

							<?php endif; ?>
								</td>
						<td>
							<form action="/reserve/list/" method="post">
								<input type="submit" name="detail_no[<?php echo $this->_tpl_vars['item']['no']; ?>
]" class="btn btn-sm" value="変更する" >
							</form>
						</td>
						<td>
							<form action="/member/list/" method="post">
								<input type="submit" name="cancel[<?php echo $this->_tpl_vars['item']['no']; ?>
]" class="btn btn-sm" value="キャンセル" onClick="return confirm('予約をキャンセルします。本当に良いですか？');">
							</form>
						</td>
					</tr>
					<?php endforeach; else: ?>
					<tr>
						<td colspan="8">現在、ご予約中のものはございません</td>
					</tr>
					<?php endif; unset($_from); ?>
				</table>
				</div>

				<div class="mt20 box-warning">※ご予約時間より10分を過ぎますとキャンセルとさせていただきます。<br >
				※ご予約1時間前の予約時間の変更、キャンセルは出来ません。<br class="sp">
				<span class="sp mt10">※予約をキャンセルしたい場合は予約詳細部分をスワイプして一番右の「キャンセル」ボタンをタップしてください。</span></div>
				<div class="tc mt35"><a href="/" class="btn btn-lg">マイページへ</a></div>
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