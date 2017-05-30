<?php /* Smarty version 2.6.26, created on 2017-05-25 20:03:12
         compiled from calendar/reserve.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'calendar/reserve.tpl', 210, false),array('function', 'html_radios', 'calendar/reserve.tpl', 245, false),)), $this); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style type="text/css">
<?php echo '
/*.list-group{
   width: 100%;
    float: left;
    margin-left: 10px;
}*/
 '; ?>

</style>
<script type="text/javascript">
<!--
<?php echo '

function winopens(shop_no){
	window.open(\'/member/member_regist/?ref=calres&shop_no=\'+shop_no, \'mywindow\', \'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes\');
}
function winopensSearch(){

	window.open(\'/reserve/member_search/?ref=calres\', \'mywindow\', \'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes\');
}

function getMenuList(){
	
	target1 = $("#menu");
	target2 = $("#coupon");
	//$(".category_m_id").remove();
	$("#menu_no").remove();
	$("#coupon_name").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList/",
		cache : false,
		dataType: "text",
		data : {
			buy_no: $("#buy_no").val(),
			menu_no: '; ?>
<?php if ($this->_tpl_vars['input_data']['menu_no']): ?><?php echo $this->_tpl_vars['input_data']['menu_no']; ?>
<?php else: ?>0<?php endif; ?><?php echo '
		},
		success: function(data, dataType) {

			target1.after(data.html);
			target2.after(data.html_coupon);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

function getMenuListAll(){

	target1 = $("#menu");
	//$(".category_m_id").remove();
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuListAll/",
		cache : false,
		dataType: "text",
		data : {
			menu_no: '; ?>
<?php if ($this->_tpl_vars['input_data']['menu_no']): ?><?php echo $this->_tpl_vars['input_data']['menu_no']; ?>
<?php else: ?>0<?php endif; ?><?php echo '
		},
		success: function(data, dataType) {
			// console.log(data);
			target1.html(data);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


jQuery(document).ready(function(){
	//$(\'#loader\').hide();
	if($("#buy_no").val()){
		getMenuList();

	}
	else{
		//使用可能な購入コースが無い場合は、メニューから選択

		getMenuListAll();


	}

// var totalwidth = 190 * $(\'.list-group\').length;

// $(\'.scoll-tree\').css(\'width\', totalwidth);

});
'; ?>

//-->
</script>

</head>

<body>
	<div >
		<div class="row" align="center">
		<form action="/calendar/reserve/" method="post">
			<div class="col-md-8 col-sm-6 col-xs-6" style="margin-left:20%;">
			<h1>新規予約</h1>

			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

				<div class="tc col-md-12 col-sm-12 col-xs-12">
					<input type="button" class="btn btn-sm btn-gray" data-dismiss="modal" value="戻る" style="">&nbsp;&nbsp;<!-- onclick="location.href='/calendar/list/<?php echo $this->_tpl_vars['param']; ?>
'" -->
					<input name="submit" type="submit" class="btn btn-sm" value="新規に予約する" style="">
				</div>
				<br />
				<br />
				<table class="table table-bordered" >
					<tr>
						<td>予約店舗名&nbsp;<span class="label">必須</span></td>
						<td>
							<?php if ($this->_tpl_vars['result_messages']['shop_no']): ?><span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['shop_no']; ?>
<br></span><?php endif; ?>
							<?php echo $this->_tpl_vars['shopInfo']['name']; ?>

						</td>
					</tr>

					<tr>
						<td>お名前&nbsp;<span class="label">必須</span></td>
						<td>
							<?php if ($this->_tpl_vars['result_messages']['member_id']): ?><span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['member_id']; ?>
<br></span><?php endif; ?>
							<?php echo $this->_tpl_vars['input_data']['name']; ?>
/<?php echo $this->_tpl_vars['input_data']['name_kana']; ?>
　様
							<input type="hidden" name="member_id" value="<?php echo $this->_tpl_vars['input_data']['member_id']; ?>
" >
				          	<a href="javascript:void(0);" onClick="winopens('<?php echo $this->_tpl_vars['input_data']['shop_no']; ?>
');" class="btn btn-search">初めての方</a>　/　
				          	<a href="javascript:void(0);" onClick="winopensSearch();" class="btn btn-search"><i class="fa fa-search">検索</i>&nbsp;

						</td>
					</tr>
					<tr>
						<td>予約日時&nbsp;<span class="label">必須</span></td>
						<td>
							<?php if ($this->_tpl_vars['result_messages']['hour']): ?><span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['hour']; ?>
<br></span><?php endif; ?>
							<?php if ($this->_tpl_vars['result_messages']['minute']): ?><span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['minute']; ?>
<br></span><?php endif; ?>
<!--
						<input class="fieldset__input js__datepicker datepicker" type="text" placeholder="クリックして日付を選択" name="hour" value="<?php echo $this->_tpl_vars['input_data']['hour']; ?>
" >
						<input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="minute" value="<?php echo $this->_tpl_vars['input_data']['minute']; ?>
" >
 -->
 						<?php echo $this->_tpl_vars['input_data']['reserve_date']; ?>
<br />
						<!-- <input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="start_time" value="<?php echo $this->_tpl_vars['input_data']['start_time']; ?>
"> -->

						<select name="start_time"  style="width: 100%">
							<option selected disabled>Select Time</option>
							<option value="10:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:00'): ?>selected<?php endif; ?>>10:00</option>
							<option value="10:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:15'): ?>selected<?php endif; ?>>10:15</option>
							<option value="10:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:30'): ?>selected<?php endif; ?>>10:30</option>
							<option value="10:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '10:45'): ?>selected<?php endif; ?>>10:45</option>
							<option value="11:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:00'): ?>selected<?php endif; ?>>11:00</option>
							<option value="11:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:15'): ?>selected<?php endif; ?>>11:15</option>
							<option value="11:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:30'): ?>selected<?php endif; ?>>11:30</option>
							<option value="11:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '11:45'): ?>selected<?php endif; ?>>11:45</option>
							<option value="12:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:00'): ?>selected<?php endif; ?>>12:00</option>
							<option value="12:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:15'): ?>selected<?php endif; ?>>12:15</option>
							<option value="12:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:30'): ?>selected<?php endif; ?>>12:30</option>
							<option value="12:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '12:45'): ?>selected<?php endif; ?>>12:45</option>
							<option value="13:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:00'): ?>selected<?php endif; ?>>13:00</option>
							<option value="13:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:15'): ?>selected<?php endif; ?>>13:15</option>
							<option value="13:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:30'): ?>selected<?php endif; ?>>13:30</option>
							<option value="13:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '13:45'): ?>selected<?php endif; ?>>13:45</option>
							<option value="14:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:00'): ?>selected<?php endif; ?>>14:00</option>
							<option value="14:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:15'): ?>selected<?php endif; ?>>14:15</option>
							<option value="14:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:30'): ?>selected<?php endif; ?>>14:30</option>
							<option value="14:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '14:45'): ?>selected<?php endif; ?>>14:45</option>
							<option value="15:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:00'): ?>selected<?php endif; ?>>15:00</option>
							<option value="15:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:15'): ?>selected<?php endif; ?>>15:15</option>
							<option value="15:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:30'): ?>selected<?php endif; ?>>15:30</option>
							<option value="15:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '15:45'): ?>selected<?php endif; ?>>15:45</option>
							<option value="16:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:00'): ?>selected<?php endif; ?>>16:00</option>
							<option value="16:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:15'): ?>selected<?php endif; ?>>16:15</option>
							<option value="16:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:30'): ?>selected<?php endif; ?>>16:30</option>
							<option value="16:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '16:45'): ?>selected<?php endif; ?>>16:45</option>
							<option value="17:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:00'): ?>selected<?php endif; ?>>17:00</option>
							<option value="17:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:15'): ?>selected<?php endif; ?>>17:15</option>
							<option value="17:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:30'): ?>selected<?php endif; ?>>17:30</option>
							<option value="17:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '17:45'): ?>selected<?php endif; ?>>17:45</option>
							<option value="18:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:00'): ?>selected<?php endif; ?>>18:00</option>
							<option value="18:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:15'): ?>selected<?php endif; ?>>18:15</option>
							<option value="18:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:30'): ?>selected<?php endif; ?>>18:30</option>
							<option value="18:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '18:45'): ?>selected<?php endif; ?>>18:45</option>
							<option value="19:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:00'): ?>selected<?php endif; ?>>19:00</option>
							<option value="19:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:15'): ?>selected<?php endif; ?>>19:15</option>
							<option value="19:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:30'): ?>selected<?php endif; ?>>19:30</option>
							<option value="19:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '19:45'): ?>selected<?php endif; ?>>19:45</option>
							<option value="20:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:00'): ?>selected<?php endif; ?>>20:00</option>
							<option value="20:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:15'): ?>selected<?php endif; ?>>20:15</option>
							<option value="20:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:30'): ?>selected<?php endif; ?>>20:30</option>
							<option value="20:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '20:45'): ?>selected<?php endif; ?>>20:45</option>
							<option value="21:00" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:00'): ?>selected<?php endif; ?>>21:00</option>
							<option value="21:15" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:15'): ?>selected<?php endif; ?>>21:15</option>
							<option value="21:30" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:30'): ?>selected<?php endif; ?>>21:30</option>
							<option value="21:45" <?php if ($this->_tpl_vars['input_data']['start_time'] == '21:45'): ?>selected<?php endif; ?>>21:45</option>
						</select>

						</td>
					</tr>
					<tr>
						<td>コース名/使用クーポン&nbsp;<span class="label">必須</span></td>
						<td>
							<?php if ($this->_tpl_vars['result_messages']['buy_no']): ?><span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['buy_no']; ?>
<br></span><?php endif; ?>

							<?php if ($this->_tpl_vars['courseArr']): ?>
								<?php echo smarty_function_html_options(array('name' => 'buy_no','options' => $this->_tpl_vars['courseArr'],'selected' => $this->_tpl_vars['input_data']['buy_no'],'onClick' => "getMenuList()",'id' => 'buy_no','style' => "width: 100%;"), $this);?>

							<?php else: ?>
								<span class="txt-red txt-sm">現在、コース未購入</span>

							<?php endif; ?>
							<br />
							<div id=coupon></div>

						</td>
					</tr>
					<tr>
						<td>メニュー名&nbsp;<span class="label">必須</span></td>
						<td>
							<?php if ($this->_tpl_vars['result_messages']['menu_no']): ?><span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['menu_no']; ?>
<br></span><?php endif; ?>

							<div id=menu></div>

							<?php if ($this->_tpl_vars['courseArr']): ?>
							<br /><span class="txt-red txt-sm">コース購入済みの場合、予約可能なメニューのみが表示されます</span>

							<?php endif; ?>

						</td>
					</tr>
				       <tr>
				          <td>予約数<span class="label">必須</span></td>
				          <td>
							<?php if ($this->_tpl_vars['result_messages']['number']): ?><span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['number']; ?>
<br></span><?php endif; ?>
							<?php echo smarty_function_html_options(array('name' => 'number','options' => $this->_tpl_vars['boothArr'],'selected' => $this->_tpl_vars['input_data']['number'],'id' => 'bootd','style' => "width: 100%;"), $this);?>
人

				        </tr>
		<!--
				        <tr>
				          <td>電話</td>
				          <td>
				         	<?php echo smarty_function_html_radios(array('name' => 'tel_flg','options' => $this->_tpl_vars['telArr'],'selected' => $this->_tpl_vars['input_data']['tel_flg']), $this);?>

				         </td>
				        </tr>
		 -->
		 <!--
				        <tr>
				          <td>備考</td>
				          <td>
								<textarea name="comment" rows="" cols=""><?php echo $this->_tpl_vars['input_data']['comment']; ?>
</textarea>
							</td>
				        </tr>
		-->
				        <tr>
				          <td>管理用備考</td>
				          <td>
								<textarea name="kanri_comment" rows="" cols=""  style="width: 100%"><?php echo $this->_tpl_vars['input_data']['kanri_comment']; ?>
</textarea>
							</td>
				        </tr>
				</table>
				<div class="tc col-md-12 col-sm-12 col-xs-12">
					<input type="button" class="btn btn-sm btn-gray" value="戻る" data-dismiss="modal" style="">&nbsp;&nbsp;<!-- onclick="location.href='/calendar/list/<?php echo $this->_tpl_vars['param']; ?>
'" -->
					<input name="submit" type="submit" class="btn btn-sm" value="新規に予約する" style="width: ">
				</div>
			</div>

			<input type="hidden" name="shop_no" value="<?php echo $this->_tpl_vars['input_data']['shop_no']; ?>
">
			<input type="hidden" name="reserve_date" value="<?php echo $this->_tpl_vars['input_data']['reserve_date']; ?>
">
			<input type="hidden" name="dt" value="<?php echo $this->_tpl_vars['dt']; ?>
" >
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->


<!-- date time picker -->
	

</body>
</html>