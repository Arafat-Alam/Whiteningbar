{include file="head.tpl"}

<script type="text/javascript">
{literal}


function getSalaryChange1() {
	target1 = $("#form_label1");
	$(".salary1").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/company/getSalaryChange/",
		cache : false,
		dataType: "json",
		data : {
			salary: $("#salary1").val(),
			pno: 1,
			job_no:{/literal}{if $input_data.job_no}{$input_data.job_no}{else}0{/if}{literal}
	    },
		success: function(data, dataType) {
			target1.before(data.html);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error!" + textStatus+ " " + errorThrown);
		}
	});

}
function getSalaryChange2() {
	target2 = $("#form_label2");
	$(".salary2").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/company/getSalaryChange/",
		cache : false,
		dataType: "json",
		data : {
			salary: $("#salary2").val(),
			pno: 2,
			job_no:{/literal}{if $input_data.job_no}{$input_data.job_no}{else}0{/if}{literal}
	    },
		success: function(data, dataType) {
			target2.before(data.html);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error!" + textStatus+ " " + errorThrown);
		}
	});

}
function getSalaryChange3() {
	target3 = $("#form_label3");
	$(".salary3").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/company/getSalaryChange/",
		cache : false,
		dataType: "json",
		data : {
			salary: $("#salary3").val(),
			pno: 3,
			job_no:{/literal}{if $input_data.job_no}{$input_data.job_no}{else}0{/if}{literal}
	    },
		success: function(data, dataType) {
			target3.before(data.html);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error!" + textStatus+ " " + errorThrown);
		}
	});

}
function getSalaryChange4() {
	target4 = $("#form_label4");
	$(".salary4").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/company/getSalaryChange/",
		cache : false,
		dataType: "json",
		data : {
			salary: $("#salary4").val(),
			pno: 4,
			job_no:{/literal}{if $input_data.job_no}{$input_data.job_no}{else}0{/if}{literal}
	    },
		success: function(data, dataType) {
			target4.before(data.html);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error!" + textStatus+ " " + errorThrown);
		}
	});

}







var tbl_cnt_t = {/literal}{$tbl_cnt_t}{literal}; //グローバル変数
var tbl_cnt_y = {/literal}{$tbl_cnt_y}{literal}; //グローバル変数

$(function(){
//追加ボタンをクリックした時の処理
$('#add_btn_t').click(function() {
			target1 = $("#image_tate");
			tbl_cnt_t++;
			var my=add_tbl_t(tbl_cnt_t);
			target1.before(my);
});


$('#add_btn_y').click(function() {
			target2 = $("#image_yoko");
			tbl_cnt_y++;
			var my=add_tbl_y(tbl_cnt_y);
			target2.before(my);
 });

function add_tbl_t(tbl_cnt_t){

	var str = '<table><tr><td><input type="file" name="file_t[]"/><br />';
	str += 'コメント：<input type="text" name="comment_t[]"></td></tr></table>';

	return str;

}

function add_tbl_y(tbl_cnt_y){

	var str = '<table><tr><td><input type="file" name="file_y[]"/><br />';
	str += 'コメント：<input type="text" name="comment_y[]"></td></tr></table>';

	return str;

}
	//雇用条件の給料
	if ($("#salary1").val() !="") {
		getSalaryChange1();
	}
	if ($("#salary2").val() !="") {
		getSalaryChange2();
	}
	if ($("#salary3").val() !="") {
		getSalaryChange3();
	}
	if ($("#salary4").val() !="") {
		getSalaryChange4();
	}


	//日付
	$("#start").datepicker({
		dateFormat: "yy/mm/dd",
		showButtonPanel: true,
	});
	$("#end").datepicker({
		dateFormat: "yy/mm/dd",
		showButtonPanel: true,
	});
});

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
		<h3>求人票編集</h3>

		{if $msg}<font color="red">{$msg}</font>{/if}
		{if $result_messages}<font color="red">入力エラーがあります</font>{/if}
		<form method="post" name="fm_search" action="company/job_edit" enctype="multipart/form-data" >
		<table class="search">
		<tr>
			<th>掲載期間<font color="red">※</font></th>
			<td>
				{if $result_messages.view_start}
					<font color="red"> {$result_messages.view_start}</font><br />
				{/if}
				{if $result_messages.view_end}
					<font color="red"> {$result_messages.view_end}</font><br />
				{/if}


			<input type="text" id="start" name="view_start" size="25" value={$input_data.view_start|date_format:"%Y/%m/%d"} />
			～
			<input type="text" id="end" name="view_end" size="25" value={$input_data.view_end|date_format:"%Y/%m/%d"}/>

			</td>
		</tr>
		<tr>
			<th>募集カテゴリ※</th>
			<td>
						{if $result_messages.category1_id}
							<font color="red"> {$result_messages.category1_id}</font><br />
						{/if}
				{html_options name=category1_id options=$category1Arr selected=$input_data.category1_id}

			</td>
		</tr>
