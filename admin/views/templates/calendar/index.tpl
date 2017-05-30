{php}
session_start();
$_SESSION['page']='calendar';
$_SESSION['tab']='calendar';
{/php}

{include file="head.tpl"}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->




{include file="calendar_head_main.tpl"}

<link rel="stylesheet" type="text/css" href="css/tipsy.css" />
<script type="text/javascript" src="js/jquery.tipsy.js"></script>

<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.css">
<!-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
//setTimeout("location.reload()",1000*60);
//-->
</SCRIPT>


{literal}
<style type="text/css">
.ui-draggable-disabled {
	opacity: 1.0;
}
<!--
-->
</style>


<script type="text/javascript">



dragmode = 1;

function dispReserve(shop_no,hour,minute,reserve_date,dt){

	document.regForm.action = "/calendar/reserve/";
	document.regForm.shop_no.value = shop_no;
	document.regForm.hour.value = hour;
	document.regForm.minute.value = minute;
	document.regForm.reserve_date.value = reserve_date;
	document.regForm.dt.value = dt;
	$('#load-data').empty();
	$('#loader1').show();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/calendar/reserve/",
		cache : false,
		// dataType: "json",
		dataType: "text",
		data : {
			shop_no: shop_no,
			hour: hour,
			minute: minute,
			reserve_date: reserve_date,
			dt: dt
			
		},
		success: function(data, dataType) {
			//console.log(data);
			$('#loader1').hide();
			$('#load-data').html(data);

		},
		error: function(xhr, textStatus, errorThrown) {
			console.log("Error! " + textStatus + " " + errorThrown);
		}
	});

	// document.regForm.submit();


}
//=================ajax============
function getList(){

	target1 = $("#menu");
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList2/",
		cache : false,
		dataType: "json",
		data : {
			course_no: $("#course_no").val(),
			menu_no: {/literal}{if $input_data.menu_no}{$input_data.menu_no}{else}0{/if}{literal}
		},
		success: function(data, dataType) {
			//console.log(data);
			target1.after(data.html);
			// delete data;

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}
//====================end of ajax============
function nextDetail(no,dt){

	document.regForm.action = "/reserve/detail/";
	document.regForm.no.value = no;
	document.regForm.dt.value = dt;
	document.regForm.ref.value = "cal";


	$('#load-data2').empty();
	$('#loader2').show();

	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/detail/",
		cache : false,
		// dataType: "json",
		dataType: "text",
		data : {
			no: no,
			dt: dt,
			ref: "cal"
			
		},
		success: function(data, dataType) {
			//console.log(data);
			$('#loader2').hide();
			$('#load-data2').html(data);
			delete data;

		},
		error: function(xhr, textStatus, errorThrown) {
			console.log("Error! " + textStatus + " " + errorThrown);
		}
	});


	// document.regForm.submit();


}

function dispDetail(aa,bb,cc){
	//alert(aa+','+bb);
	// $("#re"+aa+'_'+bb+'_'+cc).show();
	var title = $("#re"+aa+'_'+bb+'_'+cc).val();
	$("#red"+aa+'_'+bb+'_'+cc).attr("title",title);

}
function hideDetail(aa,bb,cc){
	//alert(aa+','+bb);
	$("#re"+aa+'_'+bb+'_'+cc).hide();

}

ids = new Array();
var agent = navigator.userAgent;

function cfcheck(elem, tx, ty, wid, hgt, sx, sy){
	if(dragmode == 1){
		return;
	}

	for (i = 0; i < ids.length; i++) {
		if (elem == $('#red' + ids[i]).get(0)) {
			continue;
		}

		tright = tx + wid - 4;

		if (Math.abs(ty - $('#red' + ids[i]).offset().top) < 4) {
			px = $('#red' + ids[i]).offset().left;
			pr = px + $('#red' + ids[i]).width();

			if(tx < px && tright > px || tx < pr && tright > pr || tx > px && tright < pr || tx < px && tright > pr){
				alert("予定が重複しています。");
				$(elem).offset({top:sx, left:sy - 1});
				return false;
			}
		}
	}

	return true;
}

