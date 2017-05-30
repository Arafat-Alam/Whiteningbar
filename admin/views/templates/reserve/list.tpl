{php}
session_start();
$_SESSION['page']='reserve';
$_SESSION['tab']='reserve';
$page = $_GET['page'];
$this->assign('page',$page);
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#shop_no").val("");
	$("#user_name").val("");
	$("#start_date").val("");
	$("#end_date").val("");
	$("#ins_start").val("");
	$("#ins_end").val("");
	$("#course_no").val("");


}

function orderbyChange() {
	// document.orderbyForm.action = "/reserve/list/";
	// document.orderbyForm.submit(); 
	var order = $("#selectOrderBy").val();
	$("#orders").val(order);
	$("#sbm_search").click();

}

function pageFunc() {
	var lastPage = {/literal}{$lastPage}{literal};
	var val = $('#page').val();
	if (val < 1 ) {
		alert('Page no should be gretter then 0');
		return false;
	}else if (val > lastPage) {
		alert('Maximum page no is '+lastPage);
		return false;
	}
	document.pageForm.action = "/reserve/list/";
	document.pageForm.submit();
}


function clickDisableChk(obj) {
	var id = $(obj).attr("id").replace("disabled_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#disabled_" + id).val("t");
	}
	else {
		$("#disabled_" + id).val("f");
	}
}

function clickDeleteChk(obj) {
	var id = $(obj).attr("id").replace("delete_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#delete_" + id).val("t");
	}
	else {
		$("#delete_" + id).val("f");
	}
}

