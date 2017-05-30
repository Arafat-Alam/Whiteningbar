
{php}
if(isset($_GET['dt'])){
	$dt = $_GET['dt'];	
	$this->assign('dt', $dt);
}
{/php}<!-- 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script> -->

<script type="text/javascript">
<!--
{literal}
var dirDate = '';
var date = '{/literal}{$dt}{literal}';
if (date != '') {
	var dirDate = "?dt="+date;
}
var path = window.location.pathname;
$('.path').val(path+dirDate);

function winopen(no){
	window.open('/member/member_regist/?ref=cal&no='+no, 'mywindow', 'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes');
}
function winopenSearch(no){
	window.open('/reserve/member_search/?ref=cal&no='+no, 'mywindow', 'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes');
}

function getList(){

	target1 = $("#coupon");
	//$(".category_m_id").remove();
	$("#coupon_id").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/member/getCouponList/",
		cache : false,
		dataType: "text",
		data : {
			p_coupon_id: $("#p_coupon_id").val(),
		},
		success: function(data, dataType) {
			target1.after(data.html);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}



function getList2(no){

	target1 = $("#coupon_"+no);
	//$(".category_m_id").remove();
	$("#coupon_id").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});

	$.ajax({
		type: "POST",
		url: "/member/getCouponList/",
		cache : false,
		dataType: "text",
		data : {
			p_coupon_id: $("#p_coupon_id"+no).val()
		},
		success: function(data, dataType) {
			//console.log(dataType);
			target1.html(data);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


function getBoothList(){

	target2 = $("#rev_booth");
	$("#booth").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "reserve/getBooth/",
		cache : false,
		// dataType: "json",
		data : {
			shop_no: $("#shop_no").val(),
			menu_no: $("#menu_no").val(),
		},
		success: function(data, dataType) {
			target2.after(data.html);
			
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

jQuery(document).ready(function(){
	//$('#loader').hide();
	if($("#shop_no").val()){
		getBoothList();

	}
	var total_absence = {/literal}{$total_absence}{literal};
	if (total_absence >= 3) {
		alert("No Show-up for "+total_absence+" times");
	}


	 $("body").append('<div class="graylayer"></div>');
	 $(".graylayer").click(function(){
	  $(this).fadeOut();
	  $('.window').fadeOut();
	 })
	 $('#aaa').click(function(){
	 var secHeight = $(".window").height() *0.5
	 var secWidth = $(".window").width() *0.5
	 var Heightpx = secHeight * -1;
	 var Widthpx = secWidth * -1;
	 $(".graylayer").fadeIn();

	 $(".window").fadeIn().css({
	  "margin-top" : Heightpx + "px" ,
	  "margin-left" : Widthpx + "px"
	 });
	 return false;
	})


});


// var totalwidth = 190 * $('.list-group').length;

// $('.scoll-tree').css('width', totalwidth);

{/literal}
//-->
</script>
<style>
{literal}
html,body {
 font-family:Lucida sans , "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", "メイリオ", Meiryo, sans-serif;
 margin: 0;
 padding: 0;
 }
#container{
 width:100px;
 margin:100px auto;
}

.graylayer{
 display:none;
 position: fixed;
 top:0;
 left:0;
 height:100%;
 width:100%;
 background-color: #000;
 opacity:.7;
 filter(alpha=70);
 }
.window{
 padding: 30px 40px;
 display:none;
 position: fixed;
 top: 50%;
 left:50%;
 filter: progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr=#99ffffff,EndColorStr=#99ffffff);
 background-color: rgba(255, 255, 255, 1);
 font-size: 1.1em;
 /*color: #fff;*/
 /*text-shadow:rgba(0,0,0,.8) -1px -1px;*/
 border-radius: 5px;
 z-index: 20;
}

/*.list-group{
   width: 100%;
    float: left;
    margin-left: 10px;
}*/
{/literal}
</style>

</head>

<body>

	<div id="" class="">
		<div class="row ">
		<form action="/reserve/detail/" method="post">
			<div class=" col-md-8 col-sm-6 col-xs-6" style="margin-left:20%;">
			<h1>予約</h1>

			{if $finish_flg==1}
			{include file="messages.tpl"}
			{/if}


				<div class="tc col-md-12 col-sm-12 col-xs-12">
				<input type="button" class="btn btn-lg" data-dismiss="modal" value="戻る">&nbsp;&nbsp; <!-- onclick="location.href='/calendar/list/{$param}'" -->
{if $del_flg!=1}<!-- 予約削除後は戻るボタンのみ表示 -->
				<input name="submit" type="submit" class="btn btn-lg" value="更新する" >
				<input name="del_submit" type="submit" class="btn btn-lg" value="予約の削除" onClick="return confirm('予約を削除します。複数人で予約している場合は全ての予約を削除します。良いでしょうか？');">
{/if}
				</div>
				<br />
				<table class="table table-bordered">
					<tr>
						<td>お名前&nbsp;<span class="label">必須</span></td>
						<td>


						  {if $db_data.member_id==0}
						  	{if $input_data.member_name}
						  		{$input_data.member_name}　様
						  		<input type="hidden" name="member_id" value="{$input_data.member_id}">
						  	{/if}
				          	<a href="javascript:void(0);" onClick="winopen('{$input_data.no}')" class="btn btn-search">初めての方</a>　/　
				          	<a href="javascript:void(0);" onClick="winopenSearch('{$input_data.no}')" class="btn btn-search"><i class="fa fa-search"></i>&nbsp;
				          	会員から検索</a>

				          {else}
				          	{$memArr.member_no}/{if $memArr.name}{$memArr.name}{else}{$memArr.name_kana}{/if}
				          	(TEL:{if $memArr.tel}{$memArr.tel}{else}-{/if})
				          	<a href="javascript:void();"  id="aaa" class="btn btn-search">顧客情報を見る</a>

				          {/if}
						</td>
					</tr>
					<tr>
						<td>予約日時&nbsp;<span class="label">必須</span></td>
						<td>
							<!--{$db_data.reserve_date} {$db_data.start_time|date_format:"%H:%M"}～{$db_data.end_time|date_format:"%H:%M"}  -->

				 		{if $result_messages.reserve_date}
							<span class="txt-red txt-sm">{$result_messages.reserve_date}</span><br />
						selected{/if}
				 		{if $result_messages.start_time}
							<span class="txt-red txt-sm">{$result_messages.start_time}</span><br />
						{/if}

						<input class="fieldset__input" type="date" placeholder="クリックして日付を選択" name="reserve_date" value="{$input_data.reserve_date}" style="width: 50%;">
						<!-- <input class="fieldset__input js__timepicker timepicker" type="time" placeholder="クリックして時間を選択" name="start_time" value="{$input_data.start_time}"> -->

						<select name="start_time" style="width: 50%;">
							<option selected disabled>Select Time</option>
							<option value="10:00:00" {if $input_data.start_time == '10:00:00'}selected{/if}>10:00:00</option>
							<option value="10:15:00" {if $input_data.start_time == '10:15:00'}selected{/if}>10:15:00</option>
							<option value="10:30:00" {if $input_data.start_time == '10:30:00'}selected{/if}>10:30:00</option>
							<option value="10:45:00" {if $input_data.start_time == '10:45:00'}selected{/if}>10:45:00</option>
							<option value="11:00:00" {if $input_data.start_time == '11:00:00'}selected{/if}>11:00:00</option>
							<option value="11:15:00" {if $input_data.start_time == '11:15:00'}selected{/if}>11:15:00</option>
							<option value="11:30:00" {if $input_data.start_time == '11:30:00'}selected{/if}>11:30:00</option>
							<option value="11:45:00" {if $input_data.start_time == '11:45:00'}selected{/if}>11:45:00</option>
							<option value="12:00:00" {if $input_data.start_time == '12:00:00'}selected{/if}>12:00:00</option>
							<option value="12:15:00" {if $input_data.start_time == '12:15:00'}selected{/if}>12:15:00</option>
							<option value="12:30:00" {if $input_data.start_time == '12:30:00'}selected{/if}>12:30:00</option>
							<option value="12:45:00" {if $input_data.start_time == '12:45:00'}selected{/if}>12:45:00</option>
							<option value="13:00:00" {if $input_data.start_time == '13:00:00'}selected{/if}>13:00:00</option>
							<option value="13:15:00" {if $input_data.start_time == '13:15:00'}selected{/if}>13:15:00</option>
							<option value="13:30:00" {if $input_data.start_time == '13:30:00'}selected{/if}>13:30:00</option>
							<option value="13:45:00" {if $input_data.start_time == '13:45:00'}selected{/if}>13:45:00</option>
							<option value="14:00:00" {if $input_data.start_time == '14:00:00'}selected{/if}>14:00:00</option>
							<option value="14:15:00" {if $input_data.start_time == '14:15:00'}selected{/if}>14:15:00</option>
							<option value="14:30:00" {if $input_data.start_time == '14:30:00'}selected{/if}>14:30:00</option>
							<option value="14:45:00" {if $input_data.start_time == '14:45:00'}selected{/if}>14:45:00</option>
							<option value="15:00:00" {if $input_data.start_time == '15:00:00'}selected{/if}>15:00:00</option>
							<option value="15:15:00" {if $input_data.start_time == '15:15:00'}selected{/if}>15:15:00</option>
							<option value="15:30:00" {if $input_data.start_time == '15:30:00'}selected{/if}>15:30:00</option>
							<option value="15:45:00" {if $input_data.start_time == '15:45:00'}selected{/if}>15:45:00</option>
							<option value="16:00:00" {if $input_data.start_time == '16:00:00'}selected{/if}>16:00:00</option>
							<option value="16:15:00" {if $input_data.start_time == '16:15:00'}selected{/if}>16:15:00</option>
							<option value="16:30:00" {if $input_data.start_time == '16:30:00'}selected{/if}>16:30:00</option>
							<option value="16:45:00" {if $input_data.start_time == '16:45:00'}selected{/if}>16:45:00</option>
							<option value="17:00:00" {if $input_data.start_time == '17:00:00'}selected{/if}>17:00:00</option>
							<option value="17:15:00" {if $input_data.start_time == '17:15:00'}selected{/if}>17:15:00</option>
							<option value="17:30:00" {if $input_data.start_time == '17:30:00'}selected{/if}>17:30:00</option>
							<option value="17:45:00" {if $input_data.start_time == '17:45:00'}selected{/if}>17:45:00</option>
							<option value="18:00:00" {if $input_data.start_time == '18:00:00'}selected{/if}>18:00:00</option>
							<option value="18:15:00" {if $input_data.start_time == '18:15:00'}selected{/if}>18:15:00</option>
							<option value="18:30:00" {if $input_data.start_time == '18:30:00'}selected{/if}>18:30:00</option>
							<option value="18:45:00" {if $input_data.start_time == '18:45:00'}selected{/if}>18:45:00</option>
							<option value="19:00:00" {if $input_data.start_time == '19:00:00'}selected{/if}>19:00:00</option>
							<option value="19:15:00" {if $input_data.start_time == '19:15:00'}selected{/if}>19:15:00</option>
							<option value="19:30:00" {if $input_data.start_time == '19:30:00'}selected{/if}>19:30:00</option>
							<option value="19:45:00" {if $input_data.start_time == '19:45:00'}selected{/if}>19:45:00</option>
							<option value="20:00:00" {if $input_data.start_time == '20:00:00'}selected{/if}>20:00:00</option>
							<option value="20:15:00" {if $input_data.start_time == '20:15:00'}selected{/if}>20:15:00</option>
							<option value="20:30:00" {if $input_data.start_time == '20:30:00'}selected{/if}>20:30:00</option>
							<option value="20:45:00" {if $input_data.start_time == '20:45:00'}selected{/if}>20:45:00</option>
							<option value="21:00:00" {if $input_data.start_time == '21:00:00'}selected{/if}>21:00:00</option>
							<option value="21:15:00" {if $input_data.start_time == '21:15:00'}selected{/if}>21:15:00</option>
							<option value="21:30:00" {if $input_data.start_time == '21:30:00'}selected{/if}>21:30:00</option>
							<option value="21:45:00" {if $input_data.start_time == '21:45:00'}selected{/if}>21:45:00</option>
						</select>

						</td>
					</tr>
					<tr>
						<td>予約店舗名&nbsp;<span class="label">必須</span></td>
						<td>
						{$db_data.shop_name}
						<input type="hidden" name=shop_no value="{$input_data.shop_no}" id="shop_no" >
						<!--
						{html_options name=shop_no options=$shopArr selected=$input_data.shop_no  onChange="getBootdList()" id="shop_no"}
						-->
						</td>
					</tr>
					<tr>
						<td>予約人数&nbsp;<span class="label">必須</span></td>
						<td>
							<div id="rev_bootd"></div>


						</td>
					</tr>
					<tr>
						<td>コース名/使用クーポン&nbsp;<span class="label">必須</span></td>
						<td>
							{if $db_data.fee_flg==0}
								{if $courseArr}
									{html_options name=buy_no options=$courseArr selected=$input_data.buy_no  style="width: 80%;"}
								{else}
									コース未払い
								{/if}
							{else}
					          	{$db_data.course_name} /
					          	{if $db_data.coupon_name}
					          		{$db_data.coupon_name}
					          	{else}
					          		-
					          	{/if}
					        {/if}
						</td>
					</tr>
					<tr>
						<td>メニュー名&nbsp;<span class="label">必須</span></td>
						<td>
							{html_options name=menu_no options=$menuArr selected=$input_data.menu_no id=menu_no style="width: 80%;"}

			<!--
				         	{if $db_data.menu_name}
								{$db_data.menu_name}({$db_data.raiten_cnt}回)
							{else}
								{html_options name=menu_no options=$menuArr }

							{/if}
			-->
						</td>
					</tr>
        			{foreach from=$memPayArr item=item}
			        <tr>
			          <td>{$item.name}</td>
			          <td>
			          <input type="checkbox" name="pay[{$item.id}]" value="1" {if $payArr && $item.id|in_array:$payArr}checked{/if}   /></td>
			        </tr>
        			{/foreach}
			       	<tr>
			          <td>電話確認</td>
			          <td>
			 				{html_radios name=tel_flg options=$telArr selected=$input_data.tel_flg separator=''}
			           </td>
			        </tr>
					<tr>
						<td>来店チェック</td>
						<td>
						<input type="radio" name="visit_flg" value="1" {if $input_data.visit_flg==1}checked{/if}  />来店　
						<input type="radio" name="visit_flg" value="99" {if $input_data.visit_flg==99}checked{/if}  />キャンセル　
						<input type="radio" name="visit_flg" value="0" {if $input_data.visit_flg==0}checked{/if}  />予約中
						<input type="radio" name="visit_flg" value="2" {if $input_data.visit_flg==2}checked{/if}  />来店せず
			<!--
						<ul>
						    <li><input type="radio" name="visit_flg" value="1" {if $input_data.visit_flg==1}checked{/if}  />来店</li>
				          	<li><input type="radio" name="visit_flg" value="99" {if $input_data.visit_flg==99}checked{/if}  />キャンセル</li>
				          	<li><input type="radio" name="visit_flg" value="0" {if $input_data.visit_flg==0}checked{/if}  />予約中</li>
						</ul>
			-->
						</td>
					</tr>
			        <tr>
			          <td>担当者</td>
						<td>
						 	{html_options name=staff_no options=$staffArr selected=$input_data.staff_no style="width: 80%;"}
						</td>
			        </tr>
			        <tr>
			        	<td>previous state</td>
			        	<td>
			        		<select name="pre_state" style="width: 100%;">
			        			<option>選択してください</option>
			        			<option value="S40" {if $input_data.pre_state =='S40'}selected{/if}>S40</option>
			        			<option value="S39" {if $input_data.pre_state =='S39'}selected{/if}>S39</option>
			        			<option value="S38" {if $input_data.pre_state =='S38'}selected{/if}>S38</option>
			        			<option value="S37" {if $input_data.pre_state =='S37'}selected{/if}>S37</option>
			        			<option value="S36" {if $input_data.pre_state =='S36'}selected{/if}>S36</option>
			        			<option value="S34" {if $input_data.pre_state =='S35'}selected{/if}>S34</option>
			        			<option value="S33" {if $input_data.pre_state =='S34'}selected{/if}>S33</option>
			        			<option value="S32" {if $input_data.pre_state =='S33'}selected{/if}>S32</option>
			        			<option value="S31" {if $input_data.pre_state =='S32'}selected{/if}>S31</option>
			        			<option value="S30" {if $input_data.pre_state =='S31'}selected{/if}>S30</option>
			        			<option value="S29" {if $input_data.pre_state =='S30'}selected{/if}>S29</option>
			        			<option value="S28" {if $input_data.pre_state =='S29'}selected{/if}>S28</option>
			        			<option value="S27" {if $input_data.pre_state =='S28'}selected{/if}>S27</option>
			        			<option value="S26" {if $input_data.pre_state =='S27'}selected{/if}>S26</option>
			        			<option value="S25" {if $input_data.pre_state =='S26'}selected{/if}>S25</option>
			        			<option value="S24" {if $input_data.pre_state =='S25'}selected{/if}>S24</option>
			        			<option value="S23" {if $input_data.pre_state =='S24'}selected{/if}>S23</option>
			        			<option value="S22" {if $input_data.pre_state =='S23'}selected{/if}>S22</option>
			        			<option value="S22" {if $input_data.pre_state =='S22'}selected{/if}>S22</option>
			        			<option value="S21" {if $input_data.pre_state =='S21'}selected{/if}>S21</option>
			        			<option value="S20" {if $input_data.pre_state =='S20'}selected{/if}>S20</option>
			        			<option value="S19" {if $input_data.pre_state =='S19'}selected{/if}>S19</option>
			        			<option value="S18" {if $input_data.pre_state =='S18'}selected{/if}>S18</option>
			        			<option value="S17" {if $input_data.pre_state =='S17'}selected{/if}>S17</option>
			        			<option value="S16" {if $input_data.pre_state =='S16'}selected{/if}>S16</option>
			        			<option value="S15" {if $input_data.pre_state =='S15'}selected{/if}>S15</option>
			        			<option value="S14" {if $input_data.pre_state =='S14'}selected{/if}>S14</option>
			        			<option value="S13" {if $input_data.pre_state =='S13'}selected{/if}>S13</option>
			        			<option value="S12" {if $input_data.pre_state =='S12'}selected{/if}>S12</option>
			        			<option value="S11" {if $input_data.pre_state =='S11'}selected{/if}>S11</option>
			        			<option value="S10" {if $input_data.pre_state =='S10'}selected{/if}>S10</option>
			        			<option value="S9" {if $input_data.pre_state =='S9'}selected{/if}>S9</option>
			        			<option value="S8" {if $input_data.pre_state =='S8'}selected{/if}>S8</option>
			        			<option value="S7" {if $input_data.pre_state =='S7'}selected{/if}>S7</option>
			        			<option value="S6" {if $input_data.pre_state =='S6'}selected{/if}>S6</option>
			        			<option value="S5" {if $input_data.pre_state =='S5'}selected{/if}>S5</option>
			        			<option value="S4" {if $input_data.pre_state =='S4'}selected{/if}>S4</option>
			        			<option value="S3" {if $input_data.pre_state =='S3'}selected{/if}>S3</option>
			        			<option value="S2" {if $input_data.pre_state =='S2'}selected{/if}>S2</option>
			        		</select>
			        	</td>
			        </tr>
			        <tr>			        	
			        	<td>Now State</td>
			        	<td>
			        		<select name="now_state" style="width: 100%;">
			        			<option>選択してください</option>
			        			<option value="S40" {if $input_data.now_state =='S40'}selected{/if}>S40</option>
			        			<option value="S39" {if $input_data.now_state =='S39'}selected{/if}>S39</option>
			        			<option value="S38" {if $input_data.now_state =='S38'}selected{/if}>S38</option>
			        			<option value="S37" {if $input_data.now_state =='S37'}selected{/if}>S37</option>
			        			<option value="S36" {if $input_data.now_state =='S36'}selected{/if}>S36</option>
			        			<option value="S34" {if $input_data.now_state =='S35'}selected{/if}>S34</option>
			        			<option value="S33" {if $input_data.now_state =='S34'}selected{/if}>S33</option>
			        			<option value="S32" {if $input_data.now_state =='S33'}selected{/if}>S32</option>
			        			<option value="S31" {if $input_data.now_state =='S32'}selected{/if}>S31</option>
			        			<option value="S30" {if $input_data.now_state =='S31'}selected{/if}>S30</option>
			        			<option value="S29" {if $input_data.now_state =='S30'}selected{/if}>S29</option>
			        			<option value="S28" {if $input_data.now_state =='S29'}selected{/if}>S28</option>
			        			<option value="S27" {if $input_data.now_state =='S28'}selected{/if}>S27</option>
			        			<option value="S26" {if $input_data.now_state =='S27'}selected{/if}>S26</option>
			        			<option value="S25" {if $input_data.now_state =='S26'}selected{/if}>S25</option>
			        			<option value="S24" {if $input_data.now_state =='S25'}selected{/if}>S24</option>
			        			<option value="S23" {if $input_data.now_state =='S24'}selected{/if}>S23</option>
			        			<option value="S22" {if $input_data.now_state =='S23'}selected{/if}>S22</option>
			        			<option value="S22" {if $input_data.now_state =='S22'}selected{/if}>S22</option>
			        			<option value="S21" {if $input_data.now_state =='S21'}selected{/if}>S21</option>
			        			<option value="S20" {if $input_data.now_state =='S20'}selected{/if}>S20</option>
			        			<option value="S19" {if $input_data.now_state =='S19'}selected{/if}>S19</option>
			        			<option value="S18" {if $input_data.now_state =='S18'}selected{/if}>S18</option>
			        			<option value="S17" {if $input_data.now_state =='S17'}selected{/if}>S17</option>
			        			<option value="S16" {if $input_data.now_state =='S16'}selected{/if}>S16</option>
			        			<option value="S15" {if $input_data.now_state =='S15'}selected{/if}>S15</option>
			        			<option value="S14" {if $input_data.now_state =='S14'}selected{/if}>S14</option>
			        			<option value="S13" {if $input_data.now_state =='S13'}selected{/if}>S13</option>
			        			<option value="S12" {if $input_data.now_state =='S12'}selected{/if}>S12</option>
			        			<option value="S11" {if $input_data.now_state =='S11'}selected{/if}>S11</option>
			        			<option value="S10" {if $input_data.now_state =='S10'}selected{/if}>S10</option>
			        			<option value="S9" {if $input_data.now_state =='S9'}selected{/if}>S9</option>
			        			<option value="S8" {if $input_data.now_state =='S8'}selected{/if}>S8</option>
			        			<option value="S7" {if $input_data.now_state =='S7'}selected{/if}>S7</option>
			        			<option value="S6" {if $input_data.now_state =='S6'}selected{/if}>S6</option>
			        			<option value="S5" {if $input_data.now_state =='S5'}selected{/if}>S5</option>
			        			<option value="S4" {if $input_data.now_state =='S4'}selected{/if}>S4</option>
			        			<option value="S3" {if $input_data.now_state =='S3'}selected{/if}>S3</option>
			        			<option value="S2" {if $input_data.now_state =='S2'}selected{/if}>S2</option>
			        		</select>
			        	</td>
			        </tr>
					<tr>
						<td>管理用備考</td>
						<td><textarea name="kanri_comment" style="width: 80%;">{$input_data.kanri_comment}</textarea>
						<br><font size=1>※お客様個人に対してのコメントです。</font>
						</td>
					</tr>
			        <tr>
			          <td>予約時管理用備考</td>
			          <td>
							{$input_data.reserve_kanri_comment}
							<br><font size=1>※予約を行う際に入力した管理者用の備考コメントです</font>
						</td>
			        </tr>

				</table>

				<div class="tc col-md-12 col-sm-12 col-xs-12">
				<input type="button" class="btn btn-lg" data-dismiss="modal" value="戻る"">&nbsp;&nbsp;<!-- onclick="location.href='/calendar/list/{$param}' -->
{if $del_flg!=1}<!-- 予約削除後は戻るボタンのみ表示 -->
				<input name="submit" type="submit" class="btn btn-lg" value="更新する" >
				<input name="del_submit" type="submit" class="btn btn-lg" value="予約の削除" onClick="return confirm('予約を削除します。複数人で予約している場合は全ての予約を削除します。良いでしょうか？');">
{/if}
				</div>
			</div>
        <input type="hidden" name="no" value="{$input_data.no}" >
        <input type="hidden" name="ref" value="cal" >
		<input type="hidden" name="dt" value="{$dt}" >
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->

  <section class="window"><!-- モーダル表示部分 -->
<table class="table">

       <tr>
          <th>現在のコース消費数</th>
          <td>
				{foreach from=$memArr.reserve item=item}
                      	<div class="mb5">
						{$item.name}/残{$item.zan}回
						</div>
				{/foreach}
          </td>
        </tr>
       <tr>
          <th>メールアドレス</th>
          <td>
          {$memArr.email}
          </td>
        </tr>
		<tr>
			<th>住所</th>
			<td>{$memArr.zip}<br />{$memArr.address1}{$memArr.address2}</td>
		</tr>
         <tr>
          <th>性別</th>
          <td>
				{if $memArr.sex==1}男性{/if}
				{if $memArr.sex==2}女性{/if}
			</td>
        </tr>
        <tr>
          <th>生年月日</th>
          <td>
          	{$memArr.year}
            年
            {$memArr.month}
            月
            {$memArr.day}
            日
            </td>
        </tr>
        <tr>
          <th>ご紹介者</th>
          <td>
          {$memArr.intro}
        </tr>
        <tr>
          <th>お客様備考</th>
          <td>
				{$memArr.comment}
			</td>
        </tr>
         <tr>
          <th>歯磨き粉</th>
          <td>
				{if $memArr.tooth_flg==1}１種類{/if}
				{if $memArr.tooth_flg==2}２種類{/if}
			</td>
        </tr>
         <tr>
          <th>管理用備考</th>
          <td>
				{$memArr.kanri_comment}
			</td>
        </tr>

</table>
  </section>
  <section>
  <form method="post" name="fm_search" action="/member/unpaid">
  	<table class="admins clear mt10 unpaid">
			<tr>
				<th width="100">会員No</th>
				<th width="150">お名前</th>
				<th>購入店舗</th>
				<th>予約メニュー</th>
				<th>ご購入コース料金</th>
				<th>クーポン</th>
				<th>購入</th>
				<th>DB削除</th>

			</tr>

			{foreach from=$arr key=key item="member"}
				<tr>
					<td>{$member.member_no}</td>
					<td>{$member.name}<br />{$member.name_kana}<br />{$member.tel}</td>
					<td>
							{$member.shop_name}
					</td>
					<td>
						{$member.menu_name}
					</td>
					<td>{$member.fee|number_format}円<br />({$member.course_name})</td>
				<form method="POST" action="/member/unpaid/">
					<td>
					<select name="p_coupon_id" id=p_coupon_id{$key}  onChange="getList2('{$key}')">
			          {html_options  options=$couPaArr selected=$input_data.coupon_id style="width: 80%;"}
					</select>
					<input type="hidden" name="path" class="path" id="path" value="">
			          <div id=coupon_{$key}>
			          </div>

					</td>
					<td class="tc">
							<font size=1>売上計上日</font><br>
							<input type="date" id="start{$key}" name="buy_date" size="10" value="{$buy_date|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>
							<input type="submit" name="submit" value="料金受取済" onClick="return confirm('料金を受け取り済みにします。良いですか？');" class="btn-delete btn-md">
					</td>
					<td class="tc">
							<input type="submit" name="del_submit" value="削除" onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');" class="btn-delete btn-sm">
					</td>
				<input type="hidden" name="buy_no" value="{$member.buy_no}">
				</form>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="11">予約済みで未払いの検索該当会員様はいません</td>
				</tr>
			{/foreach}

			</table>
		</form>
  </section>



<!-- date time picker -->
	<!-- <script src="/js/legacy.js"></script>
	<script src="/js/picker.js"></script>
	<script src="/js/picker.date.js"></script> 
	<script src="/js/picker.time.js"></script>
	<script src="/js/ja_JP.js"></script>
	<link href="/css/themes/default.css" rel="stylesheet" type="text/css" />
	<link href="css/themes/default.date.css" rel="stylesheet" id="theme_date">
	<link href="/css/themes/default.time.css" rel="stylesheet" id="theme_time">
	
	<link href="/css/style.css" rel="stylesheet" type="text/css" />
	<link href="/css/calendar-core.css" rel="stylesheet">
	<link href="/css/font-awesome.min.css" rel="stylesheet"> -->
	<script>
	{literal}
		// $('.datepicker').pickadate({
		// 	format: 'yyyy/mm/dd'
		// })
		// $('.timepicker').pickatime({
		// 	　clear: '消去',
		// 	 format: 'H:i',
		// 	 interval: 15,
		// 	 min: [10,0],
  		//   max: [21,15]
		// })


		// $('.timepicker').timepicker();
	{/literal}
	</script>


</body>
</html>
