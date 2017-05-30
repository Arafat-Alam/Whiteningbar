<?php /* Smarty version 2.6.26, created on 2017-03-09 22:17:59
         compiled from login.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '
/**
 * 入力チェック
 **/
function validate(){
	var msg = "";

	if ($("#user_id").val() == "") {
		msg += "\\n・ユーザーIDが入力されていません";
	}
	if ($("#password").val() == "") {
		msg += "\\n・パスワードが入力されていません";
	}

	if (msg != "") {
		alert(msg);
		return false;
	}

	return true;
}

'; ?>

</script>
</head>
<body>
<div id="wrapper">
	<div>
		<h1 class="tc"><?php echo @STR_SITE_TITLE; ?>
へのログイン</h1>
		<p class="tc">ユーザーIDとパスワードを入力して「ログイン」ボタンをクリックしてください。</p>
		<?php if ($this->_tpl_vars['msg']): ?>
			<div class="header_msg_warn">
				<div><?php echo $this->_tpl_vars['msg']; ?>
</div>
			</div>
		<?php endif; ?>

		<!-- <form name="fm" method="post" action="admin/login"> -->
		<form name="" method="post" action="/admin/login">
		<table class="center mt20">
		<tr>
			<th>ユーザーID：</th>
			<td><input type="text" name="user_id" id="user_id" size="20" value="<?php echo $this->_tpl_vars['user_id']; ?>
" /></td>
		</tr>
		<tr>
			<th>パスワード：</th>
			<td><input type="password" name="password" id="password" size="20" value="" /></td>
		</tr>
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_login" onClick="return validate()" class="btn-lg">ログイン</button>
		</div>
		<input type="hidden" name="mode" value="sys" />
		<input type="hidden" name="command" value="cert" />
		</form>

		<p class="tc">※パスワードを忘れた方は再発行しますので<a href="/admin/password/">こちらをクリック</a>してください。</p>
	</div>
</div>
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>