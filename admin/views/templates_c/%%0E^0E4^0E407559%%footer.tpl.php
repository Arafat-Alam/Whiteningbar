<?php /* Smarty version 2.6.26, created on 2017-05-08 15:35:26
         compiled from footer.tpl */ ?>
<!-- <a href="#" class="scrollToTop">Scroll Top</a> -->
<div class="scrollToTop" style="cursor: pointer;">Scroll Top</div>
<div id="footer" class="clear mt30"><?php echo @FOOTER_COPYRIGHT; ?>
</div>
<?php 
unset($_SESSION['page']);
unset($_SESSION['tab']);
 ?>

<?php if ($this->_tpl_vars['shopNo'] == 0 && $this->_tpl_vars['index'] == 'index'): ?>
<?php 

	$monthData = $this->get_template_vars('monArr'); 
	$dayData = $this->get_template_vars('dayArr');
	
	if(isset($monthData)){
		foreach($monthData as $kay => $value){

			foreach($value as $keys => $values){

				if(is_array($values)){

					foreach($values as $keyss => $valuess){
						if($keyss == 1){
							$thisMonth[$shopName] =  $valuess;
						}elseif($keyss == 0){
							$prevMonth[$shopName] =  $valuess;
						}else{
							$nextMonth[$shopName] =  $valuess;
						}
					}
				}else{
					$shopName = $values;
				}
			}
		}
		arsort($thisMonth);
		arsort($prevMonth);
		arsort($nextMonth);
	}

	$this->assign('prevMonth', json_encode($prevMonth));
	$this->assign('thisMonth', json_encode($thisMonth));
	$this->assign('nextMonth', json_encode($nextMonth));

	// day wise data array 
	if(isset($dayData)){
		foreach($dayData as $kay => $value){

			foreach($value as $keys => $values){

				if(is_array($values)){

					foreach($values as $keyss => $valuess){
						if($keyss == 1){
							$thisDay[$shopName] =  $valuess; //[This Day]
						}elseif($keyss == 0){
							$prevDay[$shopName] =  $valuess;  //[Prev Day]
						}else{
							$nextDay[$shopName] =  $valuess;  // [Next Day]
						}
					}
				}else{
					$shopName = $values;
				}
			}
		}
		arsort($prevDay);
		arsort($thisDay);
		arsort($nextDay);
	}
	$this->assign('prevDay', json_encode($prevDay));
	$this->assign('thisDay', json_encode($thisDay));
	$this->assign('nextDay', json_encode($nextDay));
 ?>


<?php echo '