$ (function(){
	$(".tooltip_container").hide();

	queryString = window.location.search || '';
	queryString = queryString.substr(1, queryString.length);

	idx = queryString.indexOf("mode=1");
	if(idx == -1){
		dragmode = 1;
		document.getElementById('mmoderadio1').checked = "checked";
	}else{
		dragmode = 2;
		document.getElementById('mmoderadio2').checked = "checked";
	}


/*

	$(".app-preview").mouseout(function(){
		$(".tooltip").hide();
	});
	$(".app-preview").mouseover(function(){

	});
*/

{/literal}
{foreach from=$arrRsv item=item}{foreach from=$item.rsv key=key item=rsv}{section name=foo start=10 loop=22}{assign var="ji" value=$smarty.section.foo.index}
{foreach from=$rsv.$ji key=bango item=jjj}
{if isset($jjj.no)}
	ids.push('{$jjj.no}_{$ji}_{$item.shop_no}');
{/if}
{/foreach}{/section}{/foreach}{/foreach}

{assign var="count" value=0}
{foreach from=$arr item=item}
{section name=foo start=1 loop=$item.booth+1}
{assign var="count" value=$count+1}
{/section}
{/foreach}
	rcount = {$count};
{literal}

	setTimeout(function() {
		gtop = $("#tablecontainer").offset().top + $("#chead").height() + 3;
		gleft = Math.floor($(".quad").offset().left);
    }, 200);

	sx = 0;
	sy = 0;

	grid_x = $("#tablecontainer").width() / 48; // by arafat changed value 48 from 44;
	grid_y = 51;

	for (i = 0; i < ids.length; i++) {
        var html = $('#re' + ids[i]).html();

		if(!(agent.search(/iPhone/) != -1 || agent.search(/iPad/) != -1 || agent.search(/iPod/) != -1 || agent.search(/Android/) != -1)){
			/*$('#red' + ids[i]).tipsy({
				gravity: 's',
	            html: true,
				fallback: html
			});*/ // by arafat for debug drag mood on
				// alert(dragmode);
		}

		if(dragmode == 2){
			$('#red' + ids[i]).draggable({
				grid: [grid_x, grid_y],
				containment: '#tablecontainer',
				drag: function(){
					$(".tipsy").remove();
				},
				start: function(){
					$(".tipsy").remove();
					sx = $(this).offset().top;
					sy = $(this).offset().left;
				},
				stop: function(){
					if(Math.floor($(this).offset().top) < Math.floor(gtop)){
						$(this).offset({top:sx, left:sy - 1});
					}else{
						ad_x = $(this).offset().left - 1;
						ad_y = $(this).offset().top - 1;

						for(x = 0;x < 44;x++){
							if(Math.abs(ad_x - (x * grid_x + gleft)) < grid_x / 2){
								ad_x = x * grid_x + gleft;
								break;
							}
						}
						for(y = 0;y < rcount;y++){
							if(Math.abs(ad_y - (y * grid_y + gtop)) < 25){
								ad_y = y * grid_y + gtop + 0.5;
								break;
							}
						}

						$(this).offset({top:ad_y, left:ad_x});

						if(cfcheck(this, $(this).offset().left, $(this).offset().top, $(this).width(), $(this).height(), sx, sy)){
							datastr = "";

							wx = Math.floor($(this).offset().left + 1 - gleft) / grid_x;
							wy = Math.floor(($(this).offset().top - gtop) / grid_y);

							wh = Math.floor(wx / 4) + 10;
							wm = Math.floor(Math.floor(wx % 4) * 15);

							datastr += wy + "," + wh + ":" + wm + "," + $(this).attr("id");

							//$("#bbb").html($.ajax({url: "/calendar/aaa/" + datastr, async: false}).responseText);
//							alert(datastr);

							if(window.confirm('予約時間を変更しますか？')){

								$.ajaxSetup({scriptCharset:"utf-8"});
								$.ajax({
									type: "POST",
									url: "/calendar/changeReserve/",
									cache : false,
									dataType: "json",
									data : {
										bango: wy,
										reserve:wh + ":" + wm,
										no:$(this).attr("id"),

									},
									success: function(data, dataType) {


										if(data.html==99){
											alert("予約時間の変更が出来ませんでした");


										}
										else{
											//成功　リロード
											alert("予約時間の変更が完了しました");

										}

										location.reload();

									},
									error: function(xhr, textStatus, errorThrown) {
										alert("Error! " + textStatus + " " + errorThrown);
										location.reload();
									}
								});
							}
							else{
								//cfcheck(this, $(this).offset().left, $(this).offset().top, $(this).width(), $(this).height(), sx, sy)
								//cfcheck(elem, tx, ty, wid, hgt, sx, sy)
								$(this).offset({top:sx, left:sy - 0}); // by arafat change value 1 to 0;

								if(agent.search(/iPhone/) != -1 || agent.search(/iPad/) != -1 || agent.search(/iPod/) != -1 || agent.search(/Android/) != -1){
									toggledrag(dragmode);
								}

//								toggledrag(dragmode);
//								return false;
							}



						}
		//				$(this).offset({top:sx, left:sy});
					}
				}
			});
		}
	}

	if(dragmode == 2){
		$(".drop").sortable();
	}
});

  function toggledrag(mode){

	q = window.location.search || '';
	q = q.substr(1, q.length);

	idx = queryString.indexOf("dt");

	if(idx > -1){
		q = q.substr(0, 13);
	}else{
		q = "";
	}

	for (i = 0; i < ids.length; i++) {
		if(mode == 1){
			location.href = "/calendar/list/?" + q;
		}else{
			location.href = "/calendar/list/?" + q + "&1=1&mode=1";
		}
  	}
  }

