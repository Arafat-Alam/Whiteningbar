{php}
session_start();
$_SESSION['page']='top';
{/php}

{include file="head.tpl"}
<!-- <script type="text/javascript">
{literal}
function winopn(){

	// sW = window.parent.screen.width;
	// sH = window.parent.screen.height;

	window.location='/calendar/list';
}

{/literal}
</script> -->
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
		<!-- tabs -->
		<!-- <ul class="tab clearfix mt20" >
			<li>
				<a href="javascript:void(0);" onClick="winopn();" class="btn btn-lg"><i class="fa fa-calendar"></i>&nbsp;予約管理カレンダーを開く</a>
			</li>
		</ul>
		<div class="clear"> </div> -->
		<!-- tabs close-->


		<h3>トップページ</h3>

		<!-- <h5 class="tc">
		<a href="javascript:void(0);" onClick="winopn();" class="btn btn-xlg"><i class="fa fa-calendar fa-lg"></i>&nbsp;予約管理カレンダーを開く</a>
		</h5> -->


		<div class="clearfix w80 center">
			<div class="left w50">
				<h4>日の予約数</h4>

				<table class="center">
					<tr><th>店舗名</th><th>昨日</th><th>本日</th><th>明日</th></tr>
					{foreach from=$dayArr item=arr}
					<tr>
						<td>{$arr.name}</td>

						{foreach from=$arr.count name=aaa item=item}

							{if $smarty.foreach.aaa.index==1}
								<td class="tc today"><!-- 本日以外はtodayを外す-->
							{else}
								<td class="tc"><!-- 本日以外はtodayを外す-->
							{/if}
								{$item}
							</td>
						{/foreach}
					</tr>

					{/foreach}
				</table>
			</div>
			{* get value by php *}
			{php}
				//$band = $this->get_template_vars('monArr'); 
				//print_r($band);	exit;

			{/php}
			<div class="right ml30 w50">
				<h4>月の予約数</h4>
				<table class="center">
					<tr><th>店舗名</th><th>先月</th><th>今月</th><th>来月</th></tr>
					{foreach from=$monArr item=arr}
					<tr>
						<td>{$arr.name}</td>

						{foreach from=$arr.count name=aaa item=item}
							{if $smarty.foreach.aaa.index==1}
								<td class="tc thismonth"><!-- 今月以外はthismonthを外す-->
							{else}
								<td class="tc">
							{/if} 
							{$item}	
						</td>

						{/foreach}
					</tr>

					{/foreach}
				</table>
			</div>
		</div>
		{if $shopNo == 0}
		<div class="clearfix w50 left" style="border-right: solid 1px gray;">
			<div class="left w100" align="">

			<div align="center">
			<br>
			<input type="radio" id="yesterday" name="day" onclick="dayChartData('yesterday')"><label for="yesterday">昨日</label>&nbsp;&nbsp;
			<input type="radio" id="today" name="day" onclick="dayChartData('today')" checked><label for="today">本日</label>&nbsp;&nbsp;
			<input type="radio" id="tomorrow" name="day" onclick="dayChartData('tomorrow')"><label for="tomorrow">明日</label>&nbsp;&nbsp;
			</div>

				<div class="bar-chart-day"></div>
			</div>
		</div>
		<div class="clearfix w50 left">
			<div class="left w100">
			<div align="center">
			<br>
			<input type="radio" id="lastMonth" name="month" onclick="monthChartData('lastMonth')"><label for="lastMonth">先月</label>&nbsp;&nbsp;
			<input type="radio" id="thismonth" name="month" onclick="monthChartData('thismonth')" checked><label for="thismonth">今月</label>&nbsp;&nbsp;
			<input type="radio" id="nextMonth" name="month" onclick="monthChartData('nextMonth')"><label for="nextMonth">来月</label>&nbsp;&nbsp;
			</div>

				<div class="bar-chart-month"></div>
			</div>
		</div>
			<hr>
			{/if}

		<div class="w90 center" >
			<h4 class="clear mt30">お知らせ</h4>
			<ul class="news" style="height: 500px; overflow-y: scroll;">
			{foreach from=$newsArr item=item}
				<li>
				<h5><span>{$item.news_date}</span>{$item.title}</h5>
				
				{if $item.img_name != ''}
				{php}

					$file = $this->get_template_vars('item');

					$fileType = mime_content_type("../../public/htdocs/user_data/img_news/".$file['img_name']);

					if($fileType == 'image/png' || $fileType == 'image/bmp' || $fileType == 'image/gif' || $fileType == 'image/jpeg' || $fileType == 'image/pjpeg'){
						{/php}
						<h5>Attached Image / 添付画像</h5>
						<img src="../../public/htdocs/user_data/img_news/{$item.img_name}" height="150px" width="150px">
						<a target="_blank" download href="../../public/htdocs/user_data/img_news/{$item.img_name}">Download</a>
						{php}
					}else{
						{/php}
						<h5>Attached File / 添付ファイル</h5>
						<span>{$item.img_name}</span> &nbsp;<a target="_blank" href="../../public/htdocs/user_data/img_news/{$item.img_name}">Download</a>
						{php}
					}
				{/php}
				{/if}
				<span></span>
				<p class="mt10">{$item.detail|nl2br}</p>
				</li>

			{/foreach}
			</ul>
		</div>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
