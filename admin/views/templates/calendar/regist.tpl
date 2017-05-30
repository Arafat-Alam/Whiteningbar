{include file="calendar_head.tpl"}
<script language="JavaScript">
<!--
{literal}

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
	<div id="wrap">
		<div class="content content-form">
		<form action="register_confirm.html">
			<div class="content-inner">
			<h1>新規会員登録</h1>
				<table class="table new-app">
					<tr>
						<th>予約店舗名&nbsp;<span class="label">必須</span></th>
						<td>
							{if $result_messages.shop_no}<span class="txt-red txt-sm">{$result_messages.shop_no}<br></span>{/if}
							{$shopInfo.name}
						</td>
					</tr>
					<tr>
						<th>メールアドレス&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.email}
								<span class="txt-red txt-sm">{$result_messages.email}</span><br />
							{/if}
							<input name="email" value="{$input_data.email}" type="text" class="form-lg">
					</td>
					</tr>
					<tr>
						<th>パスワード&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.password}
								<span class="txt-red txt-sm">{$result_messages.password}</span><br />
							{/if}

							<input name="password" value="{$input_data.password}"  type="password"><br><span class="txt-sm">6桁以上の半角英数</span></td>
					</tr>
					<tr>
						<th>お名前&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.name}
								<span class="txt-red txt-sm">{$result_messages.name}</span><br />
							{/if}

							<input name="name" value="{$input_data.name}"  type="text">
						</td>
					</tr>
					<tr>
						<th>ふりがな&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.name_kana}
								<span class="txt-red txt-sm">{$result_messages.name_kana}</span><br />
							{/if}

							<input name="name_kana" value="{$input_data.name_kana}" type="text"></td>
					</tr>
					<tr>
						<th>電話番号&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.tel}
								<span class="txt-red txt-sm">{$result_messages.tel}</span><br />
							{/if}

						<input name="tel" value="{$input_data.tel}" type="text"><br>
						</td>
					</tr>
			        <tr>
			          <th>郵便番号&nbsp;<span class="label">必須</span></th>
			          <td>
				 		{if $result_messages.zip}
							<span class="txt-red txt-sm">{$result_messages.zip}</span><br />
						{/if}
			          <input type="text" id="zip" name="zip" value="{$input_data.zip}"  class="form-sm" />
			          【住所自動入力】<br />
			          郵番を入力すると、住所の一部が自動入力されます。<br />ハイフン有無、半角・全角、どれでも入力可能です。
			          <br />入力履歴では自動入力が出来ませんのでご注意ください。
			        </td>
			        </tr>
			        <tr>
			          <th>都道府県&nbsp;<span class="label">必須</span></th>
			          <td>
				 		{if $result_messages.pref}
							<span class="txt-red txt-sm">{$result_messages.pref}</span><br />
						{/if}

						{html_options name=pref options=$prefArr selected=$input_data.pref id="pref" }
					</td>
			        </tr>
			        <tr>
			          <th>市区町村・番地&nbsp;<span class="label">必須</span></th>
			          <td>
				 		{if $result_messages.address1}
							<span class="txt-red txt-sm">{$result_messages.address1}</span><br />
						{/if}

			          <input type="text" id="city" name="address1" value="{$input_data.address1}" class="form-lg mt5" /></td>
			        </tr>
			        <tr>
			          <th>建物名</th>
			          <td>
				 		{if $result_messages.address2}
							<span class="red">{$result_messages.address2}</span><br />
						{/if}

			          <input type="text" name="address2" value="{$input_data.address2}" class="form-lg mt5" /></td>
			        </tr>
					<tr>
						<th>性別&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.sex}
								<span class="txt-red txt-sm">{$result_messages.sex}</span><br />
							{/if}
							<label><input type="radio" name="sex" value="1" {if $input_data.sex==1}checked{/if} >男性</label>
							<label><input type="radio" name="sex" value="2" {if $input_data.sex==2}checked{/if} >女性</label>
						</td>
					</tr>
					<tr>
						<th>生年月日&nbsp;<span class="label">必須</span></th>
						<td>
				         	{html_options name="year" options=$yearArr selected=$input_data.year class="form-sm"}
				            年
				            {html_options name="month" options=$monthArr selected=$input_data.month class="form-sm"}
				            月
				            {html_options name="day" options=$dayArr selected=$input_data.day class="form-sm"}
				            日
						</td>
					</tr>
					<tr>
						<th>お店からのお知らせメール&nbsp;<br class="pc"><span class="label">必須</span></th>
						<td>
							<label><input name="mail_flg" type="radio" value="1" {if $input_data.mail_flg==1}checked{/if}  >希望する</label>
							<label><input type="radio" name="mail_flg" value="0" {if $input_data.mail_flg==0}checked{/if} >希望しない</label></td>
					</tr>
					<tr>
						<th>備考</th>
						<td><textarea name="comment" rows="" cols="">{$input_data.comment}</textarea></td>
					</tr>
				</table>
      <table class="table new-app">
	       <tr>
	          <th>コース購入</th>
	      	<td>
	          {html_radios name="course_no" options=$courseArr2 selected=$input_data.course_no id=course}

	      	</td>
	      </tr>
	       <tr>
	          <th>クーポン</th>
	      	<td>
	          {html_options name="p_coupon_id" options=$couPaArr selected=$input_data.p_coupon_id id=p_coupon_id  onChange="getList()"}
	          <div id=coupon></div>
	      	</td>
	      </tr>
        <tr>
          <th>管理用備考</th>
          <td>
				<textarea name="kanri_comment" rows="" cols="">{$input_data.kanri_comment}</textarea>
			</td>
        </tr>

	</table>

				<div class="tc mt35">
					<input type="button" class="btn btn-lg btn-gray" value="戻る" onclick="location.href='/calendar/'">&nbsp;&nbsp;
					<input name="submit" type="submit" class="btn btn-lg" value="登録する"></div>
			</div>
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->

{include file="calendar_footer.tpl"}


</body>
</html>