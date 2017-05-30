<?php /* Smarty version 2.6.26, created on 2017-05-26 20:08:33
         compiled from member/unpaid.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', 'member/unpaid.tpl', 164, false),array('modifier', 'date_format', 'member/unpaid.tpl', 177, false),array('function', 'html_options', 'member/unpaid.tpl', 168, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='member';
$_SESSION['tab']='unpaid';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#member_no").val("");
	$("#user_name").val("");
}


function getList(no){

	target1 = $("#coupon"+no);
	//$(".category_m_id").remove();
	$("#coupon_id").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});

	$.ajax({
		type: "POST",
		url: "/member/getCouponList/",
		cache : false,
		dataType: "json",
		data : {
			p_coupon_id: $("#p_coupon_id"+no).val()
		},
		success: function(data, dataType) {
			target1.after(data.html);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

$(function(){
	$(".datepicker").datepicker({
		dateFormat: "yy-mm-dd"
	});



});
$(document).ready(function(){
	var user_name = $(\'#user_name\').val();
	var member_no = $(\'#member_no\').val();
		// $(\'#sbmBtn\').attr(\'disabled\',\'disabled\');
		// $(\'#sbmBtn\').attr(\'style\',\'color:red;\');
		// $(\'#vldMsg\').show();

	if (user_name != \'\' || member_no != \'\') {
	/*	$(\'#vldMsg\').hide();
		$(\'#sbmBtn\').removeAttr(\'disabled\');
		$(\'#sbmBtn\').removeAttr(\'style\');*/
	}
});

function validate() {
	var msg = "";

	// お名前
	if ($("#user_name").val() == "" && $("#member_no").val() == "") {
		msg += "ユーザー名またはユーザーIDを入力してください";
	}
	// フォームタイプ
	// if ($("#member_no").val() == "") {
	// 	msg += "・フォームタイプを選択してください\\n";
	// }
	if (msg != "") {
		alert(msg);
		return false;
	}

	// $("#fm").submit();
	return true;
}

function valueValidate(){
	
	var user_name = $(\'#user_name\').val();
	var member_no = $(\'#member_no\').val();
		// $(\'#sbmBtn\').attr(\'disabled\',\'disabled\');
		// $(\'#sbmBtn\').attr(\'style\',\'color:red;\');
		// $(\'#vldMsg\').show();

	if (user_name != \'\' || member_no != \'\') {
		// $(\'#vldMsg\').hide();
		// $(\'#sbmBtn\').removeAttr(\'disabled\');
		// $(\'#sbmBtn\').removeAttr(\'style\');
	}

}

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
$this->_smarty_include(array('smarty_include_tpl_file' => "member/menu_member.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>未払い一覧</h3>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<form method="post" name="fm_search" action="">
		<table class="search center">
		<tr>
		<!-- <span style="color: red;" id="vldMsg">Please Enter User Name Or Id</span> -->
			<th>名前</th>
			<td>
				<input type="text" name="name" id="user_name"  value="<?php echo $this->_tpl_vars['search']['name']; ?>
" size="20" onclick="valueValidate()" onkeyup="valueValidate()"/>
			</td>
			<th>会員番号</th>
			<td>
				<input type="text" name="member_no" id="member_no"  value="<?php echo $this->_tpl_vars['search']['member_no']; ?>
" size="20" onclick="valueValidate()" onkeyup="valueValidate()"/>
			</td>

		</tr>
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_search" class="btn-lg" id="sbmBtn" onclick="return validate();">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray" >クリア</button>
		</div>
		</form>
<hr>

		<p class="mt10">予約<!-- (キャンセル含） -->はしたが、コースの購入がまだの会員様の一覧です。<br />
料金を受け取りましたら、「料金受取済」のボタンを押してください<br>
日付は選択した日が売上日となり、売上に計上されます。
<br /><br />
削除ボタン（確認メッセージあり）を押すと未払いコースとそのコースに紐づく予約を完全に削除します。
<br />
件数：<?php echo $this->_tpl_vars['total_count']; ?>
件
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
  onChange="getList('<?php echo $this->_tpl_vars['key']; ?>
')">
			          <?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['couPaArr'],'selected' => $this->_tpl_vars['input_data']['coupon_id']), $this);?>

					</select>

			          <div id=coupon<?php echo $this->_tpl_vars['key']; ?>
>
			          </div>

					</td>
					<td class="tc">
							<font size=1>売上計上日</font><br>
							<input type="text" class="datepicker" id="start<?php echo $this->_tpl_vars['key']; ?>
" name="buy_date" size="10" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['buy_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y-%m-%d') : smarty_modifier_date_format($_tmp, '%Y-%m-%d')); ?>
" style="ime-mode:disabled;"/>
							<input type="submit" name="submit" value="料金受取済" onClick="return confirm('料金を受け取り済みにします。良いですか？');" class="btn-delete btn-sm">
					</td>
					<td class="tc">
							<input type="submit" name="del_submit" value="削除" onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');" class="btn-delete btn-sm"><!-- onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');"  by arafat-->
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

	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
