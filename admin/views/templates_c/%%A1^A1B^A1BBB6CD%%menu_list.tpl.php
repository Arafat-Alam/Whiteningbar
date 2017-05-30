<?php /* Smarty version 2.6.26, created on 2017-05-24 15:08:26
         compiled from reserve/menu_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'reserve/menu_list.tpl', 1, false),)), $this); ?>
<?php echo smarty_function_html_options(array('name' => 'menu_no','options' => $this->_tpl_vars['menuArr'],'selected' => $this->_tpl_vars['input_data']['menu_no'],'id' => 'menu_no','style' => "width: 100%;"), $this);?>

