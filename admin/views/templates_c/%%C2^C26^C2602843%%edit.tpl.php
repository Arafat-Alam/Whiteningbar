<?php /* Smarty version 2.6.26, created on 2017-04-19 19:53:22
         compiled from site-config/edit.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='siteConfig';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

/**
 * 入力チェック
 */
function validate() {
	var msg = "";

	if (msg != "") {
		alert(msg);
		return false;
	}
	return true;
}

'; ?>

</script>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "menu_admin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>サイト表示設定</h3>


<p class="tc">ユーザー用予約ページのベースカラーを設定します。</p>


		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<form method="post" name="fm" action="siteConfig">
			<input type="hidden" name="submit_data" value="t"/>
			<table class="center">
			<?php $_from = $this->_tpl_vars['config_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['config']):
?>
				<tr>
					<th><?php echo $this->_tpl_vars['config']['config_name']; ?>
</th>
					<td>

						<?php $_from = $this->_tpl_vars['siteColorArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['colorkey'] => $this->_tpl_vars['item']):
?>
							<label><p style="background-color:<?php echo $this->_tpl_vars['item']; ?>
; width:200px;"><input type="radio" name="config_value" value="<?php echo $this->_tpl_vars['colorkey']; ?>
" <?php if ($this->_tpl_vars['colorkey'] == $this->_tpl_vars['config']['config_value']): ?> checked <?php endif; ?> >　<?php echo $this->_tpl_vars['colorkey']; ?>
</p></label>
						<?php endforeach; endif; unset($_from); ?>

											</td>
					<input type="hidden" name="config_key[]" value="<?php echo $this->_tpl_vars['config']['config_key']; ?>
"/>
				</tr>
			<?php endforeach; else: ?>
			<tr>
				<td colspan="2">システム設定データがありません。</td>
			</tr>
			 <?php endif; unset($_from); ?>
			</table>
			<div class="tc mt20">
				<button type="submit" onClick="return validate()" class="btn-lg">更新</button>
			</div>
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
