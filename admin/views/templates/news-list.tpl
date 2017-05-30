{php}
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='list';
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
		<h3>お知らせ管理</h3>
		
		<div class="w80 center">
		<span class="red">{include file="messages.tpl"}</span>

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
			{foreach from=$resuArr item="resu"}
				<tr>
					<td>{$resu.news_date}</td>
					<td>{$resu.title}</td>
					<td class="tc"><a href="/news/edit/?news_no={$resu.news_no}" class="btn btn-sm">詳細</a></td>
					<td>
					<label><input type="radio" name="display_flg[{$resu.news_no}]" value="1"{if $resu.display_flg=="1"} checked="checked"{/if}/>表示</label>
					&nbsp;<label><input type="radio" name="display_flg[{$resu.news_no}]" value="0"{if $resu.display_flg=="0"} checked="checked"{/if}/>非表示</label>
					<input type="hidden" name="display_flg_org[{$resu.news_no}]"  value="{$resu.display_flg}" />
					</td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="{$resu.news_no}"  /></td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="5">お知らせははありません。</td>
				</tr>
			{/foreach}
			</table>
			<div class="paging">

			</div>
 {if $login_admin.shop_no>=0}
			<div class="tc">
				<input type="submit" name="regist" value="更新する" onClick="return confirm('お知らせの表示/非表示を更新します。削除にチェックしたお知らせを削除します。');" class="btn-lg">
			</div>
{/if}
			</form>
	</div>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

