{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>

{include file="head_under.tpl"}


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


<body>
	<div id="wrap">
{include file="header.tpl"}

		<div class="content">
		<h1>会員登録</h1>
		<form action="/reserve/regist/" method="post">
			<h2>基本情報の登録</h2>
			<div class="content-inner">

		{if $result_messages}
			<div class="box-warning">
			{foreach from=$result_messages item=item}
				<p class="txt-sm"><i class="fa fa-warning fa-lg"></i>&nbsp;{$item}</p>
			{/foreach}
			</div>
		{/if}

				<p>下記項目に入力後、「次へ」ボタンをクリックしてください。</p>
				<table class="table mt10">
					<tr>
						<th>メールアドレス&nbsp;<span class="label">必須</span></th>
						<td>
						 		{if $result_messages.email}
									<span class="txt-red txt-sm">{$result_messages.email}</span><br />
								{/if}

							<input type="text" name="email" value="{$input_data.email}" class="form-lg">
						</td>


					</tr>
					<tr>
						<th>パスワード&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.password}
								<span class="txt-red txt-sm">{$result_messages.password}</span><br />
							{/if}
				          <input type="password" name="password" value="{$input_data.password}"  />
				          <br><span class="txt-sm">半角英数字6文字以上</span>
						</td>
					</tr>
					<tr>
						<th>確認パスワード&nbsp;<span class="label">必須</span></th>
						<td>
					 		{if $result_messages.password}
								<span class="txt-red txt-sm">{$result_messages.password}</span><br />
							{/if}
				          <input type="password" name="password2" value="{$input_data.password2}"  />
						</td>
					</tr>
					<tr>
						<th>お名前&nbsp;
							{if $memarr.0.req_flg==1}
								<span class="label">必須</span>
							{/if}
						</th>
						<td>

					 		{if $result_messages.name}
								<span class="txt-red txt-sm">{$result_messages.name}</span><br />
							{/if}
				          <input type="text" name="name" value="{$input_data.name}"  />
				        </td>
					</tr>
					<tr>
						<th>ふりがな&nbsp;
							{if $memarr.1.req_flg==1}
								<span class="label">必須</span>
							{/if}
						</th>
				          <td>
					 		{if $result_messages.name_kana}
								<span class="txt-red txt-sm">{$result_messages.name_kana}</span><br />
							{/if}
				          <input type="text" name="name_kana" value="{$input_data.name_kana}"  /></td>
					</tr>
					<tr>
						<th>電話番号&nbsp;
							{if $memarr.2.req_flg==1}
								<span class="label">必須</span>
							{/if}
						</th>
				          <td>
					 		{if $result_messages.tel}
								<span class="txt-red txt-sm">{$result_messages.tel}</span><br />
							{/if}

				          <input type="text" name="tel" value="{$input_data.tel}" /></td>
					</tr>

			        <tr>
			          <th>郵便番号&nbsp;
							{if $memarr.3.req_flg==1}
								<span class="label">必須</span>
							{/if}

			          </th>
			          <td>
				 		{if $result_messages.zip}
							<span class="txt-red txt-sm">{$result_messages.zip}</span><br />
						{/if}
			          <input type="text" id="zip" name="zip" value="{$input_data.zip}"  />
			          <br />【住所自動入力】<br />
			          郵便番号を入力すると、住所の一部が自動入力されます。<br />ハイフン有無、半角・全角、どれでも入力可能です。
			          <br />入力履歴では自動入力が出来ませんのでご注意ください。

			        </td>
			        </tr>
			        <tr>
			          <th>都道府県&nbsp;
							{if $memarr.4.req_flg==1}
								<span class="label">必須</span>
							{/if}

			          </th>
			          <td>
				 		{if $result_messages.pref}
							<span class="txt-red txt-sm">{$result_messages.pref}</span><br />
						{/if}

						{html_options name=pref options=$prefArr selected=$input_data.pref id="pref" }
					</td>
			        </tr>
			        <tr>
			          <th>市区町村・番地&nbsp;
							{if $memarr.5.req_flg==1}
								<span class="label">必須</span>
							{/if}

			          </th>
			          <td>
				 		{if $result_messages.address1}
							<span class="txt-red txt-sm">{$result_messages.address1}</span><br />
						{/if}

			          <input type="text" id="city" name="address1" value="{$input_data.address1}"  /></td>
			        </tr>
			        <tr>
			          <th>建物名
							{if $memarr.6.req_flg==1}
								<span class="label">必須</span>
							{/if}

			          </th>
			          <td>
			          <input type="text" name="address2" value="{$input_data.address2}"  /></td>
			        </tr>

					<tr>
						<th>性別&nbsp;
							{if $memarr.7.req_flg==1}
								<span class="label">必須</span>
							{/if}

						</th>
			          <td>
				 		{if $result_messages.sex}
							<span class="txt-red txt-sm">{$result_messages.sex}</span><br />
						{/if}
							<input type="radio"  name="sex" value="1" {if $input_data.sex==1}checked{/if} />男性
							<input type="radio"  name="sex" value="2" {if $input_data.sex==2}checked{/if} />女性
						</td>
					</tr>
					<tr>
						<th>生年月日&nbsp;
							{if $memarr.8.req_flg==1}
								<span class="label">必須</span>
							{/if}
						</th>
				          <td>

				          	{html_options name="year" options=$yearArr selected=$input_data.year class="form-sm"}
				            年
				            {html_options name="month" options=$monthArr selected=$input_data.month class="form-sm"}
				            月
				            {html_options name="day" options=$dayArr selected=$input_data.day class="form-sm"}
				            日
				            </td>
					</tr>
			        <tr>
			          <th>ご紹介者</th>
			          <td>
			          <input type="text" name="intro" value="{$input_data.intro}"  />
			          <br />ご紹介者がいる場合には必ず記載してください。
			          </td>
			        </tr>
					<tr>
						<th>備考</th>
						<td><textarea name="comment" rows="" cols="">{$input_data.comment}</textarea></td>
					</tr>
				</table>
				<div class="tc mt35">
					<input type="button" class="btn btn-lg btn-gray" value="予約画面に戻る" onClick="location.href='/reserve/list/?back'">&nbsp;&nbsp;
					<input name="confirm" type="submit" class="btn btn-lg" value="確認へ">
					<input type="hidden" name="shop_no" value="{$reserve_datail.shop_no}">
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
<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastOne.js?u=pbeldad&a=spa&url_id=20150625114614&SA"></script>



<!--CC追記-->

<script type="text/javascript" charset="utf-8" src="//op.searchteria.co.jp/ads/onetag.ad?onetag_id=751"></script>
<script type="text/javascript" charset="utf-8" src="//adn-j.sp.gmossp-sp.jp/js/rt.js?rtid=34e1fe5062425d3f0a549a6bca4b9970" ></script>
<script type="text/javascript" charset="utf-8" src="//op.searchteria.co.jp/ads/onetag.ad?onetag_id=752"></script>

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
