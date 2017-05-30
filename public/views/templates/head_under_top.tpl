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
{literal}
<script>
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
</script>
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
  _fbq.push(['addPixelId', '454242464718061']);
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', 'PixelInitialized', {}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=454242464718061&amp;ev=PixelInitialized" /></noscript>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-43707320-1', 'auto', {'allowLinker': true});
  ga('require', 'linker');
  ga('linker:autoLink', ['whiteningbar.jp','wb-yoyaku.com'] );
  ga('send', 'pageview');
</script>
{/literal}
<script type="text/javascript">
<!--
{literal}

function winopn(no){
	window.open('/reserve/menu_detail/?no='+no, 'mywindow2', 'width=980, height=500, menubar=no, toolbar=no, scrollbars=yes');
}

function getNumberList(){

	if($("input:radio[name='menu_no']:checked").val()){
		menu_no=$("input:radio[name='menu_no']:checked").val();
	}
	else{
		menu_no=0;
	}

	target = $("#number_select");
	//$(".category_m_id").remove();
	$("#number").remove();
	$("#menu_msg").remove();

	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getNumber/",
		cache : false,
		dataType: "json",
		data : {
			shop_no: $("#shop_no").val(),
			menu_no: menu_no
		},
		success: function(data, dataType) {
			target.after(data.html);
			target.after(data.html_str);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});

}

jQuery( function() {
    jQuery( '.content-inner input' ) . change(
        function () {
            jQuery( '.content-inner input[type=radio]' ) . closest( 'label' ) . css( {
                backgroundColor: '#FFF',
            } );
            jQuery( '.content-inner :checked' ) . closest( 'label' ) . css( {
                backgroundColor: '#caecd8',
            } );
        }
    ) . change();


	if($("#shop_no").val()){
		getNumberList();
	}

} );


{/literal}
-->
</script>

</head>
