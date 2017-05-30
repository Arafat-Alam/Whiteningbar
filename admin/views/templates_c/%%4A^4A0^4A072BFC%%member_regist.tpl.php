<?php /* Smarty version 2.6.26, created on 2017-03-14 21:34:30
         compiled from calendar/member_regist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'calendar/member_regist.tpl', 153, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "calendar_head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>

<script language="JavaScript">
<!--
<?php echo '

function clearSearchForm() {
	$("#shop_no").val("");

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
			coupon_id:'; ?>
<?php if ($this->_tpl_vars['input_data']['coupon_id']): ?><?php echo $this->_tpl_vars['input_data']['coupon_id']; ?>
<?php else: ?>0<?php endif; ?><?php echo '
		},
		success: function(data, dataType) {
			target1.after(data.html);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

jQuery(document).ready(function(){

	if($("#p_coupon_id").val()){
		getList();

	}
});

function setOpener(){
	window.opener.location.href="/reserve/detail/?ref=cal&no='; ?>
<?php echo $this->_tpl_vars['no']; ?>
<?php echo '";
	window.close();
}
function setOpener2(){
	window.opener.location.href="/calendar/reserve/?back";

	window.close();
}


'; ?>

</script>
<body <?php echo $this->_tpl_vars['onl']; ?>
>

	<div id="wrap">
		<div class="content content-form">
		<form action="" method="post"  >
			<div class="content-inner">
			<h1>新規会員登録</h1>
			<?php if ($this->_tpl_vars['finish_flg'] == 1): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

			<?php endif; ?>

				<?php if ($this->_tpl_vars['result_messages']): ?>
					<?php $_from = $this->_tpl_vars['result_messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<p class="txt-red mt5"><?php echo $this->_tpl_vars['item']; ?>
</p>
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>


<button onClick="window.close();" class="btn btn-gray btn-sm">閉じる</button><br/>


				<div class="tc">
					<input name="submit" type="submit" class="btn btn-lg" value="登録">
				</div>
<div class="tc mt25">
</div>

				<table class="table new-app">
					<tr>
						<th>メールアドレス&nbsp;</th>
						<td>
					 		<?php if ($this->_tpl_vars['result_messages']['email']): ?>
								<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['email']; ?>
</span><br />
							<?php endif; ?>
						<input name="email" value="<?php echo $this->_tpl_vars['input_data']['email']; ?>
" type="text" class="form-lg">
						</td>
					</tr>
					<tr>
						<th>パスワード&nbsp;</th>
						<td>
					 		<?php if ($this->_tpl_vars['result_messages']['password']): ?>
								<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['password']; ?>
</span><br />
							<?php endif; ?>

						<input name="password" value="<?php echo $this->_tpl_vars['input_data']['password']; ?>
"  type="password"><br><span class="txt-sm"> 6桁以上の半角英数</span></td>
					</tr>
					<tr>
						<th>お名前&nbsp;<span class="label">必須</span></th>
						<td>
				 		<?php if ($this->_tpl_vars['result_messages']['name']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['name']; ?>
</span><br />
						<?php endif; ?>

						<input name="name" value="<?php echo $this->_tpl_vars['input_data']['name']; ?>
"  type="text"></td>
					</tr>
					<tr>
						<th>ふりがな&nbsp;</th>
						<td>
				 		<?php if ($this->_tpl_vars['result_messages']['name_kana']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['name_kana']; ?>
</span><br />
						<?php endif; ?>

						<input name="name_kana" value="<?php echo $this->_tpl_vars['input_data']['name_kana']; ?>
"  type="text"></td>
					</tr>
					<tr>
						<th>電話番号&nbsp;</th>
						<td>
				 		<?php if ($this->_tpl_vars['result_messages']['tel']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['tel']; ?>
</span><br />
						<?php endif; ?>

						<input name="tel" value="<?php echo $this->_tpl_vars['input_data']['tel']; ?>
"  type="text"></td>
					</tr>
			        <tr>
			          <th>郵便番号</th>
			          <td>
				 		<?php if ($this->_tpl_vars['result_messages']['zip']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['zip']; ?>
</span><br />
						<?php endif; ?>
			          <input type="text" id="zip" name="zip" value="<?php echo $this->_tpl_vars['input_data']['zip']; ?>
"  class="form-sm" />
			          【住所自動入力】<br />
			          郵番を入力すると、住所の一部が自動入力されます。<br />ハイフン有無、半角・全角、どれでも入力可能です。
			          <br />入力履歴では自動入力が出来ませんのでご注意ください。

			        </td>
			        </tr>
			        <tr>
			          <th>都道府県</th>
			          <td>
				 		<?php if ($this->_tpl_vars['result_messages']['pref']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['pref']; ?>
</span><br />
						<?php endif; ?>

						<?php echo smarty_function_html_options(array('name' => 'pref','options' => $this->_tpl_vars['prefArr'],'selected' => $this->_tpl_vars['input_data']['pref'],'id' => 'pref'), $this);?>

					</td>
			        </tr>
			        <tr>
			          <th>市区町村・番地</th>
			          <td>
				 		<?php if ($this->_tpl_vars['result_messages']['address1']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['address1']; ?>
</span><br />
						<?php endif; ?>

			          <input type="text" id="city" name="address1" value="<?php echo $this->_tpl_vars['input_data']['address1']; ?>
"  class="form-lg mt5" /></td>
			        </tr>
			        <tr>
			          <th>建物名</th>
			          <td>
				 		<?php if ($this->_tpl_vars['result_messages']['address2']): ?>
							<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['address2']; ?>
</span><br />
						<?php endif; ?>

			          <input type="text" name="address2" value="<?php echo $this->_tpl_vars['input_data']['address2']; ?>
"  class="form-lg mt5" /></td>
			        </tr>
					<tr>
						<th>性別&nbsp;</th>
						<td>
					 		<?php if ($this->_tpl_vars['result_messages']['sex']): ?>
								<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['result_messages']['sex']; ?>
</span><br />
							<?php endif; ?>
								<input type="radio"  name="sex" value="1" <?php if ($this->_tpl_vars['input_data']['sex'] == 1): ?>checked<?php endif; ?> />男性
								<input type="radio"  name="sex" value="2" <?php if ($this->_tpl_vars['input_data']['sex'] == 2): ?>checked<?php endif; ?> />女性
						</td>
					</tr>
					<tr>
						<th>生年月日&nbsp;</th>
						<td>

				          	<?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['yearArr'],'selected' => $this->_tpl_vars['input_data']['year'],'class' => "form-sm"), $this);?>

				            年
				            <?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['monthArr'],'selected' => $this->_tpl_vars['input_data']['month'],'class' => "mt5 form-sm"), $this);?>

				            月
				            <?php echo smarty_function_html_options(array('name' => 'day','options' => $this->_tpl_vars['dayArr'],'selected' => $this->_tpl_vars['input_data']['day'],'class' => "mt5 form-sm"), $this);?>

				            日

						</td>
					</tr>
			        <tr>
			          <th>ご紹介者</th>
			          <td>
			          <input type="text" name="intro" value="<?php echo $this->_tpl_vars['input_data']['intro']; ?>
"  class="form-lg mt5" /></td>
			        </tr>
					<tr>
						<th>備考</th>
						<td><textarea name="comment" rows="" cols=""><?php echo $this->_tpl_vars['input_data']['comment']; ?>
</textarea></td>
					</tr>
				</table>


<h2>その他管理用情報</h2>
 	<table class="table new-app">
	       <tr>
	          <th>コース購入</th>
	      	<td>
	          <?php echo smarty_function_html_options(array('name' => 'course_no','options' => $this->_tpl_vars['courseArr2'],'selected' => $this->_tpl_vars['input_data']['course_no'],'id' => 'course'), $this);?>

	      	</td>
	      </tr>
	       <tr>
	          <th>クーポン</th>
	      	<td>
	          <?php echo smarty_function_html_options(array('name' => 'p_coupon_id','options' => $this->_tpl_vars['couPaArr'],'selected' => $this->_tpl_vars['input_data']['p_coupon_id'],'id' => 'p_coupon_id','onChange' => "getList()"), $this);?>

	          <div id=coupon></div>
	      	</td>
	      </tr>
          <tr>
          <th>歯磨き粉</th>
          <td>
				<label><input type="radio"  name="tooth_flg" value="1" <?php if ($this->_tpl_vars['input_data']['tooth_flg'] == 1): ?>checked<?php endif; ?> />１種類</label>
				<label><input type="radio"  name="tooth_flg" value="2" <?php if ($this->_tpl_vars['input_data']['tooth_flg'] == 2): ?>checked<?php endif; ?> />２種類</label>
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


				<div class="tc mt35">
					<input name="submit" type="submit" class="btn btn-lg" value="登録">
				</div>
			</div>

			<input type="hidden" name="spid" value="<?php echo $this->_tpl_vars['input_data']['shop_no']; ?>
">
			<input type="hidden" name="shop_no" value="<?php echo $this->_tpl_vars['input_data']['shop_no']; ?>
">
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "calendar_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>