<!--
		<tr>
			<th>募集職種</th>
			<td>
						{if $result_messages.job}
							<font color="red"> {$result_messages.job}</font><br />
						{/if}
				<input type="text" name="job" id="user_id"  value="{$input_data.job}" size="20" />
			</td>
		</tr>
  -->
		<tr>
			<th>募集背景<font color="red">※</font></th>
			<td>
						{if $result_messages.job_background}
							<font color="red"> {$result_messages.job_background}</font><br />
						{/if}
				<textarea name="job_background"  cols="60" rows="5">{$input_data.job_background}</textarea>
			</td>
		</tr>
		<tr>
			<th>仕事内容<font color="red">※</font></th>
			<td>
						{if $result_messages.job_comment}
							<font color="red"> {$result_messages.job_comment}</font><br />
						{/if}
				<textarea name="job_comment"  cols="60" rows="10">{$input_data.job_comment}</textarea>
			</td>
		</tr>
		<tr>
			<th>勤務地住所<font color="red">※</font></th>
			<td>
						{if $result_messages.address}
							<font color="red"> {$result_messages.address}</font><br />
						{/if}
				<textarea name="address"  cols="60" rows="3">{$input_data.address}</textarea>
			</td>
		</tr>
		<tr>
			<th>勤務地<font color="red"><font color="red">※</font></font></th>
			<td>
						{if $result_messages.place}
							<font color="red"> {$result_messages.place}</font><br />
						{/if}
	            {html_checkboxes name="place" options=$placeArr selected=$input_data.place assign="checkboxes"}
				{foreach from=$checkboxes item="checkbox"}
					{$checkbox}{cycle values=",,,,,<br />"}
				{/foreach}
			</td>
		</tr>
		<tr>
			<th>勤務地最寄駅<font color="red">※</font></th>
			<td>
						{if $result_messages.station}
							<font color="red"> {$result_messages.station}</font><br />
						{/if}
				<textarea name="station"  cols="60" rows="3">{$input_data.station}</textarea>
			</td>
		</tr>
		<tr>
			<th>面接地<font color="red">※</font></th>
			<td>
						{if $result_messages.interview}
							<font color="red"> {$result_messages.interview}</font><br />
						{/if}
				<input type="checkbox" name="interview_flg" id="user_name"  value="1" {if $input_data.interview_flg==1}checked{/if} />
				勤務地と同じ<br />
				<input type="text" name="interview" id="user_id"  value="{$input_data.interview}" size="60" />
			</td>
		</tr>
		<tr>
			<th>応募方法</th>
			<td>
				<input type="radio" name="apply_flg" id="user_name"  value="1" {if $input_data.apply_flg==1}checked{/if} />
				応募フォームから受付
				<!--
				<input type="radio" name="apply_flg" id="user_name"  value="2" {if $input_data.apply_flg==2}checked{/if} />
				応募フォームと電話による受付
				  -->
			</td>
		</tr>
		<tr>
			<th>選考プロセス<font color="red">※</font></th>
			<td>
						{if $result_messages.selection}
							<font color="red"> {$result_messages.selection}</font><br />
						{/if}
				<textarea name="selection"  cols="60" rows="10">{$input_data.selection}</textarea>
			</td>
		</tr>
		<tr>
			<th>担当者<font color="red">※</font></th>
			<td>
						{if $result_messages.tanto_name}
							<font color="red"> {$result_messages.tanto_name}</font><br />
						{/if}
				<input type="text" name="tanto_name" id="user_id"  value="{$input_data.tanto_name}" size="40" />
			</td>
		</tr>
		<tr>
			<th>メールアドレス<font color="red">※</font></th>
			<td>
						{if $result_messages.email}
							<font color="red"> {$result_messages.email}</font><br />
						{/if}
				<input type="text" name="email" id="user_id"  value="{$input_data.email}" size="40" />
			</td>
		</tr>
		<tr>
			<th>サブメールアドレス１</th>
			<td>
						{if $result_messages.email_sub1}
							<font color="red"> {$result_messages.email_sub1}</font><br />
						{/if}
				<input type="text" name="email_sub1" id="user_id"  value="{$input_data.email_sub1}" size="40" />
			</td>
		</tr>
		<tr>
			<th>サブメールアドレス２</th>
			<td>
						{if $result_messages.email_sub2}
							<font color="red"> {$result_messages.email_sub2}</font><br />
						{/if}
				<input type="text" name="email_sub2" id="user_id"  value="{$input_data.email_sub2}" size="30" />
			</td>
		</tr>
		<tr>
			<th>電話番号<font color="red">※</font></th>
			<td>
						{if $result_messages.tel}
							<font color="red"> {$result_messages.tel}</font><br />
						{/if}
				<input type="text" name="tel" id="user_id"  value="{$input_data.tel}" size="30" />
			</td>
		</tr>
		<tr>
			<th>キャッチコピー<font color="red">※</font></th>
			<td>
						{if $result_messages.promo}
							<font color="red"> {$result_messages.promo}</font><br />
						{/if}
				<textarea name="promo"  cols="60" rows="3">{$input_data.promo}</textarea>
			</td>
		</tr>
		<tr>
			<th>PR<font color="red">※</font></th>
			<td>
						{if $result_messages.pr}
							<font color="red"> {$result_messages.pr}</font><br />
						{/if}
				<textarea name="pr"  cols="60" rows="20">{$input_data.pr}</textarea>
			</td>
		</tr>
		<tr>
			<th>メッセージ1<font color="red">※</font></th>
			<td>
						{if $result_messages.message1}
							<font color="red"> {$result_messages.message1}</font><br />
						{/if}
						{if $result_messages.message_title1}
							<font color="red"> {$result_messages.message_title1}</font><br />
						{/if}
				タイトル：<br />
				<input type="text" name="message_title1" id="user_id"  value="{$input_data.message_title1}" size="40" />
				<br />メッセージ：<br />
				<textarea name="message1"  cols="60" rows="5">{$input_data.message1}</textarea>
			</td>
		</tr>
		<tr>
			<th>メッセージ2</th>
			<td>
						{if $result_messages.message2}
							<font color="red"> {$result_messages.message2}</font><br />
						{/if}
				タイトル：<br />
				<input type="text" name="message_title2" id="user_id"  value="{$input_data.message_title2}" size="40" />
				<br />メッセージ：<br />
				<textarea name="message2"  cols="60" rows="5">{$input_data.message2}</textarea>
			</td>
		</tr>
		</table>

		雇用形態
		<table class="search">
		<tr>
			<th rowspan="10">条件１</th>
			<th>雇用形態<font color="red">※</font></th>
			<td>
						{if $result_messages.employ}
							<font color="red"> {$result_messages.employ}</font><br />
						{/if}
				{html_options name=employ[0] options=$employArr selected=$input_data.employ.0}
			</td>
		</tr>
		<tr>
			<th>勤務時間<font color="red">※</font></th>
			<td>
						{if $result_messages.job_time}
							<font color="red"> {$result_messages.job_time}</font><br />
						{/if}
				<input type="text" name="job_time[0]" id="user_id"  value="{$input_data.job_time.0}" size="40" />
			</td>
		</tr>
		<tr>
			<th>休日<font color="red">※</font></th>
			<td>
						{if $result_messages.holiday}
							<font color="red"> {$result_messages.holiday}</font><br />
						{/if}
				<input type="text" name="holiday[0]" id="user_id"  value="{$input_data.holiday.0}" size="60" />
			</td>
		</tr>
		<tr>
			<th>給与<font color="red">※</font></th>
			<td>
						{if $result_messages.salary_flg}
							<font color="red"> {$result_messages.salary_flg}</font><br />
						{/if}
				{html_options name=salary_flg[0] options=$salaryArr selected=$input_data.salary_flg.0 id="salary1" onChange="getSalaryChange1()"}
				<div id="form_label1"></div>
			</td>
		</tr>
		<tr>
			<th>給与補足</th>
			<td>
						{if $result_messages.salary_add}
							<font color="red"> {$result_messages.salary_add}</font><br />
						{/if}
				<input type="text" name="salary_add[0]" id="user_id"  value="{$input_data.salary_add.0}" size="60" />
			</td>
		</tr>
		<tr>
			<th>交通費<font color="red">※</font></th>
			<td>
						{if $result_messages.trafic_flg}
							<font color="red"> {$result_messages.trafic_flg}</font><br />
						{/if}
				{html_options name=trafic_flg[0] options=$traficArr selected=$input_data.trafic_flg.0}
				<input type="text" name="trafic[0]" id="user_id"  value="{$input_data.trafic.0}" size="20" />円
			</td>
		</tr>
		<tr>
			<th>交通費補足</th>
			<td>
				<input type="text" name="trafic_add[0]" id="user_id"  value="{$input_data.trafic_add.0}" size="60" />
			</td>
		</tr>
		<tr>
			<th>待遇</th>
			<td>
				<textarea name="treatment[0]" rows="5" cols="60">{$input_data.treatment.0}</textarea>
			</td>
		</tr>
		<tr>
			<th>研修・試用期間<font color="red">※</font></th>
			<td>
						{if $result_messages.try_flg}
							<font color="red"> {$result_messages.try_flg}</font><br />
						{/if}
				{html_options name=try_flg[0] options=$tryArr selected=$input_data.try_flg.0}
				<input type="text" name="try_add[0]" id="user_id"  value="{$input_data.try_add.0}" size="40" />
			</td>
		</tr>
		<tr>
			<th>応募資格<font color="red">※</font></th>
			<td>
						{if $result_messages.shikaku_add}
							<font color="red"> {$result_messages.shikaku_add}</font><br />
						{/if}
				<input type="checkbox" name="shikaku_flg[0]" id="user_name"  value="1" {if $input_data.shikaku_flg.0==1}checked{/if} />
				実務経験不問
				<textarea name="shikaku_add[0]" rows="5" cols="50">{$input_data.shikaku_add.0}</textarea>


			</td>
		</tr>

		<tr>
			<th rowspan="10">条件２</th>
			<th>雇用形態</th>
			<td>
				{html_options name=employ[1] options=$employArr selected=$input_data.employ.1}
			</td>
		</tr>
		<tr>
			<th>勤務時間</th>
			<td>
				<input type="text" name="job_time[1]" id="user_id"  value="{$input_data.job_time.1}" size="40" />
			</td>
		</tr>
		<tr>
			<th>休日</th>
			<td>
				<input type="text" name="holiday[1]" id="user_id"  value="{$input_data.holiday.1}" size="60" />
			</td>
		</tr>
		<tr>
			<th>給与</th>
			<td>
				{html_options name=salary_flg[1] options=$salaryArr selected=$input_data.salary_flg.1 id=salary2 onChange="getSalaryChange2()"}
				<div id="form_label2"></div>

			</td>
		</tr>
		<tr>
			<th>給与補足</th>
			<td>
						{if $result_messages.salary_add.1}
							<font color="red"> {$result_messages.salary_add.1}</font><br />
						{/if}
				<input type="text" name="salary_add[1]" id="user_id"  value="{$input_data.salary_add.1}" size="60" />
			</td>
		</tr>
		<tr>
			<th>交通費</th>
			<td>
				{html_options name=trafic_flg[1] options=$traficArr selected=$input_data.trafic_flg.1}
				<input type="text" name="trafic[1]" id="user_id"  value="{$input_data.trafic.1}" size="20" />円
			</td>
		</tr>
		<tr>
			<th>交通費補足</th>
			<td>
				<input type="text" name="trafic_add[1]" id="user_id"  value="{$input_data.trafic_add.1}" size="60" />
			</td>
		</tr>
		<tr>
			<th>待遇</th>
			<td>
				<textarea name="treatment[1]" rows="5" cols="60">{$input_data.treatment.1}</textarea>
			</td>
		</tr>
		<tr>
			<th>研修・試用期間</th>
			<td>
				{html_options name=try_flg[1] options=$tryArr selected=$input_data.try_flg.1}
				<input type="text" name="try_add[1]" id="user_id"  value="{$input_data.try_add.1}" size="40" />
			</td>
		</tr>
		<tr>
			<th>応募資格</th>
			<td>
				<input type="checkbox" name="shikaku_flg[1]" id="user_name"  value="1" {if $input_data.shikaku_flg.1==1}checked{/if} />
				実務経験不問
				<textarea name="shikaku_add[1]" rows="5" cols="50">{$input_data.shikaku_add.1}</textarea>

			</td>
		</tr>

		<tr>
			<th rowspan="10">条件３</th>
			<th>雇用形態</th>
			<td>
				{html_options name=employ[2] options=$employArr selected=$input_data.employ.2}
			</td>
		</tr>
		<tr>
			<th>勤務時間</th>
			<td>
				<input type="text" name="job_time[2]" id="user_id"  value="{$input_data.job_time.2}" size="40" />
			</td>
		</tr>
		<tr>
			<th>休日</th>
			<td>
				<input type="text" name="holiday[2]" id="user_id"  value="{$input_data.holiday.2}" size="60" />
			</td>
		</tr>
		<tr>
			<th>給与</th>
			<td>
				{html_options name=salary_flg[2] options=$salaryArr selected=$input_data.salary_flg.2 id=salary3 onChange="getSalaryChange3()"}
				<div id="form_label3"></div>

			</td>
		</tr>
		<tr>
			<th>給与補足</th>
			<td>
				<input type="text" name="salary_add[2]" id="user_id"  value="{$input_data.salary_add.2}" size="60" />
			</td>
		</tr>
		<tr>
			<th>交通費</th>
			<td>
				{html_options name=trafic_flg[2] options=$traficArr selected=$input_data.trafic_flg.2}
				<input type="text" name="trafic[2]" id="user_id"  value="{$input_data.trafic.2}" size="40" />円
			</td>
		</tr>
		<tr>
			<th>交通費補足</th>
			<td>
				<input type="text" name="trafic_add[2]" id="user_id"  value="{$input_data.trafic_add.2}" size="60" />
			</td>
		</tr>
		<tr>
			<th>待遇</th>
			<td>
				<textarea name="treatment[2]" rows="5" cols="60">{$input_data.treatment.2}</textarea>
			</td>
		</tr>
		<tr>
			<th>研修・試用期間</th>
			<td>
				{html_options name=try_flg[2] options=$tryArr selected=$input_data.try_flg.2}
				<input type="text" name="try_add[2]" id="user_id"  value="{$input_data.try_add.2}" size="40" />
			</td>
		</tr>
		<tr>
			<th>応募資格</th>
			<td>
				<input type="checkbox" name="shikaku_flg[2]" id="user_name"  value="1" {if $input_data.shikaku_flg.2==1}checked{/if} />
				実務経験不問
				<textarea name="shikaku_add[2]" rows="5" cols="50">{$input_data.shikaku_add.2}</textarea>
			</td>
		</tr>
		<tr>
			<th rowspan="10">条件４</th>
			<th>雇用形態</th>
			<td>
				{html_options name=employ[3] options=$employArr selected=$input_data.employ.3}
			</td>
		</tr>
		<tr>
			<th>勤務時間</th>
			<td>
				<input type="text" name="job_time[3]" id="user_id"  value="{$input_data.job_time.3}" size="40" />
			</td>
		</tr>
		<tr>
			<th>休日</th>
			<td>
				<input type="text" name="holiday[3]" id="user_id"  value="{$input_data.holiday.3}" size="60" />
			</td>
		</tr>
		<tr>
			<th>給与</th>
			<td>
				{html_options name=salary_flg[3] options=$salaryArr selected=$input_data.salary_flg.3 id=salary4 onChange="getSalaryChange4()"}
				<div id="form_label4"></div>

			</td>
		</tr>
		<tr>
			<th>給与補足</th>
			<td>
				<input type="text" name="salary_add[3]" id="user_id"  value="{$input_data.salary_add.3}" size="60" />
			</td>
		</tr>
		<tr>
			<th>交通費</th>
			<td>
				{html_options name=trafic_flg[3] options=$traficArr selected=$input_data.trafic_flg.3}
				<input type="text" name="trafic[3]" id="user_id"  value="{$input_data.trafic.3}" size="20" />円
			</td>
		</tr>
		<tr>
			<th>交通費補足</th>
			<td>
				<input type="text" name="trafic_add[3]" id="user_id"  value="{$input_data.trafic_add.3}" size="60" />
			</td>
		</tr>
		<tr>
			<th>待遇</th>
			<td>
				<textarea name="treatment[3]" rows="5" cols="60">{$input_data.treatment.3}</textarea>
			</td>
		</tr>
		<tr>
			<th>研修・試用期間</th>
			<td>
				{html_options name=try_flg[3] options=$tryArr selected=$input_data.try_flg.3}
				<input type="text" name="try_add[3]" id="user_id"  value="{$input_data.try_add.3}" size="40" />
			</td>
		</tr>
		<tr>
			<th>応募資格</th>
			<td>
				<input type="checkbox" name="shikaku_flg[3]" id="user_name"  value="1" {if $input_data.shikaku_flg.3==1}checked{/if} />
				実務経験不問
				<textarea name="shikaku_add[3]" rows="5" cols="50">{$input_data.shikaku_add.3}</textarea>
			</td>
		</tr>

		</table>


		こだわり条件の登録
		<table class="search">
		<tr>
			<td>
				{foreach from=$charaArr item="item"}

					{if $item.cflag==1}
						<br />{$item.name}<br />
					{else}
						<input type="checkbox" name="character[]" value="{$item.id}" {if $input_data.character}{if in_array($item.id,$input_data.character)}checked{/if}{/if} >{$item.name}&nbsp;&nbsp;
					{/if}
				{/foreach}
			</td>
		</tr>
		</table>
