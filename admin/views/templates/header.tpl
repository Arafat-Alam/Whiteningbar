<div id="header" class="clearfix">
	<h2 class="left">
		<a href="/index/display">{$smarty.const.STR_SITE_TITLE}</a>
	</h2>
	<div class="right">{if $login_admin}
	<strong>{$login_admin.user_name}</strong>でログイン中&nbsp;&nbsp;
	<a href="/admin/logout" class="btn btn-sm btn-gray">ログアウト</a>
	{/if}
	</div>
</div>