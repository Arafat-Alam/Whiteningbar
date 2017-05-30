{php}
session_start();
$_SESSION['page']='news';
$_SESSION['tab']='category1';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

//編集
function edit( id )
{
	document.regForm.id.value = id;
	document.regForm.submit();
}
function del( id )
{
	if( !confirm( "指定のデータを削除します。\r\nよろしいですか？" ) )
	{
		return false;
	}
	document.regForm.action = "./master/category1/";
	document.regForm.id.value = id;
	document.regForm.exec.value = "delete";
	document.regForm.submit();
}
function mainup( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "mainup";
	document.regForm.submit();
}
function maindown( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "maindown";
	document.regForm.submit();
}
function middleup( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "middleup";
	document.regForm.submit();
}
function middledown( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "middledown";
	document.regForm.submit();
}
function subup( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "subup";
	document.regForm.submit();
}
function subdown( id, val )
{
	document.regForm.action = "master/category1/";
	document.regForm.id.value = id;
	document.regForm.value.value = val;
	document.regForm.exec.value = "subdown";
	document.regForm.submit();
}
function addsub( id )
{
	document.regForm.action = "master/category1edit/";
	document.regForm.id.value = id;
	document.regForm.exec.value = "sub";
	document.regForm.submit();
}
function addmain()
{
	document.regForm.action = "master/category1edit/";
	document.regForm.exec.value = "main";
	document.regForm.submit();
}
function addmiddle(id)
{
	document.regForm.action = "master/category1edit/";
	document.regForm.id.value = id;
	document.regForm.exec.value = "middle";
	document.regForm.submit();
}


{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="menu_admin.tpl"}
		<h3>管理 > クーポン設定</h3>

<div class="w100 center">
{if $msg }
<p class="red">{$msg}</p>
{/if}
<form action="master/category1edit" name="regForm" method="post">
	<div>
	<input type="button" value="メインクーポンカテゴリー追加" onClick="addmain();" />
	</div>
<input type="hidden" name="id" />
<input type="hidden" name="value" />
<input type="hidden" name="exec" />

<!-- 一覧 -->
<table class="mt10 w100">
	<tr><th>クーポン名</th><th>上</th><th>下</th><!--  <th>上</th><th>下</th>--><th></th><th></th><th></th></tr>
{foreach from=$cateArr item="item"}

<tr>
<td>

{if $item.cflag==2}
&nbsp;&nbsp;└
{/if}

{if $item.cflag==3 && $item.subdown==1}
&nbsp;&nbsp;&nbsp;&nbsp;├
{/if}
{if $item.cflag==3 && $item.subdown==0}
&nbsp;&nbsp;&nbsp;&nbsp;└
{/if}
{$item.name}
{if $item.cflag==2}
({$item.fee}円引き)
{/if}
</td>
<td class="tc">
{if $item.mainup==1}
<a href="javascript:void( 0 );" onClick="mainup({$item.id}, {$item.v_order} )" class="btn btn-sm">▲</a>
{/if}
</td>
<td class="tc">
{if $item.maindown==1}
<a href="javascript:void( 0 );" onClick="maindown({$item.id}, {$item.v_order} )" class="btn btn-sm">▼</a>
{/if}
</td>
<!--
<td class="tc">
{if $item.middleup==1}
<a href="javascript:void( 0 );" onClick="middleup({$item.id}, {$item.v_order} )" class="btn btn-sm">▲</a>
{/if}
</td>
<td class="tc">
{if $item.middledown==1}
<a href="javascript:void( 0 );" onClick="middledown({$item.id}, {$item.v_order} )" class="btn btn-sm">▼</a>
{/if}
-->
<!--
<td>
{if $item.subup==1}
<a href="javascript:void( 0 );" onclick="subup({$item.id}, {$item.v_order} )">▲</a>
{/if}
</td>
<td>
{if $item.subdown==1}
<a href="javascript:void( 0 );" onclick="subdown({$item.id}, {$item.v_order} )">▼</a>
{/if}

</td>
-->
<td class="tc"><input type="button" value="変更" onClick="edit({$item.id})" class="btn-sm"></td>
<td class="tc">
{if $item.subflag!=1}
<input type="button" value="削除" onClick="del({$item.id});" class="btn-delete btn-sm">
{/if}
</td>
<td class="tc">
{if $item.cflag==1}
<input type="button" value="中カテゴリー追加" onClick="addmiddle({$item.id});" class="btn-sm">
<!--
<input type="button" value="小カテゴリー追加" onclick="addsub({$item.id});">
-->
{elseif $item.cflag==2}
<!--
<input type="button" value="小カテゴリー追加" onclick="addsub({$item.id});">
-->
{/if}

</td>
</tr>
{/foreach}
</table>

		<div class="mt20">
		<!-- 一覧 -->
		<input type="button" value="メインクーポンカテゴリー追加" onClick="addmain();" />
		</form>
		</div>

	</div>
</div>
</div>

{include file="footer.tpl"}
</body>
</html>
