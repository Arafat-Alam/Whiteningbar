<?php /* Smarty version 2.6.26, created on 2017-05-24 11:39:42
         compiled from report/csvData.tpl */ ?>
<?php 
$file="SaleData.xls";
header("Content-type: application/xls");
header("Content-Disposition: attachment; filename=$file");
 ?>
<?php if (isset ( $this->_tpl_vars['dataArr'] )): ?>
				<?php $_from = $this->_tpl_vars['dataArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrKey'] => $this->_tpl_vars['itemArr']):
?>
					<?php if ($this->_tpl_vars['arrKey'] == 0): ?>
					
日付 / date ;曜日 / day;総売上 / Weather;総売上 / total sale;総来客数 / total visitor;招待 / cancel visit;初来店;6回コース;12回コース;ウェディングコース;9回コース;18回コース;1回コース;24回コース;36回コース;初来店再予約;期間限定お試し3回コース;1回コース 2回連続ケア;初回限定3回コース;オープン記念キャンペーン(500円）;学割6回コース;学割9回コース;学割12回コース;学割18回コース;学割24回コース;学割36回コース;クリーニング1回コース;ホワイトニング+クリーニング1回コース;6回コース+クリーニング;学割6回コース+クリーニング;9回コース+クリーニング;学割9回コース+クリーニング;12回コース+クリーニング;学割12回コース+クリーニング;ウェディングコース+クリーニング;学割18回コース+クリーニング;18回コース+クリーニング;24回コース+クリーニング;学割24回コース+クリーニング;36回コース+クリーニング;学割36回コース+クリーニング;初回限定3回コース+クリーニング;社内管理用　+1;コース割引合計金額 / total Discount;<?php else: ?>
					
<?php echo $this->_tpl_vars['arrKey']; ?>
;<?php echo $this->_tpl_vars['itemArr']['day']; ?>
;<?php echo $this->_tpl_vars['itemArr']['weather']; ?>
;<?php echo $this->_tpl_vars['itemArr']['totalFee']; ?>
;<?php echo $this->_tpl_vars['itemArr']['totalVisitor']; ?>
;<?php echo $this->_tpl_vars['itemArr']['totalCancelVisit']; ?>
;<?php echo $this->_tpl_vars['itemArr']['1']; ?>
;<?php echo $this->_tpl_vars['itemArr']['2']; ?>
;<?php echo $this->_tpl_vars['itemArr']['3']; ?>
;<?php echo $this->_tpl_vars['itemArr']['4']; ?>
;<?php echo $this->_tpl_vars['itemArr']['6']; ?>
;<?php echo $this->_tpl_vars['itemArr']['7']; ?>
;<?php echo $this->_tpl_vars['itemArr']['11']; ?>
;<?php echo $this->_tpl_vars['itemArr']['12']; ?>
;<?php echo $this->_tpl_vars['itemArr']['13']; ?>
;<?php echo $this->_tpl_vars['itemArr']['15']; ?>
;<?php echo $this->_tpl_vars['itemArr']['18']; ?>
;<?php echo $this->_tpl_vars['itemArr']['29']; ?>
;<?php echo $this->_tpl_vars['itemArr']['30']; ?>
;<?php echo $this->_tpl_vars['itemArr']['33']; ?>
;<?php echo $this->_tpl_vars['itemArr']['34']; ?>
;<?php echo $this->_tpl_vars['itemArr']['35']; ?>
;<?php echo $this->_tpl_vars['itemArr']['36']; ?>
;<?php echo $this->_tpl_vars['itemArr']['37']; ?>
;<?php echo $this->_tpl_vars['itemArr']['40']; ?>
;<?php echo $this->_tpl_vars['itemArr']['41']; ?>
;<?php echo $this->_tpl_vars['itemArr']['42']; ?>
;<?php echo $this->_tpl_vars['itemArr']['43']; ?>
;<?php echo $this->_tpl_vars['itemArr']['44']; ?>
;<?php echo $this->_tpl_vars['itemArr']['45']; ?>
;<?php echo $this->_tpl_vars['itemArr']['46']; ?>
;<?php echo $this->_tpl_vars['itemArr']['47']; ?>
;<?php echo $this->_tpl_vars['itemArr']['48']; ?>
;<?php echo $this->_tpl_vars['itemArr']['49']; ?>
;<?php echo $this->_tpl_vars['itemArr']['50']; ?>
;<?php echo $this->_tpl_vars['itemArr']['51']; ?>
;<?php echo $this->_tpl_vars['itemArr']['52']; ?>
;<?php echo $this->_tpl_vars['itemArr']['53']; ?>
;<?php echo $this->_tpl_vars['itemArr']['54']; ?>
;<?php echo $this->_tpl_vars['itemArr']['55']; ?>
;<?php echo $this->_tpl_vars['itemArr']['56']; ?>
;<?php echo $this->_tpl_vars['itemArr']['57']; ?>
;<?php echo $this->_tpl_vars['itemArr']['58']; ?>
;<?php echo $this->_tpl_vars['itemArr']['totalDiscount']; ?>
;<?php endif; ?>
				<?php endforeach; endif; unset($_from); ?>
					
Total;;;<?php echo $this->_tpl_vars['maxTotal']['totalFee']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['totalVisitor']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['totalCancel']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['1']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['2']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['3']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['4']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['6']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['7']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['11']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['12']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['13']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['15']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['18']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['29']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['30']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['33']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['34']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['35']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['36']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['37']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['40']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['41']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['42']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['43']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['44']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['45']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['46']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['47']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['48']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['49']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['50']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['51']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['52']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['53']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['54']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['55']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['56']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['57']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['58']; ?>
;<?php echo $this->_tpl_vars['maxTotal']['totalDiscount']; ?>
;
			<?php endif; ?>