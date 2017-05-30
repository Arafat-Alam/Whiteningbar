{include file="head.tpl"}

<script type="text/javascript">
{literal}

$(function(){
	$("#start").datepicker({
		dateFormat: "yy/mm/dd"
	});


});



{/literal}
</script>

<body>

<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="menu_admin.tpl"}
		<h3>お知らせ詳細</h3>
		<div class="w80 center">
<a href="/news/list/" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;お知らせ管理に戻る</a>
		<p class="red">{$msg}</p>

		<form id="fm" name="fm" method="post" enctype="multipart/form-data" >

	{if count($result_messages) >0}
	<div><font color="red">入力エラーがあります</font></div><br />
	{/if}
		<table class="mt10 w100">
		<tr>
			<th>お知らせタイトル</th>
			<td>
						{if $result_messages.title!=""}
							<font color="red">{$result_messages.title}<br /></font>
						{/if}
						<input class="req" type="text" name="title" value="{$input_data.title}" size="50">
			</td>
		</tr>
		<tr>
			<th>内容</th>
			<td>
						{if $result_messages.detail!=""}
							<font color="red">{$result_messages.detail}<br /></font>
						{/if}
						<textarea class="reqNoT" name="detail" rows="10" cols="60">{$input_data.detail}</textarea>
			</td>
		</tr>
		<tr>
			<th>投稿日設定</th>
			<td>
						{if $result_messages.news_date!=""}
							<font color="red">{$result_messages.news_date}<br /></font>
						{/if}
				<input type="text" id="start" name="news_date" size="25" value="{$input_data.news_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
			</td>
		</tr>
		<tr>
			<th>ファイルのアップロード</th>
			<td>
				<input type="file" name="up_file" >
			</td>
		</tr>
		<tr>
			<th>
				※表示/非表示
			</th>
			<td>
				<label><input type="radio" name="display_flg" value="1"{if $input_data.display_flg=="1"} checked="checked"{/if}/>表示</label>
				&nbsp;<label><input type="radio" name="display_flg" value="0"{if $input_data.display_flg=="0"} checked="checked"{/if}/>非表示</label>

			</td>
		</tr>

		</table>
 {if $login_admin.shop_no>=0}
		<div class="mt20 tc">
			<input type="submit" name="regist"  value=" 登 録 " class="btn-lg">&nbsp;
			<input type="reset" name="submit" value="リセット">&nbsp;
			<input type="hidden" name="news_no" value="{$input_data.news_no}">
		</div>
{/if}
		</form>
		</div>


	</div>

</div>

{include file="footer.tpl"}
</body>
</html>

