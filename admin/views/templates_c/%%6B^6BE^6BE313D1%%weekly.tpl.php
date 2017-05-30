<?php /* Smarty version 2.6.26, created on 2017-04-25 14:49:08
         compiled from calendar/weekly.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'calendar/weekly.tpl', 284, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='calendar';
$_SESSION['tab']='weekly';
 ?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "calendar_head_main.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<link rel="stylesheet" type="text/css" href="css/tipsy.css" />
<script type="text/javascript" src="js/jquery.tipsy.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.css">
<!-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
//setTimeout("location.reload()",1000*60);
//-->
</SCRIPT>



<script type="text/javascript">

<?php echo '

function dispReserve(shop_no,hour,minute,reserve_date,dt){

	document.regForm.action = "/calendar/reserve/";
	/*document.regForm.shop_no.value = shop_no;
	document.regForm.hour.value = hour;
	document.regForm.minute.value = minute;
	document.regForm.reserve_date.value = reserve_date;
	document.regForm.dt.value = dt;*/
	$(\'#regFormShopNo\').val(shop_no);
	$(\'#regFormHour\').val(hour);
	$(\'#regFormMinute\').val(minute);
	$(\'#regFormReserveDate\').val(reserve_date);
	$(\'#regFormDt\').val(dt);
	// alert("asdf");

	$(\'#load-data\').empty();
	$(\'#loader1\').show();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/calendar/reserve/",
		cache : false,
		// dataType: "json",
		dataType: "text",
		data : {
			shop_no: shop_no,
			hour: hour,
			minute: minute,
			reserve_date: reserve_date,
			dt: dt
			
		},
		success: function(data, dataType) {
			//console.log(data);
			$(\'#loader1\').hide();
			$(\'#load-data\').html(data);

		},
		error: function(xhr, textStatus, errorThrown) {
			console.log("Error! " + textStatus + " " + errorThrown);
		}
	});

	// document.regForm.submit();


}


function dispDetail(aa,bb,cc){
	//alert(aa+\',\'+bb);
	// $("#re"+aa+\'_\'+bb+\'_\'+cc).show();
	var title = $("#re"+aa+\'_\'+bb+\'_\'+cc).val();
	$("#red"+aa+\'_\'+bb+\'_\'+cc).attr("title",title);

}
function hideDetail(aa,bb,cc){
	//alert(aa+\',\'+bb);
	$("#re"+aa+\'_\'+bb+\'_\'+cc).hide();

}

function nextDetail(no,dt){
	document.regForm.action = "/reserve/detail/";
	/*document.regForm.no.value = no;
	document.regForm.dt.value = dt;
	document.regForm.ref.value = "cal";*/
	$(\'#regFormNo\').val(no);
	$(\'#regFormDt\').val(dt);
	$(\'#regFormRef\').val(\'cal\');
	// alert(no+\',\'+dt);

	$(\'#load-data2\').empty();
	$(\'#loader2\').show();

	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/detail/",
		cache : false,
		// dataType: "json",
		dataType: "text",
		data : {
			no: no,
			dt: dt,
			ref: "cal"
			
		},
		success: function(data, dataType) {
			//console.log(data);
			$(\'#loader2\').hide();
			$(\'#load-data2\').html(data);
			delete data;

		},
		error: function(xhr, textStatus, errorThrown) {
			console.log("Error! " + textStatus + " " + errorThrown);
		}
	});


	// document.regForm.submit();


}



$ (function(){

	$(".tooltip").hide();

	$(".app-preview").mouseout(function(){
		$(".tooltip").hide();
	});
	$(".app-preview").mouseover(function(){
		$(".tooltip").show();
	});

});

'; ?>


</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>

<body class="yui-skin-sam">
	<!-- <div id="wrap"> -->
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
		<div class="content">

		<!-- modal start -->
		 <div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog modal-lg">
			    	
			      <!-- Modal content-->
			      <div class="modal-content" align="center">
			        <div class="modal-header">
			          <button type="button" class="close" id="modalBtn" data-dismiss="modal">&times;</button>
			        </div>
			         	<img src="images/loader.gif" id="loader1" style="height: 80px; width: 80px;">
			        <div class="modal-body" id="load-data" align="center">
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
		<!-- Modal2 start -->
			<div class="modal fade" id="myModal2" role="dialog">
			    <div class="modal-dialog modal-lg">
			    
			      <!-- Modal content-->
			      <div class="modal-content" align="center">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			        </div>
			         	<img src="images/loader.gif" id="loader2" style="height: 80px; width: 80px; display: none;">
			        <div class="modal-body" id="load-data2" align="center">
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
			  <!-- end modal -->




			<div class="content-inner clearfix bg-yellow">

				<div class="app-total">
					<div><img src="images/logo.gif" alt="Whitening Bar ロゴ"></div>
				</div>
			</div>

		<?php $_from = $this->_tpl_vars['arrRsv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aaa'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aaa']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['keyRev'] => $this->_tpl_vars['p_arrRev']):
        $this->_foreach['aaa']['iteration']++;
?>
			<div class="content-inner clear">
			<button onClick="window.close();">閉じる</button>
				<div class="time-table-box clear">
					<h1 class="fl"><?php echo $this->_tpl_vars['v_dateArr'][$this->_tpl_vars['keyRev']]; ?>
</h1>
					<div class="app-daily-total">予約数<span><?php echo $this->_tpl_vars['reseveCountArr'][$this->_tpl_vars['keyRev']]['day']; ?>
</span>件</div>
					<div class="clear">
						<table class="time-table-shop">
							<tr>
								<th>店舗名</th>
								<td>&nbsp;</td>
							</tr>
<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
<?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)1;
$this->_sections['foo']['loop'] = is_array($_loop=$this->_tpl_vars['item']['booth']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
<tr>
<?php if ($this->_sections['foo']['index'] == 1): ?>
<th rowspan="<?php echo $this->_tpl_vars['item']['booth']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</th>
<?php endif; ?>
<td class="num"><?php echo $this->_sections['foo']['index']; ?>
</td>
</tr>
<?php endfor; endif; ?>
<?php endforeach; endif; unset($_from); ?>
</table>
	<form action="" method="post" name="regForm">
	<input type="hidden" name="no" value="" id="regFormNo" />
	<input type="hidden" name="ref" value="" id="regFormRef"/>

	<input type="hidden" name="shop_no" value="" id="regFormShopNo"/>
	<input type="hidden" name="hour" value="" id="regFormHour"/>
	<input type="hidden" name="minute" value="" id="regFormMinute"/>
	<input type="hidden" name="reserve_date" value="" id="regFormReserveDate"/>

	<input type="hidden" name="dt" value="" id="regFormDt"/>
						<div class="table-container">
							<table class="time-table-app">
								<tr>
									<th>10</th>
									<th>11</th>
									<th>12</th>
									<th>13</th>
									<th>14</th>
									<th>15</th>
									<th>16</th>
									<th>17</th>
									<th>18</th>
									<th>19</th>
									<th>20</th>
									<th>21</th>
								</tr>

								<?php $_from = $this->_tpl_vars['p_arrRev']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
									<?php $_from = $this->_tpl_vars['item']['rsv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['rsv']):
?>
									<tr>
									<?php unset($this->_sections['foo']);
$this->_sections['foo']['name'] = 'foo';
$this->_sections['foo']['start'] = (int)10;
$this->_sections['foo']['loop'] = is_array($_loop=22) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['foo']['show'] = true;
$this->_sections['foo']['max'] = $this->_sections['foo']['loop'];
$this->_sections['foo']['step'] = 1;
if ($this->_sections['foo']['start'] < 0)
    $this->_sections['foo']['start'] = max($this->_sections['foo']['step'] > 0 ? 0 : -1, $this->_sections['foo']['loop'] + $this->_sections['foo']['start']);
else
    $this->_sections['foo']['start'] = min($this->_sections['foo']['start'], $this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] : $this->_sections['foo']['loop']-1);
if ($this->_sections['foo']['show']) {
    $this->_sections['foo']['total'] = min(ceil(($this->_sections['foo']['step'] > 0 ? $this->_sections['foo']['loop'] - $this->_sections['foo']['start'] : $this->_sections['foo']['start']+1)/abs($this->_sections['foo']['step'])), $this->_sections['foo']['max']);
    if ($this->_sections['foo']['total'] == 0)
        $this->_sections['foo']['show'] = false;
} else
    $this->_sections['foo']['total'] = 0;
if ($this->_sections['foo']['show']):

            for ($this->_sections['foo']['index'] = $this->_sections['foo']['start'], $this->_sections['foo']['iteration'] = 1;
                 $this->_sections['foo']['iteration'] <= $this->_sections['foo']['total'];
                 $this->_sections['foo']['index'] += $this->_sections['foo']['step'], $this->_sections['foo']['iteration']++):
$this->_sections['foo']['rownum'] = $this->_sections['foo']['iteration'];
$this->_sections['foo']['index_prev'] = $this->_sections['foo']['index'] - $this->_sections['foo']['step'];
$this->_sections['foo']['index_next'] = $this->_sections['foo']['index'] + $this->_sections['foo']['step'];
$this->_sections['foo']['first']      = ($this->_sections['foo']['iteration'] == 1);
$this->_sections['foo']['last']       = ($this->_sections['foo']['iteration'] == $this->_sections['foo']['total']);
?>
										<?php $this->assign('ji', $this->_sections['foo']['index']); ?>
										<td>
										<span style="color: black;" data-toggle="modal" data-target="#myModal">
										<div class="quad" onClick="dispReserve('<?php echo $this->_tpl_vars['item']['shop_no']; ?>
','<?php echo $this->_tpl_vars['ji']; ?>
','00','<?php echo $this->_tpl_vars['reserve_date'][$this->_tpl_vars['keyRev']]; ?>
','<?php echo $this->_tpl_vars['item']['dt']; ?>
');"></div><div class="quad" onClick="dispReserve('<?php echo $this->_tpl_vars['item']['shop_no']; ?>
','<?php echo $this->_tpl_vars['ji']; ?>
','00','<?php echo $this->_tpl_vars['reserve_date'][$this->_tpl_vars['keyRev']]; ?>
','<?php echo $this->_tpl_vars['item']['dt']; ?>
');"> </div><div class="quad" onClick="dispReserve('<?php echo $this->_tpl_vars['item']['shop_no']; ?>
','<?php echo $this->_tpl_vars['ji']; ?>
','00','<?php echo $this->_tpl_vars['reserve_date'][$this->_tpl_vars['keyRev']]; ?>
','<?php echo $this->_tpl_vars['item']['dt']; ?>
');"> </div><div class="quad" onClick="dispReserve('<?php echo $this->_tpl_vars['item']['shop_no']; ?>
','<?php echo $this->_tpl_vars['ji']; ?>
','00','<?php echo $this->_tpl_vars['reserve_date'][$this->_tpl_vars['keyRev']]; ?>
','<?php echo $this->_tpl_vars['item']['dt']; ?>
');"> </div>
										</span>

											<?php $_from = $this->_tpl_vars['rsv'][$this->_tpl_vars['ji']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bango'] => $this->_tpl_vars['jjj']):
?>
											<?php if (isset ( $this->_tpl_vars['jjj']['no'] )): ?>
											<span style="color: black;" data-toggle="modal" data-target="#myModal2">
												<div id="red<?php echo $this->_tpl_vars['jjj']['no']; ?>
_<?php echo $this->_tpl_vars['ji']; ?>
_<?php echo $this->_tpl_vars['item']['shop_no']; ?>
" onclick="nextDetail(<?php echo $this->_tpl_vars['jjj']['no']; ?>
,'<?php echo $this->_tpl_vars['item']['dt']; ?>
');" onmouseover="dispDetail(<?php echo $this->_tpl_vars['jjj']['no']; ?>
,<?php echo $this->_tpl_vars['ji']; ?>
,<?php echo $this->_tpl_vars['item']['shop_no']; ?>
);" onmouseout="hideDetail(<?php echo $this->_tpl_vars['jjj']['no']; ?>
,<?php echo $this->_tpl_vars['ji']; ?>
,<?php echo $this->_tpl_vars['item']['shop_no']; ?>
);" class="app-preview type<?php echo $this->_tpl_vars['jjj']['rsv_type']; ?>
" style="left:<?php echo $this->_tpl_vars['jjj']['px']; ?>
%;background-color : <?php echo $this->_tpl_vars['jjj']['bg']; ?>
" >
													<p>
														
														<?php echo ((is_array($_tmp=$this->_tpl_vars['jjj']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
<br><span class="bold"><?php if (isset ( $this->_tpl_vars['jjj']['name'] )): ?><?php echo $this->_tpl_vars['jjj']['name']; ?>
<?php if (isset ( $this->_tpl_vars['jjj']['name_kana'] )): ?>(<?php echo $this->_tpl_vars['jjj']['name_kana']; ?>
)<?php endif; ?>様<?php endif; ?><?php if ($this->_tpl_vars['jjj']['numb'] > 1): ?>(<?php echo $this->_tpl_vars['jjj']['numb']; ?>
)<?php endif; ?></span><br><?php echo $this->_tpl_vars['jjj']['menu_name']; ?>


													</p>
												</div>
											</span>
<textarea style="display: none;" id="re<?php echo $this->_tpl_vars['jjj']['no']; ?>
_<?php echo $this->_tpl_vars['ji']; ?>
_<?php echo $this->_tpl_vars['item']['shop_no']; ?>
">
予約時間 : <?php echo ((is_array($_tmp=$this->_tpl_vars['jjj']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>

お名前	  : <?php if (isset ( $this->_tpl_vars['jjj']['name'] )): ?><?php echo $this->_tpl_vars['jjj']['name']; ?>
<?php if (isset ( $this->_tpl_vars['jjj']['name_kana'] )): ?>(<?php echo $this->_tpl_vars['jjj']['name_kana']; ?>
)<?php endif; ?>様<?php endif; ?>

お電話番号 : <?php if (isset ( $this->_tpl_vars['jjj']['tel'] )): ?><?php echo $this->_tpl_vars['jjj']['tel']; ?>
<?php endif; ?>

メニュー : <?php if (isset ( $this->_tpl_vars['jjj']['menu_name'] )): ?><?php echo $this->_tpl_vars['jjj']['menu_name']; ?>
<?php endif; ?>

予約番号 : <?php echo $this->_tpl_vars['jjj']['reserve_no']; ?>
</textarea>
											<?php endif; ?>
											<?php endforeach; endif; unset($_from); ?>
										</td>
									<?php endfor; endif; ?>

									</tr>
									<?php endforeach; endif; unset($_from); ?>
								<?php endforeach; endif; unset($_from); ?>
							</table>
						</div>
						</form>
					</div>
				</div><!-- / .time-table-box -->
			</div><!-- / .content-inner -->
			<?php endforeach; endif; unset($_from); ?>



		</div><!-- / .content -->
		<div id="push"></div>
	</div><!-- / #wrap -->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "calendar_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


</body>
</html>