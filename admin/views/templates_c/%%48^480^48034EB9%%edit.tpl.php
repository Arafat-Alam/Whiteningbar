<?php /* Smarty version 2.6.26, created on 2017-03-10 18:51:21
         compiled from reserve/edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'reserve/edit.tpl', 115, false),array('modifier', 'nl2br', 'reserve/edit.tpl', 157, false),array('function', 'html_radios', 'reserve/edit.tpl', 166, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script language="JavaScript">
<!--
<?php echo '
jQuery(document).ready(function(){

	$("#start").datepicker({
		dateFormat: "yy/mm/dd"
	});

	if($("#shop_no").val()){
		getBoothList();
//		getCalendar();

	}
});


	function getBoothList(){

		target1 = $("#rev_start_hour");
		target2 = $("#rev_booth");
		//$(".category_m_id").remove();
		$("#booth").remove();
		$.ajaxSetup({scriptCharset:"utf-8"});
		$.ajax({
			type: "POST",
			url: "/reserve/getBooth/",
			cache : false,
			dataType: "json",
			data : {
				shop_no: $("#shop_no").val(),
			},
			success: function(data, dataType) {
				target1.after(data.time_html);
				target2.after(data.html);

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
<h4>予約申込内容</h4>
		<a href="/reserve/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;予約一覧に戻る</a><br />

			<?php if ($this->_tpl_vars['finish_flg'] == 1): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>

	<div class="clearfix">
		<div class="left w50">
			<h5>お申込み者情報</h5>
				<table class="w100">
				 <tr>
					 <th>お申込者　会員No./お名前</th>
					 <td>
					 <?php echo $this->_tpl_vars['db_memberArr']['member_no']; ?>
/<?php echo $this->_tpl_vars['db_memberArr']['name']; ?>
</td>
				  </tr>
				 <tr>
					 <th>メールアドレス</th>
					 <td>
							<?php echo $this->_tpl_vars['db_memberArr']['email']; ?>

					 </td>
				  </tr>
				 <tr>
					 <th>電話番号</th>
					 <td>
						<?php echo $this->_tpl_vars['db_memberArr']['tel']; ?>

					 </td>
				  </tr>
<!--
				 <tr>
					 <th>担当者</th>
					 <td>
					 <?php echo $this->_tpl_vars['db_memberArr']['tanto']; ?>
</td>
				  </tr>
 -->
				 <tr>
					 <th>コース名 / 使用クーポン</th>
					 <td>
					 <?php echo $this->_tpl_vars['db_courseArr']['name']; ?>
 /
						<?php if ($this->_tpl_vars['db_courseArr']['coupon_name']): ?>
							<?php echo $this->_tpl_vars['db_courseArr']['coupon_name']; ?>

						<?php else: ?>
							-
						<?php endif; ?>
					 </td>
				  </tr>
			</table>
		</div>
		<div class="right ml30 w50">
		<h5>予約内容詳細</h5>

			<table class="w100">
			  <tr>
				 <th>予約日時</th>
				 <td>
					<?php echo $this->_tpl_vars['input_data']['reserve_date']; ?>
 <?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>

				 </td>
			  </tr>

			  <tr>
				 <th>予約店舗名<span class="red">※</span></th>
				 <td>
				<?php echo $this->_tpl_vars['input_data']['shop_name']; ?>

				</td>
			  </tr>
			  <tr>
				 <th>メニュー名<span class="red">※</span></th>
				 <td>
				<?php echo $this->_tpl_vars['input_data']['menu_name']; ?>

				</td>
			  </tr>
			 <tr>
				 <th>予約数<span class="red">※</span></th>
				 <td>
				<?php echo $this->_tpl_vars['input_data']['number']; ?>
人<br />
<!--
				【来店予定者】<br />
				<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
					<?php $_from = $this->_tpl_vars['input_data']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<form action="/reserve/detail/" method="post">
						<input type="submit" value="<?php echo $this->_tpl_vars['item']['name']; ?>
" class="mt10" > <br />
						<input type="hidden" name="member_id" value="<?php echo $this->_tpl_vars['item']['member_id']; ?>
">
						<input type="hidden" name="no" value="<?php echo $this->_tpl_vars['item']['no']; ?>
">
						<input type="hidden" name="reserve_no" value="<?php echo $this->_tpl_vars['input_data']['reserve_no']; ?>
">
						</form>
					<?php endforeach; endif; unset($_from); ?>
				<?php else: ?>
					<?php $_from = $this->_tpl_vars['input_data']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						・<?php echo $this->_tpl_vars['item']['name']; ?>
<br />
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
			  </tr>
  -->
<!--
			  <tr>
				 <th>備考</th>
				 <td>
					<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['comment'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

				</td>
			  </tr>
-->
		<form action="" method="post"  >
<!--
			  <tr>
				 <th>電話</th>
				 <td>
					<?php echo smarty_function_html_radios(array('name' => 'tel_flg','options' => $this->_tpl_vars['telArr'],'selected' => $this->_tpl_vars['input_data']['tel_flg'],'separator' => "<br />"), $this);?>

				</td>
			  </tr>
 -->
			  <tr>
				 <th>管理用備考</th>
				 <td>
					<textarea name="kanri_comment" rows="" cols=""><?php echo $this->_tpl_vars['input_data']['kanri_comment']; ?>
</textarea>
				</td>
			  </tr>
		</table>
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
			<div class="mt20 tc">
			  <input type="submit"  name="submit" value="更新する" />
			  <input type="hidden" name="reserve_no" value="<?php echo $this->_tpl_vars['input_data']['reserve_no']; ?>
" >
			</div>
			</form>
		  <?php endif; ?>
		 </div>
	</div>
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