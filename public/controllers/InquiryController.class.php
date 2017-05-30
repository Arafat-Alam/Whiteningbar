<?php
class InquiryController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();


	}

	/**
	 * トップページ表示
	 */
	public function displayAction() {


		$formVa=CommonChkArray::$inquiryCheckData;
		$inqArr=CommonArray::$inq_array;

		if($_POST[confirm]){
			//送信処理

			$input_data=$_POST;
			$_SESSION["input_data"]=$input_data;
			//入力チェック
			$ret=!$this->check($_POST,$formVa);

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $msg){
					$result_messages[$msg->getMessageLevel()]=$msg->getMessageBody();
				}
				$this->view->assign("result_messages", $result_messages);
			}
			else {


				$pur=$input_data[pur];
				$input_data[pur_str]=$inqArr[$pur];

				$this->view->assign("input_data", $input_data);

				$this->setTemplatePath("inquiry_conf.tpl");

					return;

			}


		}
		else if($_POST[submit]){

			$input_data=makeGetRequest($_SESSION["input_data"]);

			//運営にメール送信
			$this->view->assign("input_data", $input_data);
			$subject = "[" . STR_SITE_TITLE . "]お問い合わせがありました";
			$mailBody = $this->view->fetch("mail/inquiry.tpl");
			send_mail(INQ_ADMIN_EMAIL, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

			$this->setTemplatePath("inquiry_fini.tpl");
			return;

		}
		else if($_POST[back]){

			$input_data=makeGetRequest($_SESSION["input_data"]);

		}
		else{

			if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
		}

		$this->view->assign("inqArr", $inqArr);
		$this->view->assign("input_data", $input_data);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("inquiry.tpl");
		return;

	}

}
?>