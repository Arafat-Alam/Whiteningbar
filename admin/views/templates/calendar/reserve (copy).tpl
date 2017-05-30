{include file="calendar_head.tpl"}
<script type="text/javascript">
<!--
{literal}

function winopn(shop_no){
	window.open('/member/member_regist/?ref=calres&shop_no='+shop_no, 'mywindow', 'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes');
}
function winopnSearch(){

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
		dataType: "json",
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
		dataType: "json",
		data : {
			menu_no: {/literal}{if $input_data.menu_no}{$input_data.menu_no}{else}0{/if}{literal}
		},
		success: function(data, dataType) {
			target1.after(data.html);
		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


jQuery(document).ready(function(){

	if($("#buy_no").val()){
		getMenuList();

	}
	else{
		//使用可能な購入コースが無い場合は、メニューから選択

		getMenuListAll();


	}


});
{/literal}
//-->
</script>

</head>

<body>
	<div id="wrap">
		<div class="content content-form">
		<form action="/calendar/reserve/" method="post" >
			<div class="content-inner">
			<h1>新規予約</h1>

			{include file="messages.tpl"}

				<div class="tc mt35">
					<input type="button" class="btn btn-lg btn-gray" value="戻る" onclick="location.href='/calendar/list/{$param}'">&nbsp;&nbsp;
					<input name="submit" type="submit" class="btn btn-lg" value="新規に予約する">
				</div>
				<br />
				<table class="table new-app">
					<tr>
						<th>予約店舗名&nbsp;<span class="label">必須</span></th>
						<td>
							{if $result_messages.shop_no}<span class="txt-red txt-sm">{$result_messages.shop_no}<br></span>{/if}
							{$shopInfo.name}
						</td>
					</tr>

					<tr>
						<th>お名前&nbsp;<span class="label">必須</span></th>
						<td>
							{if $result_messages.member_id}<span class="txt-red txt-sm">{$result_messages.member_id}<br></span>{/if}
							{$input_data.name}/{$input_data.name_kana}　様
							<input type="hidden" name="member_id" value="{$input_data.member_id}">
				          	<a href="javascript:void(0);" onClick="winopn('{$input_data.shop_no}');" class="btn btn-search">初めての方</a>　/　
				          	<a href="javascript:void(0);" onClick="winopnSearch();" class="btn btn-search"><i class="fa fa-search">検索</i>&nbsp;

						</td>
					</tr>
					<tr>
						<th>予約日時&nbsp;<span class="label">必須</span></th>
						<td>
							{if $result_messages.hour}<span class="txt-red txt-sm">{$result_messages.hour}<br></span>{/if}
							{if $result_messages.minute}<span class="txt-red txt-sm">{$result_messages.minute}<br></span>{/if}
<!--
						<input class="fieldset__input js__datepicker datepicker" type="text" placeholder="クリックして日付を選択" name="hour" value="{$input_data.hour}" >
						<input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="minute" value="{$input_data.minute}" >
 -->
 						{$input_data.reserve_date}<br />
						<input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="start_time" value="{$input_data.start_time}">

						</td>
					</tr>
					<tr>
						<th>コース名/使用クーポン&nbsp;<span class="label">必須</span></th>
						<td>
							{if $result_messages.buy_no}<span class="txt-red txt-sm">{$result_messages.buy_no}<br></span>{/if}

							{if $courseArr}
								{html_options name=buy_no options=$courseArr selected=$input_data.buy_no  onClick="getMenuList()" id="buy_no"}
							{else}
								<span class="txt-red txt-sm">現在、コース未購入</span>

							{/if}
							<br />
							<div id=coupon></div>

						</td>
					</tr>
					<tr>
						<th>メニュー名&nbsp;<span class="label">必須</span></th>
						<td>
							{if $result_messages.menu_no}<span class="txt-red txt-sm">{$result_messages.menu_no}<br></span>{/if}

							<div id=menu></div>

							{if $courseArr}
							<br /><span class="txt-red txt-sm">コース購入済みの場合、予約可能なメニューのみが表示されます</span>

							{/if}

						</td>
					</tr>
				       <tr>
				          <th>予約数<span class="label">必須</span></th>
				          <td>
							{if $result_messages.number}<span class="txt-red txt-sm">{$result_messages.number}<br></span>{/if}
							{html_options name=number options=$boothArr selected=$input_data.number id=booth}人

				        </tr>
		<!--
				        <tr>
				          <th>電話</th>
				          <td>
				         	{html_radios name=tel_flg options=$telArr selected=$input_data.tel_flg }
				         </td>
				        </tr>
		 -->
		 <!--
				        <tr>
				          <th>備考</th>
				          <td>
								<textarea name="comment" rows="" cols="">{$input_data.comment}</textarea>
							</td>
				        </tr>
		-->
				        <tr>
				          <th>管理用備考</th>
				          <td>
								<textarea name="kanri_comment" rows="" cols="">{$input_data.kanri_comment}</textarea>
							</td>
				        </tr>
				</table>
				<div class="tc mt35">
					<input type="button" class="btn btn-lg btn-gray" value="戻る" onclick="location.href='/calendar/list/{$param}'">&nbsp;&nbsp;
					<input name="submit" type="submit" class="btn btn-lg" value="新規に予約する">
				</div>
			</div>

			<input type="hidden" name="shop_no" value="{$input_data.shop_no}">
			<input type="hidden" name="reserve_date" value="{$input_data.reserve_date}">
			<input type="hidden" name="dt" value="{$dt}" >
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->

{include file="calendar_footer.tpl"}

<!-- date time picker -->
	<script src="/js/legacy.js"></script>
	<script src="/js/picker.js"></script>
	<script src="/js/picker.date.js"></script>
	<script src="/js/picker.time.js"></script>
	<script src="/js/ja_JP.js"></script>
	<script>
	{literal}
		$('.datepicker').pickadate({
			format: 'yyyy/mm/dd'
		})
		$('.timepicker').pickatime({
			　clear: '消去',
			 format: 'H:i',
			 interval: 15,
			 min: [10,0],
   		 max: [21,15]
		})
	{/literal}
	</script>

</body>
</html>
