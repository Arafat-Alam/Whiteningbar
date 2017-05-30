<?php
class SystemMessage {

	private $messageId;
	private $messageLevel;
	private $messageBody;

	public function getMessageId()
	{
	    return $this->messageId;
	}

	public function setMessageId($messageId)
	{
	    $this->messageId = $messageId;
	}

	public function getMessageLevel()
	{
	    return $this->messageLevel;
	}

	public function setMessageLevel($messageLevel)
	{
	    $this->messageLevel = $messageLevel;
	}

	public function getMessageBody()
	{
	    return $this->messageBody;
	}

	public function setMessageBody($messageBody)
	{
	    $this->messageBody = $messageBody;
	}
}
?>