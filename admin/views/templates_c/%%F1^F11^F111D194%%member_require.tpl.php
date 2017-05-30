<?php /* Smarty version 2.6.26, created on 2017-04-19 19:53:23
         compiled from admin/member_require.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='member_require';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '



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
		<h3>必須項目設定</h3>

		<div class="w80 center">
		<span class="red"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></span>

			<form name="fm_list" id="fm_list" method="POST" action="">
			<table class="w100 mt10">
			<tr>
				<th class="id">項目名</th>
				<th>必須/任意</th>
			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['item']['name_str']; ?>
</td>
					<td>
					<label><input type="radio" name="req_flg[<?php echo $this->_tpl_vars['item']['no']; ?>
]" value="1"<?php if ($this->_tpl_vars['item']['req_flg'] == '1'): ?> checked="checked"<?php endif; ?>/>必須</label>&nbsp;
					<label><input type="radio" name="req_flg[<?php echo $this->_tpl_vars['item']['no']; ?>
]" value="0"<?php if ($this->_tpl_vars['item']['req_flg'] == '0'): ?> checked="checked"<?php endif; ?>/>任意</label>
					</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>
			<div class="paging">

			</div>
			<div class="tc">
				<input type="submit" name="regist" value="更新する" onClick="return confirm('必須項目の設定を更新します。');" class="btn-lg">
			</div>
			</form>
	</div>
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
