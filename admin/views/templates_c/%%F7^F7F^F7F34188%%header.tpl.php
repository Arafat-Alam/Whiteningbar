<?php /* Smarty version 2.6.26, created on 2017-03-09 22:27:14
         compiled from header.tpl */ ?>
<div id="header" class="clearfix">
	<h2 class="left">
		<a href="/index/display"><?php echo @STR_SITE_TITLE; ?>
</a>
	</h2>
	<div class="right"><?php if ($this->_tpl_vars['login_admin']): ?>
	<strong><?php echo $this->_tpl_vars['login_admin']['user_name']; ?>
</strong>でログイン中&nbsp;&nbsp;
	<a href="/admin/logout" class="btn btn-sm btn-gray">ログアウト</a>
	<?php endif; ?>
	</div>
</div>