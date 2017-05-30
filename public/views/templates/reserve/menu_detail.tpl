{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

{include file="head_under.tpl"}
<script type="text/javascript">
<!--
{literal}



{/literal}
-->
</script>

<body>
	<div id="wrap">
{include file="header_logo.tpl"}

		<div class="content">
		<h1>メニュー詳細</h1>
		<form action="" method="post">
			<h2>{$arr.course_name}　＞　{$arr.menu_name}</h2>
			<div class="content-inner">

				<table class="table mt10">
					<tr>
						<th>
							{$arr.course_name}料金
						</th>
						<td>
							{$arr.fee|number_format}円
						</td>
					</tr>
					<tr>
						<th>
							料金説明
						</th>
						<td>
							{$arr.fee_comment|nl2br}
						</td>
					</tr>
					<tr>
						<th>
							追記説明
						</th>
						<td>
							{$arr.comment|nl2br}
						</td>
					</tr>

				</table>
				<div class="tc mt35">
					<button onClick="window.close();" class="btn">閉じる</button>
				</div>
			</div>
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastApi.js?pbeldad"></script>
</body>
</html>
