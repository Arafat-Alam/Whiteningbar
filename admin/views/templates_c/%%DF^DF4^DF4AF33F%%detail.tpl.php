<?php /* Smarty version 2.6.26, created on 2014-08-19 21:53:47
         compiled from reserve/detail.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'reserve/detail.tpl', 79, false),array('modifier', 'in_array', 'reserve/detail.tpl', 137, false),array('function', 'html_options', 'reserve/detail.tpl', 95, false),array('function', 'html_radios', 'reserve/detail.tpl', 144, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!-- date time picker -->
<link href="/css/themes/default.css" rel="stylesheet" type="text/css" />
<link href="/css/themes/default.date.css" rel="stylesheet" id="theme_date">
<link href="/css/themes/default.time.css" rel="stylesheet" id="theme_time">

<script type="text/javascript">
<!--
<?php echo '

function winopn(no){
	window.open(\'/member/member_regist/?no=\'+no, \'mywindow2\', \'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes\');
}
function winopnSearch(no){
	window.open(\'/reserve/member_search/?no=\'+no, \'mywindow2\', \'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes\');
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
		dataType: "json",
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

'; ?>

//-->
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
$this->_smarty_include(array('smarty_include_tpl_file' => "reserve/menu_reserve.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>予約管理</h3>
<h4>予約 来店詳細</h4>
<div class="w50 center">
		<a href="/reserve/edit/?reserve_no=<?php echo $this->_tpl_vars['input_data']['reserve_no']; ?>
" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;予約申込内容に戻る</a><br />
			<?php if ($this->_tpl_vars['finish_flg'] == 1): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>

<form action="" method="post"  >
<h5>予約来店者情報</h5>
      <table class="w100">
       <tr>
          <th>お名前</th>
          <td>
          <?php if ($this->_tpl_vars['db_data']['member_id'] == 0): ?>
          	<a href="javascript:void(0);" onClick="winopn('<?php echo $this->_tpl_vars['input_data']['no']; ?>
')" class="btn">初めての方</a>&nbsp;　
          	<a href="javascript:void(0);" onClick="winopnSearch('<?php echo $this->_tpl_vars['input_data']['no']; ?>
')" class="btn">会員から検索</a>

          <?php else: ?>
          	<a href="/member/edit/?member_id=<?php echo $this->_tpl_vars['memArr']['member_id']; ?>
"><?php echo $this->_tpl_vars['memArr']['member_no']; ?>
/<?php echo $this->_tpl_vars['memArr']['name']; ?>
</a>
          <?php endif; ?>

          </td>
        </tr>
        <tr>
          <th>予約日時</th>
          <td>
							<!--<?php echo $this->_tpl_vars['db_data']['reserve_date']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['db_data']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['db_data']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
  -->
	 		<?php if ($this->_tpl_vars['result_messages']['reserve_date']): ?>
				<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['reserve_date']; ?>
</span><br />
			<?php endif; ?>
	 		<?php if ($this->_tpl_vars['result_messages']['start_time']): ?>
				<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['start_time']; ?>
</span><br />
			<?php endif; ?>

						<input class="fieldset__input js__datepicker datepicker" type="text" placeholder="クリックして日付を選択" name="reserve_date" value="<?php echo $this->_tpl_vars['input_data']['reserve_date']; ?>
">
						<input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="start_time" value="<?php echo $this->_tpl_vars['input_data']['start_time']; ?>
">
          </td>
        </tr>
        <tr>
          <th>予約店舗名</th>
          <td>
						<!-- <?php echo $this->_tpl_vars['db_data']['shop_name']; ?>
 -->
						<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['input_data']['shop_no']), $this);?>

		</td>
        </tr>
       <tr>
          <th>コース名 / 使用クーポン</th>
          <td>
          	<?php echo $this->_tpl_vars['db_data']['course_name']; ?>
 /
          	<?php if ($this->_tpl_vars['db_data']['coupon_name']): ?>
          		<?php echo $this->_tpl_vars['db_data']['coupon_name']; ?>

          	<?php else: ?>
          		-
          	<?php endif; ?>
          </td>
        </tr>
         <?php if ($this->_tpl_vars['db_data']['fee_flg'] == 0): ?>
<!--
        <tr>
          <th>コース料金支払チェック</th>
          <td>
          <input type="checkbox" name="fee_flg" value="1"   /><br />初回ご来店時<br />コース料金の支払が済んだ場合にチェックしてください<br />
	          <?php echo smarty_function_html_options(array('name' => 'p_coupon_id','options' => $this->_tpl_vars['couPaArr'],'selected' => $this->_tpl_vars['input_data']['p_coupon_id'],'id' => 'p_coupon_id','onChange' => "getList()"), $this);?>

	          <div id=coupon></div>
          </td>
        </tr>
 -->
          <?php endif; ?>

        <tr>
          <th>メニュー名</th>
          <td>
          	<?php if ($this->_tpl_vars['db_data']['menu_name']): ?>
				<?php echo $this->_tpl_vars['db_data']['menu_name']; ?>
(<?php echo $this->_tpl_vars['db_data']['raiten_cnt']; ?>
回)
			<?php else: ?>
				<?php echo smarty_function_html_options(array('name' => 'menu_no','options' => $this->_tpl_vars['menuArr']), $this);?>


			<?php endif; ?>
		</td>
        </tr>
        <?php $_from = $this->_tpl_vars['memPayArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
          <tr>
          <th><?php echo $this->_tpl_vars['item']['name']; ?>
</th>
          <td>
          <input type="checkbox" name="pay[<?php echo $this->_tpl_vars['item']['id']; ?>
]" value="1" <?php if ($this->_tpl_vars['payArr'] && ((is_array($_tmp=$this->_tpl_vars['item']['id'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['payArr']) : in_array($_tmp, $this->_tpl_vars['payArr']))): ?>checked<?php endif; ?>  /></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>

       <tr>
          <th>電話確認</th>
          <td>
 				<?php echo smarty_function_html_radios(array('name' => 'tel_flg','options' => $this->_tpl_vars['telArr'],'selected' => $this->_tpl_vars['input_data']['tel_flg']), $this);?>

           </td>
        </tr>

        <tr>
          <th>来店チェック</th>
          <td>
           	<label><input type="radio" name="visit_flg" value="1" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 1): ?>checked<?php endif; ?>  />来店</label>
          	<label><input type="radio" name="visit_flg" value="99" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 99): ?>checked<?php endif; ?>  />キャンセル</label>
          	<label><input type="radio" name="visit_flg" value="0" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 0): ?>checked<?php endif; ?>  />予約中</label>
          </td>
        </tr>
        <tr>
          <th>担当者</th>
			<td>
			 	<?php echo smarty_function_html_options(array('name' => 'staff_no','options' => $this->_tpl_vars['staffArr'],'selected' => $this->_tpl_vars['input_data']['staff_no']), $this);?>

			</td>
        </tr>

        <tr>
          <th>管理用備考</th>
          <td>
				<textarea name="kanri_comment" rows="" cols=""><?php echo $this->_tpl_vars['input_data']['kanri_comment']; ?>
</textarea>
			</td>
        </tr>

	</table>
      <div class="mt20 tc">
        <input type="submit"  name="submit" value="更新する" class="btn-lg" />
        <input type="hidden" name="reserve_no" value="<?php echo $this->_tpl_vars['input_data']['reserve_no']; ?>
" >
        <input type="hidden" name="no" value="<?php echo $this->_tpl_vars['input_data']['no']; ?>
" >
        <?php if ($this->_tpl_vars['db_data']['menu_name']): ?>
        	<input type="hidden" name="menu_no" value="<?php echo $this->_tpl_vars['input_data']['menu_no']; ?>
" >
		<?php endif; ?>
      </div>
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
   		 max: [20,15]
		})
	'; ?>

	</script>

</body>
</html>