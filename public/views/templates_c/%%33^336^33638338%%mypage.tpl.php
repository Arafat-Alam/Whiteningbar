<?php /* Smarty version 2.6.26, created on 2016-09-06 20:27:45
         compiled from member/mypage.tpl */ ?>
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
&nbsp;様&nbsp;マイページ</h1>
			<div class="box-half clearfix fl heightLine-group1">
			<form action="appointment.html">
				<div class="box-inner">
					<h2><i class="fa fa-calendar"></i>&nbsp;予約状況</h2>
					<a href="/member/list/" class="btn btn-lg w100">予約の確認</a><br>
					<a href="/member/history/" class="btn btn-lg w100 mt20">予約の履歴</a><br>
					<a href="/member/reserve/" class="btn btn-lg w100 mt20">予約する</a>
				</div>
			</form>
			</div>

			<div class="box-half clearfix fr heightLine-group1">
			<form action="register.html">
				<div class="box-inner">
				<h2><i class="fa fa-user"></i>&nbsp;お客様情報</h2>
					<a href="/member/edit/" class="btn btn-lg w100">登録情報の変更</a><br>
					<a href="/member/passedit/" class="btn btn-lg w100 mt20">パスワードの変更</a><br>
					<a href="/member/withdraw/" class="btn btn-lg w100 mt20">退会する</a>
				</div>
			</form>
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