<?php /* Smarty version 2.6.26, created on 2014-09-13 13:17:18
         compiled from category2_add.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function editcancel()
{
	document.regForm.action="master/category2/";
	document.regForm.submit();
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
		<h3>会員支払項目管理</h3>


<?php if ($this->_tpl_vars['exec'] == 'middle'): ?>
	<h4>中カテゴリ追加</h4>

<?php elseif ($this->_tpl_vars['exec'] == 'sub'): ?>
	<h4>小カテゴリ追加</h4>

<?php elseif ($this->_tpl_vars['exec'] == 'main'): ?>
	<h4>メインカテゴリ追加</h4>
<?php else: ?>
	<h4>カテゴリ編集</h4>
<?php endif; ?>

<?php if ($this->_tpl_vars['msg']): ?>

	<?php if ($this->_tpl_vars['exec'] == 'middle'): ?>
		中カテゴリを追加しました。
	<?php elseif ($this->_tpl_vars['exec'] == 'sub'): ?>
		小カテゴリを追加しました。
	<?php elseif ($this->_tpl_vars['exec'] == 'main'): ?>
		大カテゴリを追加しました。
	<?php else: ?>
		カテゴリを編集しました。
	<?php endif; ?>

<?php else: ?>
<form name="regForm" method="post" action="master/category2edit">
<input type="hidden" name="ctitle" value="<?php echo $this->_tpl_vars['ctitle']; ?>
" />
<input type="hidden" name="id" value="<?php echo $this->_tpl_vars['id']; ?>
" />
<input type="hidden" name="parentid" value="<?php echo $this->_tpl_vars['parentid']; ?>
" />
<input type="hidden" name="exec" value="<?php echo $this->_tpl_vars['exec']; ?>
" />
<input type="hidden" name="cflag" value="<?php echo $this->_tpl_vars['cflag']; ?>
" />
<table class="w60 center">
</td>
</tr>
<tr>
<th>※支払項目名</th>
<td>
						<?php if ($this->_tpl_vars['result_messages']['category']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['category']; ?>
</span><br />
						<?php endif; ?>
<input type="text" name="name" value="<?php echo $this->_tpl_vars['itemObj']['name']; ?>
" style="ime-mode:active;width:350px" />
</td>
</tr>
<tr>
<th>金額</th>

<td>
						<?php if ($this->_tpl_vars['result_messages']['fee']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['fee']; ?>
</span><br />
						<?php endif; ?><br />
<input type="text" name="fee" value="<?php echo $this->_tpl_vars['itemObj']['fee']; ?>
" style="ime-mode:active;width:50px" />円
</td>
</tr>
<?php endif; ?>
</table>
<p class="mt20 tc">
	<input type="submit" name="regist" value="OK" class="btn-lg" />
	<input name="cancel" type="button" value="キャンセル" onClick="editcancel();" class="btn-gray" />
</p>
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