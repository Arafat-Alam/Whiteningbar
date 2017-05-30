{php}
session_start();
$_SESSION['page']='reserve';
//$_SESSION['tab']='weekly';
{/php}

{include file="head.tpl"}
<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>

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
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{* include file="member/menu_member.tpl" *}
		<!-- <h3>顧客一覧</h3> -->
<h4>個人情報の&nbsp;&nbsp;<a href="/member/edit/?member_id={$db_data.member_id}" class="btn"><i class="fa fa-lg fa-pencil"> </i>&nbsp;編集</a>&nbsp;<a href="/member/history/?member_id={$db_data.member_id}" class="btn"><i class="fa fa-lg fa-history"> </i>&nbsp;履歴</a></h4>
		<a href="/member/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;顧客一覧へ戻る</a><br /><br />
		<a href="/reserve/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;予約一覧へ戻る</a><br />

			{if $finish_flg==1}
			{include file="messages.tpl"}
			{elseif $result_messages}
				<span class="red">入力エラーがあります</span><br />
			{/if}
<div class="clearfix">
<div class="left w50">

<h5>個人情報</h5>
<form action="" method="post"  >
      <table class="w100">
        <tr>
          <th>登録日/最終更新日</th>
          <td>
          {$db_data.insert_date}　/　{$db_data.update_date}</td>
        </tr>
       <tr>
          <th>会員No.</th>
          <td>
          {$db_data.member_no}</td>
        </tr>
        <tr>
          <th>顧客店舗選択<span class="red">※</span></th>
          <td>
          {$db_data.shop_name}
          <!--
			{html_options name=spid options=$shopArr selected=$input_data.spid }
			<br />顧客の店舗を選択してください。顧客の会員番号に頭に付加されます。
		  -->
		</td>
        </tr>
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
          <th>お名前<span class="red">※</span></th>
          <td>
	 		{if $result_messages.name}
				<span class="red">{$result_messages.name}</span><br />
			{/if}
          <input type="text" name="name" value="{$input_data.name}"  /></td>
        </tr>
       <tr>
          <th>ふりがな<span class="red">※</span></th>
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
          <th>ビル名</th>
          <td>
	 		{if $result_messages.address2}
				<span class="red">{$result_messages.address2}</span><br />
			{/if}

          <input type="text" name="address2" value="{$input_data.address2}"  /></td>
        </tr>
         <tr>
          <th>性別</th>
          <td>
				<label><input type="radio"  name="sex" value="1" {if $input_data.sex==1}checked{/if} />男性</label>
				<label><input type="radio"  name="sex" value="2" {if $input_data.sex==2}checked{/if} />女性</label>
			</td>
        </tr>
        <tr>
          <th>生年月日</th>
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
          <th>ご紹介者</th>
          <td>
          <input type="text" name="intro" value="{$input_data.intro}"  /></td>
        </tr>
         <tr>
          <th>お知らせメール</th>
          <td>
				<label><input type="radio"  name="mail_flg" value="1" {if $input_data.mail_flg==1}checked{/if} />希望する</label>
				<label><input type="radio"  name="mail_flg" value="0" {if $input_data.mail_flg==0}checked{/if} />希望しない</label>
			</td>
        </tr>
        <tr>
          <th>お客様備考</th>
          <td>
				<textarea name="comment" rows="" cols="">{$input_data.comment}</textarea>
			</td>
        </tr>
        </table>
<!--
<h5>その他管理用情報</h5>
      <table class="w100">
       <tr>
          <th>担当者</th>
          <td>
          <input type="text" name="tanto" value="{$input_data.tanto}"  /></td>
        </tr>
         <tr>
          <th>DM</th>
          <td>
				<label><input type="radio"  name="dm_flg" value="1" {if $input_data.dm_flg==1}checked{/if} />可</label>
				<label><input type="radio"  name="dm_flg" value="0" {if $input_data.dm_flg==0}checked{/if} />不可</label>
				←こちらは必要でしょうか？お知らせメールとの違いはなんでしょうか？
			</td>
        </tr>

	</table>
  -->
{if $login_admin.shop_no>=0}

	{if $db_data.shop_no==$login_admin.shop_no || $login_admin.shop_no==0}
      <div class="mt20 tc">
        <input type="submit"  name="submit" value="更新する" class="btn-lg" />
        <input type="hidden" name="member_id" value="{$input_data.member_id}" >
      </div>
	{/if}
{/if}
</form>
</div>


