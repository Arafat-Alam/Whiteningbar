<?php /* Smarty version 2.6.26, created on 2017-05-18 13:24:32
         compiled from report/graph.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'report/graph.tpl', 63, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='graph';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#start").val("");
	$("#end").val("");


}

$(function(){

	$("#start").datepicker({
		dateFormat: "yy-mm-dd"
	});


	$("#end").datepicker({
		dateFormat: "yy-mm-dd"
	});


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
<h4>年間売上グラフ</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上日</th>
				<td>
					<select name="year">
						
						<?php $_from = $this->_tpl_vars['yearArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['value']):
?>
							<option value="<?php echo $this->_tpl_vars['value']; ?>
" <?php if ($this->_tpl_vars['year'] == $this->_tpl_vars['value']): ?><?php echo 'selected'; ?>
<?php endif; ?>><?php echo $this->_tpl_vars['value']; ?>
</option>
						<?php endforeach; endif; unset($_from); ?>
											
					</select>
				</td>
                <?php if ($this->_tpl_vars['login_admin']['shop_no'] == 0): ?>
                <th>店舗名</th>
                <td>
                    <?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['shop_no'],'id' => 'shop_no'), $this);?>

                </td>
                <?php endif; ?>
			</tr>
		</table>

		<div class="mt10 tc">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>

		</form>
	</div>
<hr>
	<?php 
		$arr = $this->get_template_vars('arr');
		foreach($arr as $key => $value){
			$monthNum  = $key;
			$dateObj   = DateTime::createFromFormat('!m', $monthNum);
			$monthName = $dateObj->format('F');
			if(isset($value['total_fee'])){
				$values[$monthName] = $value['total_fee'];
			}
			else if(isset($value['total_reserve'])){
				$values[$monthName] = $value['total_reserve'];
			}
		}
		$this->assign('values', json_encode($values));
	 ?>



<?php echo '
<script type="text/javascript">
	window.onload = function() {
		var data = \''; ?>
<?php echo $this->_tpl_vars['values']; ?>
<?php echo '\';
		var thisMonth = jQuery.parseJSON(data);
		
		var month = new Array();
	    var value = new Array();
	    $.each(thisMonth, function(key,val){
	    	month.push(key);
	    	value.push(val);
	    });
    	var a = parseInt(value[0]);
    	var b = parseInt(value[1]);
    	var c = parseInt(value[2]);
    	var d = parseInt(value[3]);
    	var e = parseInt(value[4]);
    	var f = parseInt(value[5]);
    	var g = parseInt(value[6]);
    	var h = parseInt(value[7]);
    	var i = parseInt(value[8]);
    	var j = parseInt(value[9]);
    	var k = parseInt(value[10]);
    	var l = parseInt(value[11]);



        var d2 = [[\'1\', a], [\'2\', b], [\'3\', c], [\'4\', d], [\'5\', e], [\'6\', f], 
        [\'7\', g], [\'8\', h], [\'9\', i], [\'10\', j], [\'11\', k], [\'12\', l]];

        var plot1 = $.jqplot(\'chartContainer\', [d2], {
        	title:\'売上グラフ\',
            grid: {
                drawBorder: false,
                shadow: false,
                background: \'rgba(0,0,0,0)\'
            },
            highlighter: { show: true },
            seriesDefaults: { 
                shadowAlpha: 0.1,
                shadowDepth: 2,
                fillToZero: true
            },
            series: [
                /*{
                    color: \'rgba(198,88,88,.6)\',
                    negativeColor: \'rgba(100,50,50,.6)\',
                    showMarker: true,
                    showLine: true,
                    fill: true,
                    fillAndStroke: true,
                    markerOptions: {
                        style: \'filledCircle\',
                        size: 8
                    },
                    rendererOptions: {
                        smooth: true
                    }
                },*/
                {
                    color: \'rgba(44, 190, 160, 0.7)\',
                    showMarker: true,
                    showLine: true,
                    fill: true,
                    fillAndStroke: true,
                    markerOptions: {
                        style: \'filledCircle\',
                        size: 10
                    },
                    rendererOptions: {
                        smooth: true,
                    },
                }
            ],
            axes: {
                xaxis: {
                    // padding of 0 or of 1 produce same results, range 
                    // is multiplied by 1x, so it is not padded.
        	 		renderer:$.jqplot.DateAxisRenderer,
                    pad: 1.0,
                    tickOptions: {
                      showGridline: false,
                      formatString:\'%b&nbsp;\' //%b&nbsp;%#d // jqplot.com
                    }
                },
                yaxis: {
                    pad: 1.05,
                    formatString:\'$%.2f\'
                }
            }
        });



	}
	</script>
    '; ?>







	<div id="chartContainer" style="height: 400px; width: 100%;">
	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>