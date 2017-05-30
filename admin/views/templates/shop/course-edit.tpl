{include file="head.tpl"}

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="shop/menu_shop.tpl"}
		<h3>基本設定</h3>
<h4>コース登録{if $copy==1}(コースコピー){/if}</h4>

<div class="w60 center">
		<a href="/shop/course/" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;コース一覧</a>
{include file="messages.tpl"}



		<form method="post" name="fm_search" action="shop/courseEdit/">
		<table class="search mt10 w100">
		<tr>
			<th>コース名<span class="red">※</span></th>
			<td>
						{if $result_messages.name}
							<span class="red"> {$result_messages.name}</span><br />
						{/if}
				<input type="text" name="name" id="name"  value="{$input_data.name}" size="40" />
			</td>
		</tr>
		<tr>
			<th>回数<span class="red">※</span></th>
			<td>
						{if $result_messages.number}
							<span class="red"> {$result_messages.number}</span><br />
						{/if}
				<input type="text" name="number" id="number"  value="{$input_data.number}" size="10" />回

			</td>
		</tr>
		<tr>
			<th>料金<span class="red">※</span></th>
			<td>
						{if $result_messages.fee}
							<span class="red"> {$result_messages.fee}</span><br />
						{/if}
				<input type="text" name="fee" id="zip"  value="{$input_data.fee}" size="10" />円

			</td>
		</tr>
		<tr>
			<th>期限<span class="red">※</span></th>
			<td>
						{if $result_messages.limit_month}
							<span class="red"> {$result_messages.limit_month}</span><br />
						{/if}
				購入から<input type="text" name="limit_month" id="zip"  value="{$input_data.limit_month}" size="10" />か月

			</td>
		</tr>
		<tr>
			<th>ご招待コース<span class="red">※</span></th>
			<td>
						{if $result_messages.view_flg}
							<span class="red"> {$result_messages.view_flg}</span><br />
						{/if}

				<label><input type="radio" name="invite_flg" id="invite_flg"  value="1" {if $input_data.invite_flg==1}checked{/if}  />招待コース</label>
				<label><input type="radio" name="invite_flg" id="invite_flg"  value="0" {if $input_data.invite_flg==0}checked{/if}  />通常コース</label>
			</td>
		</tr>
		<tr>
			<th>料金に関する説明</th>
			<td>
						{if $result_messages.fee_comment}
							<span class="red"> {$result_messages.fee_comment}</span><br />
						{/if}
				<textarea name="fee_comment" id="fee_comment"  >{$input_data.fee_comment}</textarea>
			</td>
		</tr>
		<tr>
			<th>表示ステータス<span class="red">※</span></th>
			<td>
						{if $result_messages.view_flg}
							<span class="red"> {$result_messages.view_flg}</span><br />
						{/if}

				<label><input type="radio" name="view_flg" id="view_flg"  value="1" {if $input_data.view_flg==1}checked{/if}  />表示</label>
				<label><input type="radio" name="view_flg" id="view_flg"  value="0" {if $input_data.view_flg==0}checked{/if}  />非表示</label>
			</td>
		</tr>
	</table>


		<div class="mt20 tc">
			<input type="submit" name="submit" value="更新" class="btn-lg">&nbsp;
<!-- 			<input type="reset"  value="クリア"> -->
			<input type="hidden" name="course_no" value="{$input_data.course_no}">

		</div>
		</form>
</div>

	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