<div class="right w50">

<h5>管理</h5>
<form action="" method="post"  >

      <table class="w100">
         <tr>
          <th>歯磨き粉</th>
          <td>
				<label><input type="radio"  name="tooth_flg" value="1" {if $kanri_data.tooth_flg==1}checked{/if} />１種類</label>
				<label><input type="radio"  name="tooth_flg" value="2" {if $kanri_data.tooth_flg==2}checked{/if} />２種類</label>
			</td>
        </tr>
         <tr>
          <th>管理用備考</th>
          <td>
				<textarea name="kanri_comment" rows="5" cols="">{$kanri_data.kanri_comment}</textarea>
			</td>
        </tr>

      </table>
{if $login_admin.shop_no>=0}
      <div class="mt20 tc">
        <input type="submit"  name="kanri_submit" value="更新する"  class="btn-lg" />
      </div>
{/if}
</form>
<hr>


<h5>購入</h5>
新規にコースをご購入の場合に、こちらから購入処理をお願いします。<br />
※コースご購入の前に予約したお客様の購入処理は「未払い一覧」にて処理してください<br />
<form action="" method="post"  >

      <table class="w100">
        <tr>
          <th>購入店舗<span class="red">※</span></th>
          <td>
			{html_options name=shop_no options=$shopArr selected=$buy_data.shop_no }
			<br />売上管理に必要です
		</td>
        </tr>
       <tr>
          <th>メニュー</th>
      	<td>
          {html_options name="course_no" options=$courseArr selected=$buy_data.course_no}

      	</td>
      </tr>
 	       <tr>
	          <th>クーポン</th>
	      	<td>
	          {html_options name="p_coupon_id" options=$couPaArr selected=$input_data.p_coupon_id id=p_coupon_id  onChange="getList()"}
	          <div id=coupon></div>


	      	</td>
	      </tr>

      </table>
{if $login_admin.shop_no>=0}
      <div class="mt20 tc">
        <input type="submit"  name="course_submit" value="ご購入" onClick="return confirm('チェックしたコースを購入します。良いですか？');" class="btn-lg" />
      </div>
{/if}
</form>
<hr>
<h5>パスワード変更</h5>
<form action="" method="post"  >

      <table class="w100">
        <tr>
       <tr>
          <th>パスワード<span class="red">※</span></th>
          <td>
	 		{if $result_messages.password}
				<span class="red">{$result_messages.password}</span><br />
			{/if}
          <input type="password" name="password" value="{$inp.password}"  />
          6桁以上の半角英数
          </td>
        </tr>
       <tr>
          <th>パスワード確認<span class="red">※</span></th>
          <td>
	 		{if $result_messages.password2}
				<span class="red">{$result_messages.password2}</span><br />
			{/if}
          <input type="password" name="password2"   /></td>
        </tr>
	</table>
{if $login_admin.shop_no>=0}
	{if $db_data.shop_no==$login_admin.shop_no || $login_admin.shop_no==0}
      <div class="mt20 tc">
        <input type="submit"  name="pass_submit" value="パスワード変更" class="btn-lg" />
      </div>
    {/if}
{/if}
</form>

<!--
<hr>
<h5>会員登録時アンケート</h5>
				<table class="table mt10">
				{foreach from=$enqArr item=item}
					<tr>
						<th>
						{$item.enq_name}
						</th>
						<td>
							{$item.answer}
								<br><span class="txt-sm">{$item.comment}</span>
							</td>
						</tr>
				{foreachelse}
						<tr>
							<td>アンケート回答はありませんでした</td>
						</tr>
				{/foreach}
				</table>

 -->

</div>



</div>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
