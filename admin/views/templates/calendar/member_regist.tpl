{include file="calendar_head.tpl"}
<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>

<script language="JavaScript">
<!--
{literal}

function clearSearchForm() {
	$("#shop_no").val("");

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
			coupon_id:{/literal}{if $input_data.coupon_id}{$input_data.coupon_id}{else}0{/if}{literal}
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

	if($("#p_coupon_id").val()){
		getList();

	}
});

function setOpener(){
	window.opener.location.href="/reserve/detail/?ref=cal&no={/literal}{$no}{literal}";
	window.close();
}
function setOpener2(){
	window.opener.location.href="/calendar/reserve/?back";

	window.close();
}


{/literal}
</script>
<body {$onl}>

	<div id="wrap">
		<div class="content content-form">
		<form action="" method="post"  >
			<div class="content-inner">
			<h1>新規会員登録</h1>
			{if $finish_flg==1}
			{include file="messages.tpl"}

			{/if}

				{if $result_messages}
					{foreach from=$result_messages item=item}
						<p class="txt-red mt5">{$item}</p>
					{/foreach}
				{/if}


<button onClick="window.close();" class="btn btn-gray btn-sm">閉じる</button><br/>


				<div class="tc">
					<input name="submit" type="submit" class="btn btn-lg" value="登録">
				</div>
<div class="tc mt25">
</div>

				<table class="table new-app">
					<tr>
						<th>メールアドレス&nbsp;</th>
						<td>
					 		{if $result_messages.email}
								<span class="txt-red txt-sm">{$result_messages.email}</span><br />
							{/if}
						<input name="email" value="{$input_data.email}" type="text" class="form-lg">
						</td>
					</tr>
					<tr>
						<th>パスワード&nbsp;</th>
						<td>
					 		{if $result_messages.password}
								<span class="txt-red txt-sm">{$result_messages.password}</span><br />
							{/if}

						<input name="password" value="{$input_data.password}"  type="password"><br><span class="txt-sm"> 6桁以上の半角英数</span></td>
					</tr>
					<tr>
						<th>お名前&nbsp;<span class="label">必須</span></th>
						<td>
				 		{if $result_messages.name}
							<span class="txt-red txt-sm">{$result_messages.name}</span><br />
						{/if}

						<input name="name" value="{$input_data.name}"  type="text"></td>
					</tr>
					<tr>
						<th>ふりがな&nbsp;</th>
						<td>
				 		{if $result_messages.name_kana}
							<span class="txt-red txt-sm">{$result_messages.name_kana}</span><br />
						{/if}

						<input name="name_kana" value="{$input_data.name_kana}"  type="text"></td>
					</tr>
					<tr>
						<th>電話番号&nbsp;</th>
						<td>
				 		{if $result_messages.tel}
							<span class="txt-red txt-sm">{$result_messages.tel}</span><br />
						{/if}

						<input name="tel" value="{$input_data.tel}"  type="text"></td>
					</tr>
			        <tr>
			          <th>郵便番号</th>
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
			          <th>都道府県</th>
			          <td>
				 		{if $result_messages.pref}
							<span class="txt-red txt-sm">{$result_messages.pref}</span><br />
						{/if}

						{html_options name=pref options=$prefArr selected=$input_data.pref id="pref" }
					</td>
			        </tr>
			        <tr>
			          <th>市区町村・番地</th>
			          <td>
				 		{if $result_messages.address1}
							<span class="txt-red txt-sm">{$result_messages.address1}</span><br />
						{/if}

			          <input type="text" id="city" name="address1" value="{$input_data.address1}"  class="form-lg mt5" /></td>
			        </tr>
			        <tr>
			          <th>建物名</th>
			          <td>
				 		{if $result_messages.address2}
							<span class="txt-red txt-sm">{$result_messages.address2}</span><br />
						{/if}

			          <input type="text" name="address2" value="{$input_data.address2}"  class="form-lg mt5" /></td>
			        </tr>
					<tr>
						<th>性別&nbsp;</th>
						<td>
					 		{if $result_messages.sex}
								<span class="txt-red txt-sm">{$result_messages.sex}</span><br />
							{/if}
								<input type="radio"  name="sex" value="1" {if $input_data.sex==1}checked{/if} />男性
								<input type="radio"  name="sex" value="2" {if $input_data.sex==2}checked{/if} />女性
						</td>
					</tr>
					<tr>
						<th>生年月日&nbsp;</th>
						<td>

				          	{html_options name="year" options=$yearArr selected=$input_data.year class="form-sm"}
				            年
				            {html_options name="month" options=$monthArr selected=$input_data.month class="mt5 form-sm"}
				            月
				            {html_options name="day" options=$dayArr selected=$input_data.day class="mt5 form-sm"}
				            日

						</td>
					</tr>
			        <tr>
			          <th>ご紹介者</th>
			          <td>
			          <input type="text" name="intro" value="{$input_data.intro}"  class="form-lg mt5" /></td>
			        </tr>
					<tr>
						<th>備考</th>
						<td><textarea name="comment" rows="" cols="">{$input_data.comment}</textarea></td>
					</tr>
				</table>


<h2>その他管理用情報</h2>
 	<table class="table new-app">
	       <tr>
	          <th>コース購入</th>
	      	<td>
	          {html_options name="course_no" options=$courseArr2 selected=$input_data.course_no id=course}
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
          <th>歯磨き粉</th>
          <td>
				<label><input type="radio"  name="tooth_flg" value="1" {if $input_data.tooth_flg==1}checked{/if} />１種類</label>
				<label><input type="radio"  name="tooth_flg" value="2" {if $input_data.tooth_flg==2}checked{/if} />２種類</label>
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
					<input name="submit" type="submit" class="btn btn-lg" value="登録">
				</div>
			</div>

			<input type="hidden" name="spid" value="{$input_data.shop_no}">
			<input type="hidden" name="shop_no" value="{$input_data.shop_no}">
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
{include file="calendar_footer.tpl"}
</body>
</html>
