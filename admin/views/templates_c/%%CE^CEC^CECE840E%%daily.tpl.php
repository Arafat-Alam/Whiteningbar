<?php /* Smarty version 2.6.26, created on 2017-04-24 07:48:25
         compiled from report/daily.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'report/daily.tpl', 51, false),array('modifier', 'number_format', 'report/daily.tpl', 99, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='daily';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#start").val("");
	$("#end").val("");


}

$(function(){

	$("#start").datepicker({
		dateFormat: "yy-mm-dd"
	});


	$("#end").datepicker({
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
$this->_smarty_include(array('smarty_include_tpl_file' => "report/menu_report.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>売上レポート</h3>
<h4>日次売上</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上日</th>
				<td>
				<input type="text" id="start" name="start_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end" name="end_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>

				</td>
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
				<th width="80">日付</th>
				<th width="80">純売上</th>
				<th width="80">総来客数</th>
				<th width="100">キャンセル</th>
				<?php $_from = $this->_tpl_vars['courseArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<th width="80"><?php echo $this->_tpl_vars['item']['name']; ?>
</th>
				<?php endforeach; endif; unset($_from); ?>
				<th width="80">他（金額）</th>
				<th width="80">割引合計金額</th>


			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<tr>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['dt'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
</td>
					<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['total_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
					<td align="right"><?php if ($this->_tpl_vars['item']['total_count']): ?><?php echo $this->_tpl_vars['item']['total_count']; ?>
<?php else: ?>0<?php endif; ?></td>
					<td align="right"><?php if ($this->_tpl_vars['item']['cancel_count']): ?><?php echo $this->_tpl_vars['item']['cancel_count']; ?>
<?php else: ?>0<?php endif; ?></td>

					<?php $_from = $this->_tpl_vars['item']['course_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fee']):
?>
					<td align="right">
						<?php echo ((is_array($_tmp=$this->_tpl_vars['fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>

					</td>
					<?php endforeach; endif; unset($_from); ?>

					<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['other_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
					<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['discount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
				</tr>
			<?php endforeach; endif; unset($_from); ?>
				<tr>
					<td>合計</td>
					<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['totalArr']['total_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
					<td align="right"><?php if ($this->_tpl_vars['totalArr']['total_count']): ?><?php echo $this->_tpl_vars['totalArr']['total_count']; ?>
<?php else: ?>0<?php endif; ?></td>
					<td align="right"><?php if ("$".($this->_tpl_vars['totalArr']).".cancel_count"): ?><?php echo $this->_tpl_vars['totalArr']['cancel_count']; ?>
<?php else: ?>0<?php endif; ?></td>
					<?php $_from = $this->_tpl_vars['totalArr']['course_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fee']):
?>
					<td align="right">
						<?php echo ((is_array($_tmp=$this->_tpl_vars['fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>

					</td>
					<?php endforeach; endif; unset($_from); ?>
					<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['totalArr']['other_fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
					<td align="right"><?php echo ((is_array($_tmp=$this->_tpl_vars['totalArr']['discount'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
				</tr>

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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
