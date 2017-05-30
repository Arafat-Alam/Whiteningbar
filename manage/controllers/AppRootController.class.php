<?php
/**
 * 管理画面用AppRootController
 * @author apiceuser
 *
 */
class AppRootController extends ControllerBase {

	/**
	 * コンストラクタ
	 */
	public function __construct() {

		parent::__construct();
//		require_once sprintf("%s/interface/SearchConditionInterface.class.php", MODEL_PATH);
//		require_once sprintf("%s/structure/shop/Manager.class.php", MODEL_PATH);
//		require_once sprintf("%s/dao/shop/ManagerDao.class.php", MODEL_PATH);
//		require_once sprintf("%s/condition/shop/ManagerSearchCondition.class.php", MODEL_PATH);

		require_once sprintf("%s/dao/CommonDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/CompanyDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/JobDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/MemberDao.class.php", MODEL_PATH);


		session_start();
	}

	/**
	 * ControllerBaseから継承するメソッド
	 * ※本クラスを継承したクラスでこのメソッドを継承すると上書きされるので注意！
	 * @see ControllerBase::preAction()
	 */
	public function preAction() {

		/*
		 * 運営者管理画面から法人管理画面を閲覧する
		 */

		if($_GET[am]){
			$adTmp=explode("_",$_GET[am]);
			if($adTmp[0]!=ADMIN_TO_MY){

				if($this->getManagerSession()) $this->deleteManagerSession();
				header("location:/company/error/");
				exit;
			}
			else{
				//メンバーデータを取得して、セッションにいれてしまう。
				$commonDao=new CommonDao();
				$company_id=$adTmp[1];
				$company_member=$commonDao->get_data_tbl("company","company_id", $company_id);

				$this->setManagerSession($company_member[0]);
			}
		}

		// ログインしていない場合
		if (!$this->isLogin()) {
			if ($this->controller != "manager" && $this->action != "login") {
				header("Location:  /manager/login");
			}
		}

		// ログイン中の管理者情報を設定
		$manager = $_SESSION[SHOP_MANAGER_SESSION_NAME];

		$this->view->assign("login_manager", $manager);

		// 共通メソッドの登録
		$this->view->register_function("html_escape", "html_escape");
		$this->view->register_function("get_pref_name", "get_pref_name");
	}

	/**
	 * ControllerBaseから継承するメソッド
	 * ※本クラスを継承したクラスでこのメソッドを継承すると上書きされるので注意！
	 * (non-PHPdoc)
	 * @see ControllerBase::afterAction()
	 */
	public function afterAction() {
		// メッセージを設定
		$this->view->assign("msg_list", $this->getMessages());
	}

	/**
	 * (non-PHPdoc)
	 * @see ControllerBase::isLogin()
	 */
	protected function isLogin() {
		if (!isset($_SESSION[SHOP_MANAGER_SESSION_NAME])) {
			return false;
		}
		return true;
	}

	/**
	 * ログインセッションからManagerを取得する
	 */
	protected function getManagerSession() {
		if (isset($_SESSION[SHOP_MANAGER_SESSION_NAME])) {
			return $_SESSION[SHOP_MANAGER_SESSION_NAME];
		}
		return false;
	}

	/**
	 * ログインセッションにManagerを保存する
	 * @param Manager $manager
	 */
	protected function setManagerSession($manager) {

		$_SESSION[SHOP_MANAGER_SESSION_NAME] = $manager;
	}

	/**
	 * ログインセッションを破棄する
	 */
	protected function deleteManagerSession() {
		unset($_SESSION[SHOP_MANAGER_SESSION_NAME]);
	}