<br />

		画像の登録
						{if $result_messages.img}
							<font color="red"> {$result_messages.img}</font><br />
						{/if}
		<table class="search">
			<tr>
				<th>
					TOPページ 新着一覧画像<font color="red">※</font>（横143px×縦107px、容量100KB以内）
				</th>
			</tr>
			<tr>
				<td>

						{if $result_messages.file_t_0}
							<font color="red"> {$result_messages.file_t_0}</font><br />
						{/if}


					<input type="file" name="file_t[0]" />
					{if $smarty.session.TMP_FUP.0!=""}
						<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP.0}" >
					{elseif $input_data.file_t.0!=""}
						<img src="{$smarty.const.URL_IMG_JOB}{$input_data.file_t.0}?{$smarty.now}" >
						<!--<input type="checkbox" name="del_t[0]" value="{$input_data.img_no.0}">削除  -->
						<input type="hidden" name="file_t[0]" value="{$input_data.file_t.0}">
					{/if}
					<br />
					<!-- コメント：<input type="text" name="comment_t[0]" value="{$input_data.comment_t.0}">-->
				</td>
			</tr>
			<tr>
				<th>
					検索結果画像<font color="red">※</font>（横180px×縦100px、容量100KB以内）
				</th>
			</tr>
			<tr>
				<td>
						{if $result_messages.file_t_1}
							<font color="red"> {$result_messages.file_t_1}</font><br />
						{/if}
					<input type="file" name="file_t[1]" />
					{if $smarty.session.TMP_FUP.1!=""}
						<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP.1}" >
					{elseif $input_data.file_t.1!=""}
						<img src="{$smarty.const.URL_IMG_JOB}{$input_data.file_t.1}?{$smarty.now}" >
						<!--<input type="checkbox" name="del_t[1]" value="{$input_data.img_no.1}">削除  -->
						<input type="hidden" name="file_t[1]" value="{$input_data.file_t.1}">
					{/if}
					<br />
					<!--  コメント：<input type="text" name="comment_t[1]" value="{$input_data.comment_t.1}">-->
				</td>
			</tr>

			<tr>
				<th>
					詳細ページメイン画像<font color="red">※</font>（横250px×縦300px、容量100KB以内）
				</th>
			</tr>
			<tr>
				<td>
						{if $result_messages.file_t_2}
							<font color="red"> {$result_messages.file_t_2}</font><br />
						{/if}
						{if $result_messages.comment_t_2}
							<font color="red"> {$result_messages.comment_t_2}</font><br />
						{/if}


					<input type="file" name="file_t[2]" />
					{if $smarty.session.TMP_FUP.2!=""}
						<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP.2}" >
					{elseif $input_data.file_t.2!=""}
						<img src="{$smarty.const.URL_IMG_JOB}{$input_data.file_t.2}?{$smarty.now}" >
						<!--<input type="checkbox" name="del_t[2]" value="{$input_data.img_no.2}">削除  -->
						<input type="hidden" name="file_t[2]" value="{$input_data.file_t.2}">
					{/if}
					<br />
					コメント：<input type="text" size="60" name="comment_t[2]" value="{$input_data.comment_t.2}">
				</td>
			</tr>

			<tr>
				<th>
					詳細ページサブ画像左（横170px×縦100px、容量100KB以内）
				</th>
			</tr>
			<tr>
				<td>
					<input type="file" name="file_t[3]" />
					{if $smarty.session.TMP_FUP.3!=""}
						<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP.3}" >
					{elseif $input_data.file_t.3!=""}
						<img src="{$smarty.const.URL_IMG_JOB}{$input_data.file_t.3}?{$smarty.now}" >
						<input type="checkbox" name="del_t[3]" value="{$input_data.img_no.3}">削除
						<input type="hidden" name="file_t[3]" value="{$input_data.file_t.3}">
					{/if}
					<br />
					コメント：<input type="text" size="60" name="comment_t[3]" value="{$input_data.comment_t.3}">
				</td>
			</tr>

			<tr>
				<th>
					詳細ページサブ画像中央（横170px×縦100px、容量100KB以内）
				</th>
			</tr>
			<tr>
				<td>
					<input type="file" name="file_t[4]" />
					{if $smarty.session.TMP_FUP.4!=""}
						<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP.4}" >
					{elseif $input_data.file_t.4!=""}
						<img src="{$smarty.const.URL_IMG_JOB}{$input_data.file_t.4}?{$smarty.now}" >
						<input type="checkbox" name="del_t[4]" value="{$input_data.img_no.4}">削除
						<input type="hidden" name="file_t[4]" value="{$input_data.file_t.4}">
					{/if}
					<br />
					コメント：<input type="text" size="60" name="comment_t[4]" value="{$input_data.comment_t.4}">
				</td>
			</tr>

			<tr>
				<th>
					詳細ページサブ画像右（横170px×縦100px、容量100KB以内）
				</th>
			</tr>
			<tr>
				<td>
					<input type="file" name="file_t[5]" />
					{if $smarty.session.TMP_FUP.5!=""}
						<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP.5}" >
					{elseif $input_data.file_t.5!=""}
						<img src="{$smarty.const.URL_IMG_JOB}{$input_data.file_t.5}?{$smarty.now}" >
						<input type="checkbox" name="del_t[5]" value="{$input_data.img_no.5}">削除
						<input type="hidden" name="file_t[5]" value="{$input_data.file_t.5}">
					{/if}
					<br />
					コメント：<input type="text" size="60" name="comment_t[5]" value="{$input_data.comment_t.5}">
				</td>
			</tr>

			</table>

		<div>
			<input type="submit" name="submit" value="更新">&nbsp;
			<input type="reset"  value="クリア">
			<input type="hidden" name="job_no" value="{$job_no}">

		</div>
		</form>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

