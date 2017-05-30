<?php /* Smarty version 2.6.26, created on 2017-05-05 15:37:02
         compiled from report/menuTrend.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'report/menuTrend.tpl', 47, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='menuTrend';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#f_year").val("");
	$("#f_month").val("");
	$("#t_year").val("");
	$("#t_month").val("");
	$("input#mon1").attr(\'checked\',false);
	$("input#mon2").attr(\'checked\',false);
	$("input#mon3").attr(\'checked\',false);


}

$(function(){


});


'; ?>

</script>
<body>
<div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="main_content">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "report/menu_report.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>売上レポート</h3>
<h4>月次売上</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上月</th>
				<td>
		          	<?php echo smarty_function_html_options(array('name' => 'f_year','options' => $this->_tpl_vars['yearArr'],'selected' => $this->_tpl_vars['search']['f_year'],'id' => 'f_year'), $this);?>

		            年
		            <?php echo smarty_function_html_options(array('name' => 'f_month','options' => $this->_tpl_vars['monthArr'],'selected' => $this->_tpl_vars['search']['f_month'],'id' => 'f_month'), $this);?>

		            月
		            ～
		          	<?php echo smarty_function_html_options(array('name' => 't_year','options' => $this->_tpl_vars['yearArr'],'selected' => $this->_tpl_vars['search']['t_year'],'id' => 't_year'), $this);?>

		            年
		            <?php echo smarty_function_html_options(array('name' => 't_month','options' => $this->_tpl_vars['monthArr'],'selected' => $this->_tpl_vars['search']['t_month'],'id' => 't_month'), $this);?>

		            月

				</td>
			</tr>
			<?php if ($this->_tpl_vars['login_admin']['shop_no'] == 0): ?>
			<tr>
				<th>ストアを選択</th>
				<td> 
					<select name="shop_no">
						<option value="0">すべての店</option>
						<?php 
							$shopArr = $this->get_template_vars('shopArr');
							$shop_no = $this->get_template_vars('shop_no');
							foreach($shopArr as $key => $value){
							
						 ?>
							<option value="<?php echo $value['shop_no']; ?>" <?php if($shop_no==$value['shop_no'])echo "selected" ?>><?php echo $value['name']; ?></option>
						<?php 
							}
						 ?>
					</select>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td colspan="2" align="center">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>

				</td>
			</tr>
		</table>

		
		</form>
	</div>
<hr>

		<!--
			<div class="paging">
				<div class="left"><strong><?php echo $this->_tpl_vars['total_cnt']; ?>
</strong>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
			</div>
			<br/>
-->			<?php if ($this->_tpl_vars['error'] == ''): ?>
			<span>
			<?php if ($this->_tpl_vars['search']['f_year'] != ''): ?>データの表示 <strong> <?php echo $this->_tpl_vars['search']['f_year']; ?>
 - <?php echo $this->_tpl_vars['search']['f_month']; ?>
 </strong> に <strong> <?php echo $this->_tpl_vars['search']['t_year']; ?>
 - <?php echo $this->_tpl_vars['search']['t_month']; ?>
 </strong>
			<?php else: ?>すべての時間のデータを表示する<?php endif; ?></span>
			<?php else: ?>
			<span style="color: red;"><h4><?php echo $this->_tpl_vars['error']; ?>
</h4></span>
			<?php endif; ?>

			<div id="bar-chart"></div>
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
<?php 
$arr = $this->get_template_vars('arr');
$this->assign('arrs', json_encode($arr));
 ?>
<script type="text/javascript">
	<?php echo '

		function abbreviateNumbers(arr) {
            var newArr = [];
            $.each(arr, function (index, value) {
                var newValue = value;
                // if (value >= 1000) {
                //     var suffixes = [" ", " K", " mil", " bil", " t"];
                //     var suffixNum = Math.floor(("" + value).length / 3);
                //     var shortValue = \'\';
                //     for (var precision = 2; precision >= 1; precision--) {
                //         shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000, suffixNum) ) : value).toPrecision(precision));
                //         var dotLessShortValue = (shortValue + \'\').replace(/[^a-zA-Z 0-9]+/g, \'\');
                //         if (dotLessShortValue.length <= 2) {
                //             break;
                //         }
                //     }
                //     if (shortValue % 1 != 0)  shortNum = shortValue.toFixed(1);
                //     newValue = value ;
                // }
                newArr[index] = newValue;
            });
            return newArr;
        }


		
        var data = \''; ?>
<?php echo $this->_tpl_vars['arrs']; ?>
<?php echo '\';
        var arr = jQuery.parseJSON(data);
        var shop = new Array();
        var value = new Array();
        var shopName = new Object;
        var i  ;
        var rv = {};
        
        $.each(arr, function(key,val){
        	shop.push(key);
        	value.push(val);

        });
        for (var i = 0; i < shop.length; i++) {
        	shopName[i] = shop[i];
        	rv[i] = value[i];
        }

        var title = "メニュー販売";
        var labels = shopName;
        // var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];

        // var values=[278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, 454, 125, 456, 235, 123, 278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, 454, 125, 456, 235, 123, 278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, 454, 125, 456, 235, 123, 278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, \'111\'];
         // var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];

        var values = rv;
        var outputValues = abbreviateNumbers(values);


        $(\'#bar-chart\').simpleChart({
            title: {
                text: title,
                align: \'center\'
            },
            type: \'bar\',
            layout: {
                width: \'100%\'
            },
            item: {
                label: labels,
                value: outputValues,
                outputValue: outputValues,
                color: [\'#4CAF50\'],
                prefix: \'\',
                suffix: \'\',
                render: {
                    margin: 0,
                    size: \'relative\'
                }
            }
        });
'; ?>

</script>
