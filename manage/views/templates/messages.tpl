{* メッセージ表示 *}
<div class="header_msg_base">
{foreach from=$msg_list|smarty:nodefaults item="msg" name="loop"}
	{if $msg->getMessageLevel() == $smarty.const.SYSTEM_MESSAGE_INFO}
		{assign var="level" value="info"}
	{elseif $msg->getMessageLevel() == $smarty.const.SYSTEM_MESSAGE_VALID}
		{assign var="level" value="valid"}
	{elseif $msg->getMessageLevel() == $smarty.const.SYSTEM_MESSAGE_WARN}
		{assign var="level" value="warn"}
	{elseif $msg->getMessageLevel() == $smarty.const.SYSTEM_MESSAGE_ERROR}
		{assign var="level" value="error"}
	{/if}
	<div class="header_msg_{$level}">
		<div>・{$msg->getMessageBody()}</div>
	</div>
{/foreach}

