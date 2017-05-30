<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script> -->
<script>
{literal}
jQuery(document).ready(function($) {
	var city = '{/literal}{$city}{literal}';
  $.ajax({
  url : "http://api.wunderground.com/api/f5f1424c54d0f07d/geolookup/conditions/q/JP/"+city+".json",
  dataType : "jsonp",
	  success : function(parsed_json) {
	  var city = parsed_json['location']['city'];
	  var temp_c = parsed_json['current_observation']['temp_c'];
	  var weather = parsed_json['current_observation']['weather'];
	  $("#data").val(weather);
	  }
  });
});
{/literal}
</script>

<div>
<h1>Set Today's Weather</h1>
	<form action="/calendar/setWeather/" method="POST" >
		<table>
		<tr >
			<th colspan="2" style="text-align: center;">{$city}</th>
		</tr>
			<tr>
				<th>Set Todays Weather :</th>
				<td>
					<input type="text" name="weather" id="data" readonly="" style="width: 100%">
					<input type="hidden" name="shop_no" id="data" value="{$shop_no}">
					<input type="hidden" name="date" id="data" value="{$date}">
				</td>
			</tr>
		</table><br>
		<input type="submit" name="submit" value="Update">
	</form>
</div>