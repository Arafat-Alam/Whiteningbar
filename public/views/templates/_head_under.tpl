<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="/images/favicon.gif" />
<link href="/css/normalize.css" rel="stylesheet" type="text/css" />
<link href="/css/base.css" rel="stylesheet" type="text/css" />
<link href="/css/general.css" rel="stylesheet" type="text/css" />
<!-- date time picker -->
<link href="/css/themes/default.css" rel="stylesheet" type="text/css" />
<link href="/css/themes/default.date.css" rel="stylesheet" id="theme_date">
<link href="/css/themes/default.time.css" rel="stylesheet" id="theme_time">
<!-- style -->
<link href="/css/style.css" rel="stylesheet" type="text/css" />
<link href="/css/font-awesome.min.css" rel="stylesheet">
<!-- 色設定用CSS -->
<link href="/css/{$cssFileName}" rel="stylesheet" type="text/css" />
<!-- スマートフォン -->
<link href="/css/smart.css" rel="stylesheet" type="text/css" />
<!-- JS -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="/js/heightLine.js"></script>
<!--[if lt IE 9]>
<script src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script>
{literal}
$(function() {
	var topBtn = $('#page-top');
	topBtn.hide();
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});
	//スクロールしてトップ
    topBtn.click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 500);
		return false;
    });
});
{/literal}
</script>

</head>
