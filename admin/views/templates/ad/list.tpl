{include file="head.tpl"}
<script type="text/javascript">
{literal}


//編集
function edit( ad_no )
{
	document.regForm.ad_no.value = ad_no;
	document.regForm.submit();
}
function del( ad_no )
{
	if( !confirm( "指定のデータを削除します。\r\nよろしいですか？" ) )
	{
		return false;
	}
	document.regForm.action = "ad/list/";
	document.regForm.ad_no.value = ad_no;
	document.regForm.exec.value = "delete";
	document.regForm.submit();
}
function mainup( ad_no, val )
{

	document.regForm.action = "ad/list/";
	document.regForm.ad_no.value = ad_no;
	document.regForm.value.value = val;
	document.regForm.exec.value = "mainup";
	document.regForm.submit();
}
function maindown( ad_no, val )
{

	document.regForm.action = "ad/list/";
	document.regForm.ad_no.value = ad_no;
	document.regForm.value.value = val;
	document.regForm.exec.value = "maindown";
	document.regForm.submit();
}
function addmain(pp,vp)
{
	document.regForm.action = "ad/edit/";
	document.regForm.exec.value = "main";
	document.regForm.pp.value = pp;//TOP or 下層
	document.regForm.vp.value = vp;//右 or 左
	document.regForm.submit();
}

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
		<h3>広告管理

		{if $adArr.p_point==0}TOP / {/if}
		{if $adArr.p_point==1}下層 / {/if}
		{if $adArr.v_point==0}右{/if}
		{if $adArr.v_point==1}左{/if}
		</h3>

{if $msg }
<div><font color="red">{$msg}</font></div><br />
{/if}
<form action="ad/edit" name="regForm" method="post">
<input type="button" value="新規広告追加" onclick="addmain({$adArr.p_point},{$adArr.v_point});" />
<input type="hidden" name="ad_no" />
<input type="hidden" name="value" />
<input type="hidden" name="exec" />
<input type="hidden" name="pp" value="{$adArr.p_point}" />
<input type="hidden" name="vp" value="{$adArr.v_point}"/>

<!-- 一覧 -->
<table>
	<tr><th>広告名</th><th>上</th><th>下</th><th>表示期間</th><th>表示/非表示</th><th></th><th></th></tr>
{foreach from=$cateArr item="item"}

<tr>
<td>
{$item.name}
</td>
<td>
{if $item.mainup==1}
<a href="javascript:void( 0 );" onclick="mainup({$item.ad_no}, {$item.v_order} )">▲</a>
{/if}
</td>
<td>
{if $item.maindown==1}
<a href="javascript:void( 0 );" onclick="maindown({$item.ad_no}, {$item.v_order} )">▼</a>
{/if}
</td>
<td>
{$item.view_start}～{$item.view_end}
</td>
<td>
{if $item.view_flg==1}表示{/if}
</td>

</td>
<td><input type="button" value="変更" onclick="edit({$item.ad_no}, {$item.v_order});"></td>
<td>
{if $item.subflag!=1}
<input type="button" value="削除" onclick="del({$item.ad_no}, {$item.v_order});">
{/if}
</td>

</tr>
{/foreach}
</table>

<!-- 一覧 -->
<input type="button" value="新規広告追加" onclick="addmain();" />
</form>

{include file="footer.tpl"}
</body>
</html>
