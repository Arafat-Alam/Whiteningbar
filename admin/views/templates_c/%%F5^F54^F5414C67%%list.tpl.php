<?php /* Smarty version 2.6.26, created on 2017-04-20 11:48:33
         compiled from report/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'report/list.tpl', 56, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='reportList';
 ?>

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
	$("#course").val("");
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
<h4>売上詳細</h4>
	<div class="w70 center">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['result_messages']): ?>
			<center><span class="red"><?php echo $this->_tpl_vars['result_messages']; ?>
</span></center>
		<?php endif; ?>

		<form method="post" name="fm_search" action="/report/list/">
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
			<?php 
				$arr = $this->get_template_vars('arr'); 
				if(isset($arr)){
					foreach($arr as $key => $val){
						$totalPrice += $val['price'];
					}	
				}
				$i=1;
				$this->assign('i',$i);
			 ?>
			<table>
				<tr>
					<th width="180">Total Price =</th>
					<td width="100" align="center"><?php echo $totalPrice; ?> 円</td>
				</tr>
			</table>
			<table class="admins clear mt10">
			<tr>
				<th width="80">sl</th>
				<th width="80">日付</th>
				<th width="80">お名前</th>
				<th width="80">来店時間</th>
				<th width="80">使用コース</th>
				<th width="80">コース消費何回目</th>
				<th width="100">コース購入</th>
				<th width="100">クーポン利用</th>
				<th width="80">その他</th>
				<th width="80">price</th>
			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['i']++; ?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['dt'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
</td>
					<td><?php if ($this->_tpl_vars['item']['name_kana']): ?><?php echo $this->_tpl_vars['item']['name_kana']; ?>
<?php else: ?><?php echo $this->_tpl_vars['item']['name']; ?>
<?php endif; ?><br><?php echo $this->_tpl_vars['item']['member_no']; ?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['use_course_name']; ?>
</td>
					<td><?php if ($this->_tpl_vars['item']['c_cnt']): ?><?php echo $this->_tpl_vars['item']['c_cnt']; ?>
回目<?php endif; ?></td>
					<td><?php echo $this->_tpl_vars['item']['course_name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['coupon_name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['other_fee']; ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['price']; ?>
 円</td>

				</tr>
			<?php endforeach; endif; unset($_from); ?>
			<tr>
				<td colspan="9" align="right">Total Price =</td>
				<td ><?php echo $totalPrice; ?> 円</td>
			</tr>
			</table>
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
