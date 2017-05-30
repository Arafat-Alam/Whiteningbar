{include file="head.tpl"}
<script type="text/javascript">
{literal}
alert("dfsg");
function clearSearchForm() {
	$("#user_id").val("");
	$("#user_name").val("");
}

function getList(member_id){

	target1 = $("#menu_"+member_id);
	//$(".category_m_id").remove();
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList/",
		cache : false,
		dataType: "json",
		data : {
			buy_no: $("#buy_no_"+member_id).val(),
		},
		success: function(data, dataType) {

			target1.after(data.html);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

function setOpener(){
//	window.opener.location.reload();
	window.opener.location.href="/reserve/detail/?no={/literal}{$no}{literal}";
	window.close();
}
function setOpener2(){
	window.opener.location.href="/calendar/edit/?no={/literal}{$no}{literal}";
	window.close();
}


{/literal}
</script>
<body {$onl}>
<div id="wrapper">
	<div id="main_content">
		<h3>顧客一覧</h3>

		{include file="messages.tpl"}
		{if $result_messages}
			<center><span class="red">{$result_messages}</span></center>
		{/if}
		<div class="center">
			<form method="post" name="fm_search" action="">
			<table class="search center">
			<tr>
				<th>名前で探す：</th>
				<td>
					<input type="text" name="name" id="user_name"  value="{$search.name}" size="20" />
				</td>
			</tr>
			</table>
			<div class="mt20 tc">
				<button type="submit" name="sbm_search" class="btn-lg" >検索</button>&nbsp;
				<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
			</div>
			</form>
		</div>
<hr>
		{* 検索結果 *}

		<p>コース選択プルダウンには使用可能な購入済みコースが表示されていますので、今回の来店予約に使用するコースを選択してください。</p>

			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
			</div>
			<br/>

				<form name="fm_list" id="fm_list" method="POST" action="">

			<table class="admins clear mt10">
			<tr>
				<th width="80">会員No</th>
				<th width="150">お名前</th>
				<th width="200">メールアドレス</th>
				<th>電話番号</th>
				<th>コース選択</th>
				<th>選択</th>
			</tr>
			{foreach from=$members item="member"}

				<tr>
					<td>{$member.member_no}</td>
					<td>{$member.name}</td>
					<td>{$member.email}</td>
					<td>{$member.tel}</td>
					<td>
						<select name="buy_no[{$member.member_id}]" id=buy_no_{$member.member_id} onChange="getList('{$member.member_id}')">
							{foreach from=$member.courseArr key="key" item="item"}
								<option value={$key}>{$item}</option>
							{/foreach}
						</select>


					<div id=menu_{$member.member_id}></div>

					</td>
					<td>
					<input type="submit" name="choice[{$member.member_id}]" value="選択" onClick="return confirm('{$member.name}様をご来店の会員とします。良いですか？');">
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="6">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			{/foreach}
			</table>
							</form>

			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>


	</div>
</div>
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
{include file="footer.tpl"}
</body>
</html>

