{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />
{include file="head_under.tpl"}

<body>
	<div id="wrap">

{include file="header.tpl"}

{literal}

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TNFNQV"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TNFNQV');</script>
<!-- End Google Tag Manager -->

{/literal}



		<div class="content">
		<h1>{$login_member.name}&nbsp;様&nbsp;予約状況</h1>
			<h2>予約の確認</h2>

			{if $msg}
			<div class="content-inner">
				<span class="txt-red txt-sm">{$msg}</span>
			</div>
			{/if}
			{if $errmsg}
				<div class="box-warning">
					<p class="txt-sm"><i class="fa fa-warning fa-lg"></i>&nbsp;{$errmsg}</p>
				</div>
			{/if}

<!--
			<div class="content-inner">
				<select name="">
					<option>選択してください</option>
					<option value="渋谷店" selected>渋谷店</option>
					<option value="自由が丘店">自由が丘店</option>
				</select>
				<input type="button" class="btn btn-search" value="表示する"><br>
				<p class="txt-sm">※選択した店舗のサイトへ移動します。</p>
			</div>
  -->
			<div class="content-inner mt50">
				<div class="table-scroll">
				<table class="table-appointment">
					<tr>
						<th>予約番号</th>
						<th>予約店舗</th>
						<th>予約日時</th>
						<th>回数</th>
						<th>コース名<br />(メニュー)</th>
						<th>コース<br />ご利用期限</th>
						<th>予約変更</th>
						<th>キャンセル</th>
					</tr>
					{foreach from=$arr item=item}
					<tr>
						<td>{$item.reserve_no}</td>
						<td><nobr>{$item.shop_name}</nobr></td>
						<td><span class="nowrap">{$item.reserve_date|date_format:"%Y/%m/%d"}({$item.youbi})</span></br>{$item.start_time|date_format:"%H:%M"}～{$item.end_time|date_format:"%H:%M"}</td>
						<td><nobr>{$item.zan}回目</nobr></td>
						<td>{$item.course_name}<br />({$item.menu_name})</td>
						<td>
							{if $item.limit_date=="0000-00-00"}
								-<!-- 料金未払いの為、まだ使用期限が決定していない -->
							{else}
								{$item.limit_date|date_format:"%Y/%m/%d"}
							{/if}
								</td>
						<td>
							<form action="/reserve/list/" method="post">
								<input type="submit" name="detail_no[{$item.no}]" class="btn btn-sm" value="変更する" >
							</form>
						</td>
						<td>
							<form action="/member/list/" method="post">
								<input type="submit" name="cancel[{$item.no}]" class="btn btn-sm" value="キャンセル" onClick="return confirm('予約をキャンセルします。本当に良いですか？');">
							</form>
						</td>
					</tr>
					{foreachelse}
					<tr>
						<td colspan="8">現在、ご予約中のものはございません</td>
					</tr>
					{/foreach}
				</table>
				</div>

				<div class="mt20 box-warning">※ご予約時間より10分を過ぎますとキャンセルとさせていただきます。<br >
				※ご予約1時間前の予約時間の変更、キャンセルは出来ません。<br class="sp">
				<span class="sp mt10">※予約をキャンセルしたい場合は予約詳細部分をスワイプして一番右の「キャンセル」ボタンをタップしてください。</span></div>
				<div class="tc mt35"><a href="/" class="btn btn-lg">マイページへ</a></div>
			</div>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

{include file="footer.tpl"}
<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastApi.js?pbeldad"></script>

{literal}

<script type="text/javascript">
  (function () {
    var tagjs = document.createElement("script");
    var s = document.getElementsByTagName("script")[0];
    tagjs.async = true;
    tagjs.src = "//s.yjtag.jp/tag.js#site=07eYmz4";
    s.parentNode.insertBefore(tagjs, s);
  }());
</script>

<noscript>
<iframe src="//b.yjtag.jp/iframe?c=07eYmz4" width="1" height="1" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</noscript>

{/literal}
</body>
</html>
