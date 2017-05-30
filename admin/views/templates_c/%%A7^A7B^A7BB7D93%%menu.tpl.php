<?php /* Smarty version 2.6.26, created on 2017-04-19 19:03:30
         compiled from shop/menu.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='menu';
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

function mainup( id, val )
{

	document.fm_list.action = "/shop/menu/";
	document.fm_list.id.value = id;
	document.fm_list.value.value = val;
	document.fm_list.exec.value = "mainup";
	document.fm_list.submit();
}
function maindown( id, val )
{
	document.fm_list.action = "/shop/menu/";
	document.fm_list.id.value = id;
	document.fm_list.value.value = val;
	document.fm_list.exec.value = "maindown";
	document.fm_list.submit();
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
<h4>メニュー一覧</h4>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<p>会員様が予約するメニューの一覧になります。</p>

		<!--
			<div class="paging">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
			</div>
  -->
<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
  <a href="/shop/menuEdit/" class="btn">メニューの新規作成</a>
<?php endif; ?>
			<form name="fm_list" id="fm_list" method="POST" action="/shop/menu/">
<input type="hidden" name="id"  />
<input type="hidden" name="exec"/>
<input type="hidden" name="value" />
			<table class="admins clear mt10">
			<tr>
				<th width="100">コース名</th>
				<th width="100">メニュー名</th>
				<th width="25">時間</th>
				<th width="50">人数</th>
				<th width="50">表示色</th>
				<th width="50">編集</th>
				<th width="50">コピー</th>
				<th width="8" >表示順</th>
				<th width="8" >表示順</th>
				<th width="20">削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['shopArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
				<tr>
					<td><?php echo $this->_tpl_vars['item']['course_name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['times']; ?>
分</td>
					<td><?php echo $this->_tpl_vars['item']['number']; ?>
人</td>
					<td><p style="background-color:<?php echo $this->_tpl_vars['item']['view_color']; ?>
;">　</p></td>
					<td class="tc"><a href="/shop/menuEdit/?sn=<?php echo $this->_tpl_vars['item']['menu_no']; ?>
" class="btn btn-sm"><i class="fa fa-pencil fa-lg"></i>&nbsp;修正</a></td>
					<td class="tc"><a href="/shop/menuEdit/?copy&sn=<?php echo $this->_tpl_vars['item']['menu_no']; ?>
" class="btn btn-sm"><i class="fa fa-files-o fa-lg"></i>&nbsp;コピー</a></td>
					<td class="tc"><?php if (($this->_foreach['name']['iteration']-1) != 0): ?><a href="javascript:void( 0 );" onClick="mainup(<?php echo $this->_tpl_vars['item']['menu_no']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▲</a><?php endif; ?></td>
					<td class="tc">
						<?php if ($this->_foreach['name']['iteration'] != count ( $this->_tpl_vars['shopArr'] )): ?>
							<a href="javascript:void( 0 );" onClick="maindown(<?php echo $this->_tpl_vars['item']['menu_no']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▼</a><?php endif; ?>
					</td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="<?php echo $this->_tpl_vars['item']['menu_no']; ?>
" /></td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="8">メニュー未設定</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>
<!--
			<div class="paging">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
				<div class="end"></div>
			</div>
 -->
 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
			<div class="tc">
				<input type="submit" name="upsubmit" value="削除" onClick="return confirm('チェックされたメニューを削除します。良いですか？');" class="btn-delete">
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
