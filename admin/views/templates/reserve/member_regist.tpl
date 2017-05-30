{include file="head.tpl"}
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
		},
		success: function(data, dataType) {
			target1.after(data.html);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

function setOpener(){


//	window.opener.location.reload();
	window.opener.location.href="/reserve/detail/?no={/literal}{$no}{literal}";
	window.close();

}

{/literal}
//-->
</script>

<body {$onl}>
<div id="wrapper">
	<div id="main_content">
	<button onClick="window.close();">閉じる</button>
		<h4>顧客登録</h4>
			{if $finish_flg==1}
			{include file="messages.tpl"}
			{/if}
<form action="" method="post"  >
<div class="clearfix">
	<div class="left w50">
      <table class="w100">
<!--
        <tr>
          <th>顧客店舗選択<span class="red">※</span></th>
          <td>
			{html_options name=spid options=$shopArr selected=$input_data.spid }
			<br />顧客の店舗を選択してください。顧客の会員番号に頭に付加されます。
		</td>
        </tr>
  -->
        <tr>
       <tr>
          <th>メールアドレス(ログインID)<span class="red">※</span></th>
          <td>
	 		{if $result_messages.email}
				<span class="red">{$result_messages.email}</span><br />
			{/if}
          <input type="text" name="email" value="{$input_data.email}"  /></td>
        </tr>
       <tr>
          <th>パスワード<span class="red">※</span></th>
          <td>
	 		{if $result_messages.password}
				<span class="red">{$result_messages.password}</span><br />
			{/if}
          <input type="password" name="password" value="{$input_data.password}"  />
          6桁以上の半角英数
          </td>
        </tr>
        <tr>
          <th>お名前<span class="red">※</span></th>
          <td>
	 		{if $result_messages.name}
				<span class="red">{$result_messages.name}</span><br />
			{/if}
          <input type="text" name="name" value="{$input_data.name}"  /></td>
        </tr>
       <tr>
          <th>フリガナ<span class="red">※</span></th>
          <td>
	 		{if $result_messages.name_kana}
				<span class="red">{$result_messages.name_kana}</span><br />
			{/if}
          <input type="text" name="name_kana" value="{$input_data.name_kana}"  /></td>
        </tr>
        <tr>
          <th>電話番号<span class="red">※</span></th>
          <td>
	 		{if $result_messages.tel}
				<span class="red">{$result_messages.tel}</span><br />
			{/if}

          <input type="text" name="tel" value="{$input_data.tel}" /></td>
        </tr>
        <tr>
          <th>郵便番号<span class="red">※</span></th>
          <td>
	 		{if $result_messages.zip}
				<span class="red">{$result_messages.zip}</span><br />
			{/if}
          <input type="text" id="zip" name="zip" value="{$input_data.zip}"  />
          【住所自動入力】<br />
          郵番を入力すると、住所の一部が自動入力されます。<br />ハイフン有無、半角・全角、どれでも入力可能です。
          <br />入力履歴では自動入力が出来ませんのでご注意ください。

        </td>
        </tr>
        <tr>
          <th>都道府県<span class="red">※</span></th>
          <td>
	 		{if $result_messages.pref}
				<span class="red">{$result_messages.pref}</span><br />
			{/if}

			{html_options name=pref options=$prefArr selected=$input_data.pref id="pref" }
		</td>
        </tr>
        <tr>
          <th>市区町村・番地<span class="red">※</span></th>
          <td>
	 		{if $result_messages.address1}
				<span class="red">{$result_messages.address1}</span><br />
			{/if}

          <input type="text" id="city" name="address1" value="{$input_data.address1}"  /></td>
        </tr>
        <tr>
          <th>建物名等</th>
          <td>
	 		{if $result_messages.address2}
				<span class="red">{$result_messages.address2}</span><br />
			{/if}

          <input type="text" name="address2" value="{$input_data.address2}"  /></td>
        </tr>
         <tr>
          <th>性別<span class="red">※</span></th>
          <td>
	 		{if $result_messages.sex}
				<span class="red">{$result_messages.sex}</span><br />
			{/if}
				<input type="radio"  name="sex" value="1" {if $input_data.sex==1}checked{/if} />男性
				<input type="radio"  name="sex" value="2" {if $input_data.sex==2}checked{/if} />女性
			</td>
        </tr>
        <tr>
          <th>生年月日<span class="red">※</span></th>
          <td>
          	{html_options name="year" options=$yearArr selected=$input_data.year}
            年
            {html_options name="month" options=$monthArr selected=$input_data.month}
            月
            {html_options name="day" options=$dayArr selected=$input_data.day}
            日
            </td>
        </tr>
         <tr>
          <th>お知らせメール<span class="red">※</span></th>
          <td>
				<label><input type="radio"  name="mail_flg" value="0" {if $input_data.mail_flg==0}checked{/if} />希望する</label>
				<label><input type="radio"  name="mail_flg" value="1" {if $input_data.mail_flg==1}checked{/if} />希望しない</label>
			</td>
        </tr>
        <tr>
          <th>備考</th>
          <td>
				<textarea name="comment" rows="" cols="">{$input_data.comment}</textarea>
			</td>
        </tr>
        </table>
	</div>

	<div class="right w50">
		<h5>その他管理用情報</h5>
      <table class="w80">
       <tr>
          <th>担当者</th>
          <td>
          <input type="text" name="tanto" value="{$input_data.tanto}"  /></td>
        </tr>
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
          <th>DM</th>
          <td>
				<label><input type="radio"  name="dm_flg" value="0" {if $input_data.dm_flg==0}checked{/if} />可</label>
				<label><input type="radio"  name="dm_flg" value="1" {if $input_data.dm_flg==1}checked{/if} />不可</label>
			</td>
        </tr>
        <tr>
          <th>管理用備考</th>
          <td>
				<textarea name="kanri_comment" rows="" cols="">{$input_data.kanri_comment}</textarea>
			</td>
        </tr>

	</table>
	</div>
</div>


{if $finish_flg!=1}
      <div class="mt20 tc">
        <input type="submit"  name="submit" value="登録" class="btn-lg" />
      </div>
{/if}
    </div>
			<input type="hidden" name="spid" value="{$db_data.shop_no}">

</form>

	</div>
</div>
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
{include file="footer.tpl"}
</body>
</html>
