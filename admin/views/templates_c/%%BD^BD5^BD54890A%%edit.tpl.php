<?php /* Smarty version 2.6.26, created on 2014-08-01 15:31:05
         compiled from admin/edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'admin/edit.tpl', 112, false),array('function', 'html_options', 'admin/edit.tpl', 124, false),)), $this); ?>
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

	// ユーザーID
	if ($("#user_id").val() == "") {
		msg += "・ユーザーIDを入力してください\\n";
	}
	// 管理者種別
	if ($("#manager_type").val() == "") {
		msg += "・管理者種別を選択してください\\n";
	}
	// 名前
	if ($("#user_name").val() == "") {
		msg += "・名前を入力してください\\n";
	}

	if ($("#mode").val() == "add") {
		if ($("#password").val() == "") {
			msg += "・パスワードを入力してください\\n";
		}
	}
	else {
		if ($("#password").val() != "" && $("#mode").val() != "add") {
			if (!confirm("パスワードを変更してもよろしいですか？")) {
				return false;
			}
		}
	}

	if (msg != "") {
		alert(msg);
		return false;
	}

	$("#fm").submit();
	return true;
}

function validateList() {
	$("#fm_list").submit();
}

function clickDisableChk(obj) {
	var id = $(obj).attr("id").replace("disabled_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#disabled_" + id).val("t");
	}
	else {
		$("#disabled_" + id).val("f");
	}
}

function clickDeleteChk(obj) {
	var id = $(obj).attr("id").replace("delete_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#delete_" + id).val("t");
	}
	else {
		$("#delete_" + id).val("f");
	}
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
		<h3>サイト管理者登録</h3>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<form id="fm" name="fm" method="post" action="">
		<input type="hidden" id="mode" name="mode" value="<?php echo $this->_tpl_vars['mode']; ?>
"/>
		<input type="hidden" id="admin_no" name="admin_no" value="<?php echo $this->_tpl_vars['admin_obj']['admin_no']; ?>
" />
		<input type="hidden" id="admin_type" name="admin_type" value="<?php echo $this->_tpl_vars['admin_obj']['admin_type']; ?>
"/>
		<table class="center">
		<tr>
			<th>ログインID</th>
			<td>
				<?php if ($this->_tpl_vars['mode'] == 'update'): ?>
					<span class="read_only"><b><?php echo $this->_tpl_vars['admin_obj']['user_id']; ?>
</b></span>
					<input type="hidden" id="user_id" name="user_id" value="<?php echo $this->_tpl_vars['admin_obj']['user_id']; ?>
" />
				<?php else: ?>
					<input type="text" id="user_id" name="user_id" size="20" value="<?php echo $this->_tpl_vars['admin_obj']['user_id']; ?>
" style="ime-mode:disabled;"/>
				<?php endif; ?>
			</td>
		</tr>
		<tr>
			<th>パスワード</th>
			<td>
				<input type="password" id="password" name="password"  size="20" value="" maxlength="20"/>
				<br />
				※変更する場合のみ入力してください。
			</td>
		</tr>
		<tr>
			<th>お名前</th>
			<td>
				<input type="text" id="user_name" name="user_name" size="20" value="<?php echo $this->_tpl_vars['admin_obj']['user_name']; ?>
" maxlength="20"/>
			</td>
		</tr>
		<tr>
			<th>予約情報権限</th>
			<td>
				<?php echo smarty_function_html_radios(array('name' => 'reserve_auth_type','options' => $this->_tpl_vars['admintypeArr'],'selected' => $this->_tpl_vars['admin_obj']['reserve_auth_type']), $this);?>

			</td>
		</tr>
		<tr>
			<th>お客様情報権限</th>
			<td>
				<?php echo smarty_function_html_radios(array('name' => 'member_auth_type','options' => $this->_tpl_vars['admintypeArr'],'selected' => $this->_tpl_vars['admin_obj']['member_auth_type']), $this);?>

			</td>
		</tr>
		<tr>
			<th>店舗</th>
			<td>
				<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['input_data']['shop_no']), $this);?>

			</td>
		</tr>


		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_save" onClick="return validate();" class="btn-lg">登録</button>
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