var gmt={};
gmt["Jan"]="01";
gmt["Feb"]="02";
gmt["Mar"]="03";
gmt["Apr"]="04";
gmt["May"]="05";
gmt["Jun"]="06";
gmt["Jul"]="07";
gmt["Aug"]="08";
gmt["Sep"]="09";
gmt["Oct"]="10";
gmt["Nov"]="11";
gmt["Dec"]="12";

// <div id="calContainer">が読み込まれたら処理を開始
YAHOO.util.Event.onContentReady("calContainer", function() {

  // YAHOO.widget.Calendarインスタンスの生成
  //var calendar = new YAHOO.widget.Calendar("calContainer","calContainer",{ pagedate:"{/literal}{$caltdy}{literal}",selected:"{/literal}{$yahooSelDate}{literal}" });
  var calendar = new YAHOO.widget.CalendarGroup("calContainer","calContainer",{ pages: 2, pagedate:"{/literal}{$caltdy}{literal}",selected:"{/literal}{$yahooSelDate}{literal}" });

  // 日付のフォーマットを 'yyyy/mm/dd' 'yyyy/mm' にする
  calendar.cfg.setProperty("MDY_YEAR_POSITION", 1);
  calendar.cfg.setProperty("MDY_MONTH_POSITION", 2);
  calendar.cfg.setProperty("MDY_DAY_POSITION", 3);
  calendar.cfg.setProperty("MY_YEAR_POSITION", 1);
  calendar.cfg.setProperty("MY_MONTH_POSITION", 2);

  // 「月」「曜日」ラベルを日本語表示にする
  calendar.cfg.setProperty("MONTHS_SHORT",   ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"]);
  calendar.cfg.setProperty("MONTHS_LONG",    ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"]);
  calendar.cfg.setProperty("WEEKDAYS_1CHAR", ["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"]);
  calendar.cfg.setProperty("WEEKDAYS_SHORT", ["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"]);
  calendar.cfg.setProperty("WEEKDAYS_MEDIUM",["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"]);
  calendar.cfg.setProperty("WEEKDAYS_LONG",  ["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"]);

  // 「年/月」ラベルを日本語表示にする
  calendar.cfg.setProperty("MY_LABEL_YEAR_POSITION",  1);
  calendar.cfg.setProperty("MY_LABEL_MONTH_POSITION",  2);
  calendar.cfg.setProperty("MY_LABEL_YEAR_SUFFIX",  "\u5E74");
  calendar.cfg.setProperty("MY_LABEL_MONTH_SUFFIX",  "");


	//月ページ切り替え
//  calendar.onChangePage = check;
  // カレンダーの描画
  calendar.render();

  calendar.changePageEvent.subscribe(function(type,args) {

ima=calendar.cfg.getProperty("pagedate").split("/");
mon=ima[0];
	changeMon=gmt[tmp[1]];

//	  check(calendar.cfg.getProperty();
	  window.setTimeout(function() {
		  calendarMenu.show();
	  }, 0);
 });

  //日付チェックしたら
  calendar.selectEvent.subscribe(function(eventName, selectDate){
	 javascript:location.href="/calendar/list/?dt="+selectDate;

	}, calendar, true);

//二か月用
function check(target){

	javascript:location.href="/calendar/list/?dt="+dt;
}



 //一か月カレンダー用
//  function check(target){
//	mm=target.getMonth()+1;
//	yy=target.getFullYear();
//	dt=yy+","+mm+",1";

//	javascript:location.href="/calendar/list/?dt="+dt;
//  }

});

{/literal}

</script>

<script type="text/javascript">
{literal}
function winopn(){

	// sW = window.parent.screen.width;
	// sH = window.parent.screen.height;

	window.location='/calendar/list';
}
$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal();
    });

    $(".weather").click(function(){

    });

});
function setWeather(city='',tddate='',shop_no=''){
		$("#myModal").children().removeClass('modal-lg');
        $("#myModal").children().addClass('modal-md');
        $("#myModal").modal();

    	$('#load-data').empty();
		$('#loader1').show();
	    $.ajaxSetup({scriptCharset:"utf-8"});
		$.ajax({
			type: "GET",
			url: "/calendar/setWeather/",
			cache : false,
			 //dataType: "json",
			dataType: "text",
			data: {
				date: tddate,
				city: city,
				shop_no: shop_no,
			},
			
			success: function(data,dataType) {
				//console.log(data);
				$('#loader1').hide();
				$('#load-data').html(data);

			},
			error: function(xhr, textStatus, errorThrown) {
				// console.log("Error! " + textStatus + " " + errorThrown);
			}
		});
}

