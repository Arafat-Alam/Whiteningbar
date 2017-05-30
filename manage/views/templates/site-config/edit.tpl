{include file="head.tpl"}
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}

	<div id="main_content">
		<h3>■システム設定一覧</h3>
		{include file="messages.tpl"}
		<form method="post" name="fm" action="siteConfig">
			<input type="hidden" name="submit_data" value="t"/>
			<table class="detail" id="sys-config">
			{foreach from=$config_list item="config"}
				<tr>
					<th>{$config->getConfigName()}</th>
					<td>
						<input type="text" name="config_value[]" value="{$config->getConfigValue()}" size="{$config->getLength()}"/>
						<br />
						{$config->getConfigExplain()}
					</td>
					<input type="hidden" name="config_key[]" value="{$config->getConfigKey()}"/>
				</tr>
			{foreachelse}
			<tr>
				<td colspan="2">システム設定データがありません。</td>
			</tr>
			 {/foreach}
			</table>
			<div>
				<button type="submit" onclick="return validate()">更新</button>
			</div>
		</form>
	</div>
</div>
{include file="footer.tpl"}

</body>
</html>

