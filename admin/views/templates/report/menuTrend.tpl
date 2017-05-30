{php}
session_start();
$_SESSION['page']='report';
$_SESSION['tab']='menuTrend';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

function clearSearchForm() {
	$("#f_year").val("");
	$("#f_month").val("");
	$("#t_year").val("");
	$("#t_month").val("");
	$("input#mon1").attr('checked',false);
	$("input#mon2").attr('checked',false);
	$("input#mon3").attr('checked',false);


}

$(function(){


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
<h4>月次売上</h4>

	<div class="w60 center">

		<form method="post" name="fm_search" action="">
		<table class="search center">
			<tr>
				<th>売上月</th>
				<td>
		          	{html_options name="f_year" options=$yearArr selected=$search.f_year id=f_year}
		            年
		            {html_options name="f_month" options=$monthArr selected=$search.f_month id=f_month}
		            月
		            ～
		          	{html_options name="t_year" options=$yearArr selected=$search.t_year id=t_year}
		            年
		            {html_options name="t_month" options=$monthArr selected=$search.t_month id=t_month}
		            月

				</td>
			</tr>
			{if $login_admin.shop_no==0}
			<tr>
				<th>ストアを選択</th>
				<td> 
					<select name="shop_no">
						<option value="0">すべての店</option>
						{php}
							$shopArr = $this->get_template_vars('shopArr');
							$shop_no = $this->get_template_vars('shop_no');
							foreach($shopArr as $key => $value){
							
						{/php}
							<option value="{php}echo $value['shop_no'];{/php}" {php}if($shop_no==$value['shop_no'])echo "selected"{/php}>{php}echo $value['name'];{/php}</option>
						{php}
							}
						{/php}
					</select>
				</td>
			</tr>
			{/if}
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

		{* 検索結果 *}
<!--
			<div class="paging">
				<div class="left"><strong>{$total_cnt}</strong>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
			</div>
			<br/>
-->			{if $error == ''}
			<span>
			{if $search.f_year != ''}データの表示 <strong> {$search.f_year} - {$search.f_month} </strong> に <strong> {$search.t_year} - {$search.t_month} </strong>
			{else}すべての時間のデータを表示する{/if}</span>
			{else}
			<span style="color: red;"><h4>{$error}</h4></span>
			{/if}

			<div id="bar-chart"></div>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
{php}
$arr = $this->get_template_vars('arr');
$this->assign('arrs', json_encode($arr));
{/php}
<script type="text/javascript">
	{literal}

		function abbreviateNumbers(arr) {
            var newArr = [];
            $.each(arr, function (index, value) {
                var newValue = value;
                // if (value >= 1000) {
                //     var suffixes = [" ", " K", " mil", " bil", " t"];
                //     var suffixNum = Math.floor(("" + value).length / 3);
                //     var shortValue = '';
                //     for (var precision = 2; precision >= 1; precision--) {
                //         shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000, suffixNum) ) : value).toPrecision(precision));
                //         var dotLessShortValue = (shortValue + '').replace(/[^a-zA-Z 0-9]+/g, '');
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


		
        var data = '{/literal}{$arrs}{literal}';
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

        // var values=[278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, 454, 125, 456, 235, 123, 278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, 454, 125, 456, 235, 123, 278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, 454, 125, 456, 235, 123, 278, 218, 206, 167, 151, 159, 140, 134, 127, 121, 343, 121, '111'];
         // var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];

        var values = rv;
        var outputValues = abbreviateNumbers(values);


        $('#bar-chart').simpleChart({
            title: {
                text: title,
                align: 'center'
            },
            type: 'bar',
            layout: {
                width: '100%'
            },
            item: {
                label: labels,
                value: outputValues,
                outputValue: outputValues,
                color: ['#4CAF50'],
                prefix: '',
                suffix: '',
                render: {
                    margin: 0,
                    size: 'relative'
                }
            }
        });
{/literal}
</script>

