<?php /* Smarty version 2.6.26, created on 2015-04-13 09:54:20
         compiled from category1_add.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function editcancel()
{
	document.regForm.action="master/category1/";
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
		<h3>クーポン管理</h3>


<?php if ($this->_tpl_vars['exec'] == 'middle'): ?>
	<h4>中カテゴリ追加</h4>

<?php elseif ($this->_tpl_vars['exec'] == 'sub'): ?>
	<h4>小カテゴリ追加</h4>

<?php elseif ($this->_tpl_vars['exec'] == 'main'): ?>
	<h4>メインカテゴリ追加</h4>
<?php else: ?>
	<h4>カテゴリ編集</h4>
<?php endif; ?>

<div class="w60 center">

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
<form name="regForm" method="post" action="master/category1edit">
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
<table class="w100 mt10">
</td>
</tr>
<tr>
<th>クーポン名<span class="red">※</span></th>
<td>
						<?php if ($this->_tpl_vars['result_messages']['category']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['category']; ?>
</span><br />
						<?php endif; ?>
<input type="text" name="name" value="<?php echo $this->_tpl_vars['name']; ?>
" style="ime-mode:active;width:350px" />
</td>
</tr>
<?php if ($this->_tpl_vars['exec'] == 'middle' || $this->_tpl_vars['itemObj']['cflag'] == 2): ?>
<tr>
	<th>ふりがな</th>
	<td>
		<?php if ($this->_tpl_vars['result_messages']['name_kana']): ?><span class="red"> <?php echo $this->_tpl_vars['result_messages']['name_kana']; ?>
</span><br /><?php endif; ?>
		<input type="text" name="name_kana" value="<?php echo $this->_tpl_vars['name_kana']; ?>
" style="ime-mode:active;width:350px" />
		<br><font size=1>※お客様からは見えませんので、ご自由にソートしたい順番（あいうえお順）でご入力ください</font>
	</td>
</tr>
<tr>
<th>クーポン種類</th>

<td>

<label><input type="radio" name="kind_flg" value="0" <?php if ($this->_tpl_vars['kind_flg'] == 0): ?> checked <?php endif; ?>  />金額の値引き</label><br />
<label><input type="radio" name="kind_flg" value="1" <?php if ($this->_tpl_vars['kind_flg'] == 1): ?> checked <?php endif; ?>  />それ以外</label>
</td>
</tr>

<tr>
<th>割引金額</th>

<td>
						<?php if ($this->_tpl_vars['result_messages']['fee']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['fee']; ?>
</span><br />
						<?php endif; ?>
クーポン種類が金額の値引きの場合は、値引きする金額を入力してください。<br />
<input type="text" name="fee" value="<?php echo $this->_tpl_vars['fee']; ?>
" style="ime-mode:active;width:50px" />円
</td>
</tr>
<?php else: ?>
<tr>
<th>月報集計用フラグ</th>

<td>

<label><input type="radio" name="report_flg" value="1" <?php if ($this->_tpl_vars['report_flg'] == 1): ?> checked <?php endif; ?>  />デコログ</label>
<label><input type="radio" name="report_flg" value="2" <?php if ($this->_tpl_vars['report_flg'] == 2): ?> checked <?php endif; ?>  />ブログ掲載</label>
<label><input type="radio" name="report_flg" value="0" <?php if ($this->_tpl_vars['report_flg'] == 0): ?> checked <?php endif; ?>  />その他</label>

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

<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>