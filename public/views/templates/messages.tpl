{* メッセージ表示 *}
<div class="header_msg_base">
{foreach from=$msg_list|smarty:nodefaults item="msg" name="loop"}
	<div class="header_msg_{$msg->getMessageLevel()}">
		<span class="txt-red txt-sm">{$msg->getMessageBody()}</span>
	</div>
{/foreach}
</div>
