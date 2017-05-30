<?php /* Smarty version 2.6.26, created on 2017-05-24 23:22:27
         compiled from calendar/edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'calendar/edit.tpl', 244, false),array('modifier', 'in_array', 'calendar/edit.tpl', 366, false),array('modifier', 'number_format', 'calendar/edit.tpl', 616, false),array('function', 'html_options', 'calendar/edit.tpl', 316, false),array('function', 'html_radios', 'calendar/edit.tpl', 372, false),)), $this); ?>

<?php 
if(isset($_GET['dt'])){
	$dt = $_GET['dt'];	
	$this->assign('dt', $dt);
}
 ?><!-- 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script> -->

<script type="text/javascript">
<!--
<?php echo '
var dirDate = \'\';
var date = \''; ?>
<?php echo $this->_tpl_vars['dt']; ?>
<?php echo '\';
if (date != \'\') {
	var dirDate = "?dt="+date;
}
var path = window.location.pathname;
$(\'.path\').val(path+dirDate);

function winopen(no){
	window.open(\'/member/member_regist/?ref=cal&no=\'+no, \'mywindow\', \'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes\');
}
function winopenSearch(no){
	window.open(\'/reserve/member_search/?ref=cal&no=\'+no, \'mywindow\', \'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes\');
}

function getList(){

	target1 = $("#coupon");
	//$(".category_m_id").remove();
	$("#coupon_id").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/member/getCouponList/",
		cache : false,
		dataType: "text",
		data : {
			p_coupon_id: $("#p_coupon_id").val(),
		},
		success: function(data, dataType) {
			target1.after(data.html);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}



function getList2(no){

	target1 = $("#coupon_"+no);
	//$(".category_m_id").remove();
	$("#coupon_id").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});

	$.ajax({
		type: "POST",
		url: "/member/getCouponList/",
		cache : false,
		dataType: "text",
		data : {
			p_coupon_id: $("#p_coupon_id"+no).val()
		},
		success: function(data, dataType) {
			//console.log(dataType);
			target1.html(data);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


function getBoothList(){

	target2 = $("#rev_booth");
	$("#booth").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "reserve/getBooth/",
		cache : false,
		// dataType: "json",
		data : {
			shop_no: $("#shop_no").val(),
			menu_no: $("#menu_no").val(),
		},
		success: function(data, dataType) {
			target2.after(data.html);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

jQuery(document).ready(function(){
	//$(\'#loader\').hide();
	if($("#shop_no").val()){
		getBoothList();

	}
	var total_absence = '; ?>
<?php echo $this->_tpl_vars['total_absence']; ?>
<?php echo ';
	if (total_absence >= 3) {
		alert("No Show-up for "+total_absence+" times");
	}


	 $("body").append(\'<div class="graylayer"></div>\');
	 $(".graylayer").click(function(){
	  $(this).fadeOut();
	  $(\'.window\').fadeOut();
	 })
	 $(\'#aaa\').click(function(){
	 var secHeight = $(".window").height() *0.5
	 var secWidth = $(".window").width() *0.5
	 var Heightpx = secHeight * -1;
	 var Widthpx = secWidth * -1;
	 $(".graylayer").fadeIn();

	 $(".window").fadeIn().css({
	  "margin-top" : Heightpx + "px" ,
	  "margin-left" : Widthpx + "px"
	 });
	 return false;
	})


});


// var totalwidth = 190 * $(\'.list-group\').length;

// $(\'.scoll-tree\').css(\'width\', totalwidth);

'; ?>

//-->
</script>
<style>
<?php echo '
html,body {
 font-family:Lucida sans , "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", "メイリオ", Meiryo, sans-serif;
 margin: 0;
 padding: 0;
 }
#container{
 width:100px;
 margin:100px auto;
}

.graylayer{
 display:none;
 position: fixed;
 top:0;
 left:0;
 height:100%;
 width:100%;
 background-color: #000;
 opacity:.7;
 filter(alpha=70);
 }
.window{
 padding: 30px 40px;
 display:none;
 position: fixed;
 top: 50%;
 left:50%;
 filter: progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr=#99ffffff,EndColorStr=#99ffffff);
 background-color: rgba(255, 255, 255, 1);
 font-size: 1.1em;
 /*color: #fff;*/
 /*text-shadow:rgba(0,0,0,.8) -1px -1px;*/
 border-radius: 5px;
 z-index: 20;
}

