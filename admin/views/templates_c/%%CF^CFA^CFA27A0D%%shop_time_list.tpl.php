<?php /* Smarty version 2.6.26, created on 2017-03-10 13:38:43
         compiled from reserve/shop_time_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'reserve/shop_time_list.tpl', 3, false),)), $this); ?>


	<?php echo smarty_function_html_options(array('name' => 'hour','options' => $this->_tpl_vars['timeArr'],'selected' => $this->_tpl_vars['input_data']['hour'],'id' => 'hour'), $this);?>
