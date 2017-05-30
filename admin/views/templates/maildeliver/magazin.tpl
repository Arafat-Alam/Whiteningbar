{php}
session_start();
$_SESSION['page']='mail';
$_SESSION['tab']='magazin';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#year").val("");
	$("#month").val("");
	$("#day").val("");
	$("#user_name").val("");
	//$("input:[name=sex]").removeAttr("checked",false);
	$("input#sex1").attr('checked',false);
	$("input#sex2").attr('checked',false);
	$("input#sex").attr('checked',false);

	$("#course").val("");
	$("#start").val("");
	$("#end").val("");

}

// $("#submitBtn").click(function(){
// 	alert("dsfasffasf");
// });

function validate(event){
	var start = $('#start').val();
	var end = $('#end').val();
	var user_name = $('#user_name').val();
	var year = $('#year').val();
	var month = $('#month').val();
	var day = $('#day').val();
	var course = $('#course').val();

	if (start == '' || end == '' || user_name == '' || year == '' || month == '' || day == '' || course == '') {
		// alert('Please Fill Up All Field ');
		alert('すべてのフィールドを入力してください');
		return false;
	}
	return true;
}

jQuery(document).ready(function($) {

	$('#allCheck').click(function(){
		if(this.checked){
			$('#check input').attr('checked','checked');
		}else{
			$('#check input').removeAttr('checked');
		}
   	});

	$("#start").datepicker({
		dateFormat: "yy-mm-dd"
	});


	$("#end").datepicker({
		dateFormat: "yy-mm-dd"
	});

});



{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="maildeliver/menu_mail.tpl"}
		<h3>ユーザー</h3>
<h4>メルマガ一斉配信</h4>

		{include file="messages.tpl"}
		{if $result_messages}
			<center><span class="red">{$result_messages}</span></center>
		{/if}

		<form method="post" name="fm_search" action="/mail/magazin/">
		<table class="search center">
		<tr>
			<th>来店日 <span style="color: red">※</span></th>
			<td colspan=3>

				<input type="text" id="start" name="start_date" size="25" value="{$search.start_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end" name="end_date" size="25" value="{$search.end_date|date_format:'%Y/%m/%d'}" style="ime-mode:disabled;"/>

			</td>
		</tr>
		<tr>
			<th>お名前 <span style="color: red">※</span></th>
			<td>
				<input type="text" name="name" id="user_name"  value="{$search.name}" size="20" />
			</td>
			<th>お誕生日 <span style="color: red">※</span></th>
			<td>
          	{html_options name="year" options=$yearArr selected=$search.year id=year}
            年
            {html_options name="month" options=$monthArr selected=$search.month id=month}
            月
            {html_options name="day" options=$dayArr selected=$search.day id=day}
            日
			</td>
		</tr>
		<tr>
			<th>コース <span style="color: red">※</span></th>
			<td>
				{html_options name="course_no" options=$courseArr selected=$search.course_no id=course}
			</td>
			<th>性別 <span style="color: red">※</span></th>
			<td>
				<label><input type="radio" name="sex" value="1" id="sex1" {if $search.sex==1}checked{/if} />男性</label>
				<label><input type="radio" name="sex" value="2" id="sex2" {if $search.sex==2}checked{/if} />女性</label>
				<label><input type="radio" name="sex" value="0" id="sex" {if $search.sex==0}checked{/if} />指定なし</label>
			</td>
		</tr>
<!--
		<tr>
			<th>お知らせ</th>
			<td>
				希望する
			</td>
		</tr>
 -->
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_search" class="btn-lg" onclick="return validate()">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
<hr>
<form action="/mail/magazin/" method="post"  >
	テンプレート選択：
	{html_options name=template_no options=$templateArr selected=$template_no }

		<p class="mt20"><label><input type="checkbox" id="allCheck">全て選択する</label></p>
      <table class="admins">
			<tr>
				<th></th>
				<th>会員No</th>
				<th>お名前</th>
				<th>E-mailアドレス</th>
				<th>管理用備考</th>

			</tr>
			{foreach from=$arr item="item"}


		        <tr>
					<td>
					<div id="check" class="tc">
						<input type="checkbox" name="member_id[]" value="{$item.member_id}"  {if $oemArr && $item.member_id|in_array:$oemArr}checked{/if} />
						</div>
					</td>
					<td>
						{$item.member_no}
					</td>
					<td>
						{$item.name}
					</td>
					<td>
						{$item.email}
					</td>
					<td>
						{$item.kanri_comment}
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="5">
						検索に該当する会員はいません
					</td>
				</tr>
			{/foreach}
     </table>

{if $login_admin.shop_no>=0}
      <div class="mt20 tc">
        <input type="submit"  name="address_submit" value="宛先決定" class="btn-lg" />
      </div>
{/if}
</form>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

