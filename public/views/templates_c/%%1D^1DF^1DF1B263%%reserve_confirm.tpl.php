<?php /* Smarty version 2.6.26, created on 2015-07-02 14:01:17
         compiled from reserve/reserve_confirm.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

<script src="https://zipaddr.googlecode.com/svn/trunk/zipaddr7.js" charset="UTF-8"></script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head_under.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<!--
<?php echo '



'; ?>

-->
</script>

<body>
	<div id="wrap">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<div class="content">
		<form action="/reserve/member/" method="post">
		<h1>予約</h1>
			<h2>予約内容のご確認</h2>
			<div class="content-inner">
				<p>下記内容で予約をお取りします。</p>
				<table class="table mt10">
					<tr>
						<th>店舗</th>
						<td><?php echo $this->_tpl_vars['reserve_datail']['shop_name']; ?>
</td>
					</tr>
					<tr>
						<th>コース</th>
						<td><?php echo $this->_tpl_vars['reserve_datail']['menu_name']; ?>
</td>
					</tr>
					<tr>
						<th>ご予約人数</th>
						<td><?php echo $this->_tpl_vars['reserve_datail']['number']; ?>
人</td>
					</tr>
					<tr>
						<th>ご予約日時</th>
						<td><?php echo $this->_tpl_vars['reserve_datail']['reserve_date']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['reserve_datail']['start_time']; ?>
&nbsp;～<?php echo $this->_tpl_vars['reserve_datail']['end_time']; ?>
</td>
					</tr>
				</table>
<div class="tc mt35">
				<?php if ($this->_tpl_vars['detail_no']): ?>
					<input type="button" class="btn btn-lg btn-gray" value="予約画面に戻る" onClick="location.href='/reserve/list/?dback=<?php echo $this->_tpl_vars['detail_no']; ?>
'">&nbsp;&nbsp;

				<?php else: ?>
					<input type="button" class="btn btn-lg btn-gray" value="予約画面に戻る" onClick="location.href='/reserve/list/?back=<?php echo $this->_tpl_vars['buy_no']; ?>
'">&nbsp;&nbsp;
				<?php endif; ?>
				<input name="submit" type="submit" class="btn btn-lg" value="登録して予約する"></div>
				<input type="hidden" name="buy_no" value="<?php echo $this->_tpl_vars['buy_no']; ?>
">
				<?php if ($this->_tpl_vars['detail_no']): ?>
				<input type="hidden" name="detail_no[<?php echo $this->_tpl_vars['detail_no']; ?>
]" value="<?php echo $this->_tpl_vars['detail_no']; ?>
">
				<?php endif; ?>
</div>
			</div>
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">var smnAdvertiserId = '00001946';</script><script type="text/javascript" src="//cd-ladsp-com.s3.amazonaws.com/script/pixel.js"></script>
<script type="text/javascript">var smnAdvertiserId = '00002059';</script><script type="text/javascript" src="//cd-ladsp-com.s3.amazonaws.com/script/pixel.js"></script>
<!-- Google Code for &#12522;&#12510;&#12540;&#12465;&#12486;&#12451;&#12531;&#12464;&#12522;&#12473;&#12488; -->
<!-- Remarketing tags may not be associated with personally identifiable information or placed on pages related to sensitive categories. For instructions on adding this tag and more information on the above requirements, read the setup guide: google.com/ads/remarketingsetup -->
<?php echo '
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
'; ?>

<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastOne.js?u=pbeldad&a=spa&url_id=20150625115004&SA"></script>
</body>
</html>