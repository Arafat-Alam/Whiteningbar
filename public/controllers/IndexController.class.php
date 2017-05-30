<?php
class IndexController extends AppRootController {

	const ARTICLE_LIST_LIMIT = 10;

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

		$commonDao = new CommonDao();

		$login_member=$this->getMemberSession();

		if($login_member){
			header("location:/member/");
			exit;
		}



		if($_POST[submit]){

			$input_data=$_POST;

			if($_POST[email]=="" || $_POST[password]==""){

					$result_messages="メールアドレスとパスワードを入力してください。";

					$this->view->assign("result_messages", $result_messages);

			}
			else{

				$fi[email]=$_POST[email];
				$fi[password]=to_hash($_POST[password]);



				$ret=$commonDao->get_data_tbl2("member",$fi);
				if($ret){
					//ログイン成功
					$this->setMemberSession($ret[0]);
					header("location:/member/");
					exit;
				}
				else{
					//エラー
						$result_messages="メールアドレスまたはパスワードが違っています。ご確認ください。";

					$this->view->assign("result_messages", $result_messages);



				}
			}
		}

		$this->view->assign("input_data", $input_data);

		$this->setTemplatePath("index.tpl");
		return;
	}





}
?>