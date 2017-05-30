<?php /* Smarty version 2.6.26, created on 2014-09-24 17:58:08
         compiled from maildeliver/delivery_mail.tpl */ ?>
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
		<h3>ユーザー</h3>
<h4>メルマガ一斉配信</h4>


			  <p class="mt20 tc">この画面の内容が送信されます。<br />
			  内容を変更したい場合はこの画面から直接編集することもできます。<br />ただし、変更したものは保存されません。

			  </p>

<form action="/mail/magazin/" method="post"  >
      <table class="center w80">
		<tr>
			<th>件名</th>
			<td>
				<input type="text" size="60" name="subject" value="<?php echo $this->_tpl_vars['template_subject']; ?>
">
			</td>
		</tr>
		<tr>
			<th rowspan="4">メール本文</th>
			<td>xxxxx様 <span class="gray sm">（※自動で顧客名が入ります）</span></td>
		</tr>
		<tr>
			　
			<td>
				<textarea name="mail" rows="20" cols="60"><?php echo $this->_tpl_vars['template_mail_text']; ?>
</textarea>
			</td>
		</tr>
		<tr>
			<td>
				※メルマガ不要な方は配信停止の設定をお願いいたします※<br />
				<?php echo @ROOT_URL; ?>
member/magazin_login/<br />

				↑<br />
				メルマガには必ずこの文章が入ります<br />

			</td>
		</tr>
		<tr>
			<td>
				<textarea name="sig" rows="10" cols="60"><?php echo $this->_tpl_vars['sigArr']['sig']; ?>
</textarea>
			</td>
		</tr>
     </table>


      <div class="mt20 tc">
         <input type="submit"  name="back" value="送信先変更" class="btn-gray" />
        <input type="submit"  name="send_submit" value="メール送信" class="btn-lg" />
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