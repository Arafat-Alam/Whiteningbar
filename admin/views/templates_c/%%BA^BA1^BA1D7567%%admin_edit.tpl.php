<?php /* Smarty version 2.6.26, created on 2014-08-19 10:59:17
         compiled from reserve/admin_edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'reserve/admin_edit.tpl', 105, false),array('function', 'html_radios', 'reserve/admin_edit.tpl', 142, false),)), $this); ?>
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
		$("#hour").remove();
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
		<h3>顧客一覧</h3>
<h4>予約登録</h4>
		<a href="/member/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;ユーザー一覧へ戻る</a><br />

			<?php if ($this->_tpl_vars['finish_flg'] == 1): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>

<form action="" method="post"  >
      <table class="mt10 center w80">
       <tr>
          <th>会員No./お名前</th>
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
       <tr>
          <th>担当者</th>
          <td>
          <?php echo $this->_tpl_vars['db_memberArr']['tanto']; ?>
</td>
        </tr>
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
        <tr>
          <th>予約可能メニューの選択<span class="red">※</span></th>
          <td>
			<?php echo smarty_function_html_options(array('name' => 'menu_no','options' => $this->_tpl_vars['menuArr'],'selected' => $this->_tpl_vars['input_data']['menu_no']), $this);?>

			<br />※ 会員の購入コースの残り回数が<br />メニューの使用回数に満たない場合は、選択肢に出てきません。
		</td>
        </tr>
        <tr>
          <th>予約店舗選択<span class="red">※</span></th>
          <td>
			<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['input_data']['shop_no'],'onClick' => "getBoothList()",'id' => 'shop_no'), $this);?>

		</td>
        <tr>
          <th>予約日<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['reserve_date']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['reserve_date']; ?>
</span><br />
			<?php endif; ?>
          	<input type="text" name="reserve_date" id="start" value="<?php echo $this->_tpl_vars['input_data']['reserve_date']; ?>
" />
          </td>
        </tr>
        <tr>
          <th>開始時間<span class="red">※</span></th>
          <td>
          	<div id="rev_start_hour"></div>

          	<?php echo smarty_function_html_options(array('name' => 'minute','options' => $this->_tpl_vars['timeArr'],'selected' => $this->_tpl_vars['input_data']['minute']), $this);?>
～
          </td>
        </tr>

        </tr>
       <tr>
          <th>予約数<span class="red">※</span></th>
          <td>
			<div id="rev_booth"></div>

        </tr>
        <tr>
          <th>電話</th>
          <td>
         	<?php echo smarty_function_html_radios(array('name' => 'tel_flg','options' => $this->_tpl_vars['telArr'],'selected' => $this->_tpl_vars['input_data']['tel_flg'],'separator' => "<br />"), $this);?>

         </td>
        </tr>
<!--
        <tr>
          <th>歯ブラシ忘れ</th>
          <td>
          <input type="checkbox" name="tooth_flg" value="1" <?php if ($this->_tpl_vars['input_data']['tooth_flg'] == 1): ?>checked<?php endif; ?>  /></td>
        </tr>
        <tr>
          <th>来店チェック</th>
          <td>
          	<input type="checkbox" name="visit_flg" value="1" <?php if ($this->_tpl_vars['input_data']['visit_flg'] == 1): ?>checked<?php endif; ?>  />
          </td>
        </tr>
        <tr>
          <th>キャンセルチェック</th>
          <td>
          	<input type="checkbox" name="cancel_flg" value="1" <?php if ($this->_tpl_vars['input_data']['cancel_flg'] == 1): ?>checked<?php endif; ?>  />
          </td>
        </tr>
        <tr>
          <th>当日お支払額</th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['fee']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['fee']; ?>
</span><br />
			<?php endif; ?>

          	<input type="text" name="fee" value="<?php echo $this->_tpl_vars['input_data']['fee']; ?>
"  />円
          </td>
        </tr>
  -->

        <tr>
          <th>備考</th>
          <td>
				<textarea name="comment" rows="" cols=""><?php echo $this->_tpl_vars['input_data']['comment']; ?>
</textarea>
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
        <input type="submit"  name="submit" value="登録する" />
        <input type="hidden" name="reserve_no" value="<?php echo $this->_tpl_vars['input_data']['reserve_no']; ?>
" >
        <input type="hidden" name="member_id" value="<?php echo $this->_tpl_vars['member_id']; ?>
" >
        <input type="hidden" name="buy_no" value="<?php echo $this->_tpl_vars['buy_no']; ?>
" >
      </div>
    </div>
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