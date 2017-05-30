{include file="head.tpl"}


<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="shop/menu_shop.tpl"}
		<h3>基本設定</h3>
<h4>メニュー登録{if $copy==1}(メニューコピー){/if}</h4>

		<a href="/shop/menu/" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;メニュー一覧</a>
{include file="messages.tpl"}


		<form method="post" name="fm_search" action="shop/menuEdit/">
		<table class="search w100 mt10">
		<tr>
			<th>対応コースの選択<span class="red">※</span></th>
			<td>
				{html_options name="course_no" options=$courseArr selected=$input_data.course_no}

			</td>
		</tr>
		<tr>
			<th>メニュー名<span class="red">※</span></th>
			<td>
						{if $result_messages.name}
							<span class="red"> {$result_messages.name}</span><br />
						{/if}
				<input type="text" name="name" id="name"  value="{$input_data.name}" size="40" />
				<br />
				<label><input type="radio" name="kind_flg" value="0" {if $input_data.kind_flg==0}checked{/if} />初回登録者用メニュー（初回用メニュー）</label>
				<label><input type="radio" name="kind_flg" value="1" {if $input_data.kind_flg==1}checked{/if} />会員登録後のメニュー</label>
				<br />
				※初回登録者用メニューとは、未会員の人が会員登録する場合に表示されるメニューです
				<br /><br />
				<label><input type="radio" name="use_count" value="1" {if $input_data.use_count==1}checked{/if} />1回分</label>
				<label><input type="radio" name="use_count" value="2" {if $input_data.use_count==2}checked{/if} />2回分</label>


			</td>
		</tr>
		<tr>
			<th>所要時間<span class="red">※</span></th>
			<td>
						{if $result_messages.times}
							<span class="red"> {$result_messages.times}</span><br />
						{/if}
				<!--<input type="text" name="times" id="times"  value="{$input_data.times}" size="10" />分  -->
				{html_options name="times" options=$menuTimeArr selected=$input_data.times}分


			</td>
		</tr>
		<tr>
			<th>人数<span class="red">※</span></th>
			<td>
						{if $result_messages.number}
							<span class="red"> {$result_messages.number}</span><br />
						{/if}
				<!--<input type="text" name="number" id="number"  value="{$input_data.number}" size="10" />人  -->
				<label><input type="radio" name="number" value="1" {if $input_data.number==1}checked{/if} />1人</label><br />
				<label><input type="radio" name="number" value="2" {if $input_data.number==2}checked{/if} />2人</label><br />

			</td>
		</tr>
		<tr>
			<th>一覧用紹介コメント</th>
			<td>
						{if $result_messages.comment}
							<span class="red"> {$result_messages.comment}</span><br />
						{/if}
				<textarea name="comment" id="comment"  >{$input_data.comment}</textarea>
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
		<tr>
			<th>スケジュール表示色</th>
			<td>

				{foreach from=$colorArr key=colorkey item=item}
					<label><span style="background-color:{$item};" class="color-pick"><input type="radio" name="color_no" value="{$colorkey}" {if $colorkey==$input_data.color_no} checked {/if} >　{$colorkey}</span></label>
				{/foreach}
			</td>
		</tr>
	</table>

 {if $login_admin.shop_no>=0}
		<div class="mt20 tc">
			<input type="submit" name="submit" value="更新" class="btn btn-lg">&nbsp;
<!-- 			<input type="reset"  value="クリア"> -->
			<input type="hidden" name="menu_no" value="{$input_data.menu_no}">

		</div>
{/if}
		</form>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

