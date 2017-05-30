<?php /* Smarty version 2.6.26, created on 2017-03-13 16:40:53
         compiled from addCategoryPull.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'addCategoryPull.tpl', 3, false),)), $this); ?>
<!-- プルダウン作成 -->

	<?php echo smarty_function_html_options(array('name' => 'number','options' => $this->_tpl_vars['boothArr'],'selected' => $this->_tpl_vars['search']['number'],'id' => 'number'), $this);?>