	/**
	 * 共通のHTTPヘッダ＆設定を出力する
	 */
	protected function outHttpResponseHeader() {
		header('Content-Type: text/html; charset=utf-8');
		header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
		header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");
		header("Cache-Control: no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		date_default_timezone_set('Asia/Tokyo');
		mb_internal_encoding(INTERNAL_ENCODING);
	}

//フォームチェック用関数
	function check($data,$checkdata) {

		//必須チェック
		$nullRet=$this->chkNull($data,$checkdata);

		foreach($checkdata["string"] as $key => $val){
		//入力データを取得
		$input = $data[$key];
		//チェック用データの取得
		$inputmaxLen = $checkdata["maxlen"][$key];
		$inputminLen = $checkdata["minlen"][$key];
		$inputChk = $checkdata["chk"][$key];
		$inputType = $checkdata["type"][$key];
		$string = $checkdata["string"][$key];

		//入力されているものに関していチェックを行う
		if($input != ""){
			if($inputType == "text" || $inputType == "textarea"){
				$ret=0;
				$ret=$this->chkString($input, $inputChk,$inputmaxLen,$inputminLen);

				if($ret != 0){
					if($ret == 1){
						$this->addMessage($key,$string."に入力された文字数が長すぎます。".$inputmaxLen."文字以下で入力してください。");
					}elseif($ret == 5){
						$this->addMessage($key,$string."に入力された文字数が短すぎます。".$inputminLen."文字以上で入力してください。");
					}elseif($ret == 3){
						$this->addMessage($key,$string."の長さが違います。".$inputmaxLen."文字の入力です。");
					}elseif($ret == 4){
						$this->addMessage($key,$string."にタブが入っています。");
					}else{
						if($inputChk == 0){
							$this->addMessage($key,$string."は半角カナは使えません");
						}elseif($inputChk == 1){
							$this->addMessage($key,$string."は半角英数で入力してください");
						}elseif($inputChk == 3){
							$this->addMessage($key,$string."を正しく入力してください");
						}elseif($inputChk == 6){
							$this->addMessage($key,$string."は全角カタカナで入力してください");
						}elseif($inputChk == 7){
							$this->addMessage($key,$string."は全角かなで入力してください");
						}elseif($inputChk == 8){
							$this->addMessage($key,$string."に半角カナは入力できません。");
						}elseif($inputChk == 11){
							$this->addMessage($key,$string."は半角数字と｢/｣で入力してください");
						}elseif($inputChk == 12){
							$this->addMessage($key,$string."は半角数字と｢.｣で入力してください");

						}else{
							$this->addMessage($key,$string."は半角数字で入力してください");
						}
					}
				}
			}
		}
	}

		if (count($this->messages) > 0) {
			return false;
		}

		return true;

	}

	function chkNull($data,$checkdata){
		$ncnt=0;
		$NerrArr=array();
		foreach($checkdata["string"] as $key => $val){

			$y = $checkdata["nchk"][$key];
			$string = $checkdata["string"][$key];
			if($y == "1"){
				$input = trim($data[$key]);
				if($input == ""){
					$this->addMessage($key, $string."を入力してください。");

				}
			}

		}
	}

	function chkString($s, $chk,$inputmaxLen,$inputminLen){

		if($inputmaxLen>0 && mb_strlen($s,"UTF-8") > $inputmaxLen){
			return 1;
		}
		if (mb_strlen($s,"UTF-8") < $inputminLen){
			return 5;
		}

		switch($chk) {
			case 1 :  // 半角英数チェック

				$s=str_replace(" ","",$s);
	        	if (!mb_ereg("^[0-9a-zA-Z\-\_\.:/~#=&\?- ]*$",$s)){
					return 2;
				}
				return 0;
				break;
			case 2 :  // 数値チェック
				if (!mb_ereg("^[[:digit:]]+$", $s)){
					return 2;
				}
				return 0;
				break;

			case 3 :  //E-mailチェック
	       		if(!mb_ereg("^[a-zA-Z0-9!#$%&*+/=?^_{|}~.-]+\@[a-zA-Z0-9-]+\.+[a-zA-Z0-9.-]+$", $s)) {
	            	return 2;
	        	}
	        	return 0;
	        	break;
			case 5 : //郵便番号/電話番号等 数字と"-"チェック
				if (!mb_ereg("^[0-9-]*$",$s)){
            		return 2;
        		}

				return 0;
	        	break;

			case 6: //全角カナチェック

				$s=str_replace(array(" ","　"),"",$s);
				$zenkanaK = "　アイエウオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンァィゥェォヴガギグゲゴザジズゼゾダヂヅデドバビブベボパピプペポャュョッー（）・";
				for($i=0;$i<strlen($s);$i=$i+2){
					$p = strpos($zenkanaK, substr($s, $i ,2));
					if($p == FALSE){
						return 2;
					}
				}
				return 0;
				break;
			case 8: //半角カナが含まれていたらout

				if (mb_ereg('[ｱ-ﾝ]',$s)){
	            	return 2;
	        	}
				return 0;
				break;
			case 11: //数値と/
				if (!mb_ereg("^[0-9./･]*$",$s)){
	            	return 2;
	        	}
				return 0;
				break;
			case 12: //数値と.
				if (!mb_ereg("^[0-9.]*$",$s)){
					return 2;
	        	}
				return 0;
				break;

			default:
				return 0;
	        	break;

	     }

		 return 0;
	}

	//SoiteConfig取得関数
	function getConfigValue($config_key){
		$commonDao=new CommonDao();

		$tmp=$commonDao->get_sql("select config_value from site_config where config_key='" .$config_key."'");

		return $tmp[0][config_value];
	}

}
?>
