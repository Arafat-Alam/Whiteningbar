<?php /* Smarty version 2.6.26, created on 2017-05-05 20:01:02
         compiled from maildeliver/magazin.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'maildeliver/magazin.tpl', 93, false),array('modifier', 'in_array', 'maildeliver/magazin.tpl', 161, false),array('function', 'html_options', 'maildeliver/magazin.tpl', 106, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='magazin';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#year").val("");
	$("#month").val("");
	$("#day").val("");
	$("#user_name").val("");
	//$("input:[name=sex]").removeAttr("checked",false);
	$("input#sex1").attr(\'checked\',false);
	$("input#sex2").attr(\'checked\',false);
	$("input#sex").attr(\'checked\',false);

	$("#course").val("");
	$("#start").val("");
	$("#end").val("");

}

// $("#submitBtn").click(function(){
// 	alert("dsfasffasf");
// });

function validate(event){
	var start = $(\'#start\').val();
	var end = $(\'#end\').val();
	var user_name = $(\'#user_name\').val();
	var year = $(\'#year\').val();
	var month = $(\'#month\').val();
	var day = $(\'#day\').val();
	var course = $(\'#course\').val();

	if (start == \'\' || end == \'\' || user_name == \'\' || year == \'\' || month == \'\' || day == \'\' || course == \'\') {
		// alert(\'Please Fill Up All Field \');
		alert(\'すべてのフィールドを入力してください\');
		return false;
	}
	return true;
}

jQuery(document).ready(function($) {

	$(\'#allCheck\').click(function(){
		if(this.checked){
			$(\'#check input\').attr(\'checked\',\'checked\');
		}else{
			$(\'#check input\').removeAttr(\'checked\');
		}
   	});

	$("#start").datepicker({
		dateFormat: "yy-mm-dd"
	});


	$("#end").datepicker({
		dateFormat: "yy-mm-dd"
	});

});



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
$this->_smarty_include(array('smarty_include_tpl_file' => "maildeliver/menu_mail.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>ユーザー</h3>
<h4>メルマガ一斉配信</h4>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['result_messages']): ?>
			<center><span class="red"><?php echo $this->_tpl_vars['result_messages']; ?>
</span></center>
		<?php endif; ?>

		<form method="post" name="fm_search" action="/mail/magazin/">
		<table class="search center">
		<tr>
			<th>来店日 <span style="color: red">※</span></th>
			<td colspan=3>

				<input type="text" id="start" name="start_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end" name="end_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>

			</td>
		</tr>
		<tr>
			<th>お名前 <span style="color: red">※</span></th>
			<td>
				<input type="text" name="name" id="user_name"  value="<?php echo $this->_tpl_vars['search']['name']; ?>
" size="20" />
			</td>
			<th>お誕生日 <span style="color: red">※</span></th>
			<td>
          	<?php echo smarty_function_html_options(array('name' => 'year','options' => $this->_tpl_vars['yearArr'],'selected' => $this->_tpl_vars['search']['year'],'id' => 'year'), $this);?>

            年
            <?php echo smarty_function_html_options(array('name' => 'month','options' => $this->_tpl_vars['monthArr'],'selected' => $this->_tpl_vars['search']['month'],'id' => 'month'), $this);?>

            月
            <?php echo smarty_function_html_options(array('name' => 'day','options' => $this->_tpl_vars['dayArr'],'selected' => $this->_tpl_vars['search']['day'],'id' => 'day'), $this);?>

            日
			</td>
		</tr>
		<tr>
			<th>コース <span style="color: red">※</span></th>
			<td>
				<?php echo smarty_function_html_options(array('name' => 'course_no','options' => $this->_tpl_vars['courseArr'],'selected' => $this->_tpl_vars['search']['course_no'],'id' => 'course'), $this);?>

			</td>
			<th>性別 <span style="color: red">※</span></th>
			<td>
				<label><input type="radio" name="sex" value="1" id="sex1" <?php if ($this->_tpl_vars['search']['sex'] == 1): ?>checked<?php endif; ?> />男性</label>
				<label><input type="radio" name="sex" value="2" id="sex2" <?php if ($this->_tpl_vars['search']['sex'] == 2): ?>checked<?php endif; ?> />女性</label>
				<label><input type="radio" name="sex" value="0" id="sex" <?php if ($this->_tpl_vars['search']['sex'] == 0): ?>checked<?php endif; ?> />指定なし</label>
			</td>
		</tr>
<!--
		<tr>
			<th>お知らせ</th>
			<td>
				希望する
			</td>
		</tr>
 -->
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_search" class="btn-lg" onclick="return validate()">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
<hr>
<form action="/mail/magazin/" method="post"  >
	テンプレート選択：
	<?php echo smarty_function_html_options(array('name' => 'template_no','options' => $this->_tpl_vars['templateArr'],'selected' => $this->_tpl_vars['template_no']), $this);?>


		<p class="mt20"><label><input type="checkbox" id="allCheck">全て選択する</label></p>
      <table class="admins">
			<tr>
				<th></th>
				<th>会員No</th>
				<th>お名前</th>
				<th>E-mailアドレス</th>
				<th>管理用備考</th>

			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>


		        <tr>
					<td>
					<div id="check" class="tc">
						<input type="checkbox" name="member_id[]" value="<?php echo $this->_tpl_vars['item']['member_id']; ?>
"  <?php if ($this->_tpl_vars['oemArr'] && ((is_array($_tmp=$this->_tpl_vars['item']['member_id'])) ? $this->_run_mod_handler('in_array', true, $_tmp, $this->_tpl_vars['oemArr']) : in_array($_tmp, $this->_tpl_vars['oemArr']))): ?>checked<?php endif; ?> />
						</div>
					</td>
					<td>
						<?php echo $this->_tpl_vars['item']['member_no']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['item']['name']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['item']['email']; ?>

					</td>
					<td>
						<?php echo $this->_tpl_vars['item']['kanri_comment']; ?>

					</td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="5">
						検索に該当する会員はいません
					</td>
				</tr>
			<?php endif; unset($_from); ?>
     </table>

<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
      <div class="mt20 tc">
        <input type="submit"  name="address_submit" value="宛先決定" class="btn-lg" />
      </div>
<?php endif; ?>
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