/*.list-group{
   width: 100%;
    float: left;
    margin-left: 10px;
}*/
'; ?>

</style>

</head>

<body>

	<div id="" class="">
		<div class="row ">
		<form action="/reserve/detail/" method="post">
			<div class=" col-md-8 col-sm-6 col-xs-6" style="margin-left:20%;">
			<h1>予約</h1>

			<?php if ($this->_tpl_vars['finish_flg'] == 1): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>


				<div class="tc col-md-12 col-sm-12 col-xs-12">
				<input type="button" class="btn btn-lg" data-dismiss="modal" value="戻る">&nbsp;&nbsp; <!-- onclick="location.href='/calendar/list/<?php echo $this->_tpl_vars['param']; ?>
'" -->
<?php if ($this->_tpl_vars['del_flg'] != 1): ?><!-- 予約削除後は戻るボタンのみ表示 -->
				<input name="submit" type="submit" class="btn btn-lg" value="更新する" >
				<input name="del_submit" type="submit" class="btn btn-lg" value="予約の削除" onClick="return confirm('予約を削除します。複数人で予約している場合は全ての予約を削除します。良いでしょうか？');">
<?php endif; ?>
				</div>
				<br />
				<table class="table table-bordered">
					<tr>
						<td>お名前&nbsp;<span class="label">必須</span></td>
						<td>


						  <?php if ($this->_tpl_vars['db_data']['member_id'] == 0): ?>
						  	<?php if ($this->_tpl_vars['input_data']['member_name']): ?>
						  		<?php echo $this->_tpl_vars['input_data']['member_name']; ?>
　様
						  		<input type="hidden" name="member_id" value="<?php echo $this->_tpl_vars['input_data']['member_id']; ?>
">
						  	<?php endif; ?>
				          	<a href="javascript:void(0);" onClick="winopen('<?php echo $this->_tpl_vars['input_data']['no']; ?>
')" class="btn btn-search">初めての方</a>　/　
				          	<a href="javascript:void(0);" onClick="winopenSearch('<?php echo $this->_tpl_vars['input_data']['no']; ?>
')" class="btn btn-search"><i class="fa fa-search"></i>&nbsp;
				          	会員から検索</a>

				          <?php else: ?>
				          	<?php echo $this->_tpl_vars['memArr']['member_no']; ?>
