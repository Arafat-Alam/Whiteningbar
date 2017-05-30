<?php /* Smarty version 2.6.26, created on 2017-03-08 15:46:56
         compiled from affiliate/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'affiliate/list.tpl', 61, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#year").val("");
	$("#month").val("");
	$("#day").val("");
	$("#start").val("");
	$("#end").val("");
	$("#r_start").val("");
	$("#r_end").val("");
	$("#reserve_no").val("");
}


$(function(){

	$("#start").datepicker({
		dateFormat: "yy/mm/dd"
	});


	$("#end").datepicker({
		dateFormat: "yy/mm/dd"
	});

	$("#r_start").datepicker({
		dateFormat: "yy/mm/dd"
	});


	$("#r_end").datepicker({
		dateFormat: "yy/mm/dd"
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
	<div id="main_content">
		<h3>アフィリエイト管理</h3>

	<div class="w80 center">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['result_messages']): ?>
			<center><span class="red"><?php echo $this->_tpl_vars['result_messages']; ?>
</span></center>
		<?php endif; ?>

		<form method="post" name="fm_search" action="/affiliate/list/">
		<table class="search center">
			<tr>
				<th>施術日</th>
				<td>
				<input type="text" id="start" name="start_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end" name="end_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
				</td>
			</tr>
			<tr>
				<th>予約を行った日</th>
				<td>
				<input type="text" id="r_start" name="r_start_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['r_start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
				～
				<input type="text" id="r_end" name="r_end_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['r_end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
				</td>
			</tr>
			<tr>
				<th>予約番号</th>
				<td><input type="text" name="d_reserve_no" value="<?php echo $this->_tpl_vars['search']['d_reserve_no']; ?>
" id="reserve_no"></td>
			</tr>
		</table>

		<div class="mt10 tc">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
	</div>
<hr>

		<!--
			<div class="paging">
				<div class="left"><strong><?php echo $this->_tpl_vars['total_cnt']; ?>
</strong>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
			</div>
			<br/>
-->
<form action="" method="post">

<button type="submit" name="csv" class="btn-lg">CSV出力</button>&nbsp;
</form>
			<form name="fm_list" id="fm_list" method="POST" action="/report/list/">

			<table class="admins clear mt10">
			<tr>
				<th width="80">予約番号</th>
				<th width="80">予約を行った日時</th>
				<th width="80">施術日時</th>
				<th width="80">名前</th>
				<th width="100">来店状況</th>
				<th width="80">初回</th>
				<th width="80">店舗</th>
			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['item']['reserve_no']; ?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['insert_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M")); ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['reserve_date']; ?>
　<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</td>
					<td align="right"><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
					<td align="right">
						<?php if ($this->_tpl_vars['item']['visit_flg'] == 0): ?>
							予約中
						<?php elseif ($this->_tpl_vars['item']['visit_flg'] == 1): ?>
							来店
						<?php else: ?>
							キャンセル
						<?php endif; ?>
					</td>
					<td align="right">
						<?php echo $this->_tpl_vars['item']['kind_flg']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['item']['shop_name']; ?>

					</td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="7">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>
<!--
			<div class="paging">
				<div class="left"><strong><?php echo $this->_tpl_vars['total_cnt']; ?>
</strong>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
				<div class="end"></div>
			</div>
  -->
</form>
	</div>
</div>
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>