{php}
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='member_require';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}



{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="menu_admin.tpl"}
		<h3>必須項目設定</h3>

		<div class="w80 center">
		<span class="red">{include file="messages.tpl"}</span>

			<form name="fm_list" id="fm_list" method="POST" action="">
			<table class="w100 mt10">
			<tr>
				<th class="id">項目名</th>
				<th>必須/任意</th>
			</tr>
			{foreach from=$arr item="item"}
				<tr>
					<td>{$item.name_str}</td>
					<td>
					<label><input type="radio" name="req_flg[{$item.no}]" value="1"{if $item.req_flg=="1"} checked="checked"{/if}/>必須</label>&nbsp;
					<label><input type="radio" name="req_flg[{$item.no}]" value="0"{if $item.req_flg=="0"} checked="checked"{/if}/>任意</label>
					</td>
				</tr>
			{/foreach}
			</table>
			<div class="paging">

			</div>
			<div class="tc">
				<input type="submit" name="regist" value="更新する" onClick="return confirm('必須項目の設定を更新します。');" class="btn-lg">
			</div>
			</form>
	</div>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

