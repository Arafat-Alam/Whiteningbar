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
		$("#hour").remove();
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
		<h3>顧客一覧</h3>
<h4>予約登録</h4>
		<a href="/member/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;ユーザー一覧へ戻る</a><br />

			{if $finish_flg==1}
			{include file="messages.tpl"}
			{/if}

<form action="" method="post"  >
      <table class="mt10 center w80">
       <tr>
          <th>会員No./お名前</th>
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
       <tr>
          <th>担当者</th>
          <td>
          {$db_memberArr.tanto}</td>
        </tr>
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
        <tr>
          <th>予約可能メニューの選択<span class="red">※</span></th>
          <td>
			{html_options name=menu_no options=$menuArr selected=$input_data.menu_no }
			<br />※ 会員の購入コースの残り回数が<br />メニューの使用回数に満たない場合は、選択肢に出てきません。
		</td>
        </tr>
        <tr>
          <th>予約店舗選択<span class="red">※</span></th>
          <td>
			{html_options name=shop_no options=$shopArr selected=$input_data.shop_no  onClick="getBoothList()" id="shop_no"}
		</td>
        <tr>
          <th>予約日<span class="red">※</span></th>
          <td>
	 		{if $result_messages.reserve_date}
				<span class="red">{$result_messages.reserve_date}</span><br />
			{/if}
          	<input type="text" name="reserve_date" id="start" value="{$input_data.reserve_date}" />
          </td>
        </tr>
        <tr>
          <th>開始時間<span class="red">※</span></th>
          <td>
          	<div id="rev_start_hour"></div>

          	{html_options name=minute options=$timeArr selected=$input_data.minute}～
          </td>
        </tr>

        </tr>
       <tr>
          <th>予約数<span class="red">※</span></th>
          <td>
			<div id="rev_booth"></div>

        </tr>
        <tr>
          <th>電話</th>
          <td>
         	{html_radios name=tel_flg options=$telArr selected=$input_data.tel_flg separator="<br />"}
         </td>
        </tr>
<!--
        <tr>
          <th>歯ブラシ忘れ</th>
          <td>
          <input type="checkbox" name="tooth_flg" value="1" {if $input_data.tooth_flg==1}checked{/if}  /></td>
        </tr>
        <tr>
          <th>来店チェック</th>
          <td>
          	<input type="checkbox" name="visit_flg" value="1" {if $input_data.visit_flg==1}checked{/if}  />
          </td>
        </tr>
        <tr>
          <th>キャンセルチェック</th>
          <td>
          	<input type="checkbox" name="cancel_flg" value="1" {if $input_data.cancel_flg==1}checked{/if}  />
          </td>
        </tr>
        <tr>
          <th>当日お支払額</th>
          <td>
	 		{if $result_messages.fee}
				<span class="red">{$result_messages.fee}</span><br />
			{/if}

          	<input type="text" name="fee" value="{$input_data.fee}"  />円
          </td>
        </tr>
  -->

        <tr>
          <th>備考</th>
          <td>
				<textarea name="comment" rows="" cols="">{$input_data.comment}</textarea>
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
        <input type="submit"  name="submit" value="登録する" />
        <input type="hidden" name="reserve_no" value="{$input_data.reserve_no}" >
        <input type="hidden" name="member_id" value="{$member_id}" >
        <input type="hidden" name="buy_no" value="{$buy_no}" >
      </div>
    </div>
</form>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
