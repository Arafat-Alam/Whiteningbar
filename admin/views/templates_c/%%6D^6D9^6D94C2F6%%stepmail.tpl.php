<?php /* Smarty version 2.6.26, created on 2017-04-19 19:20:44
         compiled from maildeliver/stepmail.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='stepmail';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function edit_submit(no){

	document.regForm.action = "./mail/edit/";
	document.regForm.template_no.value = no
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
$this->_smarty_include(array('smarty_include_tpl_file' => "maildeliver/menu_mail.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>メール管理</h3>
<h4>ステップメール設定</h4>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		
		<div class="w100 center">
		<a href="/mail/stepedit/" class="btn">新規作成</a>
			<table class="admins mt10">
			<tr>
				<th>修正</th>
				<th>タイトル</th>
				<th>配信タイミング</th>
				<th>配信状況</th>
			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<tr>
				<td class="tc"><a href="mail/stepedit/?no=<?php echo $this->_tpl_vars['item']['no']; ?>
" class="btn btn-sm"><i class="fa fa-pencil fa-lg"></i>&nbsp;修正</a></a></td>
				<td><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
				<td class="tc"><?php echo $this->_tpl_vars['item']['timing_str']; ?>
</td>
				<td class="tc">
					<form action="" method="post" name="regForm">
					<label><input type="radio" name="mail_flg" value="1" <?php if ($this->_tpl_vars['item']['mail_flg'] == 1): ?>checked<?php endif; ?> >配信する</label>&nbsp;&nbsp;
					<label><input type="radio" name="mail_flg" value="0" <?php if ($this->_tpl_vars['item']['mail_flg'] == 0): ?>checked<?php endif; ?> >配信しない</label>&nbsp;&nbsp;
				 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
					<input type="submit" name="submit" value="変更" >
					<input type="hidden" name="no" value="<?php echo $this->_tpl_vars['item']['no']; ?>
">
				<?php endif; ?>
					</form>
				</td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>
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