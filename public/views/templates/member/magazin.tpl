{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />
{include file="head_under.tpl"}

<body>
	<div id="wrap">

{include file="header_magazin.tpl"}

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
		<h1>配信停止</h1>

		<form action="" method="post">
			<h2>配信停止</h2>

			<div class="content-inner">
				<p>
					メルマガの配信を停止します。<br />
					メルマガ配信を停止しますと、WhiteningBARからのお得な情報が届かなくなります。<br /><br />
					停止希望の方は配信停止にチェックして「決定」ボタンを押してください。
				</p>
				<table class="table mt10">
					<tr>
						<th>メルマガ</th>
						<td>
					          <input type="radio" id="" name="email_flg" value="0" {if $input_data.email_flg==0}checked{/if}  />配信停止
					          <input type="radio" id="" name="email_flg" value="1" {if $input_data.email_flg==1}checked{/if}  />配信中
						</td>
					</tr>
				</table>
				<div class="tc mt35"><input name="submit" type="submit" class="btn btn-lg" value="決定" onclick="return confirm('メルマガの配信を停止しますが、良いですか？');" /></div>
			</div>
		</form>

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
