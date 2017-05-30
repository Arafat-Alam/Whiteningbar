<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<style type="text/css">
{literal}
/*.list-group{
   width: 100%;
    float: left;
    margin-left: 10px;
}*/
 {/literal}
</style>
<script type="text/javascript">
<!--
{literal}

function winopens(shop_no){
	window.open('/member/member_regist/?ref=calres&shop_no='+shop_no, 'mywindow', 'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes');
}
function winopensSearch(){

	window.open('/reserve/member_search/?ref=calres', 'mywindow', 'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes');
}

function getMenuList(){
	
	target1 = $("#menu");
	target2 = $("#coupon");
	//$(".category_m_id").remove();
	$("#menu_no").remove();
	$("#coupon_name").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList/",
		cache : false,
		dataType: "text",
		data : {
			buy_no: $("#buy_no").val(),
			menu_no: {/literal}{if $input_data.menu_no}{$input_data.menu_no}{else}0{/if}{literal}
		},
		success: function(data, dataType) {

			target1.after(data.html);
			target2.after(data.html_coupon);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

function getMenuListAll(){

	target1 = $("#menu");
	//$(".category_m_id").remove();
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuListAll/",
		cache : false,
		dataType: "text",
		data : {
			menu_no: {/literal}{if $input_data.menu_no}{$input_data.menu_no}{else}0{/if}{literal}
		},
		success: function(data, dataType) {
			// console.log(data);
			target1.html(data);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


jQuery(document).ready(function(){
	//$('#loader').hide();
	if($("#buy_no").val()){
		getMenuList();

	}
	else{
		//使用可能な購入コースが無い場合は、メニューから選択

		getMenuListAll();


	}

// var totalwidth = 190 * $('.list-group').length;

// $('.scoll-tree').css('width', totalwidth);

});
{/literal}
//-->
</script>

</head>

<body>
	<div >
		<div class="row" align="center">
		<form action="/calendar/reserve/" method="post">
			<div class="col-md-8 col-sm-6 col-xs-6" style="margin-left:20%;">
			<h1>新規予約</h1>

			{include file="messages.tpl"}

				<div class="tc col-md-12 col-sm-12 col-xs-12">
					<input type="button" class="btn btn-sm btn-gray" data-dismiss="modal" value="戻る" style="">&nbsp;&nbsp;<!-- onclick="location.href='/calendar/list/{$param}'" -->
					<input name="submit" type="submit" class="btn btn-sm" value="新規に予約する" style="">
				</div>
				<br />
				<br />
				<table class="table table-bordered" >
					<tr>
						<td>予約店舗名&nbsp;<span class="label">必須</span></td>
						<td>
							{if $result_messages.shop_no}<span class="txt-red txt-sm">{$result_messages.shop_no}<br></span>{/if}
							{$shopInfo.name}
						</td>
					</tr>

					<tr>
						<td>お名前&nbsp;<span class="label">必須</span></td>
						<td>
							{if $result_messages.member_id}<span class="txt-red txt-sm">{$result_messages.member_id}<br></span>{/if}
							{$input_data.name}/{$input_data.name_kana}　様
							<input type="hidden" name="member_id" value="{$input_data.member_id}" >
				          	<a href="javascript:void(0);" onClick="winopens('{$input_data.shop_no}');" class="btn btn-search">初めての方</a>　/　
				          	<a href="javascript:void(0);" onClick="winopensSearch();" class="btn btn-search"><i class="fa fa-search">検索</i>&nbsp;

						</td>
					</tr>
					<tr>
						<td>予約日時&nbsp;<span class="label">必須</span></td>
						<td>
							{if $result_messages.hour}<span class="txt-red txt-sm">{$result_messages.hour}<br></span>{/if}
							{if $result_messages.minute}<span class="txt-red txt-sm">{$result_messages.minute}<br></span>{/if}
<!--
						<input class="fieldset__input js__datepicker datepicker" type="text" placeholder="クリックして日付を選択" name="hour" value="{$input_data.hour}" >
						<input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="minute" value="{$input_data.minute}" >
 -->
 						{$input_data.reserve_date}<br />
						<!-- <input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="start_time" value="{$input_data.start_time}"> -->

						<select name="start_time"  style="width: 100%">
							<option selected disabled>Select Time</option>
							<option value="10:00" {if $input_data.start_time == '10:00'}selected{/if}>10:00</option>
							<option value="10:15" {if $input_data.start_time == '10:15'}selected{/if}>10:15</option>
							<option value="10:30" {if $input_data.start_time == '10:30'}selected{/if}>10:30</option>
							<option value="10:45" {if $input_data.start_time == '10:45'}selected{/if}>10:45</option>
							<option value="11:00" {if $input_data.start_time == '11:00'}selected{/if}>11:00</option>
							<option value="11:15" {if $input_data.start_time == '11:15'}selected{/if}>11:15</option>
							<option value="11:30" {if $input_data.start_time == '11:30'}selected{/if}>11:30</option>
							<option value="11:45" {if $input_data.start_time == '11:45'}selected{/if}>11:45</option>
							<option value="12:00" {if $input_data.start_time == '12:00'}selected{/if}>12:00</option>
							<option value="12:15" {if $input_data.start_time == '12:15'}selected{/if}>12:15</option>
							<option value="12:30" {if $input_data.start_time == '12:30'}selected{/if}>12:30</option>
							<option value="12:45" {if $input_data.start_time == '12:45'}selected{/if}>12:45</option>
							<option value="13:00" {if $input_data.start_time == '13:00'}selected{/if}>13:00</option>
							<option value="13:15" {if $input_data.start_time == '13:15'}selected{/if}>13:15</option>
							<option value="13:30" {if $input_data.start_time == '13:30'}selected{/if}>13:30</option>
							<option value="13:45" {if $input_data.start_time == '13:45'}selected{/if}>13:45</option>
							<option value="14:00" {if $input_data.start_time == '14:00'}selected{/if}>14:00</option>
							<option value="14:15" {if $input_data.start_time == '14:15'}selected{/if}>14:15</option>
							<option value="14:30" {if $input_data.start_time == '14:30'}selected{/if}>14:30</option>
							<option value="14:45" {if $input_data.start_time == '14:45'}selected{/if}>14:45</option>
							<option value="15:00" {if $input_data.start_time == '15:00'}selected{/if}>15:00</option>
							<option value="15:15" {if $input_data.start_time == '15:15'}selected{/if}>15:15</option>
							<option value="15:30" {if $input_data.start_time == '15:30'}selected{/if}>15:30</option>
							<option value="15:45" {if $input_data.start_time == '15:45'}selected{/if}>15:45</option>
							<option value="16:00" {if $input_data.start_time == '16:00'}selected{/if}>16:00</option>
							<option value="16:15" {if $input_data.start_time == '16:15'}selected{/if}>16:15</option>
							<option value="16:30" {if $input_data.start_time == '16:30'}selected{/if}>16:30</option>
							<option value="16:45" {if $input_data.start_time == '16:45'}selected{/if}>16:45</option>
							<option value="17:00" {if $input_data.start_time == '17:00'}selected{/if}>17:00</option>
							<option value="17:15" {if $input_data.start_time == '17:15'}selected{/if}>17:15</option>
							<option value="17:30" {if $input_data.start_time == '17:30'}selected{/if}>17:30</option>
							<option value="17:45" {if $input_data.start_time == '17:45'}selected{/if}>17:45</option>
							<option value="18:00" {if $input_data.start_time == '18:00'}selected{/if}>18:00</option>
							<option value="18:15" {if $input_data.start_time == '18:15'}selected{/if}>18:15</option>
							<option value="18:30" {if $input_data.start_time == '18:30'}selected{/if}>18:30</option>
							<option value="18:45" {if $input_data.start_time == '18:45'}selected{/if}>18:45</option>
							<option value="19:00" {if $input_data.start_time == '19:00'}selected{/if}>19:00</option>
							<option value="19:15" {if $input_data.start_time == '19:15'}selected{/if}>19:15</option>
							<option value="19:30" {if $input_data.start_time == '19:30'}selected{/if}>19:30</option>
							<option value="19:45" {if $input_data.start_time == '19:45'}selected{/if}>19:45</option>
							<option value="20:00" {if $input_data.start_time == '20:00'}selected{/if}>20:00</option>
							<option value="20:15" {if $input_data.start_time == '20:15'}selected{/if}>20:15</option>
							<option value="20:30" {if $input_data.start_time == '20:30'}selected{/if}>20:30</option>
							<option value="20:45" {if $input_data.start_time == '20:45'}selected{/if}>20:45</option>
							<option value="21:00" {if $input_data.start_time == '21:00'}selected{/if}>21:00</option>
							<option value="21:15" {if $input_data.start_time == '21:15'}selected{/if}>21:15</option>
							<option value="21:30" {if $input_data.start_time == '21:30'}selected{/if}>21:30</option>
							<option value="21:45" {if $input_data.start_time == '21:45'}selected{/if}>21:45</option>
						</select>

						</td>
					</tr>
					<tr>
						<td>コース名/使用クーポン&nbsp;<span class="label">必須</span></td>
						<td>
							{if $result_messages.buy_no}<span class="txt-red txt-sm">{$result_messages.buy_no}<br></span>{/if}

							{if $courseArr}
								{html_options name=buy_no options=$courseArr selected=$input_data.buy_no  onClick="getMenuList()" id="buy_no" style="width: 100%;"}
							{else}
								<span class="txt-red txt-sm">現在、コース未購入</span>

							{/if}
							<br />
							<div id=coupon></div>

						</td>
					</tr>
					<tr>
						<td>メニュー名&nbsp;<span class="label">必須</span></td>
						<td>
							{if $result_messages.menu_no}<span class="txt-red txt-sm">{$result_messages.menu_no}<br></span>{/if}

							<div id=menu></div>

							{if $courseArr}
							<br /><span class="txt-red txt-sm">コース購入済みの場合、予約可能なメニューのみが表示されます</span>

							{/if}

						</td>
					</tr>
				       <tr>
				          <td>予約数<span class="label">必須</span></td>
				          <td>
							{if $result_messages.number}<span class="txt-red txt-sm">{$result_messages.number}<br></span>{/if}
							{html_options name=number options=$boothArr selected=$input_data.number id=bootd style="width: 100%;"}人

				        </tr>
		<!--
				        <tr>
				          <td>電話</td>
				          <td>
				         	{html_radios name=tel_flg options=$telArr selected=$input_data.tel_flg }
				         </td>
				        </tr>
		 -->
		 <!--
				        <tr>
				          <td>備考</td>
				          <td>
								<textarea name="comment" rows="" cols="">{$input_data.comment}</textarea>
							</td>
				        </tr>
		-->
				        <tr>
				          <td>管理用備考</td>
				          <td>
								<textarea name="kanri_comment" rows="" cols=""  style="width: 100%">{$input_data.kanri_comment}</textarea>
							</td>
				        </tr>
				</table>
				<div class="tc col-md-12 col-sm-12 col-xs-12">
					<input type="button" class="btn btn-sm btn-gray" value="戻る" data-dismiss="modal" style="">&nbsp;&nbsp;<!-- onclick="location.href='/calendar/list/{$param}'" -->
					<input name="submit" type="submit" class="btn btn-sm" value="新規に予約する" style="width: ">
				</div>
			</div>

			<input type="hidden" name="shop_no" value="{$input_data.shop_no}">
			<input type="hidden" name="reserve_date" value="{$input_data.reserve_date}">
			<input type="hidden" name="dt" value="{$dt}" >
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->


<!-- date time picker -->
	

</body>
</html>
