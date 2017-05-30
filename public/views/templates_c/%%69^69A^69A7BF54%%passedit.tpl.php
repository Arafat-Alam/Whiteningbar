<?php /* Smarty version 2.6.26, created on 2016-09-10 13:44:11
         compiled from member/passedit.tpl */ ?>
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
&nbsp;様&nbsp;パスワード変更</h1>

		<form action="" method="post">
			<h2>パスワード変更</h2>

		<?php if ($this->_tpl_vars['result_messages']): ?>
			<?php $_from = $this->_tpl_vars['result_messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['item']; ?>
</span><br />
			<?php endforeach; endif; unset($_from); ?>
		<?php endif; ?>
			<div class="content-inner">
				<p>新しいパスワードを入力して「変更」ボタンをクリックしてください。</p>
				<table class="table mt10">
					<tr>
						<th>旧パスワード&nbsp;<span class="label">必須</span></th>
						<td>
							 <?php if ($this->_tpl_vars['result_messages']['old_password']): ?>
								<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['old_password']; ?>
</span><br />
							<?php endif; ?>
					          <input type="password" id="" name="old_password" value="<?php echo $this->_tpl_vars['inp']['old_password']; ?>
"  />
					          <br><span class="txt-sm">半角英数字6文字以上</span><br>
						</td>
					</tr>
					<tr>
						<th>新パスワード&nbsp;<span class="label">必須</span></th>
						<td>
							 <?php if ($this->_tpl_vars['result_messages']['password']): ?>
								<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['password']; ?>
</span><br />
							<?php endif; ?>
					          <input type="password" id="" name="password" value="<?php echo $this->_tpl_vars['inp']['password']; ?>
"  />
					          <br><span class="txt-sm">半角英数字6文字以上</span><br>
								<input type="password" name="password2" class="mt5">
							  <br><span class="txt-sm">確認のため、もう一度入力してください。</span></td>
					</tr>
				</table>
				<div class="tc mt35"><input name="pass_submit" type="submit" class="btn btn-lg" value="変更"></div>
			</div>
		</form>

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