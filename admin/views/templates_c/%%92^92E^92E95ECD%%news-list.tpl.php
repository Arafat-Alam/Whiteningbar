<?php /* Smarty version 2.6.26, created on 2017-04-19 19:53:03
         compiled from news-list.tpl */ ?>
<?php 
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='list';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '



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
		<h3>お知らせ管理</h3>
		
		<div class="w80 center">
		<span class="red"><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></span>

			<form name="fm_add" id="fm_add" method="POST" action="/news/edit/">
				<input type="hidden" name="mode" value="add" />
				<input type="submit" name="sbm_add" value="新規作成" />
			</form>



			<form name="fm_list" id="fm_list" method="POST" action="">
			<table class="w100 mt10">
			<tr>
				<th class="id">投稿設定日</th>
				<th class="id">タイトル</th>
				<th>詳細</th>
				<th>表示/非表示</th>
				<th>削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['resuArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['resu']):
?>
				<tr>
					<td><?php echo $this->_tpl_vars['resu']['news_date']; ?>
</td>
					<td><?php echo $this->_tpl_vars['resu']['title']; ?>
</td>
					<td class="tc"><a href="/news/edit/?news_no=<?php echo $this->_tpl_vars['resu']['news_no']; ?>
" class="btn btn-sm">詳細</a></td>
					<td>
					<label><input type="radio" name="display_flg[<?php echo $this->_tpl_vars['resu']['news_no']; ?>
]" value="1"<?php if ($this->_tpl_vars['resu']['display_flg'] == '1'): ?> checked="checked"<?php endif; ?>/>表示</label>
					&nbsp;<label><input type="radio" name="display_flg[<?php echo $this->_tpl_vars['resu']['news_no']; ?>
]" value="0"<?php if ($this->_tpl_vars['resu']['display_flg'] == '0'): ?> checked="checked"<?php endif; ?>/>非表示</label>
					<input type="hidden" name="display_flg_org[<?php echo $this->_tpl_vars['resu']['news_no']; ?>
]"  value="<?php echo $this->_tpl_vars['resu']['display_flg']; ?>
" />
					</td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="<?php echo $this->_tpl_vars['resu']['news_no']; ?>
"  /></td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="5">お知らせははありません。</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>
			<div class="paging">

			</div>
 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
			<div class="tc">
				<input type="submit" name="regist" value="更新する" onClick="return confirm('お知らせの表示/非表示を更新します。削除にチェックしたお知らせを削除します。');" class="btn-lg">
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
