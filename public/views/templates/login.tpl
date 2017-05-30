{include file="head.tpl"}
<title> ｜{$smarty.const.SITE_TITLE}</title>
<meta name="keywords" content="dummy" />
<meta name="description" content="dummy" />

</head>

<body>
{include file="header.tpl"}
<div id="ctn-content">
<div id="ctn-content-inner">


<div class="box-heading-top">
	<h1 class="hdg-lv1-01">ログイン</h1>
<!-- /box-heading-top --></div>

<dl class="box-login">
	<dt><img src="/common/images/btn_aside02_01.gif" width="233" height="32" alt="会員ログイン" /></dt>
	<dd>
  	<form action="#" method="post">
			<p>メールアドレス</p>
			<p class="input-text"><input type="text" name="email" value="{$input_data.email}" /></p>
			<p>パスワード</p>
			<p class="input-text"><input type="password" name="password" /></p>
			{if $msg}<p class="invalid-message">{$msg}</p>{/if}
			<p class="input-button"><input src="/common/images/btn_aside02_02.png" type="image" name="btn-confirm" alt="会員ログイン" class="btn-op" /></p>
			<p class="link-detail"><a href="/member/password/">パスワードを忘れた方はこちら</a></p>

    <div class="blk-fb-01">
			<p class="link-fb-01">Facebookアカウントを利用してログイン</p>
      <p><input type="image"  src="/common/images/btn_fb_01.png" width="213" height="40" name="facebook" alt="Facebookでログイン" /></p>
		<!-- /blk-fb-01 --></div>

	</form>

	</dd>
</dl>

<!-- /ctn-content-inner --></div>
<!-- /ctn-content --></div>

{include file="footer.tpl"}
