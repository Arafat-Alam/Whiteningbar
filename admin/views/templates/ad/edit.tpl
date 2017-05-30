{include file="head.tpl"}

<script type="text/javascript">
{literal}

function editcancel(pp,vp)
{
	document.regForm.action="ad/list/";
	document.regForm.pp.value = pp;
	document.regForm.vp.value = vp;
	document.regForm.submit();
}

$(function(){
	$("#start").datetimepicker({
		dateFormat: "yy/mm/dd",
		timeFormat: "HH:mm:00"
	});

	$("#end").datetimepicker({
		dateFormat: "yy/mm/dd",
		timeFormat: "HH:mm:59"
	});


});



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

		編集しました。


{else}
<form name="regForm" method="post" action="ad/edit/" enctype="multipart/form-data" >
<input type="hidden" name="ctitle" value="{$ctitle}" />
<input type="hidden" name="ad_no" value="{$input_data.ad_no}" />
<input type="hidden" name="exec" value="{$exec}" />
<input type="hidden" name="pp" value="{$adArr.p_point}" />
<input type="hidden" name="vp" value="{$adArr.v_point}" />


{if $upErrFlg==99}
<font color="red">登録処理に失敗しました<br /></font>
{elseif $upErrFlg==1}
<font color="red">広告登録が完了しました<br /></font>
{/if}

<a href="/ad/list/?pp={$adArr.p_point}&vp={$adArr.v_point}">←広告リストに戻る</a><br />
<font color="red">
{if $result_messages.name}{$result_messages.name}{/if}
{if $result_messages.link}{$result_messages.link}{/if}
{if $result_messages.file}{$result_messages.file}{/if}
</font>
<br />

※は必須項目です
<table class="admin_list01">
</td>
</tr>
<tr>
<th>※広告名</th>

<td>

<input type="text" name="name" value="{$input_data.name}" style="ime-mode:active;width:350px" />
</td>
</tr>
<tr>
	<th>
		※広告バナー
	</th>
	<td>
		<input type="file" name="up_file"  size="30"/>
		{if $smarty.session.TMP_FUP!=""}
			<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP}" widht=80 height=100>
		{elseif $input_data.img_name!=""}
			<img src="{$smarty.const.URL_IMG_AD}{$input_data.img_name}?{$smarty.now}" widht=80 height=100>
			<!-- <input type="checkbox" name="del" value="{$input_data.img_name}">削除する バナー無はありえないので。-->
			<input type="hidden" name="img_name" value="{$input_data.img_name}" />
		{/if}
	</td>
</tr>
<th>※リンク先</th>

<td>

<input type="text" name="link" value="{$input_data.link}" style="ime-mode:active;width:350px" />
</td>
</tr>
<tr>
	<th>
		※表示/非表示
	</th>
	<td>
		<input type="radio" name="view_flg" value="1"{if $input_data.view_flg=="1"} checked="checked"{/if}/>表示
		&nbsp;<input type="radio" name="view_flg" value="0"{if $input_data.view_flg=="0"} checked="checked"{/if}/>非表示

	</td>
</tr>
<tr>
	<th>
		※掲載期間設定
	</th>
	<td>
		<input type="text" id="start" name="view_start" size="25" value="{$input_data.view_start}" style="ime-mode:disabled;"/>
		～
		<input type="text" id="end" name="view_end" size="25" value="{$input_data.view_end}" style="ime-mode:disabled;"/>
	</td>
</tr>
<tr>
	<th>
		掲載料金
	</th>
	<td>
		<input type="text" name="fee" value="{$input_data.fee}"  />
	</td>
</tr>



</table>
{if $upErrFlg}
<br /><a href="/ad/list/?pp={$adArr.p_point}&vp={$adArr.v_point}">←広告リストに戻る</a><br />
{else}
<p class="center">
	<input type="submit" name="regist" value="OK" />
	<input name="cancel" type="button" value="キャンセル" onclick="editcancel({$adArr.p_point}, {$adArr.v_point});" />
</p>
{/if}
</form>

{/if}
{include file="footer.tpl"}
</body>
</html>
