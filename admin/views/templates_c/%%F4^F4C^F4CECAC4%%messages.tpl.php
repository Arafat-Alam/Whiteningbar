<?php /* Smarty version 2.6.26, created on 2017-03-08 15:46:56
         compiled from messages.tpl */ ?>
<div class="header_msg_base">
<?php $_from = $this->_tpl_vars['msg_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['msg']):
        $this->_foreach['loop']['iteration']++;
?>
	<div class="header_msg_<?php echo $this->_tpl_vars['msg']->getMessageLevel(); ?>
">
		<span class="txt-red txt-sm"><?php echo $this->_tpl_vars['msg']->getMessageBody(); ?>
</span>
	</div>
<?php endforeach; endif; unset($_from); ?>
</div>