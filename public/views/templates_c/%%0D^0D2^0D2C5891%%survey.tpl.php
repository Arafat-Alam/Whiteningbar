<?php /* Smarty version 2.6.26, created on 2014-07-15 12:01:28
         compiled from reserve/survey.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'reserve/survey.tpl', 56, false),array('function', 'html_radios', 'reserve/survey.tpl', 58, false),array('function', 'html_checkboxes', 'reserve/survey.tpl', 60, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head_under.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<!--
<?php echo '



'; ?>

-->
</script>

<body>
	<div id="wrap">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<div class="content">
		<h1>予約する</h1>
		<form action="" method="post">
			<h2>アンケート</h2>
			<div class="content-inner">
				<p>下記項目に入力後、「次へ」ボタンをクリックしてください。</p>

				<?php if ($this->_tpl_vars['result_messages']): ?>
					<?php $_from = $this->_tpl_vars['result_messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<p class="txt-red mt5"><?php echo $this->_tpl_vars['item']; ?>
</p>
					<?php endforeach; endif; unset($_from); ?>
				<?php endif; ?>
				<table class="table mt10">
				<?php $_from = $this->_tpl_vars['setArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<tr>
						<th>
						<?php echo $this->_tpl_vars['item']['name']; ?>

						<?php if ($this->_tpl_vars['item']['status'] == 1): ?>
							<span class="label">必須</span>
						<?php endif; ?>
						<?php if ($this->_tpl_vars['item']['in_min'] > 0): ?>
							<br /><?php echo $this->_tpl_vars['item']['in_min']; ?>
文字以上
						<?php endif; ?>
						<?php if ($this->_tpl_vars['item']['in_max'] > 0): ?>
							<?php echo $this->_tpl_vars['item']['in_max']; ?>
文字以下
						<?php endif; ?>

						</th>
						<td>
					<?php $this->assign('itemno', $this->_tpl_vars['item']['komoku_no']); ?>
					<?php if ($this->_tpl_vars['item']['form_type'] == 1): ?><!-- input  -->
							<input name="no[<?php echo $this->_tpl_vars['itemno']; ?>
]" value="<?php echo $this->_tpl_vars['input_data']['no'][$this->_tpl_vars['itemno']]; ?>
" type="text" class="form-lg">
					<?php elseif ($this->_tpl_vars['item']['form_type'] == 2): ?><!-- textarea  -->
							<textarea name="no[<?php echo $this->_tpl_vars['itemno']; ?>
]"><?php echo $this->_tpl_vars['input_data']['no'][$this->_tpl_vars['itemno']]; ?>
</textarea>
					<?php elseif ($this->_tpl_vars['item']['form_type'] == 3): ?><!-- select  -->
							<?php echo smarty_function_html_options(array('name' => "no[".($this->_tpl_vars['itemno'])."]",'options' => $this->_tpl_vars['item']['opt'],'selected' => $this->_tpl_vars['input_data']['no'][$this->_tpl_vars['itemno']]), $this);?>

					<?php elseif ($this->_tpl_vars['item']['form_type'] == 4): ?><!-- radio  -->
							<?php echo smarty_function_html_radios(array('name' => "no[".($this->_tpl_vars['itemno'])."]",'options' => $this->_tpl_vars['item']['opt'],'selected' => $this->_tpl_vars['input_data']['no'][$this->_tpl_vars['itemno']]), $this);?>

					<?php elseif ($this->_tpl_vars['item']['form_type'] == 5): ?><!-- checkbox  -->
							<?php echo smarty_function_html_checkboxes(array('name' => "no[".($this->_tpl_vars['itemno'])."]",'options' => $this->_tpl_vars['item']['opt'],'selected' => $this->_tpl_vars['input_data']['no'][$this->_tpl_vars['itemno']]), $this);?>

					<?php endif; ?>
								<br><span class="txt-sm"><?php echo $this->_tpl_vars['item']['comment']; ?>
</span>
							</td>
						</tr>
				<?php endforeach; endif; unset($_from); ?>
				</table>
				<div class="tc mt35">
				<input type="button" name="back" class="btn btn-lg btn-gray" value="戻る"  onclick="location.href='/reserve/list/?back'">&nbsp;&nbsp;

				<input type="submit" name="submit" class="btn btn-lg" value="次へ"></div>
			</div>
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
</html>