{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>

{include file="head_under.tpl"}
<script type="text/javascript">
<!--
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
-->
</script>

<body>
	<div id="wrap">
{include file="header.tpl"}

		<div class="content">
		<h1>会員登録</h1>
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
			</div>

		<form action="/reserve/regist/" method="post">
			<h2>基本情報の登録</h2>
			<div class="content-inner">
				<p>入力項目をご確認のうえ、「登録して予約する」ボタンをクリックしてください。</p>
				<table class="table mt10">
					<tr>
						<th>メールアドレス</th>
						<td>{$input_data.email}</td>
					</tr>
					<tr>
						<th>パスワード</th>
						<td>XXXXXX&nbsp;&nbsp;<span class="txt-sm txt-red">セキュリティ保護のため非表示</span></td>
					</tr>
					<tr>
						<th>お名前</th>
						<td>{$input_data.name}</td>
					</tr>
					<tr>
						<th>ふりがな</th>
						<td>{$input_data.name_kana}</td>
					</tr>
					<tr>
						<th>電話番号</th>
						<td>{$input_data.tel}</td>
					</tr>
					<tr>
						<th>住所</th>
						<td>
							<span class="address">郵便番号</span>{$input_data.zip}<br>
							<span class="address">都道府県</span>{$input_data.pref_str}<br>
							<span class="address">市区町村・番地</span>{$input_data.address1}<br>
							<span class="address">建物名</span>{$input_data.address2}
						</td>
					</tr>
					<tr>
						<th>性別</th>
						<td>{if $input_data.sex==1}男性{elseif $input_data.sex==2}女性{/if}</td>
					</tr>
					<tr>
						<th>生年月日</th>
						<td>
							{$input_data.year}年{$input_data.month}月{$input_data.day}日
						</td>
					</tr>
			        <tr>
			          <th>ご紹介者</th>
			          <td>
			          {$input_data.intro}
			          </td>
			        </tr>
					<tr>
						<th>備考</th>
						<td>{$input_data.comment|nl2br}</td>
					</tr>
				</table>
				<div class="tc mt35">
				<input type="button" class="btn btn-lg btn-gray" value="予約画面に戻る" onClick="location.href='/reserve/list/?back'">&nbsp;&nbsp;
				<input name="back" type="submit" class="btn btn-lg btn-gray" value="登録フォームに戻る" >&nbsp;&nbsp;
				<input name="submit" type="submit" class="btn btn-lg" value="登録して予約する"></div>
				<input type="hidden" name="shop_no" value="{$reserve_datail.shop_no}">
			</div>
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

{include file="footer.tpl"}
<script type="text/javascript">var smnAdvertiserId = '00001946';</script><script type="text/javascript" src="//cd-ladsp-com.s3.amazonaws.com/script/pixel.js"></script>
<script type="text/javascript">var smnAdvertiserId = '00002059';</script><script type="text/javascript" src="//cd-ladsp-com.s3.amazonaws.com/script/pixel.js"></script>
<!-- Google Code for &#12522;&#12510;&#12540;&#12465;&#12486;&#12451;&#12531;&#12464;&#12522;&#12473;&#12488; -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
{literal}
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 988498814;
var google_conversion_label = "pdbTCJKn5AgQ_pat1wM";
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/988498814/?value=0&amp;label=pdbTCJKn5AgQ_pat1wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
{/literal}
<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastOne.js?u=pbeldad&a=spa&url_id=20150625115004&SA"></script>



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
