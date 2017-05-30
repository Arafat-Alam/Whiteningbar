<?php
class AdminController extends AppRootController {

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

    		$commonDao = new CommonDao();
    		$commonDao->set_db();
    		$search['status']="active";
    		$search['user_id']=$this->request->getParam("user_id");
    		$search['password']=to_hash($this->request->getParam("password"));
    		$admin_list = $commonDao->get_data_tbl2("site_administrators",$search);    		

/*
    		$search = new SiteAdminSearchCondition();
    		$search->setStatus("active");
    		$search->setUserId($this->request->getParam("user_id"));
    		$search->setPassword($this->request->getParam("password"));
    		$admin_dao = new SiteAdminDao();
			$admin_list = $admin_dao->doSearch($search);
*/
			if (count($admin_list) != 0) {
				$admin = $admin_list[0];
				$this->setAdminSession($admin);

				//アフィリエイト用であれば、アフィリエイト画面に飛ばす
				$login_admin = $this->getAdminSession();
				if($login_admin['shop_no']=="-2"){

					header("location:/affiliate/list/");
					exit;
				}


				header("Location: /index/display");
				exit;
			}
			else {
				$this->view->assign("user_id", $this->request->getParam("user_id"));
				$this->view->assign("msg", "ユーザーIDまたはパスワードが一致しません。");
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
		$this->deleteAdminSession();
		header("Location:  /admin/login");
	}

	/**
	 * 管理者一覧表示
	 */
	public function listAction() {
		$search = '';
		$dao = new SiteAdminDao();
		$commonDao=new CommonDao();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		//検索
		if (isset($_POST["sbm_search"])) {


			$search['status']=$_POST['status'];
			$search['user_name']=$_POST['user_name'];
			$search['shop_no']=$_POST['shop_no'];
			$search['reserve_auth_type']=$_POST['reserve_auth_type'];
			$search['member_auth_type']=$_POST['member_auth_type'];
			$search['page']=1;

//			$_SESSION[search_condition]=$search;

			$this->view->assign("search", $search);

		}
/*
		if(isset($_POST[sbm_save])){

			$mode = $_REQUEST["mode"];
			$op = "登録";
			$admin_obj=$_POST;

			//入力チェック
			$checkData=CommonChkArray::$adminNewCheckData;


			//入力チェック
			$ret=!$this->check($admin_obj,$checkData);


			//ユーザーID重複チェック
			if($mode=="add"){
				$ret=$commonDao->get_data_tbl("site_administrators","user_id",$admin_obj[user_id]);
				if($ret){
					$this->addMessage("error", "入力されたログインIDはすでに使用されています");
				}
			}

			if (count($this->getMessages()) >0) {
				$this->setSessionMessage();

				//$this->view->assign("result_messages", $result_messages);
			}
			else {

				foreach($checkData[dbstring] as $key=>$val){
					$ins[$key]=$admin_obj[$key];
				}

				if($mode=="add" || $mode!="add" && $admin_obj[password]!=""){
					$ins[password]=to_hash(trim($admin_obj["password"]));
				}
				if($mode=="add"){
					//新規登録
					$ins[status]="active";
					$commonDao->InsertItemData2("site_administrators",$ins);

				}
				else{
					$op = "更新";
					$admin_no = $_REQUEST["admin_no"];
					//$admin_obj = $dao->getAdmin($admin_no);

					$uwhere[admin_no]=$admin_no;
					$commonDao->updateData2("site_administrators",$ins,$uwhere);
				}

				$this->addMessage("info", "サイト管理者を" . $op . "しました");
				$this->margeMessages($dao->getMessages());
				$this->setSessionMessage();
				$admin_obj=array();
				$admin_obj[admin_type]="admin";
				$mode="add";
			}

		}
		else
*/
		if(isset($_REQUEST["admin_no"])){

			$admin_obj = $dao->getAdmin($_REQUEST["admin_no"]);
			$mode = "update";

		}
		else{
			//デフォルトチェック
			$admin_obj['reserve_auth_type']="0";
			$admin_obj['member_auth_type']="0";
			$admin_obj['status']="active";

			$mode = "add";

		}

//
		//権限
		$admintypeArr=CommonArray::$adminType_array;
		$this->view->assign("admintypeArr", $admintypeArr);

		//店舗選択に追加する候補群
		$addArr=CommonArray::$adminShopType_array;


		//---------- 検索 管理一覧--------------------------------------------

		if($login_admin['shop_no']>0){
			$search['shop_no']=$login_admin['shop_no'];
		}


		$admins = $dao->doSearch($search);
		for($i=0;$i<count($admins);$i++){
			//店舗
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$admins[$i]['shop_no']);
			if($tmp){
				$admins[$i]['shop_name']=$tmp[0]['name'];
			}
			else{
				$admins[$i]['shop_name']=$addArr[$admins[$i]['shop_no']];
			}

			//権限
			@$admins[$i]['reserve_auth_type_str']=$admintypeArr[$admins[$i]['reserve_auth_type']];
			@$admins[$i]['member_auth_type_str']=$admintypeArr[$admins[$i]['member_auth_type']];

		}
		// echo "<pre>"; print_r($admins);
		$this->view->assign("admins", $admins);