/<?php if ($this->_tpl_vars['memArr']['name']): ?><?php echo $this->_tpl_vars['memArr']['name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['memArr']['name_kana']; ?>
<?php endif; ?>
				          	(TEL:<?php if ($this->_tpl_vars['memArr']['tel']): ?><?php echo $this->_tpl_vars['memArr']['tel']; ?>
<?php else: ?>-<?php endif; ?>)
				          	<a href="javascript:void();"  id="aaa" class="btn btn-search">顧客情報を見る</a>

				          <?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>予約日時&nbsp;<span class="label">必須</span></td>
						<td>
							<!--<?php echo $this->_tpl_vars['db_data']['reserve_date']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['db_data']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['db_data']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
  -->

				 		<?php if ($this->_tpl_vars['result_messages']['reserve_date']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['reserve_date']; ?>
</span><br />
						selected<?php endif; ?>
				 		<?php if ($this->_tpl_vars['result_messages']['start_time']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['start_time']; ?>
</span><br />
						<?php endif; ?>

						<input class="fieldset__input" type="date" placeholder="クリックして日付を選択" name="reserve_date" value="<?php echo $this->_tpl_vars['input_data']['reserve_date']; ?>
" style="width: 50%;">
						<!-- <input class="fieldset__input js__timepicker timepicker" type="time" placeholder="クリックして時間を選択" name="start_time" value="<?php echo $this->_tpl_vars['input_data']['start_time']; ?>
"> -->

						<select name="start_time" style="width: 50%;">
							<option selected disabled>Select Time</option>
							<option value="10:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:00:00'): ?>selected<?php endif; ?>>10:00:00</option>
							<option value="10:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:15:00'): ?>selected<?php endif; ?>>10:15:00</option>
							<option value="10:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:30:00'): ?>selected<?php endif; ?>>10:30:00</option>
							<option value="10:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:45:00'): ?>selected<?php endif; ?>>10:45:00</option>
							<option value="11:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:00:00'): ?>selected<?php endif; ?>>11:00:00</option>
							<option value="11:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:15:00'): ?>selected<?php endif; ?>>11:15:00</option>
							<option value="11:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:30:00'): ?>selected<?php endif; ?>>11:30:00</option>
							<option value="11:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:45:00'): ?>selected<?php endif; ?>>11:45:00</option>
							<option value="12:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:00:00'): ?>selected<?php endif; ?>>12:00:00</option>
							<option value="12:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:15:00'): ?>selected<?php endif; ?>>12:15:00</option>
							<option value="12:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:30:00'): ?>selected<?php endif; ?>>12:30:00</option>
							<option value="12:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:45:00'): ?>selected<?php endif; ?>>12:45:00</option>
							<option value="13:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:00:00'): ?>selected<?php endif; ?>>13:00:00</option>
							<option value="13:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:15:00'): ?>selected<?php endif; ?>>13:15:00</option>
							<option value="13:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:30:00'): ?>selected<?php endif; ?>>13:30:00</option>
							<option value="13:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:45:00'): ?>selected<?php endif; ?>>13:45:00</option>
							<option value="14:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:00:00'): ?>selected<?php endif; ?>>14:00:00</option>
							<option value="14:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:15:00'): ?>selected<?php endif; ?>>14:15:00</option>
							<option value="14:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:30:00'): ?>selected<?php endif; ?>>14:30:00</option>
							<option value="14:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:45:00'): ?>selected<?php endif; ?>>14:45:00</option>
							<option value="15:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:00:00'): ?>selected<?php endif; ?>>15:00:00</option>
							<option value="15:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:15:00'): ?>selected<?php endif; ?>>15:15:00</option>
							<option value="15:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:30:00'): ?>selected<?php endif; ?>>15:30:00</option>
							<option value="15:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:45:00'): ?>selected<?php endif; ?>>15:45:00</option>
							<option value="16:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:00:00'): ?>selected<?php endif; ?>>16:00:00</option>
							<option value="16:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:15:00'): ?>selected<?php endif; ?>>16:15:00</option>
							<option value="16:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:30:00'): ?>selected<?php endif; ?>>16:30:00</option>
							<option value="16:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:45:00'): ?>selected<?php endif; ?>>16:45:00</option>
							<option value="17:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:00:00'): ?>selected<?php endif; ?>>17:00:00</option>
							<option value="17:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:15:00'): ?>selected<?php endif; ?>>17:15:00</option>
							<option value="17:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:30:00'): ?>selected<?php endif; ?>>17:30:00</option>
							<option value="17:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:45:00'): ?>selected<?php endif; ?>>17:45:00</option>
							<option value="18:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:00:00'): ?>selected<?php endif; ?>>18:00:00</option>
							<option value="18:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:15:00'): ?>selected<?php endif; ?>>18:15:00</option>
							<option value="18:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:30:00'): ?>selected<?php endif; ?>>18:30:00</option>
							<option value="18:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:45:00'): ?>selected<?php endif; ?>>18:45:00</option>
							<option value="19:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:00:00'): ?>selected<?php endif; ?>>19:00:00</option>
							<option value="19:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:15:00'): ?>selected<?php endif; ?>>19:15:00</option>
							<option value="19:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:30:00'): ?>selected<?php endif; ?>>19:30:00</option>
							<option value="19:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:45:00'): ?>selected<?php endif; ?>>19:45:00</option>
							<option value="20:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:00:00'): ?>selected<?php endif; ?>>20:00:00</option>
							<option value="20:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:15:00'): ?>selected<?php endif; ?>>20:15:00</option>
							<option value="20:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:30:00'): ?>selected<?php endif; ?>>20:30:00</option>
							<option value="20:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:45:00'): ?>selected<?php endif; ?>>20:45:00</option>
							<option value="21:00:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:00:00'): ?>selected<?php endif; ?>>21:00:00</option>
							<option value="21:15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:15:00'): ?>selected<?php endif; ?>>21:15:00</option>
							<option value="21:30:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:30:00'): ?>selected<?php endif; ?>>21:30:00</option>
							<option value="21:45:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:45:00'): ?>selected<?php endif; ?>>21:45:00</option>
						</select>

						</td>
					</tr>
					<tr>
						<td>予約店舗名&nbsp;<span class="label">必須</span></td>
						<td>
						<?php echo $this->_tpl_vars['db_data']['shop_name']; ?>

						<input type="hidden" name=shop_no value="<?php echo $this->_tpl_vars['input_data']['shop_no']; ?>
" id="shop_no" >
						<!--
						<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['input_data']['shop_no'],'onChange' => "getBootdList()",'id' => 'shop_no'), $this);?>

						-->
						</td>
					</tr>
					<tr>
						<td>予約人数&nbsp;<span class="label">必須</span></td>
						<td>
							<div id="rev_bootd"></div>


						</td>
					</tr>
					<tr>
						<td>コース名/使用クーポン&nbsp;<span class="label">必須</span></td>
						<td>
							<?php if ($this->_tpl_vars['db_data']['fee_flg'] == 0): ?>
								<?php if ($this->_tpl_vars['courseArr']): ?>
									<?php echo smarty_function_html_options(array('name' => 'buy_no','options' => $this->_tpl_vars['courseArr'],'selected' => $this->_tpl_vars['input_data']['buy_no'],'style' => "width: 80%;"), $this);?>

								<?php else: ?>
									コース未払い
								<?php endif; ?>
							<?php else: ?>
					          	<?php echo $this->_tpl_vars['db_data']['course_name']; ?>
 /
					          	<?php if ($this->_tpl_vars['db_data']['coupon_name']): ?>
					          		<?php echo $this->_tpl_vars['db_data']['coupon_name']; ?>

					          	<?php else: ?>
					          		-
					          	<?php endif; ?>
					        <?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>メニュー名&nbsp;<span class="label">必須</span></td>
						<td>
							<?php echo smarty_function_html_options(array('name' => 'menu_no','options' => $this->_tpl_vars['menuArr'],'selected' => $this->_tpl_vars['input_data']['menu_no'],'id' => 'menu_no','style' => "width: 80%;"), $this);?>


			<!--
				         	<?php if ($this->_tpl_vars['db_data']['menu_name']): ?>
								<?php echo $this->_tpl_vars['db_data']['menu_name']; ?>
(<?php echo $this->_tpl_vars['db_data']['raiten_cnt']; ?>
回)
							<?php else: ?>
								<?php echo smarty_function_html_options(array('name' => 'menu_no','options' => $this->_tpl_vars['menuArr']), $this);?>


							<?php endif; ?>
			-->
						</td>
					</tr>
        			<?php $_from = $this->_tpl_vars['memPayArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			        <tr>
			          <td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
			          <td>
			          <input type="checkbox" name="pay[<?php echo $this->_tpl_vars['item']['id']; ?>
]" value="1" <?php if ($this->_tpl_vars['payArr'] && ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['payArr']) : in_array($_tmp, $this->_tpl_vars['payArr']))): ?>checked<?php endif; ?>   /></td>
			        </tr>
        			<?php endforeach; endif; unset($_from); ?>
			       	<tr>
			          <td>電話確認</td>
			          <td>
			 				<?php echo smarty_function_html_radios(array('name' => 'tel_flg','options' => $this->_tpl_vars['telArr'],'selected' => $this->_tpl_vars['input_data']['tel_flg'],'separator' => ''), $this);?>

			           </td>
			        </tr>
					<tr>
						<td>来店チェック</td>
						<td>
						<input type="radio" name="visit_flg" value="1" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 1): ?>checked<?php endif; ?>  />来店　
						<input type="radio" name="visit_flg" value="99" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 99): ?>checked<?php endif; ?>  />キャンセル　
						<input type="radio" name="visit_flg" value="0" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 0): ?>checked<?php endif; ?>  />予約中
						<input type="radio" name="visit_flg" value="2" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 2): ?>checked<?php endif; ?>  />来店せず
			<!--
						<ul>
						    <li><input type="radio" name="visit_flg" value="1" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 1): ?>checked<?php endif; ?>  />来店</li>
				          	<li><input type="radio" name="visit_flg" value="99" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 99): ?>checked<?php endif; ?>  />キャンセル</li>
				          	<li><input type="radio" name="visit_flg" value="0" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 0): ?>checked<?php endif; ?>  />予約中</li>
						</ul>
			-->
						</td>
					</tr>
			        <tr>
			          <td>担当者</td>
						<td>
						 	<?php echo smarty_function_html_options(array('name' => 'staff_no','options' => $this->_tpl_vars['staffArr'],'selected' => $this->_tpl_vars['input_data']['staff_no'],'style' => "width: 80%;"), $this);?>

						</td>
			        </tr>
			        <tr>
			        	<td>previous state</td>
			        	<td>
			        		<select name="pre_state" style="width: 100%;">
			        			<option>選択してください</option>
			        			<option value="S40" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S40'): ?>selected<?php endif; ?>>S40</option>
			        			<option value="S39" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S39'): ?>selected<?php endif; ?>>S39</option>
			        			<option value="S38" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S38'): ?>selected<?php endif; ?>>S38</option>
			        			<option value="S37" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S37'): ?>selected<?php endif; ?>>S37</option>
			        			<option value="S36" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S36'): ?>selected<?php endif; ?>>S36</option>
			        			<option value="S34" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S35'): ?>selected<?php endif; ?>>S34</option>
			        			<option value="S33" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S34'): ?>selected<?php endif; ?>>S33</option>
			        			<option value="S32" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S33'): ?>selected<?php endif; ?>>S32</option>
			        			<option value="S31" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S32'): ?>selected<?php endif; ?>>S31</option>
			        			<option value="S30" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S31'): ?>selected<?php endif; ?>>S30</option>
			        			<option value="S29" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S30'): ?>selected<?php endif; ?>>S29</option>
			        			<option value="S28" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S29'): ?>selected<?php endif; ?>>S28</option>
			        			<option value="S27" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S28'): ?>selected<?php endif; ?>>S27</option>
			        			<option value="S26" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S27'): ?>selected<?php endif; ?>>S26</option>
			        			<option value="S25" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S26'): ?>selected<?php endif; ?>>S25</option>
			        			<option value="S24" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S25'): ?>selected<?php endif; ?>>S24</option>
			        			<option value="S23" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S24'): ?>selected<?php endif; ?>>S23</option>
			        			<option value="S22" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S23'): ?>selected<?php endif; ?>>S22</option>
			        			<option value="S22" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S22'): ?>selected<?php endif; ?>>S22</option>
			        			<option value="S21" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S21'): ?>selected<?php endif; ?>>S21</option>
			        			<option value="S20" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S20'): ?>selected<?php endif; ?>>S20</option>
			        			<option value="S19" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S19'): ?>selected<?php endif; ?>>S19</option>
			        			<option value="S18" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S18'): ?>selected<?php endif; ?>>S18</option>
			        			<option value="S17" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S17'): ?>selected<?php endif; ?>>S17</option>
			        			<option value="S16" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S16'): ?>selected<?php endif; ?>>S16</option>
			        			<option value="S15" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S15'): ?>selected<?php endif; ?>>S15</option>
			        			<option value="S14" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S14'): ?>selected<?php endif; ?>>S14</option>
			        			<option value="S13" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S13'): ?>selected<?php endif; ?>>S13</option>
			        			<option value="S12" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S12'): ?>selected<?php endif; ?>>S12</option>
			        			<option value="S11" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S11'): ?>selected<?php endif; ?>>S11</option>
			        			<option value="S10" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S10'): ?>selected<?php endif; ?>>S10</option>
			        			<option value="S9" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S9'): ?>selected<?php endif; ?>>S9</option>
			        			<option value="S8" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S8'): ?>selected<?php endif; ?>>S8</option>
			        			<option value="S7" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S7'): ?>selected<?php endif; ?>>S7</option>
			        			<option value="S6" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S6'): ?>selected<?php endif; ?>>S6</option>
			        			<option value="S5" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S5'): ?>selected<?php endif; ?>>S5</option>
			        			<option value="S4" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S4'): ?>selected<?php endif; ?>>S4</option>
			        			<option value="S3" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S3'): ?>selected<?php endif; ?>>S3</option>
			        			<option value="S2" <?php if ($this->_tpl_vars['input_data']['pre_state'] == 'S2'): ?>selected<?php endif; ?>>S2</option>
			        		</select>
			        	</td>
			        </tr>
			        <tr>			        	
			        	<td>Now State</td>
			        	<td>
			        		<select name="now_state" style="width: 100%;">
			        			<option>選択してください</option>
			        			<option value="S40" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S40'): ?>selected<?php endif; ?>>S40</option>
			        			<option value="S39" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S39'): ?>selected<?php endif; ?>>S39</option>
			        			<option value="S38" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S38'): ?>selected<?php endif; ?>>S38</option>
			        			<option value="S37" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S37'): ?>selected<?php endif; ?>>S37</option>
			        			<option value="S36" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S36'): ?>selected<?php endif; ?>>S36</option>
			        			<option value="S34" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S35'): ?>selected<?php endif; ?>>S34</option>
			        			<option value="S33" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S34'): ?>selected<?php endif; ?>>S33</option>
			        			<option value="S32" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S33'): ?>selected<?php endif; ?>>S32</option>
			        			<option value="S31" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S32'): ?>selected<?php endif; ?>>S31</option>
			        			<option value="S30" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S31'): ?>selected<?php endif; ?>>S30</option>
			        			<option value="S29" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S30'): ?>selected<?php endif; ?>>S29</option>
			        			<option value="S28" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S29'): ?>selected<?php endif; ?>>S28</option>
			        			<option value="S27" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S28'): ?>selected<?php endif; ?>>S27</option>
			        			<option value="S26" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S27'): ?>selected<?php endif; ?>>S26</option>
			        			<option value="S25" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S26'): ?>selected<?php endif; ?>>S25</option>
			        			<option value="S24" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S25'): ?>selected<?php endif; ?>>S24</option>
			        			<option value="S23" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S24'): ?>selected<?php endif; ?>>S23</option>
			        			<option value="S22" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S23'): ?>selected<?php endif; ?>>S22</option>
			        			<option value="S22" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S22'): ?>selected<?php endif; ?>>S22</option>
			        			<option value="S21" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S21'): ?>selected<?php endif; ?>>S21</option>
			        			<option value="S20" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S20'): ?>selected<?php endif; ?>>S20</option>
			        			<option value="S19" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S19'): ?>selected<?php endif; ?>>S19</option>
			        			<option value="S18" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S18'): ?>selected<?php endif; ?>>S18</option>
			        			<option value="S17" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S17'): ?>selected<?php endif; ?>>S17</option>
			        			<option value="S16" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S16'): ?>selected<?php endif; ?>>S16</option>
			        			<option value="S15" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S15'): ?>selected<?php endif; ?>>S15</option>
			        			<option value="S14" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S14'): ?>selected<?php endif; ?>>S14</option>
			        			<option value="S13" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S13'): ?>selected<?php endif; ?>>S13</option>
			        			<option value="S12" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S12'): ?>selected<?php endif; ?>>S12</option>
			        			<option value="S11" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S11'): ?>selected<?php endif; ?>>S11</option>
			        			<option value="S10" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S10'): ?>selected<?php endif; ?>>S10</option>
			        			<option value="S9" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S9'): ?>selected<?php endif; ?>>S9</option>
			        			<option value="S8" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S8'): ?>selected<?php endif; ?>>S8</option>
			        			<option value="S7" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S7'): ?>selected<?php endif; ?>>S7</option>
			        			<option value="S6" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S6'): ?>selected<?php endif; ?>>S6</option>
			        			<option value="S5" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S5'): ?>selected<?php endif; ?>>S5</option>
			        			<option value="S4" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S4'): ?>selected<?php endif; ?>>S4</option>
			        			<option value="S3" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S3'): ?>selected<?php endif; ?>>S3</option>
			        			<option value="S2" <?php if ($this->_tpl_vars['input_data']['now_state'] == 'S2'): ?>selected<?php endif; ?>>S2</option>
			        		</select>
			        	</td>
			        </tr>
					<tr>
						<td>管理用備考</td>
						<td><textarea name="kanri_comment" style="width: 80%;"><?php echo $this->_tpl_vars['input_data']['kanri_comment']; ?>
