<?php /* Smarty version 2.6.26, created on 2017-05-16 21:15:05
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'index.tpl', 154, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='top';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- <script type="text/javascript">
<?php echo '
function winopn(){

	// sW = window.parent.screen.width;
	// sH = window.parent.screen.height;

	window.location=\'/calendar/list\';
}

'; ?>

</script> -->
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
		<!-- tabs -->
		<!-- <ul class="tab clearfix mt20" >
			<li>
				<a href="javascript:void(0);" onClick="winopn();" class="btn btn-lg"><i class="fa fa-calendar"></i>&nbsp;予約管理カレンダーを開く</a>
			</li>
		</ul>
		<div class="clear"> </div> -->
		<!-- tabs close-->


		<h3>トップページ</h3>

		<!-- <h5 class="tc">
		<a href="javascript:void(0);" onClick="winopn();" class="btn btn-xlg"><i class="fa fa-calendar fa-lg"></i>&nbsp;予約管理カレンダーを開く</a>
		</h5> -->


		<div class="clearfix w80 center">
			<div class="left w50">
				<h4>日の予約数</h4>

				<table class="center">
					<tr><th>店舗名</th><th>昨日</th><th>本日</th><th>明日</th></tr>
					<?php $_from = $this->_tpl_vars['dayArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['arr']['name']; ?>
</td>

						<?php $_from = $this->_tpl_vars['arr']['count']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aaa'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aaa']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['aaa']['iteration']++;
?>

							<?php if (($this->_foreach['aaa']['iteration']-1) == 1): ?>
								<td class="tc today"><!-- 本日以外はtodayを外す-->
							<?php else: ?>
								<td class="tc"><!-- 本日以外はtodayを外す-->
							<?php endif; ?>
								<?php echo $this->_tpl_vars['item']; ?>

							</td>
						<?php endforeach; endif; unset($_from); ?>
					</tr>

					<?php endforeach; endif; unset($_from); ?>
				</table>
			</div>
						<?php 
				//$band = $this->get_template_vars('monArr'); 
				//print_r($band);	exit;

			 ?>
			<div class="right ml30 w50">
				<h4>月の予約数</h4>
				<table class="center">
					<tr><th>店舗名</th><th>先月</th><th>今月</th><th>来月</th></tr>
					<?php $_from = $this->_tpl_vars['monArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arr']):
?>
					<tr>
						<td><?php echo $this->_tpl_vars['arr']['name']; ?>
</td>

						<?php $_from = $this->_tpl_vars['arr']['count']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aaa'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aaa']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['aaa']['iteration']++;
?>
							<?php if (($this->_foreach['aaa']['iteration']-1) == 1): ?>
								<td class="tc thismonth"><!-- 今月以外はthismonthを外す-->
							<?php else: ?>
								<td class="tc">
							<?php endif; ?> 
							<?php echo $this->_tpl_vars['item']; ?>
	
						</td>

						<?php endforeach; endif; unset($_from); ?>
					</tr>

					<?php endforeach; endif; unset($_from); ?>
				</table>
			</div>
		</div>
		<?php if ($this->_tpl_vars['shopNo'] == 0): ?>
		<div class="clearfix w50 left" style="border-right: solid 1px gray;">
			<div class="left w100" align="">

			<div align="center">
			<br>
			<input type="radio" id="yesterday" name="day" onclick="dayChartData('yesterday')"><label for="yesterday">昨日</label>&nbsp;&nbsp;
			<input type="radio" id="today" name="day" onclick="dayChartData('today')" checked><label for="today">本日</label>&nbsp;&nbsp;
			<input type="radio" id="tomorrow" name="day" onclick="dayChartData('tomorrow')"><label for="tomorrow">明日</label>&nbsp;&nbsp;
			</div>

				<div class="bar-chart-day"></div>
			</div>
		</div>
		<div class="clearfix w50 left">
			<div class="left w100">
			<div align="center">
			<br>
			<input type="radio" id="lastMonth" name="month" onclick="monthChartData('lastMonth')"><label for="lastMonth">先月</label>&nbsp;&nbsp;
			<input type="radio" id="thismonth" name="month" onclick="monthChartData('thismonth')" checked><label for="thismonth">今月</label>&nbsp;&nbsp;
			<input type="radio" id="nextMonth" name="month" onclick="monthChartData('nextMonth')"><label for="nextMonth">来月</label>&nbsp;&nbsp;
			</div>

				<div class="bar-chart-month"></div>
			</div>
		</div>
			<hr>
			<?php endif; ?>

		<div class="w90 center" >
			<h4 class="clear mt30">お知らせ</h4>
			<ul class="news" style="height: 500px; overflow-y: scroll;">
			<?php $_from = $this->_tpl_vars['newsArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<li>
				<h5><span><?php echo $this->_tpl_vars['item']['news_date']; ?>
</span><?php echo $this->_tpl_vars['item']['title']; ?>
</h5>
				
				<?php if ($this->_tpl_vars['item']['img_name'] != ''): ?>
				<?php 

					$file = $this->get_template_vars('item');

					$fileType = mime_content_type("../../public/htdocs/user_data/img_news/".$file['img_name']);

					if($fileType == 'image/png' || $fileType == 'image/bmp' || $fileType == 'image/gif' || $fileType == 'image/jpeg' || $fileType == 'image/pjpeg'){
						 ?>
						<h5>Attached Image / 添付画像</h5>
						<img src="../../public/htdocs/user_data/img_news/<?php echo $this->_tpl_vars['item']['img_name']; ?>
" height="150px" width="150px">
						<a target="_blank" download href="../../public/htdocs/user_data/img_news/<?php echo $this->_tpl_vars['item']['img_name']; ?>
">Download</a>
						<?php 
					}else{
						 ?>
						<h5>Attached File / 添付ファイル</h5>
						<span><?php echo $this->_tpl_vars['item']['img_name']; ?>
</span> &nbsp;<a target="_blank" href="../../public/htdocs/user_data/img_news/<?php echo $this->_tpl_vars['item']['img_name']; ?>
">Download</a>
						<?php 
					}
				 ?>
				<?php endif; ?>
				<span></span>
				<p class="mt10"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['detail'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</p>
				</li>

			<?php endforeach; endif; unset($_from); ?>
			</ul>
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