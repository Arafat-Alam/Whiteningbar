<?php /* Smarty version 2.6.26, created on 2017-05-24 22:59:45
         compiled from calendar/setWeather.tpl */ ?>
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script> -->
<script>
<?php echo '
jQuery(document).ready(function($) {
	var city = \''; ?>
<?php echo $this->_tpl_vars['city']; ?>
<?php echo '\';
  $.ajax({
  url : "http://api.wunderground.com/api/f5f1424c54d0f07d/geolookup/conditions/q/JP/"+city+".json",
  dataType : "jsonp",
	  success : function(parsed_json) {
	  var city = parsed_json[\'location\'][\'city\'];
	  var temp_c = parsed_json[\'current_observation\'][\'temp_c\'];
	  var weather = parsed_json[\'current_observation\'][\'weather\'];
	  $("#data").val(weather);
	  }
  });
});
'; ?>

</script>

<div>
<h1>Set Today's Weather</h1>
	<form action="/calendar/setWeather/" method="POST" >
		<table>
		<tr >
			<th colspan="2" style="text-align: center;"><?php echo $this->_tpl_vars['city']; ?>
</th>
		</tr>
			<tr>
				<th>Set Todays Weather :</th>
				<td>
					<input type="text" name="weather" id="data" readonly="" style="width: 100%">
					<input type="hidden" name="shop_no" id="data" value="<?php echo $this->_tpl_vars['shop_no']; ?>
">
					<input type="hidden" name="date" id="data" value="<?php echo $this->_tpl_vars['date']; ?>
">
				</td>
			</tr>
		</table><br>
		<input type="submit" name="submit" value="Update">
	</form>
</div>