</textarea>
						<br><font size=1>※お客様個人に対してのコメントです。</font>
						</td>
					</tr>
			        <tr>
			          <td>予約時管理用備考</td>
			          <td>
							<?php echo $this->_tpl_vars['input_data']['reserve_kanri_comment']; ?>

							<br><font size=1>※予約を行う際に入力した管理者用の備考コメントです</font>
						</td>
			        </tr>

				</table>

				<div class="tc col-md-12 col-sm-12 col-xs-12">
				<input type="button" class="btn btn-lg" data-dismiss="modal" value="戻る"">&nbsp;&nbsp;<!-- onclick="location.href='/calendar/list/<?php echo $this->_tpl_vars['param']; ?>
' -->
<?php if ($this->_tpl_vars['del_flg'] != 1): ?><!-- 予約削除後は戻るボタンのみ表示 -->
				<input name="submit" type="submit" class="btn btn-lg" value="更新する" >
				<input name="del_submit" type="submit" class="btn btn-lg" value="予約の削除" onClick="return confirm('予約を削除します。複数人で予約している場合は全ての予約を削除します。良いでしょうか？');">
<?php endif; ?>
				</div>
			</div>
        <input type="hidden" name="no" value="<?php echo $this->_tpl_vars['input_data']['no']; ?>
