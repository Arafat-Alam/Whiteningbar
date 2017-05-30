<?php
class MVCBase {

	const SESSION_MESSAGES_NAME = "session_messages";
	protected $messages = array();
	protected $logger;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		// log4phpの設定
		$this->logger = & LoggerManager::getLogger("App");
		LoggerNDC::clear();
		LoggerNDC::push(getenv("REMOTE_ADDR"));
	}

	protected function issetSessionMessage() {
		if (isset($_SESSION[$this::SESSION_MESSAGES_NAME])) {
			return true;
		}
		return false;
	}

	/**
	 * Sessionからメッセージを取得する
	 * @param Boolean $bDelete 取得時にSESSION変数からメッセージを削除するか(true or false)
	 */
	protected function getSessionMessage($bDelete = true) {
		if (isset($_SESSION[$this::SESSION_MESSAGES_NAME])) {
			$messages = unserialize($_SESSION[$this::SESSION_MESSAGES_NAME]);

			if ($bDelete) {
				unset($_SESSION[$this::SESSION_MESSAGES_NAME]);
			}

			return $messages;
		}
		else {
			return null;
		}
	}

	/**
	 * Sessionにメッセージを保存する
	 */
	protected function setSessionMessage() {
		$_SESSION[$this::SESSION_MESSAGES_NAME] = serialize($this->messages);
	}

	/**
	 * メッセージを追加する
	 * @param int $messageLevel
	 * @param String $messageBody
	 */
	public function addMessage($messageLevel, $messageBody) {
		$msg = new SystemMessage();
		$msg->setMessageLevel($messageLevel);
		$msg->setMessageBody($messageBody);
		$messageKey = uniqid(get_random_string(20));
		$this->messages[$messageKey] = $msg;
	}

	/**
	 * 配列をマージする
	 * @param unknown_type $messages
	 */
	public function margeMessages($messages) {
		$this->messages += $messages;
		//array_merge($this->messages, $messages);
	}

	/**
	 * メッセージを取得する
	 */
	public function getMessages() {
		if ($this->issetSessionMessage()) {
			$this->margeMessages($this->getSessionMessage());
		}
		return $this->messages;
	}

	/**
	 * すべてのメッセージを結合して返す
	 * @param unknown_type $sep　区切り文字
	 */
	public function getAllMessages($sep = "\n") {
		$msg = "";
		foreach ($this->messages as $message) {
			$msg .= $message->getMessageBody();
			$msg .= $sep;
		}
		return $msg;
	}

	/**
	 * メッセージの件数を返す
	 * Enter description here ...
	 * @param unknown_type $messageLevel
	 */
	public function countMessage($messageLevel) {
		$cnt = 0;
		foreach ($this->messages as $msg) {
			if ($msg->getMessageLevel() == $messageLevel) {
				$cnt++;
			}
		}
		return $cnt;
	}
}