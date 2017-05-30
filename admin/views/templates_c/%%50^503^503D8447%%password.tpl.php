<?php /* Smarty version 2.6.26, created on 2017-03-09 22:18:36
         compiled from admin/password.tpl */ ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<body>
<div id="wrapper">
	<div>

	<h2 class="tc">パスワードを忘れた方</h2>
		<p class="mt20 tc">パスワードをお忘れの場合、仮パスワードを発行いたします。<br>
				必要事項をご入力の上、「送信する」ボタンを押して下さい。</p>
			<div class="sm-box tc">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<form action=""  method="post">

		<table style="margin-left:auto; margin-right:auto; margin-bottom:10px;">
		<tr>
			<th>ログインID：</th>
			<td><input type="text" name="user_id" id="user_id" size="20" value="<?php echo $this->_tpl_vars['user_id']; ?>
" /></td>
		</tr>
		<tr>
			<th>ご登録のメールアドレス：</th>
			<td><input type="text" name="email" id="email" size="20" value="<?php echo $this->_tpl_vars['email']; ?>
" /></td>
		</tr>
		</table>


				<div class="submit">

					<input type="submit" value="送信する" />
				</div>
			</form>
			</dl>

	</div>
</div>


	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
</body>
</html>