<?php /* Smarty version 2.6.26, created on 2017-04-24 13:43:49
         compiled from maildeliver/list.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='mailList';
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
<h4>メールテンプレート作成</h4>

<div class="w50 center">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
			<div class="submit mt20">
				<form action="/mail/edit/" method="post">
					<input type="submit" value="メールテンプレート新規作成">
				</form>
			</div>
<?php endif; ?>

<h5>メールテンプレート一覧</h5>
			<form action="" method="post" name="regForm">
			<input type="hidden" name="template_no">
			<?php echo $this->_tpl_vars['page_navi']; ?>


			<table class="w100">
			<tr>
				<th>タイトル</th>
				<th>編集</th>
				<th>削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<tr>
				<td><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
				<td class="tc">
				 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
					<input type="button" value="編集" onClick="edit_submit(<?php echo $this->_tpl_vars['item']['template_no']; ?>
)">
				<?php endif; ?>
				</td>
				<td class="tc">
					<input type="checkbox" name="delete[]" value="<?php echo $this->_tpl_vars['item']['template_no']; ?>
">
				</td>

			</tr>
			<?php endforeach; endif; unset($_from); ?>


			</table>
			<?php echo $this->_tpl_vars['page_navi']; ?>


 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
			<div class="mt20 tc">
				<input type="submit" name="sbm_delete" value="削除" onClick="confirm('メールテンプレートを削除します。');" class="btn-delete">
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