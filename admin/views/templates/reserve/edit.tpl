{include file="head.tpl"}

<script language="JavaScript">
<!--
{literal}
jQuery(document).ready(function(){

	$("#start").datepicker({
		dateFormat: "yy/mm/dd"
	});

	if($("#shop_no").val()){
		getBoothList();
//		getCalendar();

	}
});


	function getBoothList(){

		target1 = $("#rev_start_hour");
		target2 = $("#rev_booth");
		//$(".category_m_id").remove();
		$("#booth").remove();
		$.ajaxSetup({scriptCharset:"utf-8"});
		$.ajax({
			type: "POST",
			url: "/reserve/getBooth/",
			cache : false,
			dataType: "json",
			data : {
				shop_no: $("#shop_no").val(),
			},
			success: function(data, dataType) {
				target1.after(data.time_html);
				target2.after(data.html);

			},
			error: function(xhr, textStatus, errorThrown) {
				alert("Error! " + textStatus + " " + errorThrown);
			}
		});



	}

{/literal}
//-->
</script>

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="reserve/menu_reserve.tpl"}
		<h3>予約管理</h3>
<h4>予約申込内容</h4>
		<a href="/reserve/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;予約一覧に戻る</a><br />

			{if $finish_flg==1}
			{include file="messages.tpl"}
			{/if}

	<div class="clearfix">
		<div class="left w50">
			<h5>お申込み者情報</h5>
				<table class="w100">
				 <tr>
					 <th>お申込者　会員No./お名前</th>
					 <td>
					 {$db_memberArr.member_no}/{$db_memberArr.name}</td>
				  </tr>
				 <tr>
					 <th>メールアドレス</th>
					 <td>
							{$db_memberArr.email}
					 </td>
				  </tr>
				 <tr>
					 <th>電話番号</th>
					 <td>
						{$db_memberArr.tel}
					 </td>
				  </tr>
<!--
				 <tr>
					 <th>担当者</th>
					 <td>
					 {$db_memberArr.tanto}</td>
				  </tr>
 -->
				 <tr>
					 <th>コース名 / 使用クーポン</th>
					 <td>
					 {$db_courseArr.name} /
						{if $db_courseArr.coupon_name}
							{$db_courseArr.coupon_name}
						{else}
							-
						{/if}
					 </td>
				  </tr>
			</table>
		</div>
		<div class="right ml30 w50">
		<h5>予約内容詳細</h5>

			<table class="w100">
			  <tr>
				 <th>予約日時</th>
				 <td>
					{$input_data.reserve_date} {$input_data.start_time|date_format:"%H:%M"}～{$input_data.end_time|date_format:"%H:%M"}
				 </td>
			  </tr>

			  <tr>
				 <th>予約店舗名<span class="red">※</span></th>
				 <td>
				{$input_data.shop_name}
				</td>
			  </tr>
			  <tr>
				 <th>メニュー名<span class="red">※</span></th>
				 <td>
				{$input_data.menu_name}
				</td>
			  </tr>
			 <tr>
				 <th>予約数<span class="red">※</span></th>
				 <td>
				{$input_data.number}人<br />
<!--
				【来店予定者】<br />
				{if $login_admin.shop_no>=0}
					{foreach from=$input_data.detail item=item}
						<form action="/reserve/detail/" method="post">
						<input type="submit" value="{$item.name}" class="mt10" > <br />
						<input type="hidden" name="member_id" value="{$item.member_id}">
						<input type="hidden" name="no" value="{$item.no}">
						<input type="hidden" name="reserve_no" value="{$input_data.reserve_no}">
						</form>
					{/foreach}
				{else}
					{foreach from=$input_data.detail item=item}
						・{$item.name}<br />
					{/foreach}
				{/if}
			  </tr>
  -->
<!--
			  <tr>
				 <th>備考</th>
				 <td>
					{$input_data.comment|nl2br}
				</td>
			  </tr>
-->
		<form action="" method="post"  >
<!--
			  <tr>
				 <th>電話</th>
				 <td>
					{html_radios name=tel_flg options=$telArr selected=$input_data.tel_flg separator="<br />"}
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
		{if $login_admin.shop_no>=0}
			<div class="mt20 tc">
			  <input type="submit"  name="submit" value="更新する" />
			  <input type="hidden" name="reserve_no" value="{$input_data.reserve_no}" >
			</div>
			</form>
		  {/if}
		 </div>
	</div>
</div>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
