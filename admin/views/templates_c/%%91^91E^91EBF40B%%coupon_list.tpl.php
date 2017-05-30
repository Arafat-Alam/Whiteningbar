<?php /* Smarty version 2.6.26, created on 2017-03-24 09:58:05
         compiled from member/coupon_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'member/coupon_list.tpl', 3, false),)), $this); ?>


	<?php echo smarty_function_html_options(array('name' => 'coupon_id','options' => $this->_tpl_vars['arr'],'selected' => $this->_tpl_vars['input_data']['p_coupon_id'],'id' => 'coupon_id'), $this);?>