<script type="text/javascript">
	


	function abbreviateNumber(arr) {
            var newArr = [];
            $.each(arr, function (index, value) {
                var newValue = value;
                if (value >= 1000) {
                    var suffixes = [" ", " K", " mil", " bil", " t"];
                    var suffixNum = Math.floor(("" + value).length / 3);
                    var shortValue = \'\';
                    for (var precision = 2; precision >= 1; precision--) {
                        shortValue = parseFloat((suffixNum != 0 ? (value / Math.pow(1000, suffixNum) ) : value).toPrecision(precision));
                        var dotLessShortValue = (shortValue + \'\').replace(/[^a-zA-Z 0-9]+/g, \'\');
                        if (dotLessShortValue.length <= 2) {
                            break;
                        }
                    }
                    if (shortValue % 1 != 0)  shortNum = shortValue.toFixed(1);
                    newValue = shortValue + suffixes[suffixNum];
                }
                newArr[index] = newValue;
            });
            return newArr;
        }


        /*
		console.log(thisDay);
		var values = "";
        $.each( thisDay, function( index, value){
        	values +=  value+",";
        });

        values = values.replace(/,+$/,\'\');*/
        function monthChartData(chartData){
        	if (chartData == \'lastMonth\') {
        		var data = \''; ?>
<?php echo $this->_tpl_vars['prevMonth']; ?>
<?php echo '\';
        		var thisMonth = jQuery.parseJSON(data);
        		
        		var shop = new Array();
		        var value = new Array();
		        var shopName = new Object;
		        var i  ;
		        var rv = {};


		        $.each(thisMonth, function(key,val){
		        	shop.push(key);
		        	value.push(val);
		        });

		        for (var i = 0; i < shop.length; i++) {
		        	shopName[i] = shop[i];
		        	rv[i] = value[i];
		        }

				var title = "先月";
				var labels = shopName;
		        // var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];
        
        		// var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
         		// var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
         		var values = rv;
		        var outputValues = abbreviateNumber(values);

		        $(\'.bar-chart-month\').simpleChart({
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


        	}else if(chartData == \'nextMonth\'){
        		var data = \''; ?>
<?php echo $this->_tpl_vars['nextMonth']; ?>
<?php echo '\';
        		var thisMonth = jQuery.parseJSON(data);

        		var shop = new Array();
		        var value = new Array();
		        var shopName = new Object;
		        var i  ;
		        var rv = {};

		        $.each(thisMonth, function(key,val){
		        	shop.push(key);
		        	value.push(val);
		        });

		        for (var i = 0; i < shop.length; i++) {
		        	shopName[i] = shop[i];
		        	rv[i] = value[i];
		        }


		        var title = "来月";
		        var labels = shopName;
		        // var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];
        
        		// var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
         		// var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
         		
         		var values = rv;
		        var outputValues = abbreviateNumber(values);

		        $(\'.bar-chart-month\').simpleChart({
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


        	}else{
        		var data = \''; ?>
<?php echo $this->_tpl_vars['thisMonth']; ?>
<?php echo '\';
        		var thisMonth = jQuery.parseJSON(data);

        		var shop = new Array();
		        var value = new Array();
		        var shopName = new Object;
		        var i  ;
		        var rv = {};

		        $.each(thisMonth, function(key,val){
		        	shop.push(key);
		        	value.push(val);
		        });

		        for (var i = 0; i < shop.length; i++) {
		        	shopName[i] = shop[i];
		        	rv[i] = value[i];
		        }


		        var title = "今月";
		        var labels = shopName;
		        // var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];
        
        		// var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
         		// var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
         		var values = rv;
		        var outputValues = abbreviateNumber(values);

		        $(\'.bar-chart-month\').simpleChart({
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


        	}
        }
        var data = \''; ?>
<?php echo $this->_tpl_vars['thisMonth']; ?>
<?php echo '\';
        var thisMonth = jQuery.parseJSON(data);

        var shop = new Array();
        var value = new Array();
        var shopName = new Object;
        var i  ;
        var rv = {};

        $.each(thisMonth, function(key,val){
        	shop.push(key);
        	value.push(val);
        });


        for (var i = 0; i < shop.length; i++) {
        	shopName[i] = shop[i];
        	rv[i] = value[i];
        }


        var title = "今月";
		var labels = shopName;
        
        // var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];

        
        // var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
         // var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
         var values = rv;
        var outputValues = abbreviateNumber(values);

        $(\'.bar-chart-month\').simpleChart({
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





		function dayChartData(chartData){
        	if (chartData == \'yesterday\') {
        		var data = \''; ?>
<?php echo $this->_tpl_vars['prevDay']; ?>
<?php echo '\';
        		var thisDay = jQuery.parseJSON(data);

        		var shop = new Array();
		        var value = new Array();
		        var shopName = new Object;
		        var i  ;
		        var rv = {};

		        $.each(thisDay, function(key,val){
		        	shop.push(key);
		        	value.push(val);
		        });

		        for (var i = 0; i < shop.length; i++) {
		        	shopName[i] = shop[i];
		        	rv[i] = value[i];
		        }


        		var title = "昨日";
				var labels = shopName;
        		// var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];
        
        		// var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
        	 	// var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
        		var values = rv;
        		var outputValues = abbreviateNumber(values);
        		

        		$(\'.bar-chart-day\').simpleChart({
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

        	}else if(chartData == \'tomorrow\'){
        		var data = \''; ?>
<?php echo $this->_tpl_vars['nextDay']; ?>
<?php echo '\';
        		var thisDay = jQuery.parseJSON(data);

        		var shop = new Array();
		        var value = new Array();
		        var shopName = new Object;
		        var i  ;
		        var rv = {};

		        $.each(thisDay, function(key,val){
		        	shop.push(key);
		        	value.push(val);
		        });

		        for (var i = 0; i < shop.length; i++) {
		        	shopName[i] = shop[i];
		        	rv[i] = value[i];
		        }



        		var title = "明日";
				var labels = shopName;
        		// var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];
        
        		// var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
        	 	// var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
        		var values = rv;
        		var outputValues = abbreviateNumber(values);
        		


        		$(\'.bar-chart-day\').simpleChart({
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


        	}else{
        		var data = \''; ?>
<?php echo $this->_tpl_vars['thisDay']; ?>
<?php echo '\';
        		var thisDay = jQuery.parseJSON(data);

        		var shop = new Array();
		        var value = new Array();
		        var shopName = new Object;
		        var i  ;
		        var rv = {};

		        $.each(thisDay, function(key,val){
		        	shop.push(key);
		        	value.push(val);
		        });

		        for (var i = 0; i < shop.length; i++) {
		        	shopName[i] = shop[i];
		        	rv[i] = value[i];
		        }



        		var title = "本日";
				var labels = shopName;
        		// var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];
        
        		// var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
        	 	// var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
        		var values = rv;
        		var outputValues = abbreviateNumber(values);
        		

        		$(\'.bar-chart-day\').simpleChart({
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
		        });//end 



        	}
        }

        var data = \''; ?>
<?php echo $this->_tpl_vars['thisDay']; ?>
<?php echo '\';
        var thisDay = jQuery.parseJSON(data);

        var shop = new Array();
        var value = new Array();
        var shopName = new Object;
        var i  ;
        var rv = {};

		$.each(thisDay, function(key,val){
		   	shop.push(key);
		   	value.push(val);
		});

		for (var i = 0; i < shop.length; i++) {
        	shopName[i] = shop[i];
        	rv[i] = value[i];
        }

        var title = "本日";
		var labels = shopName;
        // var labels = [shop[0],shop[1],shop[2],shop[3],shop[4],shop[5],shop[6],shop[7],shop[8], shop[9],shop[10],shop[11],shop[12],shop[13],shop[14],shop[15],shop[16]];
        
		// var values = [278, 218, 206, 167, 151, 159, 140, 134, 127, 121];
	 	// var values = [ value[0], value[1], value[2], value[3], value[4], value[5], value[6], 	value[7], 	value[8], 	value[9], value[10], value[11], value[12], value[13], value[14], value[15], value[16]];
	 	var values = rv;
        var outputValues = abbreviateNumber(values);

        $(\'.bar-chart-day\').simpleChart({
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


</script>
'; ?>

<?php endif; ?>
<?php echo '
<script type="text/javascript">
	$(document).ready(function() {
		$("#jMenu").jMenu({
			openClick : false,
			 TimeBeforeOpening : 100,
			TimeBeforeClosing : 11,
			animatedText : false,
			paddingLeft: 1,
			effects : {
				effectSpeedOpen : 150,
				effectSpeedClose : 150,
				effectTypeOpen : \'slide\',
				effectTypeClose : \'slide\',
				effectOpen : \'swing\',
				effectClose : \'swing\'
			}

		});
	});
	$(function() {
		 $(\'#tablefix\').tablefix({ height: 600, fixRows: 1});
	});
</script>
<script type="text/javascript" src="js/indexTpl.js"></script>
<script>
$(document).ready(function(){
	$(\'.scrollToTop\').mouseover(function(){
		$(\'.scrollToTop\').css("opacity", ".4");
	});

	$(\'.scrollToTop\').mouseout(function(){
		$(\'.scrollToTop\').css("opacity", "1");
	});
	
	//Check to see if the window is top if not then display button
	$(window).scroll(function(){
		if ($(this).scrollTop() > 100) {
			$(\'.scrollToTop\').fadeIn();
			$(\'.scrollToTop\').css("opacity", "1");
		} else {
			$(\'.scrollToTop\').fadeOut();
		}
	});
	
	//Click event to scroll to top
	$(\'.scrollToTop\').click(function(){
		$(\'html, body\').animate({scrollTop : 0},800);
		return false;
	});
	
});
</script>
'; ?>