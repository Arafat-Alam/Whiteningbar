{if $hide_header != "t"}
	<div id="h1_title">
		<div id="h1_title_left">{$smarty.const.STR_SITE_TITLE}</div>
		<div id="h1_title_right">
			<div class="header_user_info">


				<em><b>{$login_manager.company_name}様</b></em>でログイン中&nbsp;

				<a href="manager/logout">ログアウト</a>
			</div>
		</div>
	</div>
	<div id="h1_title_end"></div>
{/if}
