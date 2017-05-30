<?php /* Smarty version 2.6.26, created on 2017-05-16 11:23:17
         compiled from news-edit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'news-edit.tpl', 61, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
<?php echo '

$(function(){
	$("#start").datepicker({
		dateFormat: "yy/mm/dd"
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
$this->_smarty_include(array('smarty_include_tpl_file' => "menu_admin.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>お知らせ詳細</h3>
		<div class="w80 center">
<a href="/news/list/" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;お知らせ管理に戻る</a>
		<p class="red"><?php echo $this->_tpl_vars['msg']; ?>
</p>

		<form id="fm" name="fm" method="post" enctype="multipart/form-data" >

	<?php if (count ( $this->_tpl_vars['result_messages'] ) > 0): ?>
	<div><font color="red">入力エラーがあります</font></div><br />
	<?php endif; ?>
		<table class="mt10 w100">
		<tr>
			<th>お知らせタイトル</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['title'] != ""): ?>
							<font color="red"><?php echo $this->_tpl_vars['result_messages']['title']; ?>
<br /></font>
						<?php endif; ?>
						<input class="req" type="text" name="title" value="<?php echo $this->_tpl_vars['input_data']['title']; ?>
" size="50">
			</td>
		</tr>
		<tr>
			<th>内容</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['detail'] != ""): ?>
							<font color="red"><?php echo $this->_tpl_vars['result_messages']['detail']; ?>
<br /></font>
						<?php endif; ?>
						<textarea class="reqNoT" name="detail" rows="10" cols="60"><?php echo $this->_tpl_vars['input_data']['detail']; ?>
</textarea>
			</td>
		</tr>
		<tr>
			<th>投稿日設定</th>
			<td>
						<?php if ($this->_tpl_vars['result_messages']['news_date'] != ""): ?>
							<font color="red"><?php echo $this->_tpl_vars['result_messages']['news_date']; ?>
<br /></font>
						<?php endif; ?>
				<input type="text" id="start" name="news_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['input_data']['news_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
			</td>
		</tr>
		<tr>
			<th>ファイルのアップロード</th>
			<td>
				<input type="file" name="up_file" >
			</td>
		</tr>
		<tr>
			<th>
				※表示/非表示
			</th>
			<td>
				<label><input type="radio" name="display_flg" value="1"<?php if ($this->_tpl_vars['input_data']['display_flg'] == '1'): ?> checked="checked"<?php endif; ?>/>表示</label>
				&nbsp;<label><input type="radio" name="display_flg" value="0"<?php if ($this->_tpl_vars['input_data']['display_flg'] == '0'): ?> checked="checked"<?php endif; ?>/>非表示</label>

			</td>
		</tr>

		</table>
 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<div class="mt20 tc">
			<input type="submit" name="regist"  value=" 登 録 " class="btn-lg">&nbsp;
			<input type="reset" name="submit" value="リセット">&nbsp;
			<input type="hidden" name="news_no" value="<?php echo $this->_tpl_vars['input_data']['news_no']; ?>
">
		</div>
<?php endif; ?>
		</form>
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
