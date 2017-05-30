<?php /* Smarty version 2.6.26, created on 2017-05-24 11:39:42
         compiled from report/saleData.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'report/saleData.tpl', 71, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='saleData';
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

<button type="submit" name="csv" class="btn-lg">XLS出力</button>&nbsp;
</form>
			<?php if (isset ( $this->_tpl_vars['dataArr'] )): ?>
			<table>	
				<?php $_from = $this->_tpl_vars['dataArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrKey'] => $this->_tpl_vars['itemArr']):
?>
					<?php if ($this->_tpl_vars['arrKey'] == 0): ?>
						<tr>
							<th>日付 / date</th>
							<th>曜日 / day</th>
							<th>総売上 / Weather</th>
							<th>総売上 / total sale</th>
							<th>総来客数 / total visitor</th>
							<th>招待 / cancel visit</th>
							<th>初来店</th>
							<th>6回コース</th>
							<th>12回コース</th>
							<th>ウェディングコース</th>
							<th>9回コース</th>
							<th>18回コース</th>
							<th>1回コース</th>
							<th>24回コース</th>
							<th>36回コース</th>
							<th>初来店再予約</th>
							<th>期間限定お試し3回コース</th>
							<th>1回コース 2回連続ケア</th>
							<th>初回限定3回コース</th>
							<th>オープン記念キャンペーン(500円）</th>
							<th>学割6回コース</th>
							<th>学割9回コース</th>
							<th>学割12回コース</th>
							<th>学割18回コース</th>
							<th>学割24回コース</th>
							<th>学割36回コース</th>
							<th>クリーニング1回コース</th>
							<th>ホワイトニング+クリーニング1回コース</th>
							<th>6回コース+クリーニング</th>
							<th>学割6回コース+クリーニング</th>
							<th>9回コース+クリーニング</th>
							<th>学割9回コース+クリーニング</th>
							<th>12回コース+クリーニング</th>
							<th>学割12回コース+クリーニング</th>
							<th>ウェディングコース+クリーニング</th>
							<th>学割18回コース+クリーニング</th>
							<th>18回コース+クリーニング</th>
							<th>24回コース+クリーニング</th>
							<th>学割24回コース+クリーニング</th>
							<th>36回コース+クリーニング</th>
							<th>学割36回コース+クリーニング</th>
							<th>初回限定3回コース+クリーニング</th>
							<th>社内管理用　+1</th>
							<th>コース割引合計金額 / total Discount</th>
						</tr>
					<?php else: ?>
						<tr>
							<td><?php echo $this->_tpl_vars['arrKey']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['day']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['weather']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['totalFee']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['totalVisitor']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['totalCancelVisit']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['1']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['2']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['3']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['4']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['6']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['7']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['11']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['12']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['13']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['15']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['18']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['29']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['30']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['33']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['34']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['35']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['36']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['37']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['40']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['41']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['42']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['43']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['44']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['45']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['46']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['47']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['48']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['49']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['50']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['51']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['52']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['53']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['54']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['55']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['56']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['57']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['58']; ?>
</td>
							<td><?php echo $this->_tpl_vars['itemArr']['totalDiscount']; ?>
</td>
						</tr>
					<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
						<tr>
							<td colspan="3">Total</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['totalFee']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['totalVisitor']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['totalCancel']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['1']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['2']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['3']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['4']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['6']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['7']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['11']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['12']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['13']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['15']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['18']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['29']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['30']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['33']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['34']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['35']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['36']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['37']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['40']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['41']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['42']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['43']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['44']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['45']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['46']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['47']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['48']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['49']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['50']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['51']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['52']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['53']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['54']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['55']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['56']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['57']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['58']; ?>
</td>
							<td><?php echo $this->_tpl_vars['maxTotal']['totalDiscount']; ?>
</td>
						</tr>
			</table>
			<?php endif; ?>
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
