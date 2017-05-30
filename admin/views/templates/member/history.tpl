{php}
session_start();
$_SESSION['page']='reserve';
//$_SESSION['tab']='weekly';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}


{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="member/menu_member.tpl"}
		<!-- <h3>顧客一覧</h3> -->
<h4>個人情報の&nbsp;&nbsp;<a href="/member/edit/?member_id={$memArr.member_id}" class="btn"><i class="fa fa-lg fa-pencil"> </i>&nbsp;編集</a>&nbsp;<a href="/member/history/?member_id={$memArr.member_id}" class="btn"><i class="fa fa-lg fa-history"> </i>&nbsp;履歴</a></h4>

<h4>{$memArr.name}さんの購入/来店履歴</h4>

		<a href="/member/list" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;顧客一覧へ戻る</a><br /><br />
		<a href="/reserve/list/?back" class="btn"><i class="fa fa-angle-double-left"></i>&nbsp;予約一覧へ戻る</a><br />

		{* 検索結果 *}
		{foreach from=$buyCourseArr item=item}
			<p class="mt10">
			<form action="" method="post">
			{$item.name}購入日：<strong>{if $item.fee_flg==1}{$item.buy_date|date_format:"%G/%m/%d"}{else}未払い{/if}</strong>&nbsp;&nbsp;&nbsp;
			期限：<strong>{if $item.fee_flg==1}{$item.limit_date|date_format:"%G/%m/%d"}{else}-{/if}</strong>&nbsp;&nbsp;&nbsp;
			店舗：<strong>{$item.shop_name}</strong>&nbsp;&nbsp;&nbsp;
			クーポン：<strong>{$item.coupon_name}</strong>
			{if $item.fee_flg==0}<input type="submit" name="un_submit" value="未払い削除" onClick="return confirm('未払いのコース情報と予約を完全に削除します。良いでしょうか？');" />{/if}
			{if $item.fee_flg==1 && $item.rcnt==0}<input type="submit" name="submit" value="購入コースの取り消し" onClick="return confirm('コース購入を取り消します。良いでしょうか？');" />{/if}
			<input type="hidden" name="buy_no" value="{$item.buy_no}" />
			</form>
			</p>

			<table class="admins mt10">
			<tr>
				<th width="80">予約番号</th>
				<!-- <th width="80">detail</th> -->
				<th width="50">予約日</th>
				<th width="80">メニュー名</th>
				<th width="80">use count</th>
				<th width="80">Pre State</th>
				<th width="80">Now State</th>
				<th width="80">時間</th>
<!--  				<th width="80">店舗</th>-->
				<th width="20">来店状況</th>
				<th width="20">担当者</th>
				<th width="20">削除</th>
			</tr>
			{foreach from=$item.reserve item="res"}
				<tr>
					<td>{$res.reserve_no}</td>
					<!-- <td>{$res.no}</td> -->
					<td>{$res.insert_date}</td>
					<td>{$res.menu_name}</td>
					<td>{$res.use_count}</td>
					<td>{$res.pre_state}</td>
					<td>{$res.now_state}</td>
					<td>
						{$res.reserve_date} {$res.start_time|date_format:"%H:%M"}～{$res.end_time|date_format:"%H:%M"}
					</td>
					<!-- <td>{$res.shop_name}</td>-->
					<td>
						{if $res.visit_flg==1}
							ご来店
						{elseif $res.visit_flg==99}
							キャンセル
						{else}
							ご予約中
						{/if}
					</td>
					<td>{$res.staff_name}</td>
					<td>
						{if $res.visit_flg==99}
						<form action="" method="post">
							<input type="submit"  name="del" value="削除する" onclick="return confirm('履歴から削除しますが良いですか？');" />
							<input type="hidden" name="detail_no" value="{$res.no}">
							<input type="hidden" name="reserve_no" value="{$res.reserve_no}">
						</form>
						{/if}
					</td>

				</tr>
			{foreachelse}
				<tr>
					<td colspan="7">来店履歴はまだありません。</td>
				</tr>
			{/foreach}
			</table>

			<hr class="mb20">

		{foreachelse}
			ご購入履歴はまだありません
		{/foreach}



	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

