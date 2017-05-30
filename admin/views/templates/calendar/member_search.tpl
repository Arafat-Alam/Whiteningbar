{include file="calendar_head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#tel").val("");
	$("#user_name").val("");
}

//現在未使用
function getList(member_id){

	target1 = $("#menu_"+member_id);
	//$(".category_m_id").remove();
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList/",
		cache : false,
		dataType: "json",
		data : {
			buy_no: $("#buy_no_"+member_id).val(),
		},
		success: function(data, dataType) {


		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


//該当メンバーの詳細
function getMemberInfo(member_id){

	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMemberInfo/",
		cache : false,
		dataType: "json",
		data : {
			member_id: member_id,
		},
		success: function(data, dataType) {
			$("#modal_name").html(data.name+" / "+data.name_kana);
			$("#modal_email").html(data.email);
			$("#modal_tel").html(data.tel);
			$("#modal_address").html(data.zip+"<br>"+data.address1+data.address2);
			if(data.sex==1){
				$("#modal_sex").html("男性");
			}
			else if(data.sex==2){
				$("#modal_sex").html("女性");
			}
			$("#modal_birth").html(data.year+"/"+data.month+"/"+data.day);
			$("#modal_intro").html(data.intro);
			$("#modal_comment").html(data.comment);
			$("#modal_kanri_comment").html(data.kanri_comment);
			if(data.tooth_flg==1){
				$("#modal_tooth_flg").html("1種類");
			}
			else if(data.sex==2){
				$("#modal_tooth_flg").html("1種類");
			}
			$("#modal_reserve").html(data.reserve);


			//モーダル表示用
			 	var secHeight = $(".window").height() *0.5
			 	var secWidth = $(".window").width() *0.5
			 	var Heightpx = secHeight * -1;
			 	var Widthpx = secWidth * -1;
			 	$(".graylayer").fadeIn();

			 	$(".window").fadeIn().css({
			  	"margin-top" : Heightpx + "px" ,
			  	"margin-left" : Widthpx + "px"
			 	});
			 	return false;


		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

function setOpener(){
	window.opener.location.href="/reserve/detail/?ref=cal&no={/literal}{$no}{literal}";
	window.close();
}
function setOpener2(){
	window.opener.location.href="/calendar/list/?back";

	window.close();
}

jQuery(document).ready(function(){

	$("body").append('<div class="graylayer"></div>');
	 $(".graylayer").click(function(){
	  $(this).fadeOut();
	  $('.window').fadeOut();
	 })
//	 $('.aaa').click(function(){

//		 var secHeight = $(".window").height() *0.5
//	 	var secWidth = $(".window").width() *0.5
//	 	var Heightpx = secHeight * -1;
//	 	var Widthpx = secWidth * -1;
//	 	$(".graylayer").fadeIn();

//	 	$(".window").fadeIn().css({
//	  	"margin-top" : Heightpx + "px" ,
//	  	"margin-left" : Widthpx + "px"
//	 	});
//	 	return false;
//	})


});

{/literal}
</script>
<style>
{literal}
html,body {
 font-family:Lucida sans , "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro", "メイリオ", Meiryo, sans-serif;
 margin: 0;
 padding: 0;
 }
#container{
 width:100px;
 margin:100px auto;
}

.graylayer{
 display:none;
 position: fixed;
 top:0;
 left:0;
 height:100%;
 width:100%;
 background-color: #000;
 opacity:.7;
 filter(alpha=70);
 }
.window{
 padding: 30px 40px;
 display:none;
 position: fixed;
 top: 50%;
 left:50%;
 filter: progid:DXImageTransform.Microsoft.Gradient(GradientType=0,StartColorStr=#99ffffff,EndColorStr=#99ffffff);
 background-color: rgba(255, 255, 255, 1);
 font-size: 1.1em;
 /*color: #fff;*/
 /*text-shadow:rgba(0,0,0,.8) -1px -1px;*/
 border-radius: 5px;
 z-index: 20;
}
{/literal}
</style>

<body {$onl}>

	<div id="wrap">
		<div class="content content-form">
			<div class="content-inner">
			<h1>顧客検索</h1>
			<form method="post" name="fm_search" action="">
				<table class="table">
					<tr>
						<th>名前</th>
						<td><input name="name" id="user_name"  value="{$search.name}" type="text">&nbsp;
						</td>
						<th>電話番号</th>
						<td><input name="tel" id="tel"  value="{$search.tel}" type="text">&nbsp;
						</td>
					</tr>
				</table>
				<div class="mt20 tc">
					<button type="submit" name="sbm_search"  class="btn btn-search w100-sp">検索</button>&nbsp;
					<button type="button" onClick="clearSearchForm()" class="btn btn-search btn-gray w100-sp">クリア</button>
				</div>

			</form>
			</div>
			<div class="content-inner">

{include file="messages.tpl"}


			<form name="fm_list" id="fm_list" method="POST" action="">
<!--
				<p>コース選択プルダウンには使用可能な購入済みコースが表示されていますので、今回の来店予約に使用するコースを選択してください。</p>
-->
			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				{if $navi}<div class="right">{$navi}</div>{/if}
			</div>

<button onClick="window.close();" class="btn btn-gray btn-sm">閉じる</button>
				<table class="table clear mt10">
						<tr class="pc">
							<th class="tc">会員No.</th>
							<th class="tc" colspan=2>名前</th>
							<!-- <th class="tc">コース選択</th> -->
							<th class="tc">選択</th>
						</tr>
			{foreach from=$members item="member"}
				<tr>
					<td><span class="sp txt-sm">会員NO.：</span>{$member.member_no}</td>
					<td>
					<span class="sp txt-sm">お名前：</span>{$member.name} / {$member.name_kana}

					</td>
					<td>
					<a href="javascript:void();"  id="aaa" class="btn btn-search" onClick="getMemberInfo('{$member.member_id}');" />顧客情報を見る</a>

					</td>
<!--
					<td>
						<select name="buy_no[{$member.member_id}]" id=buy_no_{$member.member_id} onChange="getList('{$member.member_id}')">
							{foreach from=$member.courseArr key="key" item="item"}
								<option value={$key}>{$item}</option>
							{/foreach}
						</select>
						<div id=menu_{$member.member_id}></div>

					</td>
  -->
					<td>
					<input type="submit" name="choice[{$member.member_id}]" value="選択" class="btn w100" onClick="return confirm('{$member.name}様をご来店の会員とします。良いですか？');">
					</td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="4">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>

			{/foreach}
					</table>

			<div class="paging clearfix">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
			</div>

			</form>
			</div>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
  <section class="window"><!-- モーダル表示部分 -->

<table class="table">
       <tr>
          <th>現在のコース消費数</th>
          <td>
          <div id="modal_reserve"></div>
          </td>
        </tr>
       <tr>
          <th>お名前</th>
          <td>
          <div id="modal_name"></div>
          </td>
        </tr>
       <tr>
          <th>メールアドレス</th>
          <td>
          <div id="modal_email"></div>
          </td>
        </tr>
       <tr>
          <th>tel</th>
          <td>
          <div id="modal_tel"></div>
          </td>
        </tr>
		<tr>
			<th>住所</th>
			<td>
          <div id="modal_address"></div>
			</td>
		</tr>
         <tr>
          <th>性別</th>
          <td>
          <div id="modal_sex"></div>
			</td>
        </tr>
        <tr>
          <th>生年月日</th>
          <td>
          <div id="modal_birth"></div>
            </td>
        </tr>
        <tr>
          <th>ご紹介者</th>
          <td>
                    <div id="modal_intro"></div>

          {$member.intro}
        </tr>
        <tr>
          <th>お客様備考</th>
          <td>
                    <div id="modal_comment"></div>
 			</td>
        </tr>
         <tr>
          <th>歯磨き粉</th>
          <td>
                    <div id="modal_tooth_flg"></div>
			</td>
        </tr>
         <tr>
          <th>管理用備考</th>
          <td>
                    <div id="modal_kanri_comment"></div>
			</td>
        </tr>

</table>

  </section>
{include file="calendar_footer.tpl"}
</body>
</html>
