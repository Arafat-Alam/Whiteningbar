<?php /* Smarty version 2.6.26, created on 2017-05-02 20:21:54
         compiled from shop/edit.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='edit';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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
<h4>店舗登録</h4>

<div class="w60 center">
<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
		<a href="/shop/list" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;店舗一覧</a>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<form method="post" name="fm_search" action="/shop/edit">
		<table class="search w100">
		<tr>
			<th>店名<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['name']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['name']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="name" id="name"  value="<?php echo $this->_tpl_vars['input_data']['name']; ?>
" size="40" />
			</td>
		</tr>
		<tr>
			<th>郵便番号</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['zip']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['zip']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="zip" id="zip"  value="<?php echo $this->_tpl_vars['input_data']['zip']; ?>
" size="10" />

			</td>
		</tr>
		<tr>
			<th>住所</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['address']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['address']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="address" id="address"  value="<?php echo $this->_tpl_vars['input_data']['address']; ?>
" size="50" />
			</td>
		</tr>
		<tr>
			<th>電話番号</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['tel']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['tel']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="tel" id="tel"  value="<?php echo $this->_tpl_vars['input_data']['tel']; ?>
" size="30" />
			</td>
		</tr>
		<tr>
			<th>メール送信先のEmail</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['send_email']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['send_email']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="send_email" id="send_email"  value="<?php echo $this->_tpl_vars['input_data']['send_email']; ?>
" size="30" />
			</td>
		</tr>
	</table>

<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<div class="mt20 tc">
			<input type="submit" name="submit" value="更新" class="btn-lg">&nbsp;
<!-- 			<input type="reset"  value="クリア"> -->
			<input type="hidden" name="shop_no" value="<?php echo $this->_tpl_vars['input_data']['shop_no']; ?>
">

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
