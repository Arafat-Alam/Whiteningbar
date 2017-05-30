<?php /* Smarty version 2.6.26, created on 2017-04-19 12:53:06
         compiled from mst_category1.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='category1';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

//編集
function edit( id )
{
	document.regForm.id.value = id;
	document.regForm.submit();
}
function del( id )
{
	if( !confirm( "指定のデータを削除します。\\r\\nよろしいですか？" ) )
	{
		return false;
	}
	document.regForm.action = "./master/category1/";
	document.regForm.id.value = id;
	document.regForm.exec.value = "delete";
	document.regForm.submit();
}
function mainup( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "mainup";
	document.regForm.submit();
}
function maindown( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "maindown";
	document.regForm.submit();
}
function middleup( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "middleup";
	document.regForm.submit();
}
function middledown( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "middledown";
	document.regForm.submit();
}
function subup( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "subup";
	document.regForm.submit();
}
function subdown( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "subdown";
	document.regForm.submit();
}
function addsub( id )
{
	document.regForm.action = "master/category1edit/";
	document.regForm.id.value = id;
	document.regForm.exec.value = "sub";
	document.regForm.submit();
}
function addmain()
{
	document.regForm.action = "master/category1edit/";
	document.regForm.exec.value = "main";
	document.regForm.submit();
}
function addmiddle(id)
{
	document.regForm.action = "master/category1edit/";
	document.regForm.id.value = id;
	document.regForm.exec.value = "middle";
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
		<h3>管理 > クーポン設定</h3>

<div class="w100 center">
<?php if ($this->_tpl_vars['msg']): ?>
<p class="red"><?php echo $this->_tpl_vars['msg']; ?>
</p>
<?php endif; ?>
<form action="master/category1edit" name="regForm" method="post">
	<div>
	<input type="button" value="メインクーポンカテゴリー追加" onClick="addmain();" />
	</div>
<input type="hidden" name="id" />
<input type="hidden" name="value" />
<input type="hidden" name="exec" />

<!-- 一覧 -->
<table class="mt10 w100">
	<tr><th>クーポン名</th><th>上</th><th>下</th><!--  <th>上</th><th>下</th>--><th></th><th></th><th></th></tr>
<?php $_from = $this->_tpl_vars['cateArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>

<tr>
<td>

<?php if ($this->_tpl_vars['item']['cflag'] == 2): ?>
&nbsp;&nbsp;└
<?php endif; ?>

<?php if ($this->_tpl_vars['item']['cflag'] == 3 && $this->_tpl_vars['item']['subdown'] == 1): ?>
&nbsp;&nbsp;&nbsp;&nbsp;├
<?php endif; ?>
<?php if ($this->_tpl_vars['item']['cflag'] == 3 && $this->_tpl_vars['item']['subdown'] == 0): ?>
&nbsp;&nbsp;&nbsp;&nbsp;└
<?php endif; ?>
<?php echo $this->_tpl_vars['item']['name']; ?>

<?php if ($this->_tpl_vars['item']['cflag'] == 2): ?>
(<?php echo $this->_tpl_vars['item']['fee']; ?>
円引き)
<?php endif; ?>
</td>
<td class="tc">
<?php if ($this->_tpl_vars['item']['mainup'] == 1): ?>
<a href="javascript:void( 0 );" onClick="mainup(<?php echo $this->_tpl_vars['item']['id']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▲</a>
<?php endif; ?>
</td>
<td class="tc">
<?php if ($this->_tpl_vars['item']['maindown'] == 1): ?>
<a href="javascript:void( 0 );" onClick="maindown(<?php echo $this->_tpl_vars['item']['id']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▼</a>
<?php endif; ?>
</td>
<!--
<td class="tc">
<?php if ($this->_tpl_vars['item']['middleup'] == 1): ?>
<a href="javascript:void( 0 );" onClick="middleup(<?php echo $this->_tpl_vars['item']['id']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▲</a>
<?php endif; ?>
</td>
<td class="tc">
<?php if ($this->_tpl_vars['item']['middledown'] == 1): ?>
<a href="javascript:void( 0 );" onClick="middledown(<?php echo $this->_tpl_vars['item']['id']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▼</a>
<?php endif; ?>
-->
<!--
<td>
<?php if ($this->_tpl_vars['item']['subup'] == 1): ?>
<a href="javascript:void( 0 );" onclick="subup(<?php echo $this->_tpl_vars['item']['id']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )">▲</a>
<?php endif; ?>
</td>
<td>
<?php if ($this->_tpl_vars['item']['subdown'] == 1): ?>
<a href="javascript:void( 0 );" onclick="subdown(<?php echo $this->_tpl_vars['item']['id']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )">▼</a>
<?php endif; ?>

</td>
-->
<td class="tc"><input type="button" value="変更" onClick="edit(<?php echo $this->_tpl_vars['item']['id']; ?>
)" class="btn-sm"></td>
<td class="tc">
<?php if ($this->_tpl_vars['item']['subflag'] != 1): ?>
<input type="button" value="削除" onClick="del(<?php echo $this->_tpl_vars['item']['id']; ?>
);" class="btn-delete btn-sm">
<?php endif; ?>
</td>
<td class="tc">
<?php if ($this->_tpl_vars['item']['cflag'] == 1): ?>
<input type="button" value="中カテゴリー追加" onClick="addmiddle(<?php echo $this->_tpl_vars['item']['id']; ?>
);" class="btn-sm">
<!--
<input type="button" value="小カテゴリー追加" onclick="addsub(<?php echo $this->_tpl_vars['item']['id']; ?>
);">
-->
<?php elseif ($this->_tpl_vars['item']['cflag'] == 2): ?>
<!--
<input type="button" value="小カテゴリー追加" onclick="addsub(<?php echo $this->_tpl_vars['item']['id']; ?>
);">
-->
<?php endif; ?>

</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>

		<div class="mt20">
		<!-- 一覧 -->
		<input type="button" value="メインクーポンカテゴリー追加" onClick="addmain();" />
		</form>
		</div>

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