" >
        <input type="hidden" name="ref" value="cal" >
		<input type="hidden" name="dt" value="<?php echo $this->_tpl_vars['dt']; ?>
" >
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->

  <section class="window"><!-- モーダル表示部分 -->
<table class="table">

       <tr>
          <th>現在のコース消費数</th>
          <td>
				<?php $_from = $this->_tpl_vars['memArr']['reserve']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                      	<div class="mb5">
						<?php echo $this->_tpl_vars['item']['name']; ?>
/残<?php echo $this->_tpl_vars['item']['zan']; ?>
回
						</div>
				<?php endforeach; endif; unset($_from); ?>
          </td>
        </tr>
       <tr>
          <th>メールアドレス</th>
          <td>
          <?php echo $this->_tpl_vars['memArr']['email']; ?>

          </td>
        </tr>
		<tr>
			<th>住所</th>
			<td><?php echo $this->_tpl_vars['memArr']['zip']; ?>
<br /><?php echo $this->_tpl_vars['memArr']['address1']; ?>
<?php echo $this->_tpl_vars['memArr']['address2']; ?>
</td>
		</tr>
         <tr>
          <th>性別</th>
          <td>
				<?php if ($this->_tpl_vars['memArr']['sex'] == 1): ?>男性<?php endif; ?>
				<?php if ($this->_tpl_vars['memArr']['sex'] == 2): ?>女性<?php endif; ?>
			</td>
        </tr>
        <tr>
          <th>生年月日</th>
          <td>
          	<?php echo $this->_tpl_vars['memArr']['year']; ?>

            年
            <?php echo $this->_tpl_vars['memArr']['month']; ?>

            月
            <?php echo $this->_tpl_vars['memArr']['day']; ?>

            日
            </td>
        </tr>
        <tr>
          <th>ご紹介者</th>
          <td>
          <?php echo $this->_tpl_vars['memArr']['intro']; ?>

        </tr>
        <tr>
          <th>お客様備考</th>
          <td>
				<?php echo $this->_tpl_vars['memArr']['comment']; ?>

			</td>
        </tr>
         <tr>
          <th>歯磨き粉</th>
          <td>
				<?php if ($this->_tpl_vars['memArr']['tooth_flg'] == 1): ?>１種類<?php endif; ?>
				<?php if ($this->_tpl_vars['memArr']['tooth_flg'] == 2): ?>２種類<?php endif; ?>
			</td>
        </tr>
         <tr>
          <th>管理用備考</th>
          <td>
				<?php echo $this->_tpl_vars['memArr']['kanri_comment']; ?>

			</td>
        </tr>

