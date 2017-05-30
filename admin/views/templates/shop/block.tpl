{php}
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='block';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}


$(function(){

	$("#start").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#end").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#timestart").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#start_r").datepicker({
		dateFormat: "yy-mm-dd"
	});
	$("#end_r").datepicker({
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
	{include file="shop/menu_shop.tpl"}
		<h3>基本設定</h3>
<h4>ブロック設定</h4>

<div class="w80 center">
{if $login_admin.shop_no<=0}
		<a href="/shop/list" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;店舗一覧</a>
{/if}

{include file="messages.tpl"}


		<table class="search w100">
		<tr>
		<form method="post" name="fm_search" action="">
			<th>日付期間で設定</th>
			<td>
				select Booth: 
				<select name="booth_no" style="width: 50%">
				{php}
					$booth = $this->get_template_vars('boothArr');
						for($a=1; $a<=$booth['booth']; $a++){
							echo "<option value='".$a."'>".$a."</option>";
						}
				{/php}
				</select> 
				<br>
				
				ブロック開始日時：<input type="text" id="start" name="start_date" size="25" value="{$input_data.start_date|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>
				<input name="start_time" value="{$input_data.start_time|date_format:'%H:%M'}"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
<br />
				～
<br />
				ブロック終了日時：<input type="text" id="end" name="end_date" size="25" value="{$input_data.end_date|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>
				<input name="end_time" value="{$input_data.end_time|date_format:'%H:%M'}"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">

			</td>
			<td>
				<input type="hidden" name="no" value="{$input_data.no}" />
				<input type="hidden" name="kind_flg" value=1>
				<input type="submit" name="submit" value="決定">&nbsp;
			</td>
		</form>
		</tr>
		<tr>
		<form method="post" name="fm_search" action="">
			<th>時間単位で設定</th>
			<td>
				select Booth: 
				<select name="booth_no" style="width: 50%">
				{php}
					$booth = $this->get_template_vars('boothArr');
						for($a=1; $a<=$booth['booth']; $a++){
							echo "<option value='".$a."'>".$a."</option>";
						}
				{/php}
				</select> 
				<br>
						{if $result_messages.from_def_h}
							<span class="red"> {$result_messages.from_def_h}</span><br />
						{/if}
				日付：<input type="text" id="timestart" name="start_date_t" size="25" value="{$input_data.start_date_t|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>
<br />
				時間：<input name="start_time_t" value="{$input_data.start_time_t|date_format:'%H:%M'}"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
				～
				<input name="end_time_t" value="{$input_data.end_time_t|date_format:'%H:%M'}"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
			</td>
			<td>
				<input type="hidden" name="no_t" value="{$input_data.no_t}" />
				<input type="hidden" name="kind_flg" value=2>
				<input type="submit" name="submit" value="決定" >&nbsp;
			</td>
		</form>
		</tr>
		<tr>
		<form method="post" name="fm_search" action="">
			<th>リピートで設定</th>
			<td>
			select Booth: 
				<select name="booth_no" style="width: 50%">
				{php}
					$booth = $this->get_template_vars('boothArr');
						for($a=1; $a<=$booth['booth']; $a++){
							echo "<option value='".$a."'>".$a."</option>";
						}
				{/php}
				</select> 
				<br>
				
				期間<br/>
				<input type="text" id="start_r" name="start_date_r" size="25" value="{$input_data.start_date_r|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end_r" name="end_date_r" size="25" value="{$input_data.end_date_r|date_format:'%Y-%m-%d'}" style="ime-mode:disabled;"/>

<br />
				ブロック時間<br/>
				<input name="start_time_r" value="{$input_data.start_time_r|date_format:'%H:%M'}"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">
				～
				<input name="end_time_r" value="{$input_data.end_time_r|date_format:'%H:%M'}"  class="fieldset__input js__timepicker timepicker" type="text" placeholder="クリックして時間を選択">

<br />
※指定した期間、同じ時間帯で予約のブロックを行います。
			</td>
			<td>
				<input type="hidden" name="no_r" value="{$input_data.no_r}" />
				<input type="hidden" name="kind_flg" value=3>
				<input type="submit" name="submit" value="決定">&nbsp;
			</td>
		</form>
		</tr>
	</table>


<hr>
<a href="/shop/block/?sn={$shop_no}" class="btn">&nbsp;新規登録</a>
<form method="post" name="fm_search" action="">
			<table  class="admins clear">
			<tr>
				<th>ブロック内容</th>
				<th>修正</th>
				<th>Booth</th>
				<th>削除</th>
			</tr>
			{foreach from=$arr item="item"}
			<tr>
				<td>
					{if $item.kind_flg==1}
					※期間でブロック<br />
						{$item.start_date}
						{$item.start_time}
						～
						{$item.end_date}
						{$item.end_time}
					{elseif $item.kind_flg==3}
					※リピートブロック<br />
						{$item.start_date}
						～
						{$item.end_date}
						<br />
						{$item.start_time}
						～
						{$item.end_time}
					{else}
					※時間ブロック<br />
						{$item.start_date}<br />
						{$item.start_time}～{$item.end_time}

					{/if}

				</td>
				<td>
					Booth No : {$item.booth_no}
				</td>
				<td class="tc"><a href="/shop/block/?modify={$item.no}&sn={$item.shop_no}" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i>&nbsp;修正</a></td>
				<td class="tc"><input type="checkbox" name="delete_dummy[]" value="{$item.no}" /></td>
			</tr>
			{/foreach}
			</table>

			<div class="tc">
				<input type="submit" name="del_submit" value="削除する" onClick="return confirm('チェックされた内容を削除します。良いですか？');" class="btn-delete">
			</div>
</form>

</div>
	</div>
</div>
{include file="footer.tpl"}
	<!-- date time picker -->
	<script src="/js/legacy.js"></script>
	<script src="/js/picker.js"></script>
	<script src="/js/picker.date.js"></script>
	<script src="/js/picker.time.js"></script>
	<script src="/js/ja_JP.js"></script>
	<script>
	{literal}
		$('.datepicker').pickadate({
			format: 'yyyy/mm/dd'
		})
		$('.timepicker').pickatime({
			　clear: '消去',
			 format: 'H:i',
			 interval: 15,
			 min: [10,0],
   		 max: [21,0]
		})
		{/literal}
	</script>

</body>
</html>