{/literal}
</script>
{if $back == 'back'}
<script>
{literal}
$(document).ready(function(){
	$("#myModal").modal();
	
		$('#load-data').empty();
		$('#loader1').show();
		$.ajaxSetup({scriptCharset:"utf-8"});
		$.ajax({
			type: "GET",
			url: "/calendar/reserve/?back",
			cache : false,
			 //dataType: "json",
			dataType: "text",
			
			success: function(data,dataType) {
				//console.log(data);
				$('#loader1').hide();
				$('#load-data').html(data);

			},
			error: function(xhr, textStatus, errorThrown) {
				// console.log("Error! " + textStatus + " " + errorThrown);
			}
		});
});

if (dragmode == 2) {
}
{/literal}
</script>
{/if}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body class="yui-skin-sam">
	<!-- <div id=" wrap" > -->
	<div id="wrapper">

		{include file="header.tpl"}
		{include file="sidebar.tpl"}


		<div class="content"  style="margin-top: 30px;">

		<div class="container">
			  <!-- Modal -->
			  <div class="modal fade col-xs-12 col-sm-12" id="myModal" role="dialog">
			    <div class="modal-dialog  modal-lg">
			    
			      <!-- Modal content-->
			      <div class="modal-content" align="center">
			        <div class="modal-header">
			          <img src="images/loader.gif" id="loader1" style="height: 80px; width: 80px;">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			        </div>
			        <div class="modal-body" id="load-data" align="center">
			        </div>
			        <div class="modal-footer">
			          <!-- <button type="button" class="btn btn-success" data-dismiss="modal">Close</button> -->
			        </div>
			      </div>
			      
			    </div>
			  </div>


			  <!-- Modal -->
			  <!-- <div class="modal fade" id="myModal3" role="dialog">
			    <div class="modal-dialog modal-lg">
			    	
			      < Modal content >
			      <div class="modal-content" align="center">
			        <div class="modal-header">
			          <button type="button" class="close" id="modalBtn" data-dismiss="modal">&times;</button>
			        </div>
			         	<img src="images/loader.gif" id="loader1" style="height: 80px; width: 80px;">
			        <div class="modal-body"  >
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div> -->

			  <!-- MOdal 2 -->
			  <div class="modal fade" id="myModal2" role="dialog">
			    <div class="modal-dialog modal-lg">
			    
			      <!-- Modal content-->
			      <div class="modal-content" align="center">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			        </div>
			         	<img src="images/loader.gif" id="loader2" style="height: 80px; width: 80px;">
			        <div class="modal-body" id="load-data2" align="center">
			        </div>
			        <div class="modal-footer">
			          <!-- <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button> -->
			        </div>
			      </div>
			      
			    </div>
			  </div>
			 </div>
  			<!-- modal end -->
			<div class="content-inner clearfix bg-yellow printHide">

				<div class="app-total">
					<div><img src="images/logo.gif" alt="Whitening Bar ロゴ"></div>
					<div class="app-today">
						本日の予約<br><span>{$reseveCountArr.day}</span>件
					</div>
					<div class="app-month mt10">
						今月の予約受付数<br><span>{$reseveCountArr.mon}</span>件
					</div>
				</div>

				<div class="calendar-container">
					<div id="calContainer"></div>
				</div>

				<ul class="app-menu">
					<li><a href="/calendar/list/" class="btn"><i class="fa fa-edit fa-lg"></i>本日の予約</a></li>
					<li><a href="/calendar/weekly/" class="btn"><i class="fa fa-calendar fa-lg"></i>一週間の予約一覧</a></li>
					<li><a href="javascript:location.reload();" class="btn"><i class="fa fa-refresh fa-lg"></i>最新の情報に更新</a></li>
					<!-- <li><a href="javascript:window.close();" class="btn"><i class="fa fa-check fa-lg"></i>予約カレンダーを閉じる</a></li> -->
					<!--<li><a href="#" class="btn"><i class="fa fa-check fa-lg"></i>過去の予約を全て完了</a></li>  -->
					<!--<li><a href="newapp.html" class="btn"><i class="fa fa-edit fa-lg"></i>新規予約の作成</a></li>  -->
				</ul>
			</div>

			<div class="content-inner clear">
			<button type="button" onclick="window.print();">印刷する</button>&nbsp;
				<div class="time-table-box clear">
					<h1 class="fl">{$v_date}</h1>
					<div class="app-daily-total">予約数<span>{$reseveCountArr.day}</span>件</div>
					<div class="app-daily-total printHide"><input type="radio" name="mmode" id="mmoderadio1" value="1" checked="checked" onclick="toggledrag(1);" /> <label for="mmoderadio1" style="display:inline;">詳細表示</label>　<input type="radio" name="mmode" id="mmoderadio2" value="2" onclick="toggledrag(2);" /> <label for="mmoderadio2" style="display:inline;">移動モード</label></div>
					<div class="clear">
						<table class="time-table-shop">
							<tr>
								<th>店舗名</th>
								<td>&nbsp;</td>
							</tr>
							{foreach from=$arr name=aaa item=item}
							{section name=foo start=1 loop=$item.booth+1}
							<tr>
							{if $smarty.section.foo.index==1}
							{if  $smarty.foreach.aaa.iteration % 2 == 0 }
							<th rowspan="{$item.booth}" class="even">
							{else}
							<th rowspan="{$item.booth}">
							{/if}
							{$item.name}<br>
							{if $item.weather == ''}
							<span onclick="setWeather('{$item.city}','{$tddate}','{$item.shop_no}')">
							{if  $smarty.foreach.aaa.iteration % 2 == 0 }
							<button class="weather">Set Weather</button>
							{else}
							<button class="weather" style="background-color: #3e8e41;">Set Weather</button>
							{/if}
							</span>
							{else}
							{$item.weather}<br>
							<span onclick="setWeather('{$item.city}','{$tddate}','{$item.shop_no}')">
							{if  $smarty.foreach.aaa.iteration % 2 == 0 }
							<button class="weather">Update Weather</button>
							{else}
							<button class="weather" style="background-color: #3e8e41;">Update Weather</button>
							{/if}
							</span>
							{/if}
							</th>
							{/if}
							{if  $smarty.foreach.aaa.iteration % 2 == 0 }
							<td class="num even">
							{else}
							<td class="num">
							{/if}
							{$smarty.section.foo.index}</td>
							</tr>
							{/section}
							{/foreach}
						</table>

