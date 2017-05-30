<?php /* Smarty version 2.6.26, created on 2017-04-19 19:53:00
         compiled from admin/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'admin/list.tpl', 144, false),array('function', 'html_options', 'admin/list.tpl', 165, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='adminList';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {

	$(\'#status0\').attr(\'checked\', false);
	$(\'#status1\').attr(\'checked\', false);
	$("#search_user_name").val("");
	$(\'#shop_no\').children().removeAttr(\'selected\');
	$(\'#reserve_auth_type0\').attr(\'checked\', false);
	$(\'#reserve_auth_type1\').attr(\'checked\', false);
	$(\'#reserve_auth_type2\').attr(\'checked\', false);
	$("#member_auth_type0").removeAttr(\'checked\', false);
	$("#member_auth_type1").removeAttr(\'checked\', false);
	$("#member_auth_type2").removeAttr(\'checked\', false);

}

// 入力チェック
function validate() {
	var msg = "";

	// ユーザーID
	if ($("#user_id").val() == "") {
		msg += "・ログインIDを入力してください\\n";
	}
	// 管理者種別
	if ($("#manager_type").val() == "") {
		msg += "・管理者種別を選択してください\\n";
	}
	// 名前
	if ($("#user_name").val() == "") {
		msg += "・お名前を入力してください\\n";
	}
	// メールアドレス
	if ($("#email").val() == "") {
		msg += "・メールアドレスを入力してください\\n";
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
		<h3>サイト管理者</h3>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<form id="fm" name="fm" method="post" action="/admin/edit/">
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
			<th>メールアドレス</th>
			<td>
				<input type="text" id="email" name="email" size="20" value="<?php echo $this->_tpl_vars['admin_obj']['email']; ?>
" />
			</td>
		</tr>
<!--
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
  -->
		<tr>
			<th>ステータス</th>
			<td>
				<label><input type="radio"  name="status" value="active" <?php if ($this->_tpl_vars['admin_obj']['status'] == 'active'): ?>checked<?php endif; ?> >有効</label>&nbsp;&nbsp;
				<label><input type="radio"  name="status" value="disabled" <?php if ($this->_tpl_vars['admin_obj']['status'] == 'disabled'): ?>checked<?php endif; ?> >無効</label>

			</td>
		</tr>
		<tr>
			<th>店舗</th>
			<td>
				<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['admin_obj']['shop_no']), $this);?>

			</td>
		</tr>

		</table>
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<div class="mt20 tc">
			<button type="submit" name="sbm_save" onClick="return validate();" class="btn-lg">登録</button>
		</div>
		<?php endif; ?>
		</form>
<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
<h4>管理者検索</h4>
		<form method="post" name="fm_search" action="admin/list/">
		<table class="center">
		<tr>
			<th>ステータス</th>
			<td>
				<label><input type="radio" id="status0"  name="status" value="active" <?php if ($this->_tpl_vars['search']['status'] == 'active'): ?>checked<?php endif; ?> >有効</label>&nbsp;&nbsp;
				<label><input type="radio" id="status1"  name="status" value="disabled" <?php if ($this->_tpl_vars['search']['status'] == 'disabled'): ?>checked<?php endif; ?> >無効</label>
			</td>
			<th>お名前</th>
			<td>
				<input type="text" name="user_name" id="search_user_name"  value="<?php echo $this->_tpl_vars['search']['user_name']; ?>
" size="20" />
			</td>
			<th>店舗</th>
			<td>
				<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopSearchArr'],'selected' => $this->_tpl_vars['search']['shop_no'],'id' => 'shop_no'), $this);?>

			</td>

		</tr>
<!--
		<tr>
			<th>予約情報権限</th>
			<td>
				<?php $_from = $this->_tpl_vars['admintypeArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
					<input type="radio" name="reserve_auth_type" value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['search']['reserve_auth_type'] == $this->_tpl_vars['key']): ?>checked<?php endif; ?>  id="reserve_auth_type<?php echo ($this->_foreach['name']['iteration']-1); ?>
">
					<?php echo $this->_tpl_vars['item']; ?>

				<?php endforeach; endif; unset($_from); ?>

			</td>
			<th>お客様情報権限</th>
			<td>
				<?php $_from = $this->_tpl_vars['admintypeArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
					<input type="radio" name="member_auth_type" value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['search']['member_auth_type'] == $this->_tpl_vars['key']): ?>checked<?php endif; ?>  id="member_auth_type<?php echo ($this->_foreach['name']['iteration']-1); ?>
">
					<?php echo $this->_tpl_vars['item']; ?>

				<?php endforeach; endif; unset($_from); ?>

			</td>
		</tr>
-->
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
<?php endif; ?>
		<h4>管理者一覧</h4>
<a href="/admin/list/" class="btn">新規作成</a>
<p>店舗が「その他」の場合は、閲覧のみ可能です。</p>
		<form method="POST" action="/admin/bulkUpdate/">
			<table class="admins clear">
		<tr>
			<th>ログインID</th>
			<th>お名前</th>
			<th>メールアドレス</th>
			<th>店舗</th>
<!--
			<th>予約情報権限</th>
			<th>お客様情報権限</th>
-->
			<th>ステータス無効</th>
			<th>削除</th>
		</tr>
		<?php $_from = $this->_tpl_vars['admins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['admin']):
?>
			<tr>
				<td><a href="admin/list/?admin_no=<?php echo $this->_tpl_vars['admin']['admin_no']; ?>
"><?php echo $this->_tpl_vars['admin']['user_id']; ?>
</a></td>
				<td><?php echo $this->_tpl_vars['admin']['user_name']; ?>
</td>
				<td><?php echo $this->_tpl_vars['admin']['email']; ?>
</td>
				<td><?php echo $this->_tpl_vars['admin']['shop_name']; ?>
</td>
<!--
				<td><?php echo $this->_tpl_vars['admin']['reserve_auth_type_str']; ?>
</td>
				<td><?php echo $this->_tpl_vars['admin']['member_auth_type_str']; ?>
</td>
-->
				<td class="tc"><input type="checkbox" name="disabled_dummy[]" id="disabled_dummy_<?php echo $this->_tpl_vars['admin']['admin_no']; ?>
" value="<?php echo $this->_tpl_vars['admin']['admin_no']; ?>
" <?php if ($this->_tpl_vars['admin']['status'] == 'disabled'): ?> checked="checked"<?php endif; ?> onClick="clickDisableChk(this)"/></td>
				<td class="tc"><input type="checkbox" name="delete_dummy[]" id="delete_dummy_<?php echo $this->_tpl_vars['admin']['admin_no']; ?>
" value="<?php echo $this->_tpl_vars['admin']['admin_no']; ?>
" onClick="clickDeleteChk(this)"/></td>
			</tr>
		<?php endforeach; endif; unset($_from); ?>
		</table>
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<div class="tc">
			<input type="submit" value="一覧を更新する" onClick="return confirm('更新します。良いですか？')">
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
