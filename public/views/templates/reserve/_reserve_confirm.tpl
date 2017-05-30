{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>

{include file="head_under.tpl"}
<script type="text/javascript">
<!--
{literal}



{/literal}
-->
</script>

<body>
	<div id="wrap">
{include file="header.tpl"}

		<div class="content">
		<form action="/reserve/member/" method="post">
		<h1>予約</h1>
			<h2>予約内容のご確認</h2>
			<div class="content-inner">
				<p>下記内容で予約をお取りします。</p>
				<table class="table mt10">
					<tr>
						<th>店舗</th>
						<td>{$reserve_datail.shop_name}</td>
					</tr>
					<tr>
						<th>コース</th>
						<td>{$reserve_datail.menu_name}</td>
					</tr>
					<tr>
						<th>ご予約人数</th>
						<td>{$reserve_datail.number}人</td>
					</tr>
					<tr>
						<th>ご予約日時</th>
						<td>{$reserve_datail.reserve_date}&nbsp;&nbsp;{$reserve_datail.start_time}&nbsp;～{$reserve_datail.end_time}</td>
					</tr>
				</table>
<div class="tc mt35">
				{if $detail_no}
					<input type="button" class="btn btn-lg btn-gray" value="予約画面に戻る" onClick="location.href='/reserve/list/?dback={$detail_no}'">&nbsp;&nbsp;

				{else}
					<input type="button" class="btn btn-lg btn-gray" value="予約画面に戻る" onClick="location.href='/reserve/list/?back={$buy_no}'">&nbsp;&nbsp;
				{/if}
				<input name="submit" type="submit" class="btn btn-lg" value="登録して予約する"></div>
				<input type="hidden" name="buy_no" value="{$buy_no}">
				{if $detail_no}
				<input type="hidden" name="detail_no[{$detail_no}]" value="{$detail_no}">
				{/if}
</div>
			</div>
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

{include file="footer.tpl"}

</body>
</html>