<form action="" method="post" name="regForm">
<input type="hidden" name="no" />
<input type="hidden" name="ref" />

<input type="hidden" name="shop_no" />
<input type="hidden" name="hour" />
<input type="hidden" name="minute" />
<input type="hidden" name="reserve_date" />

<input type="hidden" name="dt" />
						<div class="table-container" id="tablecontainer">
							<table class="time-table-app">
								<tr>
									<th id="chead">10</th>
									<th>11</th>
									<th>12</th>
									<th>13</th>
									<th>14</th>
									<th>15</th>
									<th>16</th>
									<th>17</th>
									<th>18</th>
									<th>19</th>
									<th>20</th>
									<th>21</th>
								</tr>
								{foreach from=$arrRsv name=aaa item=item}
									{foreach from=$item.rsv key=key item=rsv}
									<tr>
									{section name=foo start=10 loop=22}
										{assign var="ji" value=$smarty.section.foo.index}
										{if  $smarty.foreach.aaa.iteration % 2 == 0 }
										<td class="drop even">
										{else}
										<td class="drop odd">
										{/if}
										<span style="color: black;" data-toggle="modal" data-target="#myModal" id="myBtn">
											<div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','00','{$reserve_date}','{$item.dt}');" id="dispReserve('{$item.shop_no}','{$ji}','00','{$reserve_date}','{$item.dt}');"></div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','15','{$reserve_date}','{$item.dt}');"></div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','30','{$reserve_date}','{$item.dt}');"></div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','45','{$reserve_date}','{$item.dt}');"></div>
										</span>
									{foreach from=$rsv.$ji key=bango item=jjj}
									{if isset($jjj.no)}
									<!-- call for modal from a tag -->
										{if !isset($jjj.blockWidth)}
										{php}
											if($_GET['mode'] == 1){
												echo "<span style='color: black;' >";	
											}else{
												echo "<span style='color: black;' data-toggle='modal' data-target='#myModal2'>";
											}
										{/php}
										{else}
											<span style='color: black;' >
										{/if}
											
												<div onclick="if(dragmode == 1){if !isset($jjj.blockWidth)}nextDetail({$jjj.no},'{$item.dt}'){/if};" onmouseover="dispDetail({$jjj.no},{$ji},{$item.shop_no});" onmouseout="hideDetail({$jjj.no},{$ji},{$item.shop_no});" class="app-preview type{$jjj.rsv_type}" style="left:{$jjj.px}%; background-color : {$jjj.bg}; border: gray solid 0.1px; {$jjj.blockWidth}" id="red{$jjj.no}_{$ji}_{$item.shop_no}" >
													<p>{$jjj.start_time|date_format:"%H:%M"}<br><span class="bold">{if isset($jjj.name)}{$jjj.name}{if isset($jjj.name_kana)}({$jjj.name_kana}){/if}様{/if}{if $jjj.numb>1}({$jjj.numb}){/if}</span><br>{$jjj.menu_name}</p>
												</div>
											</span>
												<div class="tooltip_container"  id="" style="display: none;  color: black; z-index: 999999999999">
													<div class="tooltip clearfix" style="background-color: white; opacity: .8; ">
														<dl><!-- マウスオーバー字に吹き出しとして表示させる情報 -->
															<dt>予約時間</dt>
															<dd>{$jjj.start_time|date_format:"%H:%M"}</dd>
															<dt>お名前</dt>
															<dd>{if isset($jjj.name)}{$jjj.name}{if isset($jjj.name_kana)}({$jjj.name_kana}){/if}様{/if}</dd>
															<dt>お電話番号</dt>
															<dd>{if isset($jjj.tel)}{$jjj.tel}{/if}</dd>
															<dt>メニュー</dt>
															<dd>{if isset($jjj.menu_name)}{$jjj.menu_name}{/if}</dd>
															<dt>予約番号</dt>
															<dd>{$jjj.reserve_no}</dd>
														</dl>
													</div>
												</div>
