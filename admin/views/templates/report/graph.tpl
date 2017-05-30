{php}
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='graph';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

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


{/literal}
</script>

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="report/menu_report.tpl"}
		<h3>売上レポート</h3>
<h4>年間売上グラフ</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上日</th>
				<td>
					<select name="year">
						
						{foreach from=$yearArr item="value"}
							<option value="{$value}" {if $year==$value}{'selected'}{/if}>{$value}</option>
						{/foreach}
											
					</select>
				</td>
                {if $login_admin.shop_no==0}
                <th>店舗名</th>
                <td>
                    {html_options name=shop_no options=$shopArr selected=$shop_no id=shop_no}
                </td>
                {/if}
			</tr>
		</table>

		<div class="mt10 tc">
			<button type="submit" name="sbm_search" class="btn-lg">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>

		</form>
	</div>
<hr>
	{php}
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
	{/php}



{literal}
<script type="text/javascript">
	window.onload = function() {
		var data = '{/literal}{$values}{literal}';
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



        var d2 = [['1', a], ['2', b], ['3', c], ['4', d], ['5', e], ['6', f], 
        ['7', g], ['8', h], ['9', i], ['10', j], ['11', k], ['12', l]];

        var plot1 = $.jqplot('chartContainer', [d2], {
        	title:'売上グラフ',
            grid: {
                drawBorder: false,
                shadow: false,
                background: 'rgba(0,0,0,0)'
            },
            highlighter: { show: true },
            seriesDefaults: { 
                shadowAlpha: 0.1,
                shadowDepth: 2,
                fillToZero: true
            },
            series: [
                /*{
                    color: 'rgba(198,88,88,.6)',
                    negativeColor: 'rgba(100,50,50,.6)',
                    showMarker: true,
                    showLine: true,
                    fill: true,
                    fillAndStroke: true,
                    markerOptions: {
                        style: 'filledCircle',
                        size: 8
                    },
                    rendererOptions: {
                        smooth: true
                    }
                },*/
                {
                    color: 'rgba(44, 190, 160, 0.7)',
                    showMarker: true,
                    showLine: true,
                    fill: true,
                    fillAndStroke: true,
                    markerOptions: {
                        style: 'filledCircle',
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
                      formatString:'%b&nbsp;' //%b&nbsp;%#d // jqplot.com
                    }
                },
                yaxis: {
                    pad: 1.05,
                    formatString:'$%.2f'
                }
            }
        });



	}
	</script>
    {/literal}






	<div id="chartContainer" style="height: 400px; width: 100%;">
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
