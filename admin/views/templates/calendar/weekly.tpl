{php}
session_start();
$_SESSION['page']='calendar';
$_SESSION['tab']='weekly';
{/php}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



{include file="calendar_head_main.tpl"}

<link rel="stylesheet" type="text/css" href="css/tipsy.css" />
<script type="text/javascript" src="js/jquery.tipsy.js"></script>

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/ui-lightness/jquery-ui.css">
<!-- <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script> -->
<script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
//setTimeout("location.reload()",1000*60);
//-->
</SCRIPT>



<script type="text/javascript">

{literal}

function dispReserve(shop_no,hour,minute,reserve_date,dt){

	document.regForm.action = "/calendar/reserve/";
	/*document.regForm.shop_no.value = shop_no;
	document.regForm.hour.value = hour;
	document.regForm.minute.value = minute;
	document.regForm.reserve_date.value = reserve_date;
	document.regForm.dt.value = dt;*/
	$('#regFormShopNo').val(shop_no);
	$('#regFormHour').val(hour);
	$('#regFormMinute').val(minute);
	$('#regFormReserveDate').val(reserve_date);
	$('#regFormDt').val(dt);
	// alert("asdf");

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

function nextDetail(no,dt){
	document.regForm.action = "/reserve/detail/";
	/*document.regForm.no.value = no;
	document.regForm.dt.value = dt;
	document.regForm.ref.value = "cal";*/
	$('#regFormNo').val(no);
	$('#regFormDt').val(dt);
	$('#regFormRef').val('cal');
	// alert(no+','+dt);

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



$ (function(){

	$(".tooltip").hide();

	$(".app-preview").mouseout(function(){
		$(".tooltip").hide();
	});
	$(".app-preview").mouseover(function(){
		$(".tooltip").show();
	});

});

{/literal}

</script>

{include file="head.tpl"}
</head>

<body class="yui-skin-sam">
	<!-- <div id="wrap"> -->
	<div id="wrapper">
		{include file="header.tpl"}
		{include file="sidebar.tpl"}
		<div class="content">

		<!-- modal start -->
		 <div class="modal fade" id="myModal" role="dialog">
			    <div class="modal-dialog modal-lg">
			    	
			      <!-- Modal content-->
			      <div class="modal-content" align="center">
			        <div class="modal-header">
			          <button type="button" class="close" id="modalBtn" data-dismiss="modal">&times;</button>
			        </div>
			         	<img src="images/loader.gif" id="loader1" style="height: 80px; width: 80px;">
			        <div class="modal-body" id="load-data" align="center">
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
		<!-- Modal2 start -->
			<div class="modal fade" id="myModal2" role="dialog">
			    <div class="modal-dialog modal-lg">
			    
			      <!-- Modal content-->
			      <div class="modal-content" align="center">
			        <div class="modal-header">
			          <button type="button" class="close" data-dismiss="modal">&times;</button>
			        </div>
			         	<img src="images/loader.gif" id="loader2" style="height: 80px; width: 80px; display: none;">
			        <div class="modal-body" id="load-data2" align="center">
			        </div>
			        <div class="modal-footer">
			          <button type="button" class="btn btn-lg" data-dismiss="modal">Close</button>
			        </div>
			      </div>
			      
			    </div>
			  </div>
			  <!-- end modal -->




			<div class="content-inner clearfix bg-yellow">

				<div class="app-total">
					<div><img src="images/logo.gif" alt="Whitening Bar ロゴ"></div>
				</div>
			</div>

		{foreach from=$arrRsv name=aaa key=keyRev item=p_arrRev}
			<div class="content-inner clear">
			<button onClick="window.close();">閉じる</button>
				<div class="time-table-box clear">
					<h1 class="fl">{$v_dateArr.$keyRev}</h1>
					<div class="app-daily-total">予約数<span>{$reseveCountArr.$keyRev.day}</span>件</div>
					<div class="clear">
						<table class="time-table-shop">
							<tr>
								<th>店舗名</th>
								<td>&nbsp;</td>
							</tr>
{foreach from=$arr item=item}
{section name=foo start=1 loop=$item.booth+1}
<tr>
{if $smarty.section.foo.index==1}
<th rowspan="{$item.booth}">{$item.name}</th>
{/if}
<td class="num">{$smarty.section.foo.index}</td>
</tr>
{/section}
{/foreach}
</table>
	<form action="" method="post" name="regForm">
	<input type="hidden" name="no" value="" id="regFormNo" />
	<input type="hidden" name="ref" value="" id="regFormRef"/>

	<input type="hidden" name="shop_no" value="" id="regFormShopNo"/>
	<input type="hidden" name="hour" value="" id="regFormHour"/>
	<input type="hidden" name="minute" value="" id="regFormMinute"/>
	<input type="hidden" name="reserve_date" value="" id="regFormReserveDate"/>

	<input type="hidden" name="dt" value="" id="regFormDt"/>
						<div class="table-container">
							<table class="time-table-app">
								<tr>
									<th>10</th>
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

								{foreach from=$p_arrRev item=item}
									{foreach from=$item.rsv key=key item=rsv}
									<tr>
									{section name=foo start=10 loop=22}
										{assign var="ji" value=$smarty.section.foo.index}
										<td>
										<span style="color: black;" data-toggle="modal" data-target="#myModal">
										<div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','00','{$reserve_date.$keyRev}','{$item.dt}');"></div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','00','{$reserve_date.$keyRev}','{$item.dt}');"> </div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','00','{$reserve_date.$keyRev}','{$item.dt}');"> </div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','00','{$reserve_date.$keyRev}','{$item.dt}');"> </div>
										</span>

											{foreach from=$rsv.$ji key=bango item=jjj}
											{if isset($jjj.no)}
											<span style="color: black;" data-toggle="modal" data-target="#myModal2">
												<div id="red{$jjj.no}_{$ji}_{$item.shop_no}" onclick="nextDetail({$jjj.no},'{$item.dt}');" onmouseover="dispDetail({$jjj.no},{$ji},{$item.shop_no});" onmouseout="hideDetail({$jjj.no},{$ji},{$item.shop_no});" class="app-preview type{$jjj.rsv_type}" style="left:{$jjj.px}%;background-color : {$jjj.bg}" >
													<p>
														
														{$jjj.start_time|date_format:"%H:%M"}<br><span class="bold">{if isset($jjj.name)}{$jjj.name}{if isset($jjj.name_kana)}({$jjj.name_kana}){/if}様{/if}{if $jjj.numb>1}({$jjj.numb}){/if}</span><br>{$jjj.menu_name}

													</p>
												</div>
											</span>
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
			{/foreach}



		</div><!-- / .content -->
		<div id="push"></div>
	</div><!-- / #wrap -->

{include file="calendar_footer.tpl"}


</body>
</html>
