{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />
{include file="head_under.tpl"}
<body>

<!--CC追記-->



	<div id="wrap">
{include file="header.tpl"}

		<div class="content">
		<h1>予約をする</h1>
	 		{if $result_messages}
				<span class="txt-red txt-sm">{$result_messages}</span><br />
			{/if}

			<div class="box-half clearfix fl heightLine-group1">
			<form action="" method="post">
				<div class="box-inner">
					<h2>登録済みの方</h2>
					<p>ログインID(メールアドレス)とパスワードを入力してください。</p>
					<p class="txt-sm">パスワードをお忘れの方は<a href="/member/password/"><span class="txt-red">こちらをクリックしてください</span></a></p>
					<dl class="mt20">
						<dt>ログインID(メールアドレス)</dt>
						<dd><input name="email" type="email" class="w100" value="{$input_data.email}"></dd>
						<dt>パスワード</dt>
						<dd><input name="password" type="password" class="w100" value="{$input_data.password}"></dd>
					</dl>
					<input type="submit" name="submit" class="btn w100 mt20 btn-lg" value="ログイン">
				</div>
			</form>
			</div>

			<div class="box-half clearfix fr heightLine-group1">
			<form action="/reserve/list/" method="post">
				<div class="box-inner">
				<h2>初めての方</h2>
					<p>お客様情報を登録して予約します。<br>次回からはログインID(メールアドレス)とパスワードの入力だけで予約が可能です。</p>
					<input type="submit" class="btn w100 mt50 btn-lg" value="予約する">
				</div>
			</form>
			</div>

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
<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastApi.js?pbeldad"></script>

<!--CC追記-->
<script type="text/javascript" charset="utf-8" src="//op.searchteria.co.jp/ads/onetag.ad?onetag_id=752"></script>



</body>
</html>


