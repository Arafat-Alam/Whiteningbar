<?php /* Smarty version 2.6.26, created on 2014-09-10 01:07:26
         compiled from mail/regist.tpl */ ?>


◆顧客店舗
<?php echo $this->_tpl_vars['reserve_datail']['shop_name']; ?>


◆メールアドレス
<?php echo $this->_tpl_vars['input_data']['email']; ?>


◆お名前
<?php echo $this->_tpl_vars['input_data']['name']; ?>


◆ふりがな
<?php echo $this->_tpl_vars['input_data']['name_kana']; ?>


◆電話番号
<?php echo $this->_tpl_vars['input_data']['tel']; ?>


◆住所
<?php echo $this->_tpl_vars['input_data']['zip']; ?>

<?php echo $this->_tpl_vars['input_data']['pref_str']; ?>
<?php echo $this->_tpl_vars['input_data']['address1']; ?>
<?php echo $this->_tpl_vars['input_data']['address2']; ?>


◆性別
<?php echo $this->_tpl_vars['input_data']['sex_str']; ?>


◆生年月日
<?php if ($this->_tpl_vars['input_data']['year']): ?><?php echo $this->_tpl_vars['input_data']['year']; ?>
年<?php echo $this->_tpl_vars['input_data']['month']; ?>
月<?php echo $this->_tpl_vars['input_data']['day']; ?>
日<?php endif; ?>


◆ご紹介者名
<?php echo $this->_tpl_vars['input_data']['intro']; ?>


◆備考
<?php echo $this->_tpl_vars['input_data']['comment']; ?>

