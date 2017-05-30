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
			<h2>予約する</h2>
			<div class="content-inner">
				{if $msg}<span class="txt-red txt-sm">{$msg}</span>{/if}
			</div>
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
			<form action="/reserve/list/" method="post">
				<table class="table-appointment">
					<tr>
						<th>ご購入したコース</th>
						<th>ご利用期限</th>
						<th>残回数</th>
						<th>予約</th>
					</tr>
					{foreach from=$arr item=item}
					<tr>
						<td>{$item.name}</td>
						<td>
						{if $item.fee_flg==1}
							{$item.limit_date|date_format:"%Y/%m/%d"}
						{else}
							-
						{/if}
						</td>
						<td>{$item.zan}/{$item.number}</td>
						<td><input name="reserve[{$item.buy_no}]" type="submit" class="btn btn-sm" value="予約する"></td>
					</tr>
					{foreachelse}
						<td colspan=6><a href="/reserve/list/">予約する</a></td>
					{/foreach}
				</table>
					{if $arr}
						<div class="tc mt20"><a href="/reserve/list/" class="btn btn-lg">新規メニューのご予約</a></div>
					{/if}
				</form>
				<div class="tc mt35"><a href="/member/" class="btn btn-lg">マイページへ</a></div>
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