</table>
  </section>
  <section>
  <form method="post" name="fm_search" action="/member/unpaid">
  	<table class="admins clear mt10 unpaid">
			<tr>
				<th width="100">会員No</th>
				<th width="150">お名前</th>
				<th>購入店舗</th>
				<th>予約メニュー</th>
				<th>ご購入コース料金</th>
				<th>クーポン</th>
				<th>購入</th>
				<th>DB削除</th>

			</tr>

			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['member']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['member']['member_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['member']['name']; ?>
<br /><?php echo $this->_tpl_vars['member']['name_kana']; ?>
<br /><?php echo $this->_tpl_vars['member']['tel']; ?>
</td>
					<td>
							<?php echo $this->_tpl_vars['member']['shop_name']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['member']['menu_name']; ?>

					</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['member']['fee'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
円<br />(<?php echo $this->_tpl_vars['member']['course_name']; ?>
)</td>
				<form method="POST" action="/member/unpaid/">
					<td>
					<select name="p_coupon_id" id=p_coupon_id<?php echo $this->_tpl_vars['key']; ?>
  onChange="getList2('<?php echo $this->_tpl_vars['key']; ?>
')">
			          <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['couPaArr'],'selected' => $this->_tpl_vars['input_data']['coupon_id'],'style' => "width: 80%;"), $this);?>

					</select>
					<input type="hidden" name="path" class="path" id="path" value="">
			          <div id=coupon_<?php echo $this->_tpl_vars['key']; ?>
