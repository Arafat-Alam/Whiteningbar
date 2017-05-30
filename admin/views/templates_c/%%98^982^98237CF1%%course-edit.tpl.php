<?php /* Smarty version 2.6.26, created on 2014-09-24 10:29:17
         compiled from shop/course-edit.tpl */ ?>
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
<h4>コース登録<?php if ($this->_tpl_vars['copy'] == 1): ?>(コースコピー)<?php endif; ?></h4>

<div class="w60 center">
		<a href="/shop/course/" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;コース一覧</a>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



		<form method="post" name="fm_search" action="shop/courseEdit/">
		<table class="search mt10 w100">
		<tr>
			<th>コース名<span class="red">※</span></th>
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
			<th>回数<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['number']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['number']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="number" id="number"  value="<?php echo $this->_tpl_vars['input_data']['number']; ?>
" size="10" />回

			</td>
		</tr>
		<tr>
			<th>料金<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['fee']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['fee']; ?>
</span><br />
						<?php endif; ?>
				<input type="text" name="fee" id="zip"  value="<?php echo $this->_tpl_vars['input_data']['fee']; ?>
" size="10" />円

			</td>
		</tr>
		<tr>
			<th>期限<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['limit_month']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['limit_month']; ?>
</span><br />
						<?php endif; ?>
				購入から<input type="text" name="limit_month" id="zip"  value="<?php echo $this->_tpl_vars['input_data']['limit_month']; ?>
" size="10" />か月

			</td>
		</tr>
		<tr>
			<th>ご招待コース<span class="red">※</span></th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['view_flg']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['view_flg']; ?>
</span><br />
						<?php endif; ?>

				<label><input type="radio" name="invite_flg" id="invite_flg"  value="1" <?php if ($this->_tpl_vars['input_data']['invite_flg'] == 1): ?>checked<?php endif; ?>  />招待コース</label>
				<label><input type="radio" name="invite_flg" id="invite_flg"  value="0" <?php if ($this->_tpl_vars['input_data']['invite_flg'] == 0): ?>checked<?php endif; ?>  />通常コース</label>
			</td>
		</tr>
		<tr>
			<th>料金に関する説明</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['fee_comment']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['fee_comment']; ?>
</span><br />
						<?php endif; ?>
				<textarea name="fee_comment" id="fee_comment"  ><?php echo $this->_tpl_vars['input_data']['fee_comment']; ?>
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
	</table>


		<div class="mt20 tc">
			<input type="submit" name="submit" value="更新" class="btn-lg">&nbsp;
<!-- 			<input type="reset"  value="クリア"> -->
			<input type="hidden" name="course_no" value="<?php echo $this->_tpl_vars['input_data']['course_no']; ?>
">

		</div>
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
