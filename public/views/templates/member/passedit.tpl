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
		<h1>{$login_member.name}&nbsp;様&nbsp;パスワード変更</h1>

		<form action="" method="post">
			<h2>パスワード変更</h2>

		{if $result_messages}
			{foreach from=$result_messages item=item}
				<span class="txt-red txt-sm">{$item}</span><br />
			{/foreach}
		{/if}
			<div class="content-inner">
				<p>新しいパスワードを入力して「変更」ボタンをクリックしてください。</p>
				<table class="table mt10">
					<tr>
						<th>旧パスワード&nbsp;<span class="label">必須</span></th>
						<td>
							 {if $result_messages.old_password}
								<span class="txt-red txt-sm">{$result_messages.old_password}</span><br />
							{/if}
					          <input type="password" id="" name="old_password" value="{$inp.old_password}"  />
					          <br><span class="txt-sm">半角英数字6文字以上</span><br>
						</td>
					</tr>
					<tr>
						<th>新パスワード&nbsp;<span class="label">必須</span></th>
						<td>
							 {if $result_messages.password}
								<span class="txt-red txt-sm">{$result_messages.password}</span><br />
							{/if}
					          <input type="password" id="" name="password" value="{$inp.password}"  />
					          <br><span class="txt-sm">半角英数字6文字以上</span><br>
								<input type="password" name="password2" class="mt5">
							  <br><span class="txt-sm">確認のため、もう一度入力してください。</span></td>
					</tr>
				</table>
				<div class="tc mt35"><input name="pass_submit" type="submit" class="btn btn-lg" value="変更"></div>
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
