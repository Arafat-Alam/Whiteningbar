{php}
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='siteConfig';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

/**
 * 入力チェック
 */
function validate() {
	var msg = "";

	if (msg != "") {
		alert(msg);
		return false;
	}
	return true;
}

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}

	<div id="main_content">
	{include file="menu_admin.tpl"}
		<h3>サイト表示設定</h3>


<p class="tc">ユーザー用予約ページのベースカラーを設定します。</p>


		{include file="messages.tpl"}
		<form method="post" name="fm" action="siteConfig">
			<input type="hidden" name="submit_data" value="t"/>
			<table class="center">
			{foreach from=$config_list item="config"}
				<tr>
					<th>{$config.config_name}</th>
					<td>

						{foreach from=$siteColorArr key=colorkey item=item}
							<label><p style="background-color:{$item}; width:200px;"><input type="radio" name="config_value" value="{$colorkey}" {if $colorkey==$config.config_value} checked {/if} >　{$colorkey}</p></label>
						{/foreach}

						{*$config.config_explain*}
					</td>
					<input type="hidden" name="config_key[]" value="{$config.config_key}"/>
				</tr>
			{foreachelse}
			<tr>
				<td colspan="2">システム設定データがありません。</td>
			</tr>
			 {/foreach}
			</table>
			<div class="tc mt20">
				<button type="submit" onClick="return validate()" class="btn-lg">更新</button>
			</div>
		</form>
	</div>
</div>
{include file="footer.tpl"}

</body>
</html>