		//店舗
		if($login_admin['shop_no']>0){
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$login_admin['shop_no']);
			$shopArr=makePulldownTableList($tmp,"shop_no","name");
		}
		else{
			$tmp=$commonDao->get_data_tbl("shop");
			$shopTmpArr=makePulldownTableList($tmp,"shop_no","name");
			//店舗に追加
			$shopArr=$addArr+$shopTmpArr;

		}

		//編集用
		$this->view->assign("shopArr", $shopArr);

		//検索用
		$noArr[""]="";
		$shopArr=$noArr+$shopArr;
		$this->view->assign("shopSearchArr", $shopArr);


		$this->view->assign("admin_obj", $admin_obj);
		$this->view->assign("mode", $mode);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("admin/list.tpl");
		return;
	}

	/**
	 * 管理者情報登録・更新
	 */
	public function editAction() {

		$dao = new SiteAdminDao();
		$commonDao=new CommonDao();

		// ログイン中のAdminを取得
		$admin = $this->getAdminSession();

		$mode = $_REQUEST["mode"];
//		$op = "登録";


//		if(isset($_POST[sbm_save])){

			$mode = $_REQUEST["mode"];
			$op = "登録";
			$admin_obj=$_POST;
			$_SESSION['admin_obj']=$admin_obj;

			//入力チェック
			$checkData=CommonChkArray::$adminNewCheckData;

			//入力チェック
			$ret=!$this->check($admin_obj,$checkData);


			//ユーザーID重複チェック
			if($mode=="add"){
				$ret=$commonDao->get_data_tbl("site_administrators","user_id",$admin_obj['user_id']);
				if($ret){
					$this->addMessage("error", "入力されたユーザーIDはすでに使用されています");
				}
			}

			if (count($this->getMessages()) >0) {
				$this->setSessionMessage();

				$this->redirect("/admin/list/");

				//$this->view->assign("result_messages", $result_messages);
			}
			else {

				foreach($checkData['dbstring'] as $key=>$val){
					$ins[$key]=$admin_obj[$key];
				}

				if($mode=="add" || $mode!="add" && $admin_obj['password']!=""){
					$ins['password']=to_hash(trim($admin_obj["password"]));
				}
				if($mode=="add"){
					//新規登録
					$ins['status']="active";
					$commonDao->InsertItemData2("site_administrators",$ins);

				}
				else{
					$op = "更新";
					$admin_no = $_REQUEST["admin_no"];
					//$admin_obj = $dao->getAdmin($admin_no);

					$uwhere['admin_no']=$admin_no;
					$commonDao->updateData2("site_administrators",$ins,$uwhere);
				}

				if($_SESSION['admin_obj']) unset($_SESSION['admin_obj']);

				$this->addMessage("info", "サイト管理者を" . $op . "しました");
				$this->margeMessages($dao->getMessages());
				$this->setSessionMessage();
				$this->redirect("/admin/list/");


/*
				$this->margeMessages($dao->getMessages());
				$this->setSessionMessage();
				$admin_obj=array();
				$admin_obj[admin_type]="admin";
				$mode="add";
*/
			}

//		}
/*
		else if(isset($_REQUEST["admin_no"])){

			$admin_obj = $dao->getAdmin($_REQUEST["admin_no"]);
			$mode = "update";

		}
		else{

			$admin_obj[admin_type]="admin";

		}

		$admins = $dao->doSearch($search);
		$this->view->assign("admins", $admins);

		$this->view->assign("admin_obj", $admin_obj);
		$this->view->assign("mode", $mode);

		//
		$admintypeArr=CommonArray::$adminType_array;
		$this->view->assign("admintypeArr", $admintypeArr);

		//店舗
		//登録中のコース
		$tmp=$commonDao->get_data_tbl("shop");
		$shopTmpArr=makePulldownTableList($tmp,"shop_no","name");

		$addArr[0]="本部";
		$addArr[-1]="その他";
		$shopArr=array_merge($addArr,$shopTmpArr);

		$this->view->assign("shopArr", $shopArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("admin/edit.tpl");
		return;
*/
		return ;
	}

	/**
	 * リスト更新
	 */
	public function bulkUpdateAction() {

		// ログイン中のAdminを取得
		$admin = $this->getAdminSession();

		$commonDao=new CommonDao();

		//無効
		$commonDao->updateData("site_administrators", "status","active","","");
		if($_POST['disabled_dummy']){
			foreach($_POST['disabled_dummy'] as $key=>$val){
				//無効処理
								//無効処理
				if($admin[admin_no]==$val){
					$this->addMessage("error", "自分自身を無効する事はできません");
					$this->setSessionMessage();
					$this->redirect("/admin/list");
					return;
				}
				else{

					$commonDao->updateData("site_administrators", "status","disabled","admin_no",$val);
				}
			}
		}

		//削除
		if($_POST['delete_dummy']){
			foreach($_POST['delete_dummy'] as $key=>$val){
				//無効処理
				if($admin[admin_no]==$val){
					$this->addMessage("error", "自分自身を削除することはできません");
					$this->setSessionMessage();
					$this->redirect("/admin/list");
					return;
				}
				else{

					$commonDao->del_Data("site_administrators", "admin_no",$val);

				}

			}
		}


		$this->addMessage(SYSTEM_MESSAGE_INFO, "管理者一覧を更新しました");
		$this->setSessionMessage();
		$this->redirect("/admin/list");
		return;
	}

	/**
	 * POSTデータをSiteAdminオブジェクトに格納する
	 * @param SiteAdmin $admin
	 */
	private function setAdminPostData(SiteAdmin $admin) {
		$admin->setAdminNo($_REQUEST["admin_no"]);
		$admin->setUserId(trim($_REQUEST["user_id"]));
		$admin->setEmail(trim($_REQUEST["email"]));
		$admin->setUserName(trim($_REQUEST["user_name"]));
		$admin->setAdminType(trim($_REQUEST["admin_type"]));

		// パスワードがsubmitされた場合は変更する
		if (strlen($_REQUEST["password"]) > 0) {
			$admin->setPassword(to_hash(trim($_REQUEST["password"])));
		}
	}

	/**
	 * 入力チェック
	 * @param SiteAdmin $admin
	 * @return String エラーメッセージ（エラーがない場合は空文字列）
	 */
	private function validate(SiteAdmin $admin) {

		// ユーザーID重複チェック
		$dao = new SiteAdminDao();
		//$search = new SiteAdminSearchCondition();
		$search = new SiteAdmin();
		$search->setUserId($admin->getUserId());
		$search->setAdminNoNotIn($admin->getAdminNo());
		$admin_list = $dao->doSearch($search);
		if (count($admin_list) != 0) {
			$this->addMessage(SYSTEM_MESSAGE_VALID, "入力されたユーザーIDはすでに使用されています");
		}

		// 名前
		if (!strlen($admin->getUserName())) {
			$this->addMessage(SYSTEM_MESSAGE_VALID, "名前を入力してください");
		}

		// 管理者種別
		if (!strlen($admin->getAdminType())) {
			$this->addMessage(SYSTEM_MESSAGE_VALID, "管理者種別を選択してください");
		}

		if ($this->countMessage(SYSTEM_MESSAGE_VALID) > 0) {
			return false;
		}
		return true;
	}


	/**
	 * パスワードを忘れた方
	 */
	public function passwordAction() {

		$commonDao=new CommonDao();

		if($_POST){
			$email=$_POST['email'];
			$user_id=$_POST['user_id'];


			if($email=="" || $user_id==""){

				$this->addMessage("error", "ユーザーIDとメールアドレスは両方、入力してください。");

			}
			else{

				//メアドcheck
				$tmp=$commonDao->get_data_tbl("site_administrators","email",$email);
				if(!$tmp){
					$this->addMessage("error", "ご入力のメールアドレスは登録されていません。");
					$err=1;
				}
				else{
					$tmp=$commonDao->get_data_tbl("site_administrators","user_id",$user_id);
					if(!$tmp){
						$this->addMessage("error", "ご入力のユーザーIDは登録されていません。");
						$err=1;
					}
				}

				if($err!=1){
					$tmp=$commonDao->get_data_tbl("site_administrators",array("email","user_id"),array($email,$user_id));
					if(!$tmp){
						$this->addMessage("error", "ご入力のユーザーIDとメールアドレスが間違っています。");
					}
					else {

						//仮パスワード発行
						$pass=substr((md5(date("YmdD His"))), 0, 8);

						$tmp1[]="password";
						$tmp2[]=to_hash($pass);

						$commonDao->updateData("site_administrators", "password", to_hash($pass), "admin_no", $tmp[0]['admin_no']);

						//メール送信
						$this->view->assign("input_data", $tmp[0]);
						$this->view->assign("pass", $pass);

						$subject = "[" . STR_SITE_TITLE . "]仮パスワード発行";
						$mailBody = $this->view->fetch("mail/password.tpl");
						send_mail($email, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

						$this->setTemplatePath("admin/password_fini.tpl");
						return;
					}
				}
			}
		}

		$this->view->assign("email", $email);
		$this->view->assign("user_id", $user_id);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("admin/password.tpl");
		return;
	}

	/**
	 *
	 * 会員登録
	 * 必須項目の設定
	 * ※ユーザー側からの登録のみ
	 *
	 */
	public function member_requireAction() {

		$commonDao=new CommonDao();


		if($_POST['regist']){

			foreach($_POST['req_flg'] as $key=>$val){

				$fi['req_flg']=$val;
				$wfi['no']=$key;

				$ret=$commonDao->updateData2("member_require", $fi, $wfi);
				if(!$ret){
					break;
				}
			}

			if($ret){
					$this->addMessage("info","必須項目の設定が完了しました");

			}
			else{
				$this->addMessage("info","必須項目の設定に失敗しました");

			}

		}


		$arr=$commonDao->get_data_tbl("member_require","","","no");

		$this->view->assign("arr", $arr);


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("admin/member_require.tpl");
		return;


	}


}
?>