>
			          </div>

					</td>
					<td class="tc">
							<font size=1>売上計上日</font><br>
							<input type="date" id="start<?php echo $this->_tpl_vars['key']; ?>
" name="buy_date" size="10" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['buy_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>
							<input type="submit" name="submit" value="料金受取済" onClick="return confirm('料金を受け取り済みにします。良いですか？');" class="btn-delete btn-md">
					</td>
					<td class="tc">
							<input type="submit" name="del_submit" value="削除" onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');" class="btn-delete btn-sm">
					</td>
				<input type="hidden" name="buy_no" value="<?php echo $this->_tpl_vars['member']['buy_no']; ?>
">
				</form>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="11">予約済みで未払いの検索該当会員様はいません</td>
				</tr>
			<?php endif; unset($_from); ?>

			</table>
		</form>
  </section>



<!-- date time picker -->
	<!-- <script src="/js/legacy.js"></script>
	<script src="/js/picker.js"></script>
	<script src="/js/picker.date.js"></script> 
	<script src="/js/picker.time.js"></script>
	<script src="/js/ja_JP.js"></script>
	<link href="/css/themes/default.css" rel="stylesheet" type="text/css" />
	<link href="css/themes/default.date.css" rel="stylesheet" id="theme_date">
	<link href="/css/themes/default.time.css" rel="stylesheet" id="theme_time">
	
	<link href="/css/style.css" rel="stylesheet" type="text/css" />
	<link href="/css/calendar-core.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet"> -->
	<script>
	<?php echo '
		// $(\'.datepicker\').pickadate({
		// 	format: \'yyyy/mm/dd\'
		// })
		// $(\'.timepicker\').pickatime({
		// 	　clear: \'消去\',
		// 	 format: \'H:i\',
		// 	 interval: 15,
		// 	 min: [10,0],
  		//   max: [21,15]
		// })


		// $(\'.timepicker\').timepicker();
	'; ?>

	</script>


</body>
</html>