function getList(){

	target1 = $("#menu");
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList2/",
		cache : false,
		dataType: "text",
		data : {
			course_no: $("#course_no").val(),
			menu_no: {/literal}{if $input_data.menu_no}{$input_data.menu_no}{else}0{/if}{literal}
		},
		success: function(data, dataType) {
			console.log(data);
			// target1.after(data.html);
			target1.html(data);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


$(function(){
	$("#start_date").datepicker({
		dateFormat: "yy/mm/dd"
	});
	$("#end_date").datepicker({
		dateFormat: "yy/mm/dd"
	});
	$("#ins_start").datepicker({
		dateFormat: "yy/mm/dd"
	});
	$("#ins_end").datepicker({
		dateFormat: "yy/mm/dd"
	});

	if($("#course_no").val()){
		getList();
	}


});


{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
		{include file="reserve/menu_reserve.tpl"}
		<h3>予約一覧</h3>

	<div class="w80 center search_section">
		{include file="messages.tpl"}
		{if $result_messages}
			<center><span class="red">{$result_messages}</span></center>
		{/if}

		<form method="post" name="fm_search" action="/reserve/list/" name="searchForm">
		<table class="admins clear mt10">
		{if $login_admin.shop_no<=0}
			<tr>
				<th>予約店舗</th>
				<td>
					{html_options name=shop_no options=$shopArr selected=$search.shop_no id=shop_no}
				</td>
			</tr>
		{/if}
		<tr>
				<th>予約日</th>
				<td>
				<input type="text" id="start_date" name="start_date" size="25" value="{$search.start_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end_date" name="end_date" size="25" value="{$search.end_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>

<input type="submit" name="submit_today" value="本日">
				</td>
		</tr>
		<tr>
				<th>予約登録日</th>
				<td>
				<input type="text" id="ins_start" name="ins_start" size="25" value="{$search.ins_start|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
				～
				<input type="text" id="ins_end" name="ins_end" size="25" value="{$search.ins_end|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>

				</td>
		</tr>
		<tr>
				<th>コース > メニュー</th>
				<td>
					{html_options name=course_no options=$courseArr selected=$search.course_no id="course_no" onChange="getList()" }
※コースを選択すると対応するメニューが表示されます
					<div id="menu"></div>
				</td>
		</tr>
		<tr>
			<th>お申込者名</th>
			<td>
				<input type="text" name="name" id="user_name"  value="{$search.name}" size="20" />
			</td>
		</tr>
		<tr>
			<th>ソート</th>
			<td>
				予約日が
				<label><input type="radio" name="orderby" value="1" {if $search.orderby==1}checked{/if}>新しい順　</label>
				<label><input type="radio" name="orderby" value="2" {if $search.orderby==2}checked{/if}>古い順　</label>/　
				予約登録日が
				<label><input type="radio" name="orderby" value="3" {if $search.orderby==3}checked{/if}>新しい順　</label>
				<label><input type="radio" name="orderby" value="4" {if $search.orderby==4}checked{/if}>古い順　</label>

				<!-- <input type="hidden" name="page" id="page" value="{$page}"> -->
			</td>
		</tr>


		</table>
		<!-- <p class="tc">※店舗とお申込者を入力した場合、該当のお客様が予約をした店舗で検索します。</p> -->

		<div class="mt10 tc">
			<button type="submit" name="sbm_search" class="btn-lg" id="sbm_search">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
	</div>
<hr>
<form action="" method="post">

<button type="submit" name="csv" class="btn-lg">CSV出力</button>&nbsp;
<button type="button" class="btn-lg" onclick="window.print();">印刷する</button>&nbsp;
</form>

		{* 検索結果 *}

			<div class="paging clearfix">
				<div class="left">Showing {$from} to {$to} of {$total_cnt} items  
						{* 件のデータが見つかりました。*}
				</div>
				<div class="right">{$navi}</div>
			</div>
				<div>
					<form action="" method="POST" name="orderbyForm">
					<div class="left">
					ソート : 
						<select name="orderbyselect" onchange="orderbyChange()" id="selectOrderBy">
							<option value="none">ソートの選択</option>
							<option value="reserve_date" {if $ord=='reserve_date'}{'selected'}{/if}>予約日</option>
							{if $login_admin.shop_no<=0}
							<option value="shop" {if $ord=='shop'}{'selected'}{/if}>予約店舗</option>
							{/if}
							<option value="reserve_no" {if $ord=='reserve_no'}{'selected'}{/if}>予約番号</option>
						</select>
					</div>
					</form>
					<form action="" method="GET" name="pageForm">
					<div class="right">
						Jump to Page No : <input type="number" name="page" min="1" id="page">
								<input type="button" name="btn" value="Jump" onclick="pageFunc()">
					</div>
					</form>
				</div>

			<table  class="admins clear" style="margin-top: 50px; " id="dataTable">
				<thead>	
					<tr>
						<th width="80">予約番号</th>
						<th width="80">予約日</th>
						<th width="80">時間</th>
						<th width="120">お申込者</th>
						{if $login_admin.shop_no<=0}
							<th width="100">予約店舗</th>
						{/if}
						<th width="130">メニュー</th>
						<th class="nowrap">人数</th>
						<!--  <th width="150">メッセージ</th>-->
						<th  id="right_th">管理メモ</th>
					</tr>
				</thead>
			{foreach from=$arr item="item"}
			 {assign var=rno value="$item.reserve_no"}
			 <tbody>
				<tr>
					<td><a href="/reserve/edit/?reserve_no={$item.reserve_no}">{$item.reserve_no}</a></td>
					<td>{$item.reserve_date|date_format:"%Y/%m/%d"}</td>
					<td>{$item.start_time|date_format:"%H:%M"}～{$item.end_time|date_format:"%H:%M"}</td>
					<td>{$item.name}/{$item.name_kana}<br />
						<a href="/member/edit/?member_id={$item.member_id}" class="btn btn-sm">詳細</a>&nbsp;<a href="/member/history/?member_id={$item.member_id}" class="btn btn-sm">履歴</a>
						<br />({$item.member_no})
					</td>
					{if $login_admin.shop_no<=0}
						<td>{$item.shop_name}</td>
					{/if}
					<td>{$item.menu_name}</td>
					<td class="tc">{$item.number}人</td>
					<!-- <td>{$item.comment|nl2br}</td>-->
					<td id="right_com">
						<form name="fm_list" id="fm_list" method="POST" action="/reserve/list/">
                        <div class="left w60">
                            <textarea name="kanri_comment" class="w100">{$item.kanri_comment}</textarea>
                            <!-- {html_radios name=tel_flg options=$telArr selected=$item.tel_flg } -->
                        </div>
                        <div class="right">
                            <input type="submit" name="submit" value="更新">
                            <input type="hidden" name="reserve_no" value="{$item.reserve_no}">
                        </div>
						</form>
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="11">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			{/foreach}
			</tbody>
			</table>
			<div class="paging">
				<div class="left">Showing {$from} to {$to} of {$total_cnt} items  
						{* 件のデータが見つかりました。*}
				</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>
			</form>

	</div>
</div>
{include file="footer.tpl"}
<style type="text/css">
{literal}
	@media print {
		table { page-break-after:auto }
		tr    { page-break-inside:avoid; page-break-after:auto }
		td    { page-break-inside:avoid; page-break-after:auto }
		thead { display:table-header-group }
		tfoot { display:table-footer-group }

		header { display: none; }
		head{ display: none;}
		h3 { display: none; }
		button { display: none; }
		hr { display: none; }
		form { display: none; }
		#header{ display: none; }
		#jMenu{ display: none; }
		#footer{ display: none; }/*
		#right_com{ display: none; }
		#right_th{ display: none; }*/
		.search_section{ display: none; }
		.scrollToTop{ display: none ! important; }
		.tab{ display: none; }
		.paging{ display: none; }
		.left{ display: none; }
		.right{ display: none; }
		#dataTable{margin-top: -100px;}
	}
{/literal}
</style>
<script type="text/javascript">
{literal}
/*$(document).ready(function() {
    $('#dataTable').DataTable();
} );*/
{/literal}
</script>
</body>
</html>

