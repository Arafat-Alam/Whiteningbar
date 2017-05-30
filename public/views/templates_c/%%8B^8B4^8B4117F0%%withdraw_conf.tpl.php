<?php /* Smarty version 2.6.26, created on 2016-09-07 18:02:34
         compiled from member/withdraw_conf.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>歯のホワイトニング専門店Whitening Bar　基本情報の編集</title>
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
&nbsp;様&nbsp;退会</h1>
			<div class="content-inner">
				<?php if ($this->_tpl_vars['finish_flg'] == 1): ?>
				<p class="tc mt50">
				購入したコースがまだ残っています。<br />
				退会後は購入したコースはご使用になれませんが、退会しますか？
				</p>
				<?php elseif ($this->_tpl_vars['finish_flg'] == 2): ?>
				<p class="tc mt50">
					予約中のメニューがあります<br />
					退会後はキャンセル扱いになりますが、退会しますか？

				</p>
				<?php else: ?>
					<?php echo @STR_SITE_TITLE; ?>
から退会します。<br />
					退会後も<?php echo @STR_SITE_TITLE; ?>
のご利用は可能ですが、<br />新規登録からのご利用になります事を
					ご了承ください。

				<?php endif; ?>
				<div class="tc mt50">
					<form action="" method="post">
					<input type="submit" name="submit" class="btn btn-sm" value="退会する">
					<a href="/member/" class="btn btn-lg">マイページへ戻る</a>
				</form>
				</div>

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