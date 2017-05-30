<?php /* Smarty version 2.6.26, created on 2015-03-27 18:08:50
         compiled from maildeliver/edit.tpl */ ?>
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
<h4>メールテンプレート作成</h4>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<form action="" method="post"  >
      <table class="center w80">
        <tr>
          <th>テンプレートタイトル&nbsp;&nbsp;<span class="red">※</span></th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['title']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['title']; ?>
</span><br />
			<?php endif; ?>

          <input type="text" size="30" name="title" value="<?php echo $this->_tpl_vars['input_data']['title']; ?>
" /></td>
        </tr>
        <tr>
          <th>件名（subject)&nbsp;&nbsp;<span class="red">※</span><br />メール送信時の件名</th>
          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['subject']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['subject']; ?>
</span><br />
			<?php endif; ?>

          <input type="text" size="30" name="subject" value="<?php echo $this->_tpl_vars['input_data']['subject']; ?>
" /></td>
        </tr>
	        <tr>
	          <th>メール本文&nbsp;&nbsp;<span class="red">※</span></th>
	          <td>
	 		<?php if ($this->_tpl_vars['result_messages']['mail_text']): ?>
				<span class="red"><?php echo $this->_tpl_vars['result_messages']['mail_text']; ?>
</span><br />
			<?php endif; ?>
				<textarea name="mail_text" rows="25" cols="40"><?php echo $this->_tpl_vars['input_data']['mail_text']; ?>
</textarea>

	          </td>
	        </tr>
<!--
        <tr>
          <th>緊急のお知らせ</th>
          <td>
          <label><input type="checkbox" name="em_flg" value="1" <?php if ($this->_tpl_vars['input_data']['em_flg'] == 1): ?>checked<?php endif; ?> />
          ※メール不要の顧客にも緊急メールとして送信します。</label>
          </td>
        </tr>
 -->
     </table>


      <div class="mt20 tc">
        <input type="submit"  name="submit" value="登録" class="btn-lg" />
        <input type="hidden" name="template_no" value="<?php echo $this->_tpl_vars['input_data']['template_no']; ?>
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