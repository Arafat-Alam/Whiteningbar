<?php /* Smarty version 2.6.26, created on 2017-04-24 21:18:45
         compiled from maildeliver/stepedit.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'maildeliver/stepedit.tpl', 35, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
		<h3>メール管理</h3>
<h4>ステップメール詳細設定</h4>

		<?php if ($this->_tpl_vars['fini_flg'] == 1): ?>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>

		<form action="" method="post"  >
		      <table class="w80 center">

			        <tr>
			          <th>タイトル<span class="red">※</span></th>
			          <td>
				 		<?php if ($this->_tpl_vars['result_messages']['title']): ?>
							<span class="red"><?php echo $this->_tpl_vars['result_messages']['title']; ?>
</span><br />
						<?php endif; ?>

						<input type="text" name="title" value="<?php echo $this->_tpl_vars['input_data']['title']; ?>
" size="60">
			          </td>
			        </tr>

			        <tr>
			          <th>配信タイミング<span class="red">※</span></th>
			          <td>
				 		<?php if ($this->_tpl_vars['result_messages']['step_long']): ?>
							<span class="red"><?php echo $this->_tpl_vars['result_messages']['step_long']; ?>
</span><br />
						<?php endif; ?>
						<?php echo smarty_function_html_options(array('name' => 'step_kind','options' => $this->_tpl_vars['stepArr']['kind'],'selected' => $this->_tpl_vars['input_data']['step_kind']), $this);?>
の
						<input type="text" name="step_long" value="<?php echo $this->_tpl_vars['input_data']['step_long']; ?>
" size="10">
						<?php echo smarty_function_html_options(array('name' => 'step_time','options' => $this->_tpl_vars['stepArr']['time'],'selected' => $this->_tpl_vars['input_data']['step_time']), $this);?>

						<?php echo smarty_function_html_options(array('name' => 'step_when','options' => $this->_tpl_vars['stepArr']['when'],'selected' => $this->_tpl_vars['input_data']['step_when']), $this);?>

			          </td>
			        </tr>

			        <tr>
			          <th>テンプレート選択<span class="red">※</span></th>
			          <td>
						<?php echo smarty_function_html_options(array('name' => 'template_no','options' => $this->_tpl_vars['templateArr'],'selected' => $this->_tpl_vars['input_data']['template_no']), $this);?>

			          </td>
			        </tr>

		     </table>


		      <div class="mt20 tc">
		        <input type="submit"  name="submit" value="設定" class="btn-lg" />
		        <input type="hidden" name="no" value="<?php echo $this->_tpl_vars['input_data']['no']; ?>
">
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