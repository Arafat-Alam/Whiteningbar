<?php /* Smarty version 2.6.26, created on 2017-05-26 15:52:56
         compiled from shop/block.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'shop/block.tpl', 69, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='block';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '


$(function(){

	$("#start").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#end").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#timestart").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#start_r").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#end_r").datepicker({
		dateFormat: "yy-mm-dd"
	});

});


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
<h4>ブロック設定</h4>

<div class="w80 center">
<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
		<a href="/shop/list" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;店舗一覧</a>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


		<table class="search w100">
		<tr>
		<form method="post" name="fm_search" action="">
			<th>日付期間で設定</th>
			<td>
				select Booth: 
				<select name="booth_no" style="width: 50%">
				<?php 
					$booth = $this->get_template_vars('boothArr');
						for($a=1; $a<=$booth['booth']; $a++){
							echo "<option value='".$a."'>".$a."</option>";
						}
				 ?>
				</select> 
				<br>
				
				ブロック開始日時：<input type="text" id="start" name="start_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>
				<input name="start_time" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
<br />
				～
<br />
				ブロック終了日時：<input type="text" id="end" name="end_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>
				<input name="end_time" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">

			</td>
			<td>
				<input type="hidden" name="no" value="<?php echo $this->_tpl_vars['input_data']['no']; ?>
" />
				<input type="hidden" name="kind_flg" value=1>
				<input type="submit" name="submit" value="決定">&nbsp;
			</td>
		</form>
		</tr>
		<tr>
		<form method="post" name="fm_search" action="">
			<th>時間単位で設定</th>
			<td>
				select Booth: 
				<select name="booth_no" style="width: 50%">
				<?php 
					$booth = $this->get_template_vars('boothArr');
						for($a=1; $a<=$booth['booth']; $a++){
							echo "<option value='".$a."'>".$a."</option>";
						}
				 ?>
				</select> 
				<br>
						<?php if ($this->_tpl_vars['result_messages']['from_def_h']): ?>
							<span class="red"> <?php echo $this->_tpl_vars['result_messages']['from_def_h']; ?>
</span><br />
						<?php endif; ?>
				日付：<input type="text" id="timestart" name="start_date_t" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['start_date_t'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>
<br />
				時間：<input name="start_time_t" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['start_time_t'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
				～
				<input name="end_time_t" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['end_time_t'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
			</td>
			<td>
				<input type="hidden" name="no_t" value="<?php echo $this->_tpl_vars['input_data']['no_t']; ?>
" />
				<input type="hidden" name="kind_flg" value=2>
				<input type="submit" name="submit" value="決定" >&nbsp;
			</td>
		</form>
		</tr>
		<tr>
		<form method="post" name="fm_search" action="">
			<th>リピートで設定</th>
			<td>
			select Booth: 
				<select name="booth_no" style="width: 50%">
				<?php 
					$booth = $this->get_template_vars('boothArr');
						for($a=1; $a<=$booth['booth']; $a++){
							echo "<option value='".$a."'>".$a."</option>";
						}
				 ?>
				</select> 
				<br>
				
				期間<br/>
				<input type="text" id="start_r" name="start_date_r" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['start_date_r'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end_r" name="end_date_r" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['end_date_r'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>

<br />
				ブロック時間<br/>
				<input name="start_time_r" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['start_time_r'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
				～
				<input name="end_time_r" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['end_time_r'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">

<br />
※指定した期間、同じ時間帯で予約のブロックを行います。
			</td>
			<td>
				<input type="hidden" name="no_r" value="<?php echo $this->_tpl_vars['input_data']['no_r']; ?>
" />
				<input type="hidden" name="kind_flg" value=3>
				<input type="submit" name="submit" value="決定">&nbsp;
			</td>
		</form>
		</tr>
	</table>


<hr>
<a href="/shop/block/?sn=<?php echo $this->_tpl_vars['shop_no']; ?>
" class="btn">&nbsp;新規登録</a>
<form method="post" name="fm_search" action="">
			<table  class="admins clear">
			<tr>
				<th>ブロック内容</th>
				<th>修正</th>
				<th>Booth</th>
				<th>削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			<tr>
				<td>
					<?php if ($this->_tpl_vars['item']['kind_flg'] == 1): ?>
					※期間でブロック<br />
						<?php echo $this->_tpl_vars['item']['start_date']; ?>

						<?php echo $this->_tpl_vars['item']['start_time']; ?>

						～
						<?php echo $this->_tpl_vars['item']['end_date']; ?>

						<?php echo $this->_tpl_vars['item']['end_time']; ?>

					<?php elseif ($this->_tpl_vars['item']['kind_flg'] == 3): ?>
					※リピートブロック<br />
						<?php echo $this->_tpl_vars['item']['start_date']; ?>

						～
						<?php echo $this->_tpl_vars['item']['end_date']; ?>

						<br />
						<?php echo $this->_tpl_vars['item']['start_time']; ?>

						～
						<?php echo $this->_tpl_vars['item']['end_time']; ?>

					<?php else: ?>
					※時間ブロック<br />
						<?php echo $this->_tpl_vars['item']['start_date']; ?>
<br />
						<?php echo $this->_tpl_vars['item']['start_time']; ?>
～<?php echo $this->_tpl_vars['item']['end_time']; ?>


					<?php endif; ?>

				</td>
				<td>
					Booth No : <?php echo $this->_tpl_vars['item']['booth_no']; ?>

				</td>
				<td class="tc"><a href="/shop/block/?modify=<?php echo $this->_tpl_vars['item']['no']; ?>
&sn=<?php echo $this->_tpl_vars['item']['shop_no']; ?>
" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
				<td class="tc"><input type="checkbox" name="delete_dummy[]" value="<?php echo $this->_tpl_vars['item']['no']; ?>
" /></td>
			</tr>
			<?php endforeach; endif; unset($_from); ?>
			</table>

			<div class="tc">
				<input type="submit" name="del_submit" value="削除する" onClick="return confirm('チェックされた内容を削除します。良いですか？');" class="btn-delete">
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
	<!-- date time picker -->
	<script src="/js/legacy.js"></script>
	<script src="/js/picker.js"></script>
	<script src="/js/picker.date.js"></script>
	<script src="/js/picker.time.js"></script>
	<script src="/js/ja_JP.js"></script>
	<script>
	<?php echo '
		$(\'.datepicker\').pickadate({
			format: \'yyyy/mm/dd\'
		})
		$(\'.timepicker\').pickatime({
			　clear: \'消去\',
			 format: \'H:i\',
			 interval: 15,
			 min: [10,0],
   		 max: [21,0]
		})
		'; ?>

	</script>

</body>
</html>