<textarea style="display: none;" id="re{$jjj.no}_{$ji}_{$item.shop_no}">
予約時間 : {$jjj.start_time|date_format:"%H:%M"}
お名前	  : {if isset($jjj.name)}{$jjj.name}{if isset($jjj.name_kana)}({$jjj.name_kana}){/if}様{/if}

お電話番号 : {if isset($jjj.tel)}{$jjj.tel}{/if}

メニュー : {if isset($jjj.menu_name)}{$jjj.menu_name}{/if}

予約番号 : {$jjj.reserve_no}</textarea>
									{/if}
									{/foreach}

									</td>
									{/section}
									</tr>
									{/foreach}
								{/foreach}
							</table>
						</div>
					</form>
					</div>

				</div><!-- / .time-table-box -->
			</div><!-- / .content-inner -->


		</div><!-- / .content -->
		<div id="push"></div>
	</div><!-- / #wrap -->
{include file="footer.tpl"}
<!-- {include file="calendar_footer.tpl"} -->


<style type="text/css">
{literal}
.modal-body {
    max-width: 100%;
    overflow-x: auto;
}


	@media print {
		table { page-break-after:auto }
		tr    { page-break-inside:avoid; page-break-after:auto }
		td    { page-break-inside:avoid; page-break-after:auto }
		thead { display:table-header-group }
		tfoot { display:table-footer-group }

		header { display: none; }
		head{ display: none;}
		h3 { display: none; }
		button { display: none; }
		hr { display: none; }
		/*form { display: none; }*/
		#header{ display: none; }
		#jMenu{ display: none; }
		#footer{ display: none; }
		.printHide{ display: none; }
		.search_section{ display: none; }
		.scrollToTop{ display: none ! important; }
		.tab{ display: none; }
		.paging{ display: none; }
		.left{ display: none; }
		.right{ display: none; }
	}
{/literal}
</style>
</body>
</html>
