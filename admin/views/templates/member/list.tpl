{php}
session_start();
$_SESSION['page']='member';
$_SESSION['tab']='customer';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#member_no").val("");
	$("#tel").val("");
	$("#user_name").val("");
	$("#shop_no").val("");
	 $("#member_flg").attr("checked", false);
}

function rsv_submit( member_id, buy_no )
{

	document.fm_list.action = "reserve/adminEdit/";
	document.fm_list.member_id.value = member_id;
	document.fm_list.buy_no.value = buy_no;
	document.fm_list.exec.value = "rsv_submit";
	document.fm_list.submit();
}

function orderbyChange() {
	document.orderbyForm.action = "/member/list/";
	document.orderbyForm.submit(); 
}


function pageFunc() {
	var val = $('#page').val();
	if (val < 1) {
		alert('Page no should be gretter then 0');
		return false;
	}
	document.pageForm.action = "/member/list/";
	document.pageForm.submit();
}




{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="member/menu_member.tpl"}
		<h3>顧客一覧</h3>

		{include file="messages.tpl"}
		{if $result_messages}
			<center><span class="red">{$result_messages}</span></center>
		{/if}

		<form method="post" name="fm_search" action="/member/list/">
		<table class="search center">
		<tr>
			<th>名前</th>
			<td>
				<input type="text" name="name" id="user_name"  value="{$search.name}" size="20" />
			</td>
			<th>会員番号</th>
			<td>
				<input type="text" name="member_no" id="member_no"  value="{$search.member_no}" size="20" />
			</td>

		</tr>
		<tr>
			<th>電話番号</th>
			<td>
				<input type="text" name="tel" id="tel"  value="{$search.tel}" size="20" />
			</td>
				<th>店舗</th>
				<td>
					{html_options name=shop_no options=$shopArr selected=$search.shop_no id=shop_no}
				</td>
		<tr>
			<th>削除会員も含む</th>
			<td>
				<input type="checkbox" name="member_flg" id="member_flg"  value="1" {if $search.member_flg==1}checked{/if} />
			</td>
		</tr>
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_search" class="btn-lg" >検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
<hr>
{if $login_admin.shop_no>=0}
<a href="/member/edit/" class="btn">新規作成</a>
<br />
{/if}
<form action="" method="post">

<button type="submit" name="csv" class="btn-lg mt10">CSV出力</button>&nbsp;
<button type="submit" name="csv_history" class="btn-lg mt10">CSV(履歴付き)出力</button>&nbsp;
</form>


		{* 検索結果 *}
<p class="mt10">未使用の購入済みコースがある会員様の削除は出来ません。<br/>
予約中→来店に変更しない場合には、規定回数に達しても来店状況に表示され続けます</p>
			<div class="paging clearfix">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
			</div>

			<div>
				<div class="left">
					<form action="" method="GET" name="orderbyForm">
					ソート : 
						<select name="orderby" onchange="orderbyChange()">
							<option value="none">ソートの選択</option>
							<option value="member_id" {if $ord=='member_id'}{'selected'}{/if}>会員 ID</option>
							<option value="name" {if $ord=='name'}{'selected'}{/if}>お名前</option>
						</select>
					</form>
				</div>
				<div class="right">
					<form action="" method="GET" name="pageForm">
						<div class="right">
							Jump to Page No : <input type="number" name="page" min="1" id="page">
									<input type="button" name="btn" value="Jump" onclick="pageFunc()">
						</div>
					</form>
				</div>
			</div>


			<!--<table id="tablefix" class="admins clear">-->
			<table  class="admins clear" style="margin-top: 50px;">

			<tr>
				<th>編集</th>
				<th width="100">会員No</th>
				<th width="150">お名前</th>
				<th>電話番号</th>
				<th>購入/残回数</th>
				<th >管理用備考</th>
				<th>削除</th>
			</tr>
			{foreach from=$members item="member"}

				<tr>
					<!--<td class="tc"><a href="member/history/?member_id={$member.member_id}" class="btn btn-sm"><i class="fa fa-lg fa-history"> </i></a></td>  -->
					<td class="tc"><a href="member/edit/?member_id={$member.member_id}" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i></a></td>
					<td>{$member.member_no}</td>
					<td>{$member.name}<br />{$member.name_kana}</td>
					<td>{$member.tel}</td>
					<td>
						{foreach from=$member.reserve item=item}
                        	<div class="mb5">
							{$item.name}/残{$item.zan}回
                            </div>
						{/foreach}
						{if $member.rplan==1}予約あり{/if}
					</td>


					<td>
						<form name="fm_list" id="fm_list" method="POST" action="/member/list/">
                    	<div class="left w60">
							<textarea name="kanri_comment[{$member.member_id}]" class="w100">{$member.kanri_comment}</textarea>
                        </div>
                        {if $member.shop_no==$login_admin.shop_no || $login_admin.shop_no==0}
                        <div class="right">
							<input type="submit" name="submit" value="更新">
                         </div>
                         {/if}
						</form>
					</td>
					<td class="tc">
					{if $login_admin.shop_no>=0}
						{if $member.member_flg==99}
							削除会員
						{elseif !$member.reserve && $member.rplan!=1 && ($member.shop_no==$login_admin.shop_no || $login_admin.shop_no==0)}
						<form name="fm_list" id="fm_list" method="POST" action="/member/list/">
							<input type="submit" name="delete_dummy[{$member.member_id}]" value="削除" onClick="return confirm('{$member.name}様のデータを削除しますが良いですか？');" class="btn-delete btn-sm">
						</form>
						{/if}
					{/if}
					</td>

				</tr>

			{foreachelse}
				<tr>
					<td colspan="11">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			{/foreach}
			</table>
			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

