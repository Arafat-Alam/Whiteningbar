<?php /* Smarty version 2.6.26, created on 2017-03-10 18:43:06
         compiled from reserve/member_regist.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'reserve/member_regist.tpl', 66, false),array('function', 'html_radios', 'reserve/member_regist.tpl', 204, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
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
		},
		success: function(data, dataType) {
			target1.after(data.html);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

function setOpener(){


//	window.opener.location.reload();
	window.opener.location.href="/reserve/detail/?no='; ?>
<?php echo $this->_tpl_vars['no']; ?>
<?php echo '";
	window.close();

}

'; ?>

//-->
</script>

<body <?php echo $this->_tpl_vars['onl']; ?>
>
<div id="wrapper">
	<div id="main_content">
	<button onClick="window.close();">閉じる</button>
		<h4>顧客登録</h4>
			<?php if ($this->_tpl_vars['finish_flg'] == 1): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
			<?php endif; ?>
<form action="" method="post"  >
<div class="clearfix">
	<div class="left w50">
      <table class="w100">
<!--
        <tr>
          <th>顧客店舗選択<span class="red">※</span></th>
          <td>
			<?php echo smarty_function_html_options(array('name' => 'spid','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['input_data']['spid']), $this);?>

			<br />顧客の店舗を選択してください。顧客の会員番号に頭に付加されます。
		</td>
        </tr>
  -->
        <tr>
       <tr>
          <th>メールアドレス(ログインID)<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['email']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['email']; ?>
</span><br />
			<?php endif; ?>
          <input type="text" name="email" value="<?php echo $this->_tpl_vars['input_data']['email']; ?>
"  /></td>
        </tr>
       <tr>
          <th>パスワード<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['password']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['password']; ?>
</span><br />
			<?php endif; ?>
          <input type="password" name="password" value="<?php echo $this->_tpl_vars['input_data']['password']; ?>
"  />
          6桁以上の半角英数
          </td>
        </tr>
        <tr>
          <th>お名前<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['name']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['name']; ?>
</span><br />
			<?php endif; ?>
          <input type="text" name="name" value="<?php echo $this->_tpl_vars['input_data']['name']; ?>
"  /></td>
        </tr>
       <tr>
          <th>フリガナ<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['name_kana']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['name_kana']; ?>
</span><br />
			<?php endif; ?>
          <input type="text" name="name_kana" value="<?php echo $this->_tpl_vars['input_data']['name_kana']; ?>
"  /></td>
        </tr>
        <tr>
          <th>電話番号<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['tel']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['tel']; ?>
</span><br />
			<?php endif; ?>

          <input type="text" name="tel" value="<?php echo $this->_tpl_vars['input_data']['tel']; ?>
" /></td>
        </tr>
        <tr>
          <th>郵便番号<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['zip']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['zip']; ?>
</span><br />
			<?php endif; ?>
          <input type="text" id="zip" name="zip" value="<?php echo $this->_tpl_vars['input_data']['zip']; ?>
"  />
          【住所自動入力】<br />
          郵番を入力すると、住所の一部が自動入力されます。<br />ハイフン有無、半角・全角、どれでも入力可能です。
          <br />入力履歴では自動入力が出来ませんのでご注意ください。

        </td>
        </tr>
        <tr>
          <th>都道府県<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['pref']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['pref']; ?>
</span><br />
			<?php endif; ?>

			<?php echo smarty_function_html_options(array('name' => 'pref','options' => $this->_tpl_vars['prefArr'],'selected' => $this->_tpl_vars['input_data']['pref'],'id' => 'pref'), $this);?>

		</td>
        </tr>
        <tr>
          <th>市区町村・番地<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['address1']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['address1']; ?>
</span><br />
			<?php endif; ?>

          <input type="text" id="city" name="address1" value="<?php echo $this->_tpl_vars['input_data']['address1']; ?>
"  /></td>
        </tr>
        <tr>
          <th>建物名等</th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['address2']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['address2']; ?>
</span><br />
			<?php endif; ?>

          <input type="text" name="address2" value="<?php echo $this->_tpl_vars['input_data']['address2']; ?>
"  /></td>
        </tr>
         <tr>
          <th>性別<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['sex']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['sex']; ?>
</span><br />
			<?php endif; ?>
				<input type="radio"  name="sex" value="1" <?php if ($this->_tpl_vars['input_data']['sex'] == 1): ?>checked<?php endif; ?> />男性
				<input type="radio"  name="sex" value="2" <?php if ($this->_tpl_vars['input_data']['sex'] == 2): ?>checked<?php endif; ?> />女性
			</td>
        </tr>
        <tr>
          <th>生年月日<span class="red">※</span></th>
          <td>
          	<?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['yearArr'],'selected' => $this->_tpl_vars['input_data']['year']), $this);?>

            年
            <?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['monthArr'],'selected' => $this->_tpl_vars['input_data']['month']), $this);?>

            月
            <?php echo smarty_function_html_options(array('name' => 'day','options' => $this->_tpl_vars['dayArr'],'selected' => $this->_tpl_vars['input_data']['day']), $this);?>

            日
            </td>
        </tr>
         <tr>
          <th>お知らせメール<span class="red">※</span></th>
          <td>
				<label><input type="radio"  name="mail_flg" value="0" <?php if ($this->_tpl_vars['input_data']['mail_flg'] == 0): ?>checked<?php endif; ?> />希望する</label>
				<label><input type="radio"  name="mail_flg" value="1" <?php if ($this->_tpl_vars['input_data']['mail_flg'] == 1): ?>checked<?php endif; ?> />希望しない</label>
			</td>
        </tr>
        <tr>
          <th>備考</th>
          <td>
				<textarea name="comment" rows="" cols=""><?php echo $this->_tpl_vars['input_data']['comment']; ?>
</textarea>
			</td>
        </tr>
        </table>
	</div>

	<div class="right w50">
		<h5>その他管理用情報</h5>
      <table class="w80">
       <tr>
          <th>担当者</th>
          <td>
          <input type="text" name="tanto" value="<?php echo $this->_tpl_vars['input_data']['tanto']; ?>
"  /></td>
        </tr>
	       <tr>
	          <th>コース購入</th>
	      	<td>
	          <?php echo smarty_function_html_radios(array('name' => 'course_no','options' => $this->_tpl_vars['courseArr2'],'selected' => $this->_tpl_vars['input_data']['course_no'],'id' => 'course'), $this);?>


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
          <th>DM</th>
          <td>
				<label><input type="radio"  name="dm_flg" value="0" <?php if ($this->_tpl_vars['input_data']['dm_flg'] == 0): ?>checked<?php endif; ?> />可</label>
				<label><input type="radio"  name="dm_flg" value="1" <?php if ($this->_tpl_vars['input_data']['dm_flg'] == 1): ?>checked<?php endif; ?> />不可</label>
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
	</div>
</div>


<?php if ($this->_tpl_vars['finish_flg'] != 1): ?>
      <div class="mt20 tc">
        <input type="submit"  name="submit" value="登録" class="btn-lg" />
      </div>
<?php endif; ?>
    </div>
			<input type="hidden" name="spid" value="<?php echo $this->_tpl_vars['db_data']['shop_no']; ?>
">

</form>

	</div>
</div>
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>