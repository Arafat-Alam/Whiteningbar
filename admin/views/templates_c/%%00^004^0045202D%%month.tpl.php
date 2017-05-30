<?php /* Smarty version 2.6.26, created on 2017-04-21 08:48:28
         compiled from report/month.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'report/month.tpl', 47, false),array('modifier', 'date_format', 'report/month.tpl', 160, false),array('modifier', 'number_format', 'report/month.tpl', 161, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='month';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#f_year").val("");
	$("#f_month").val("");
	$("#t_year").val("");
	$("#t_month").val("");
	$("input#mon1").attr(\'checked\',false);
	$("input#mon2").attr(\'checked\',false);
	$("input#mon3").attr(\'checked\',false);


}

$(function(){


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
<h4>月次売上</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上月</th>
				<td>
		          	<?php echo smarty_function_html_options(array('name' => 'f_year','options' => $this->_tpl_vars['yearArr'],'selected' => $this->_tpl_vars['search']['f_year'],'id' => 'f_year'), $this);?>

		            年
		            <?php echo smarty_function_html_options(array('name' => 'f_month','options' => $this->_tpl_vars['monthArr'],'selected' => $this->_tpl_vars['search']['f_month'],'id' => 'f_month'), $this);?>

		            月
		            ～
		          	<?php echo smarty_function_html_options(array('name' => 't_year','options' => $this->_tpl_vars['yearArr'],'selected' => $this->_tpl_vars['search']['t_year'],'id' => 't_year'), $this);?>

		            年
		            <?php echo smarty_function_html_options(array('name' => 't_month','options' => $this->_tpl_vars['monthArr'],'selected' => $this->_tpl_vars['search']['t_month'],'id' => 't_month'), $this);?>

		            月

				</td>
			</tr>
			<?php if ($this->_tpl_vars['login_admin']['shop_no'] == 0): ?>
			<tr>
				<th>ストアを選択</th>
				<td> 
					<select name="shop_no">
						<option value="0">すべての店</option>
						<?php 
							$shopArr = $this->get_template_vars('shopArr');
							$shop_no = $this->get_template_vars('shop_no');
							foreach($shopArr as $key => $value){
							
						 ?>
							<option value="<?php echo $value['shop_no']; ?>" <?php if($shop_no==$value['shop_no'])echo "selected" ?>><?php echo $value['name']; ?></option>
						<?php 
							}
						 ?>
					</select>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td colspan="2" align="center">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>

				</td>
			</tr>
		</table>

		<table class="search center">
		<tr>
			<th>月選択</th>
			<td>
				<input type="radio" name="mon" value="0" <?php if ($this->_tpl_vars['search']['mon'] == 0): ?>checked<?php endif; ?> id=mon1 />今月　
				<input type="radio" name="mon" value="1" <?php if ($this->_tpl_vars['search']['mon'] == 1): ?>checked<?php endif; ?> id=mon2 />先月　
				<input type="radio" name="mon" value="2" <?php if ($this->_tpl_vars['search']['mon'] == 2): ?>checked<?php endif; ?> id=mon3 />先々月

			</td>
		</tr>
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] == 0): ?>
		<tr>
				<th>ストアを選択</th>
				<td> 
					<select name="shop_no1">
						<option value="0">すべての店</option>
						<?php 
							$shopArr = $this->get_template_vars('shopArr');
							$shop_no1 = $this->get_template_vars('shop_no1');
							foreach($shopArr as $key => $value){
							
						 ?>
							<option value="<?php echo $value['shop_no']; ?>" <?php if($shop_no1==$value['shop_no'])echo "selected" ?> ><?php echo $value['name']; ?></option>
						<?php 
							}
						 ?>
					</select>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td colspan="2" align="center">
			<button type="submit" name="sbm_search2" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>

				</td>
			</tr>
		</table>
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
					<td align="right"><?php if ($this->_tpl_vars['totalArr']['cancel_count']): ?><?php echo $this->_tpl_vars['totalArr']['cancel_count']; ?>
<?php else: ?>0<?php endif; ?></td>
					<?php $_from = $this->_tpl_vars['totalArr']['course_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fee']):
?>
					<td align="right">
						<?php echo $this->_tpl_vars['fee']; ?>

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
