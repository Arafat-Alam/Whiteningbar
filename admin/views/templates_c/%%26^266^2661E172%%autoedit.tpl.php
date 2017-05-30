<?php /* Smarty version 2.6.26, created on 2014-09-13 11:04:49
         compiled from maildeliver/autoedit.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="main_content">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "maildeliver/menu_mail.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>メール管理</h3>
<h4>自動配信メール詳細設定</h4>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


		<form action="" method="post"  >
		      <table class="w80 center">

			        <tr>
			          <th>サブジェクト</th>
			          <td>
						<input type="text" name="subject" value="<?php echo $this->_tpl_vars['input_data']['subject']; ?>
" size="60">
			          </td>
			        </tr>

			        <tr>
			          <th>文章ヘッダ</th>
			          <td>
						<textarea name="header_text" rows="10" cols="60"><?php echo $this->_tpl_vars['input_data']['header_text']; ?>
</textarea>
			          </td>
			        </tr>

			        <tr>
			          <th>文章フッタ</th>
			          <td>
						<textarea name="footer_text" rows="10" cols="60"><?php echo $this->_tpl_vars['input_data']['footer_text']; ?>
</textarea>
			          </td>
			        </tr>

		     </table>

 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		      <div class="mt20 tc">
		        <input type="submit"  name="submit" value="更新" class="btn-lg" />
		      </div>
<?php endif; ?>
		</form>
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>