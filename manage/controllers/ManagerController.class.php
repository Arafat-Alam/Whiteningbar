<?php
class ManagerController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

	}

	/**
	 * ログイン画面
	 */
    public function loginAction() {


    	// formがsubmitされた
    	if (isset($_POST["sbm_login"])) {

    		$commonDao=new CommonDao();

    		$tmp1[]="email";
   			$tmp2[]=$this->request->getParam("email");
    		$tmp1[]="password";
   			$tmp2[]=to_hash($this->request->getParam("password"));


    		$ret=$commonDao->get_data_tbl("company",$tmp1,$tmp2);
    		if(!$ret){
				$this->view->assign("email", $this->request->getParam("email"));
				$this->view->assign("msg", "ユーザーIDまたはパスワードが一致しません。");
    		}
    		else{



    			$manager = $ret[0];
    			if($manager[admit_flg]==0){
					$this->view->assign("msg", "承認作業が完了していません。管理者の承認が完了するまで少しお待ちください。");

    			}
    			else{

	    			$this->setManagerSession($manager);
	    			header("Location:/company/edit/");
    				exit;

    			}

    		}
     	}

    	// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        $this->setTemplatePath("login.tpl");
        return;
	}

	/**
	 * ログアウト
	 */
	public function logoutAction() {
		$this->deleteManagerSession();
		header("Location:  /");
	}

	/**
	 * 管理者一覧表示・検索
	 */
	public function listAction() {

		$search = null;
		$search_flag = false;

		// ログイン中のManagerを取得
		$login_manager = $this->getManagerSession();

		$page = $this->request->getParam("page");

		$dao = new ManagerDao();

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {
			$search = new ManagerSearchCondition();
			$search->setCurPage(1);
			$search->setShopNo($login_manager->getShopNo());
			$search->setUserName($_POST["user_name"]);
			$search->setManagerType($_POST["manager_type"]);

			// システム管理者以外の場合はシステム管理者を検索結果に含めない
			if ($login_manager->getSystemAdmin()!="t") {
				$search->setSystemAdmin("f");
			}

		// ページ番号が渡されたか？
		}
		else if ($page) {
			// ページングによる遷移
			$search = unserialize($_SESSION["search_condition"]);
			$search->setCurPage($this->request->getParam("page"));

		// 削除の場合
		}
		else if ($this->request->getParam("sbm_del")) {
			$search = unserialize($_SESSION["search_condition"]);
			$search->setCurPage(1);
			$manager_obj = $dao->getManager($this->request->getParam("manager_no"));
			$dao->delete($manager_obj);
			$this->addMessage(SYSTEM_MESSAGE_INFO, "管理者マスタを削除しました");
		}

		// sessionに検索条件が保存されている場合
		if (!isset($_REQUEST["sbm_search"]) && !isset($_REQUEST["page"]) && isset($_SESSION["search_condition"]) && $_SESSION["search_type"]=="manager") {
			$search = unserialize($_SESSION["search_condition"]);
			$search->setCurPage(1);
		}

		if ($search) {
			$managers = $dao->doSearch($search, 20);
			$total_cnt = $dao->doSearchCount($search);
			$page_navi = get_page_navi($total_cnt, 20, $page, "/manager/list/");
			$search_flag = true;

			// sessionに検索条件を保存
			$_SESSION["search_type"] = "manager";
			$_SESSION["search_condition"] = serialize($search);
		}
		else {
			$search = new ManagerSearchCondition();
		}

		$this->view->assign("search_flag", $search_flag);
		$this->view->assign("manager_type_tbl", CommonTbl::$manager_type_tbl);
		$this->view->assign("search_obj", $search);
		$this->view->assign("managers", $managers);
		$this->view->assign("total_cnt", $total_cnt);
		$this->view->assign("navi", $page_navi);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("manager/list.tpl");
		return;
	}

	/**
	 * 管理者情報編集
	 */
	public function editAction() {

		$dao = new ManagerDao();

		// ログイン中のManagerを取得
		$login_manager = $this->getManagerSession();

		$mode = $this->request->getParam("mode");

		// Managerオブジェクトの取得
		if ($mode == "add") {

			// 登録の場合は新規に生成
			$manager_obj = new Manager();
			$manager_obj->setShopNo($login_manager->getShopNo());

		} else {
			// 変更の場合は、管理者No.より検索
			$manager_no = $this->request->getParam("manager_no");
			$manager_obj = $dao->getManager($manager_no);
		}

		$manager_obj->setInsertUserId($login_manager->getUserId());
		$manager_obj->setUpdateUserId($login_manager->getUserId());

		// 登録・変更ボタンが送信されていなければ初期画面を表示する
		if (!isset($_POST["sbm_save"])) {
			if ($mode == "add") {
				$this->view->assign("sbm_value", "登録");
			} else {
				$this->view->assign("sbm_value", "変更");
			}
		}

		// 登録・変更ボタンが送信されていればDB保存処理を行う
		if (isset($_POST["sbm_save"])) {

			// 入力データをオブジェクトに設定
			$this->setManagerPostData($manager_obj);

			// 入力チェック
			if (!$this->validate($manager_obj)) {
				$this->view->assign("mode", $mode);
				$this->view->assign("sbm_value", $command == "add" ? "登録" : "変更");
			} else {

				// 権限チェック
				if ($login_manager->getManagerType() != "super") {
					print("権限がありません");
					die;
				}
				// ショップNo.が一致するか
				if ($login_manager->getShopNo() != $manager_obj->getShopNo()) {
					print("他のショップの管理者は変更できません");
					die;
				}

				switch($mode){
					case "add": // 登録
						$manager_obj->setStatus("active");
						$manager_obj->setSystemAdmin("f");
						$ret = $dao->insert($manager_obj);
						$manager_no = $ret;
						$this->view->assign("sbm_value", "登録");
						$mode = "edit";
						break;
					case "edit": // 変更
						$ret = $dao->update($manager_obj);
						$this->view->assign("sbm_value", "変更");
						break;
				}
				if (!$ret) {
					$this->addMessage(SYSTEM_MESSAGE_ERROR, "管理者マスタの" . $this->view->get_template_vars("sbm_value") . "に失敗しました" . $dao->getAllMessages());
				} else {
					$this->addMessage(SYSTEM_MESSAGE_INFO, "管理者マスタを".$this->view->get_template_vars("sbm_value")."しました");
					$this->margeMessages($dao->getMessages());
					$this->setSessionMessage();
					$this->redirect("/manager/list");
					return;
				}
			}
		}

		// 入力フォーム画面の表示
		$this->view->assign("manager_type_tbl", CommonTbl::$manager_type_tbl);
		$this->view->assign("manager_obj", $manager_obj);
		$this->view->assign("mode", $mode);
		$this->view->assign("msg_list", $this->getMessages());

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("manager/edit.tpl");
		return;
	}

	/**
	 * パスワードを忘れた方
	 */
	public function passwordAction() {

		$commonDao=new CommonDao();
		$result=0;
		if($_POST){
			$email=$_POST[email];

			if($email==""){
				$resMsg="メールアドレスを入力してください。";
			}
			else{

				//メアドcheck
				$tmp=$commonDao->get_data_tbl("company","email",$email);
				if(!$tmp){
					$resMsg="ご入力のメールアドレスは登録されていません。";
				}
				else{

					//仮パスワード発行
					$pass=substr((md5(date("YmdD His"))), 0, 8);

					$tmp1[]="password";
					$tmp2[]=to_hash($pass);

					$commonDao->updateData("company", "password", to_hash($pass), "company_id", $tmp[0][company_id]);

					//企業の担当者にメール送信
					$this->view->assign("input_data", $tmp[0]);
					$this->view->assign("pass", $pass);

					$subject = "[" . STR_SITE_TITLE . " 法人会員様]仮パスワード発行";
					$mailBody = $this->view->fetch("mail/password.tpl");
					send_mail($email, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

					$resMsg="ご入力のメールアドレスに仮パスワードを送りました。ご確認ください。";
					$result=1;
				}
			}
		}

		$this->view->assign("result", $result);

		$this->view->assign("resMsg", $resMsg);
		$this->view->assign("email", $email);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("password.tpl");
		return;



	}


	/**
	 * POSTデータをManagerオブジェクトに格納する
	 * @param Manager $manager オブジェクト
	 */
	private function setManagerPostData(Manager $manager) {
		$manager->setManagerNo($_REQUEST["manager_no"]);
		$manager->setUserId(trim($_REQUEST["user_id"]));
		$manager->setEmail(trim($_REQUEST["email"]));
		$manager->setUserName(trim($_REQUEST["user_name"]));
		$manager->setManagerType(trim($_REQUEST["manager_type"]));

		// パスワードが変更された
		if (strlen($_REQUEST["password"]) > 1) {
			$manager->setPassword(to_hash(trim($_REQUEST["password"])));
		}
	}

	/**
	 * 入力チェック
	 * @param Manager $manager オブジェクト
	 * @return String エラーメッセージ（エラーがない場合は空文字列）
	 */
	private function validate(Manager $manager) {

		// ユーザーID重複チェック
		if ($command == "add") {
			$dao = new ManagerDao();
			$search = new ManagerSearchCondition();
			$search->setUserId($this->request->getParam("user_id"));
			$managerList = $dao->doSearch($search);
			if (count($managerList) != 0) {
				$this->addMessage(SYSTEM_MESSAGE_VALID, "入力されたユーザーIDはすでに使用されています");
			}
		}

		// 名前
		if (!strlen($manager->getUserName())) {
			$this->addMessage(SYSTEM_MESSAGE_VALID, "名前を入力してください");
		}

		// 管理者種別
		if (!strlen($manager->getManagerType())) {
			$this->addMessage(SYSTEM_MESSAGE_VALID, "管理者種別を選択してください");
		}

		if ($this->countMessage(SYSTEM_MESSAGE_VALID) > 0) {
			return false;
		}
		return true;
	}
}
?>
