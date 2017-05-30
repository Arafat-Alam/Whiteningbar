<?php /* Smarty version 2.6.26, created on 2014-08-18 14:57:13
         compiled from shop/menu-edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'shop/menu-edit.tpl', 22, false),)), $this); ?>
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
<h4>メニュー登録<?php if ($this->_tpl_vars['copy'] == 1): ?>(メニューコピー)<?php endif; ?></h4>

		<a href="/shop/menu/" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;メニュー一覧</a>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


		<form method="post" name="fm_search" action="shop/menuEdit/">
		<table class="search w100 mt10">
		<tr>
			<th>対応コースの選択<span class="red">※</span></th>
			<td>
				<?php echo smarty_function_html_options(array('name' => 'course_no','options' => $this->_tpl_vars['courseArr'],'selected' => $this->_tpl_vars['input_data']['course_no']), $this);?>


			</td>
		</tr>
		<tr>
			<th>メニュー名<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['name']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['name']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="name" id="name"  value="<?php echo $this->_tpl_vars['input_data']['name']; ?>
" size="40" />
				<br />
				<label><input type="radio" name="kind_flg" value="0" <?php if ($this->_tpl_vars['input_data']['kind_flg'] == 0): ?>checked<?php endif; ?> />初回登録者用メニュー（初回用メニュー）</label>
				<label><input type="radio" name="kind_flg" value="1" <?php if ($this->_tpl_vars['input_data']['kind_flg'] == 1): ?>checked<?php endif; ?> />会員登録後のメニュー</label>
				<br />
				※初回登録者用メニューとは、未会員の人が会員登録する場合に表示されるメニューです
				<br /><br />
				<label><input type="radio" name="use_count" value="1" <?php if ($this->_tpl_vars['input_data']['use_count'] == 1): ?>checked<?php endif; ?> />1回分</label>
				<label><input type="radio" name="use_count" value="2" <?php if ($this->_tpl_vars['input_data']['use_count'] == 2): ?>checked<?php endif; ?> />2回分</label>


			</td>
		</tr>
		<tr>
			<th>所要時間<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['times']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['times']; ?>
</span><br />
						<?php endif; ?>
				<!--<input type="text" name="times" id="times"  value="<?php echo $this->_tpl_vars['input_data']['times']; ?>
" size="10" />分  -->
				<?php echo smarty_function_html_options(array('name' => 'times','options' => $this->_tpl_vars['menuTimeArr'],'selected' => $this->_tpl_vars['input_data']['times']), $this);?>
分


			</td>
		</tr>
		<tr>
			<th>人数<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['number']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['number']; ?>
</span><br />
						<?php endif; ?>
				<!--<input type="text" name="number" id="number"  value="<?php echo $this->_tpl_vars['input_data']['number']; ?>
" size="10" />人  -->
				<label><input type="radio" name="number" value="1" <?php if ($this->_tpl_vars['input_data']['number'] == 1): ?>checked<?php endif; ?> />1人</label><br />
				<label><input type="radio" name="number" value="2" <?php if ($this->_tpl_vars['input_data']['number'] == 2): ?>checked<?php endif; ?> />2人</label><br />

			</td>
		</tr>
		<tr>
			<th>一覧用紹介コメント</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['comment']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['comment']; ?>
</span><br />
						<?php endif; ?>
				<textarea name="comment" id="comment"  ><?php echo $this->_tpl_vars['input_data']['comment']; ?>
</textarea>
			</td>
		</tr>
		<tr>
			<th>表示ステータス<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['view_flg']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['view_flg']; ?>
</span><br />
						<?php endif; ?>

				<label><input type="radio" name="view_flg" id="view_flg"  value="1" <?php if ($this->_tpl_vars['input_data']['view_flg'] == 1): ?>checked<?php endif; ?>  />表示</label>
				<label><input type="radio" name="view_flg" id="view_flg"  value="0" <?php if ($this->_tpl_vars['input_data']['view_flg'] == 0): ?>checked<?php endif; ?>  />非表示</label>
			</td>
		</tr>
		<tr>
			<th>スケジュール表示色</th>
			<td>

				<?php $_from = $this->_tpl_vars['colorArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['colorkey'] => $this->_tpl_vars['item']):
?>
					<label><span style="background-color:<?php echo $this->_tpl_vars['item']; ?>
;" class="color-pick"><input type="radio" name="color_no" value="<?php echo $this->_tpl_vars['colorkey']; ?>
" <?php if ($this->_tpl_vars['colorkey'] == $this->_tpl_vars['input_data']['color_no']): ?> checked <?php endif; ?> >　<?php echo $this->_tpl_vars['colorkey']; ?>
</span></label>
				<?php endforeach; endif; unset($_from); ?>
			</td>
		</tr>
	</table>

 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<div class="mt20 tc">
			<input type="submit" name="submit" value="更新" class="btn btn-lg">&nbsp;
<!-- 			<input type="reset"  value="クリア"> -->
			<input type="hidden" name="menu_no" value="<?php echo $this->_tpl_vars['input_data']['menu_no']; ?>
">

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
