<?php /* Smarty version 2.6.26, created on 2017-04-21 14:06:58
         compiled from shop/list.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='shopList';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#owner_id").val("");
	$("#owner_name").val("");
	$("#email").val("");
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
$this->_smarty_include(array('smarty_include_tpl_file' => "shop/menu_shop.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>基本設定</h3>
<h4>店舗一覧</h4>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


		<!--
			<div class="paging">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
			</div>
  -->
			<form name="fm_list" id="fm_list" method="POST" action="shop/list/">
<div class="w80 center">
ユーザー側表示とは：<br />チェックされている店舗のみがユーザー側に表示されます。管理画面は全て表示されます。<br /><br />
			<table class="admins clear">
			<tr>
				<th >基本情報</th>
				<th >営業設定</th>
				<th >予約ブロック設定</th>
				<th width="100">店名</th>
				<th width="50">店舗ID</th>
				<th>ユーザー側表示</th>
				<th>削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['shopArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<tr>
					<td class="tc"><a href="/shop/edit/?sn=<?php echo $this->_tpl_vars['item']['shop_no']; ?>
" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
					<td class="tc"><a href="/shop/operate/?sn=<?php echo $this->_tpl_vars['item']['shop_no']; ?>
" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
					<td class="tc"><a href="/shop/block/?sn=<?php echo $this->_tpl_vars['item']['shop_no']; ?>
" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
					<td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['spid']; ?>
</td>
					<td class="tc"><input type="checkbox" name="view_flg[]" value="<?php echo $this->_tpl_vars['item']['shop_no']; ?>
" <?php if ($this->_tpl_vars['item']['view_flg'] == 1): ?>checked<?php endif; ?> /></td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="<?php echo $this->_tpl_vars['item']['shop_no']; ?>
" /></td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="8">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>

 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
			<div class="tc">
				<input type="submit" name="submit" value="更新する" onClick="return confirm('チェックされた内容を更新します。削除にチェックを入れてる場合には店舗を削除します');" class="btn-delete">
			</div>
<?php endif; ?>
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
