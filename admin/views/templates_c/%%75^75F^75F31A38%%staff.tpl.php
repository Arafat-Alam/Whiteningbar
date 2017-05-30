<?php /* Smarty version 2.6.26, created on 2017-04-19 19:03:41
         compiled from shop/staff.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'shop/staff.tpl', 65, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='staff';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '


// 入力チェック
function validate() {
	var msg = "";

	// 名前
	if ($("#user_name").val() == "") {
		msg += "・お名前を入力してください\\n";
	}

	if (msg != "") {
		alert(msg);
		return false;
	}

	$("#fm").submit();
	return true;
}

function validateList() {



	$("#flist").submit();
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
$this->_smarty_include(array('smarty_include_tpl_file' => "shop/menu_shop.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>担当者管理</h3>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<form id="fm" name="fm" method="post" action="">
		<input type="hidden" id="mode" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
"/>
		<input type="hidden" id="admin_no" name="staff_no" value="<?php echo $this->_tpl_vars['admin_obj']['staff_no']; ?>
" />

		<table class="center">
		<tr>
			<th>お名前</th>
			<td>
				<input type="text" id="user_name" name="name" size="20" value="<?php echo $this->_tpl_vars['admin_obj']['name']; ?>
" maxlength="20"/>
			</td>
		</tr>
		<tr>
			<th>店舗</th>
			<td>
				<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['input_data']['shop_no']), $this);?>

			</td>
		</tr>
		<tr>
			<th>表示/非表示</th>
			<td>
				<label><input type="radio"  name="view_flg" value="1" <?php if ($this->_tpl_vars['admin_obj']['view_flg'] == '1'): ?>checked<?php endif; ?> >表示</label>&nbsp;&nbsp;
				<label><input type="radio"  name="view_flg" value="0" <?php if ($this->_tpl_vars['admin_obj']['view_flg'] == '0'): ?>checked<?php endif; ?> >非表示</label>

			</td>
		</tr>

		</table>
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<div class="mt20 tc">
			<button type="submit" name="sbm_save" onClick="return validate();" class="btn-lg">更新</button>
		</div>
		<?php endif; ?>
		</form>

<a href="/shop/staff/" class="btn mt20">新規作成</a>
		<form method="POST" action="/shop/staff/" >
			<table class="admins clear mt10">
		<tr>
			<th>お名前</th>
			<th>店舗</th>
			<th>表示/非表示</th>
			<th>削除</th>
		</tr>
		<?php $_from = $this->_tpl_vars['admins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['admin']):
?>
			<tr>
				<td><a href="/shop/staff/?s=<?php echo $this->_tpl_vars['admin']['staff_no']; ?>
&ss=<?php echo $this->_tpl_vars['admin']['shop_no']; ?>
" ><?php echo $this->_tpl_vars['admin']['name']; ?>
</a></td>
				<td><?php echo $this->_tpl_vars['admin']['shop_name']; ?>
</td>
				<td>
				<label><input type="radio"  name="modi_view_flg[<?php echo $this->_tpl_vars['admin']['staff_no']; ?>
]" value="1" <?php if ($this->_tpl_vars['admin']['view_flg'] == '1'): ?>checked<?php endif; ?> >表示</label>&nbsp;&nbsp;
				<label><input type="radio"  name="modi_view_flg[<?php echo $this->_tpl_vars['admin']['staff_no']; ?>
]" value="0" <?php if ($this->_tpl_vars['admin']['view_flg'] == '0'): ?>checked<?php endif; ?> >非表示</label>
				</td>
				<td class="tc"><input type="checkbox" name="delete_dummy[]" id="delete_dummy_<?php echo $this->_tpl_vars['admin']['staff_no']; ?>
" value="<?php echo $this->_tpl_vars['admin']['staff_no']; ?>
" /></td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</table>
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0 && $this->_tpl_vars['admins']): ?>
		<div class="tc">
			<input type="submit" name="modify" value="一覧を更新する" onClick="return confirm('更新します。良いですか？')">
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
