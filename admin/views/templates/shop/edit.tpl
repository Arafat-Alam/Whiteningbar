{php}
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='edit';
{/php}

{include file="head.tpl"}

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="shop/menu_shop.tpl"}
		<h3>基本設定</h3>
<h4>店舗登録</h4>

<div class="w60 center">
{if $login_admin.shop_no<=0}
		<a href="/shop/list" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;店舗一覧</a>
{/if}

{include file="messages.tpl"}

		<form method="post" name="fm_search" action="/shop/edit">
		<table class="search w100">
		<tr>
			<th>店名<span class="red">※</span></th>
			<td>
						{if $result_messages.name}
							<span class="red"> {$result_messages.name}</span><br />
						{/if}
				<input type="text" name="name" id="name"  value="{$input_data.name}" size="40" />
			</td>
		</tr>
		<tr>
			<th>郵便番号</th>
			<td>
						{if $result_messages.zip}
							<span class="red"> {$result_messages.zip}</span><br />
						{/if}
				<input type="text" name="zip" id="zip"  value="{$input_data.zip}" size="10" />

			</td>
		</tr>
		<tr>
			<th>住所</th>
			<td>
						{if $result_messages.address}
							<span class="red"> {$result_messages.address}</span><br />
						{/if}
				<input type="text" name="address" id="address"  value="{$input_data.address}" size="50" />
			</td>
		</tr>
		<tr>
			<th>電話番号</th>
			<td>
						{if $result_messages.tel}
							<span class="red"> {$result_messages.tel}</span><br />
						{/if}
				<input type="text" name="tel" id="tel"  value="{$input_data.tel}" size="30" />
			</td>
		</tr>
		<tr>
			<th>メール送信先のEmail</th>
			<td>
						{if $result_messages.send_email}
							<span class="red"> {$result_messages.send_email}</span><br />
						{/if}
				<input type="text" name="send_email" id="send_email"  value="{$input_data.send_email}" size="30" />
			</td>
		</tr>
	</table>

{if $login_admin.shop_no>=0}
		<div class="mt20 tc">
			<input type="submit" name="submit" value="更新" class="btn-lg">&nbsp;
<!-- 			<input type="reset"  value="クリア"> -->
			<input type="hidden" name="shop_no" value="{$input_data.shop_no}">

		</div>
{/if}
		</form>

</div>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

