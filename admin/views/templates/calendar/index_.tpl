{include file="calendar_head.tpl"}

<script type="text/javascript">
<!--
{literal}

function dispReserve(shop_no,hour,minute,reserve_date,dt){


	document.regForm.action = "/calendar/reserve/";
	document.regForm.shop_no.value = shop_no;
	document.regForm.hour.value = hour;
	document.regForm.minute.value = minute;
	document.regForm.reserve_date.value = reserve_date;
	document.regForm.dt.value = dt;

	document.regForm.submit();


}

function nextDetail(no,dt){

	document.regForm.action = "/reserve/detail/";
	document.regForm.no.value = no;
	document.regForm.dt.value = dt;
	document.regForm.ref.value = "cal";
	document.regForm.submit();


}

function dispDetail(aa,bb){

	$("#re"+aa+bb).show();

}

$ (function(){

	$(".tooltip").hide();

	$(".app-preview").mouseout(function(){
		$(".tooltip").hide();
	});
	$(".app-preview").mouseover(function(){

	});

});

// <div id="calContainer">が読み込まれたら処理を開始
YAHOO.util.Event.onContentReady("calContainer", function() {

  // YAHOO.widget.Calendarインスタンスの生成
  var calendar = new YAHOO.widget.Calendar("calContainer","calContainer",{ pagedate:"{/literal}{$caltdy}{literal}",selected:"{/literal}{$yahooSelDate}{literal}"});

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

  calendar.changePageEvent.subscribe(function() {
	  check(calendar.cfg.getProperty("pagedate"));
	  window.setTimeout(function() {
		  calendarMenu.show();
	  }, 0);
 });

  //日付チェックしたら
  calendar.selectEvent.subscribe(function(eventName, selectDate){
	 javascript:location.href="/calendar/list/?dt="+selectDate;

	}, calendar, true);

  function check(target){

	mm=target.getMonth()+1;
	yy=target.getFullYear();
	dt=yy+","+mm+",1";
	javascript:location.href="/calendar/list/?dt="+dt;
  }

});
{/literal}
//-->
</script>



</head>

<body class="yui-skin-sam">
	<div id="wrap">

		<div class="content">
			<div class="content-inner clearfix bg-yellow">

				<div class="app-total">
					<div><img src="/images/logo.gif" alt="Whitening Bar ロゴ"></div>
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
					<li><a href="/calendar/weekly/" class="btn" target=_blank><i class="fa fa-calendar fa-lg"></i>一週間の予約一覧</a></li>
					<li><a href="javascript:location.reload();" class="btn"><i class="fa fa-refresh fa-lg"></i>最新の情報に更新</a></li>
					<li><a href="javascript:window.close();" class="btn"><i class="fa fa-check fa-lg"></i>予約カレンダーを閉じる</a></li>
					<!--<li><a href="#" class="btn"><i class="fa fa-check fa-lg"></i>過去の予約を全て完了</a></li>  -->
					<!--<li><a href="newapp.html" class="btn"><i class="fa fa-edit fa-lg"></i>新規予約の作成</a></li>  -->
				</ul>
			</div>

			<div class="content-inner clear">
			<button onClick="window.close();">閉じる</button>
				<div class="time-table-box clear">
					<h1 class="fl">{$v_date}</h1>
					<div class="app-daily-total">予約数<span>{$reseveCountArr.day}</span>件</div>
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
<input type="hidden" name="no" />
<input type="hidden" name="ref" />

<input type="hidden" name="shop_no" />
<input type="hidden" name="hour" />
<input type="hidden" name="minute" />
<input type="hidden" name="reserve_date" />

<input type="hidden" name="dt" />
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
								</tr>
								{foreach from=$arrRsv item=item}
									{foreach from=$item.rsv key=key item=rsv}
									<tr>
									{section name=foo start=10 loop=21}
										{assign var="ji" value=$smarty.section.foo.index}

										<td><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','00','{$reserve_date}','{$item.dt}');"></div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','15','{$reserve_date}','{$item.dt}');"> </div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','30','{$reserve_date}','{$item.dt}');"> </div><div class="quad" onClick="dispReserve('{$item.shop_no}','{$ji}','45','{$reserve_date}','{$item.dt}');"> </div>

									{foreach from=$rsv.$ji key=bango item=jjj}
									{if isset($jjj.no)}
												<div onclick="nextDetail({$jjj.no},'{$item.dt}');" onmouseover="dispDetail({$key},{$ji});" class="app-preview type{$jjj.rsv_type}" style="left:{$jjj.px}%;background-color : {$jjj.bg}" >
													<p>{$bango.start_time|date_format:"%H:%M"}<br><span class="bold">{if $jjj.name}{$jjj.name}様{/if}</span><br>{$jjj.menu_name}</p>
												</div>
												<div class="tooltip clearfix"  id="re{$key}{$ji}">
												<dl><!-- マウスオーバー字に吹き出しとして表示させる情報 -->
													<dt>予約時間</dt>
													<dd>{$jjj.start_time|date_format:"%H:%M"}</dd>
													<dt>お名前</dt>
													<dd>{if isset($jjj.name)}{$jjj.name}様{/if}</dd>
													<dt>お電話番号</dt>
													<dd>{if isset($jjj.tel)}{$jjj.tel}{/if}</dd>
													<dt>メニュー</dt>
													<dd>{if isset($jjj.menu_name)}{$jjj.menu_name}{/if}</dd>
													<dt>予約番号</dt>
													<dd>{$jjj.reserve_no}</dd>
												</dl>
												</div>
									{/if}
									{/foreach}

									</td>
									{/section}
									</tr>
									{/foreach}
								{/foreach}
							</table>
						</div>
					</div>
</form>

				</div><!-- / .time-table-box -->
			</div><!-- / .content-inner -->


		</div><!-- / .content -->
		<div id="push"></div>
	</div><!-- / #wrap -->

{include file="calendar_footer.tpl"}


</body>
</html>
