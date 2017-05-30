{php}
$file="SaleData.xls";
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=$file");
{/php}
{if isset($dataArr)}
				{foreach from=$dataArr key=arrKey item=itemArr}
					{if $arrKey==0}
					
日付 / date ;曜日 / day;総売上 / Weather;総売上 / total sale;総来客数 / total visitor;招待 / cancel visit;初来店;6回コース;12回コース;ウェディングコース;9回コース;18回コース;1回コース;24回コース;36回コース;初来店再予約;期間限定お試し3回コース;1回コース 2回連続ケア;初回限定3回コース;オープン記念キャンペーン(500円）;学割6回コース;学割9回コース;学割12回コース;学割18回コース;学割24回コース;学割36回コース;クリーニング1回コース;ホワイトニング+クリーニング1回コース;6回コース+クリーニング;学割6回コース+クリーニング;9回コース+クリーニング;学割9回コース+クリーニング;12回コース+クリーニング;学割12回コース+クリーニング;ウェディングコース+クリーニング;学割18回コース+クリーニング;18回コース+クリーニング;24回コース+クリーニング;学割24回コース+クリーニング;36回コース+クリーニング;学割36回コース+クリーニング;初回限定3回コース+クリーニング;社内管理用　+1;コース割引合計金額 / total Discount;{else}
					
{$arrKey};{$itemArr.day};{$itemArr.weather};{$itemArr.totalFee};{$itemArr.totalVisitor};{$itemArr.totalCancelVisit};{$itemArr.1};{$itemArr.2};{$itemArr.3};{$itemArr.4};{$itemArr.6};{$itemArr.7};{$itemArr.11};{$itemArr.12};{$itemArr.13};{$itemArr.15};{$itemArr.18};{$itemArr.29};{$itemArr.30};{$itemArr.33};{$itemArr.34};{$itemArr.35};{$itemArr.36};{$itemArr.37};{$itemArr.40};{$itemArr.41};{$itemArr.42};{$itemArr.43};{$itemArr.44};{$itemArr.45};{$itemArr.46};{$itemArr.47};{$itemArr.48};{$itemArr.49};{$itemArr.50};{$itemArr.51};{$itemArr.52};{$itemArr.53};{$itemArr.54};{$itemArr.55};{$itemArr.56};{$itemArr.57};{$itemArr.58};{$itemArr.totalDiscount};{/if}
				{/foreach}
					
Total;;;{$maxTotal.totalFee};{$maxTotal.totalVisitor};{$maxTotal.totalCancel};{$maxTotal.1};{$maxTotal.2};{$maxTotal.3};{$maxTotal.4};{$maxTotal.6};{$maxTotal.7};{$maxTotal.11};{$maxTotal.12};{$maxTotal.13};{$maxTotal.15};{$maxTotal.18};{$maxTotal.29};{$maxTotal.30};{$maxTotal.33};{$maxTotal.34};{$maxTotal.35};{$maxTotal.36};{$maxTotal.37};{$maxTotal.40};{$maxTotal.41};{$maxTotal.42};{$maxTotal.43};{$maxTotal.44};{$maxTotal.45};{$maxTotal.46};{$maxTotal.47};{$maxTotal.48};{$maxTotal.49};{$maxTotal.50};{$maxTotal.51};{$maxTotal.52};{$maxTotal.53};{$maxTotal.54};{$maxTotal.55};{$maxTotal.56};{$maxTotal.57};{$maxTotal.58};{$maxTotal.totalDiscount};
			{/if}
