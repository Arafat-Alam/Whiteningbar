{include file="head.tpl"}
<!-- date time picker -->
<link href="/css/themes/default.css" rel="stylesheet" type="text/css" />
<link href="/css/themes/default.date.css" rel="stylesheet" id="theme_date">
<link href="/css/themes/default.time.css" rel="stylesheet" id="theme_time">

<script type="text/javascript">
<!--
{literal}

function winopn(no){
	window.open('/member/member_regist/?no='+no, 'mywindow2', 'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes');
}
function winopnSearch(no){
	window.open('/reserve/member_search/?no='+no, 'mywindow2', 'width=1200, height=900, menubar=no, toolbar=no, scrollbars=yes');
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
		dataType: "json",
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
<h4>予約 来店詳細</h4>
<div class="w50 center">
		<a href="/reserve/edit/?reserve_no={$input_data.reserve_no}" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;予約申込内容に戻る</a><br />
			{if $finish_flg==1}
			{include file="messages.tpl"}
			{/if}

<form action="" method="post"  >
<h5>予約来店者情報</h5>
      <table class="w100">
       <tr>
          <th>お名前</th>
          <td>
          {if $db_data.member_id==0}
          	<a href="javascript:void(0);" onClick="winopn('{$input_data.no}')" class="btn">初めての方</a>&nbsp;　
          	<a href="javascript:void(0);" onClick="winopnSearch('{$input_data.no}')" class="btn">会員から検索</a>

          {else}
          	<a href="/member/edit/?member_id={$memArr.member_id}">{$memArr.member_no}/{$memArr.name}</a>
          {/if}

          </td>
        </tr>
        <tr>
          <th>予約日時</th>
          <td>
							<!--{$db_data.reserve_date} {$db_data.start_time|date_format:"%H:%M"}～{$db_data.end_time|date_format:"%H:%M"}  -->
	 		{if $result_messages.reserve_date}
				<span class="txt-red txt-sm">{$result_messages.reserve_date}</span><br />
			{/if}
	 		{if $result_messages.start_time}
				<span class="txt-red txt-sm">{$result_messages.start_time}</span><br />
			{/if}

						<input class="fieldset__input js__datepicker datepicker" type="text" placeholder="クリックして日付を選択" name="reserve_date" value="{$input_data.reserve_date}">
						<input class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択" name="start_time" value="{$input_data.start_time}">
          </td>
        </tr>
        <tr>
          <th>予約店舗名</th>
          <td>
						<!-- {$db_data.shop_name} -->
						{html_options name=shop_no options=$shopArr selected=$input_data.shop_no }
		</td>
        </tr>
       <tr>
          <th>コース名 / 使用クーポン</th>
          <td>
          	{$db_data.course_name} /
          	{if $db_data.coupon_name}
          		{$db_data.coupon_name}
          	{else}
          		-
          	{/if}
          </td>
        </tr>
         {if $db_data.fee_flg==0}
<!--
        <tr>
          <th>コース料金支払チェック</th>
          <td>
          <input type="checkbox" name="fee_flg" value="1"   /><br />初回ご来店時<br />コース料金の支払が済んだ場合にチェックしてください<br />
	          {html_options name="p_coupon_id" options=$couPaArr selected=$input_data.p_coupon_id id=p_coupon_id  onChange="getList()"}
	          <div id=coupon></div>
          </td>
        </tr>
 -->
          {/if}

        <tr>
          <th>メニュー名</th>
          <td>
          	{if $db_data.menu_name}
				{$db_data.menu_name}({$db_data.raiten_cnt}回)
			{else}
				{html_options name=menu_no options=$menuArr }

			{/if}
		</td>
        </tr>
        {foreach from=$memPayArr item=item}
          <tr>
          <th>{$item.name}</th>
          <td>
          <input type="checkbox" name="pay[{$item.id}]" value="1" {if $payArr && $item.id|in_array:$payArr}checked{/if}  /></td>
        </tr>
        {/foreach}

       <tr>
          <th>電話確認</th>
          <td>
 				{html_radios name=tel_flg options=$telArr selected=$input_data.tel_flg }
           </td>
        </tr>

        <tr>
          <th>来店チェック</th>
          <td>
           	<label><input type="radio" name="visit_flg" value="1" {if $input_data.visit_flg==1}checked{/if}  />来店</label>
          	<label><input type="radio" name="visit_flg" value="99" {if $input_data.visit_flg==99}checked{/if}  />キャンセル</label>
          	<label><input type="radio" name="visit_flg" value="0" {if $input_data.visit_flg==0}checked{/if}  />予約中</label>
            <label><input type="radio" name="visit_flg" value="2" {if $input_data.visit_flg==2}checked{/if}  />来店せず</label>
          </td>
        </tr>
        <tr>
          <th>担当者</th>
			<td>
			 	{html_options name=staff_no options=$staffArr selected=$input_data.staff_no}
			</td>
        </tr>

        <tr>
          <th>管理用備考</th>
          <td>
				<textarea name="kanri_comment" rows="" cols="">{$input_data.kanri_comment}</textarea>
			</td>
        </tr>

	</table>
      <div class="mt20 tc">
        <input type="submit"  name="submit" value="更新する" class="btn-lg" />
        <input type="hidden" name="reserve_no" value="{$input_data.reserve_no}" >
        <input type="hidden" name="no" value="{$input_data.no}" >
        {if $db_data.menu_name}
        	<input type="hidden" name="menu_no" value="{$input_data.menu_no}" >
		{/if}
      </div>
    </div>
</form>
</div>
	</div>
</div>
{include file="footer.tpl"}
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
   		 max: [20,15]
		})
	{/literal}
	</script>

</body>
</html>
