<?php /* Smarty version 2.6.26, created on 2017-03-14 00:40:44
         compiled from reserve/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'reserve/index.tpl', 44, false),array('modifier', 'date_format', 'reserve/index.tpl', 81, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head_under_top.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


<?php echo '

<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-TNFNQV"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
\'//www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,\'script\',\'dataLayer\',\'GTM-TNFNQV\');</script>
<!-- End Google Tag Manager -->

'; ?>




<body>
	<div id="wrap">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


		<div class="content">
		<h1>予約をする</h1>
		<?php if ($this->_tpl_vars['result_messages']): ?>
        	<div class="box-warning">
                <?php $_from = $this->_tpl_vars['result_messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                    <p class="txt-sm"><i class="fa fa-warning fa-lg"></i>&nbsp;<?php echo $this->_tpl_vars['item']; ?>
</p>
                <?php endforeach; endif; unset($_from); ?>
            </div>
		<?php endif; ?>

			<h2 class="step"><span>STEP1</span>店舗を選択</h2>
		<form action="/reserve/list/#choice" method="post">
			<div class="content-inner">

			<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['search']['shop_no'],'id' => 'shop_no','onChange' => "getNumberList();"), $this);?>


				<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['shop_no']; ?>
</p>
			</div>
			<h2 class="step"><span>STEP2</span>予約メニューの選択</h2>
			<div class="content-inner show-scroll">
				<ul class="select-course">
					<?php $_from = $this->_tpl_vars['menuArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<li><label><input type="radio" name="menu_no" value="<?php echo $this->_tpl_vars['item']['menu_no']; ?>
" <?php if ($this->_tpl_vars['search']['menu_no'] == $this->_tpl_vars['item']['menu_no']): ?>checked<?php endif; ?> onClick="getNumberList();"><?php echo $this->_tpl_vars['item']['name']; ?>
</label>
						<a href="javascript:void(0);" onClick="winopn('<?php echo $this->_tpl_vars['item']['menu_no']; ?>
')" class="btn btn-sm">詳細</a></li>
					<?php endforeach; endif; unset($_from); ?>

				</ul>
				<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['menu_no']; ?>
</p>

			</div>
			<!-- コース回数が1回の場合のみ、人数の選択が可能となる。複数回数コースの場合は一人予約のみ -->
			<h2 class="step"><span>STEP3</span>ご予約人数を選択</h2>
			<div class="content-inner">
			ご予約する店舗、予約メニューにより、ご予約可能な人数が変わります。
			<div id=number_select></div><!-- 人数プルダウンの表示　各店舗のブース数　 -->

				<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['number']; ?>
</p>
			</div>
<a name=choice></a>
			<h2 class="step"><span>STEP4</span>日時を選択</h2>
			<div class="content-inner tc">

							<?php if ($this->_tpl_vars['result_messages']['shop_no'] || $this->_tpl_vars['result_messages']['menu_no'] || $this->_tpl_vars['result_messages']['number']): ?>
								<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['shop_no']; ?>
</p>
								<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['menu_no']; ?>
</p>
								<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['number']; ?>
</p>
							<?php elseif ($this->_tpl_vars['result_messages']['reserve_date'] || $this->_tpl_vars['result_messages']['reserve_time']): ?>
								<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['reserve_date']; ?>
</p>
								<p class="txt-red mt5"><?php echo $this->_tpl_vars['result_messages']['reserve_time']; ?>
</p>
							<?php endif; ?>

				<input name="reserve_date" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['reserve_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" class="fieldset__input js__datepicker datepicker" type="text" placeholder="クリックして日付を選択">
				<input name="reserve_time" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['reserve_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%H:%M') : smarty_modifier_date_format($_tmp, '%H:%M')); ?>
"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択"><br>
				<input name="submit" type="submit" value="この日時で予約" class="btn btn-lg mt20">
				<input name="buy_no" type="hidden" value="<?php echo $this->_tpl_vars['buy_no']; ?>
">
				<?php if ($this->_tpl_vars['detail_no'] > 0): ?>
				<input type="hidden" name="detail_no[<?php echo $this->_tpl_vars['detail_no']; ?>
]" value="<?php echo $this->_tpl_vars['detail_no']; ?>
">
				<?php endif; ?>

		</form>
					<?php if ($this->_tpl_vars['zanArr']): ?>
                    	<div class="box-warning mt20">
							<p><i class="fa fa-warning"></i>&nbsp;ご希望の日時のご予約が出来ませんでした。<br />もう一度、日時を選択して頂くか、以下のご希望に近いご予約可能な日時からお選びください。</p>
                        </div>
					<?php endif; ?>
					<table class="table-schedule">
					<tr>
					<?php if ($this->_tpl_vars['zanArr']): ?>
						<th colspan="2">
							<?php if ($this->_tpl_vars['zanArr']): ?><?php echo $this->_tpl_vars['search']['reserve_date']; ?>
<?php if ($this->_tpl_vars['weejjp']): ?><?php echo $this->_tpl_vars['weekjp']; ?>
）<?php endif; ?><?php endif; ?>
						</th>
					<?php endif; ?>
					</tr>
					<?php $_from = $this->_tpl_vars['zanArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<form action="/reserve/regist/" method="post">
						<tr>
							<td>
							<?php if ($this->_tpl_vars['item']['detail'] == ""): ?>
								×
							<?php else: ?>
								◎
							<?php endif; ?>
								<?php echo $this->_tpl_vars['item']['start_time']; ?>
～</td>
							<td>
								<?php if ($this->_tpl_vars['item']['detail'] != ""): ?>
									<input name="" type="submit" value="予約する" class="btn">
									<input type="hidden" name="reserve_detail" value="<?php echo $this->_tpl_vars['item']['detail']; ?>
">
									<input type="hidden" name="buy_no" value="<?php echo $this->_tpl_vars['buy_no']; ?>
">
									<?php if ($this->_tpl_vars['detail_no'] > 0): ?>
									<input type="hidden" name="detail_no[<?php echo $this->_tpl_vars['detail_no']; ?>
]" value="<?php echo $this->_tpl_vars['detail_no']; ?>
">
									<?php endif; ?>

								<?php endif; ?>
							</td>
						</tr>
						</form>
					<?php endforeach; endif; unset($_from); ?>
				</table>
			</div>

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

	<!-- date time picker -->
	<script src="/js/legacy.js"></script>
	<script src="/js/picker.js"></script>
	<script src="/js/picker.date.js"></script>
	<script src="/js/picker.time.js"></script>
	<script src="/js/ja_JP.js"></script>
	<script>
	<?php echo '
		$(\'.datepicker\').pickadate({
			format: \'yyyy/mm/dd\'
		})
		$(\'.timepicker\').pickatime({
			　clear: \'消去\',
			 format: \'H:i\',
			 interval: 15,
			 min: [10,0],
   		 max: [21,15]
		})
		'; ?>

	</script>



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



<script>
  (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');

ga(\'create\', \'UA-43707320-1\', \'auto\');
ga(\'send\', \'pageview\');
ga(\'linker:autoLink\', [\'whiteningbar.jp\', \'wb-yoyaku.com\'] );
</script>



<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/988498814/?value=0&amp;label=pdbTCJKn5AgQ_pat1wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
'; ?>

<script type="text/javascript" charset="UTF-8" src="//navicast.jp/NavicastApi.js?pbeldad"></script>


<!--CC追記-->
<script type="text/javascript" charset="utf-8" src="//op.searchteria.co.jp/ads/onetag.ad?onetag_id=751"></script>
<script type="text/javascript" charset="utf-8" src="//adn-j.sp.gmossp-sp.jp/js/rt.js?rtid=34e1fe5062425d3f0a549a6bca4b9970" ></script>
<script type="text/javascript" charset="utf-8" src="//op.searchteria.co.jp/ads/onetag.ad?onetag_id=752"></script>

<?php echo '

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

'; ?>


</body>
</html>