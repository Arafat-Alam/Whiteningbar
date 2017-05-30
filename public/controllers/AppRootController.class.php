<?php
/**
 * 公開画面用AppRootController
 * @author apiceuser
 *
 */
class AppRootController extends ControllerBase {

	private $redirect_path;
	private $configs;
	private $keywords;
	private $description;
	private $title;

	/**
	 * コンストラクタ
	 */
	public function __construct() {

		parent::__construct();

		require_once sprintf("%s/dao/MemberDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/CommonDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/ReserveDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/ShopDao.class.php", MODEL_PATH);

		session_start();


	}

	/**
	 * カートセッションチェック
	 */
	protected function checkCartSessionTime() {
		if (isset($_SESSION[CART_SESSION_NAME])) {
			$s = $_SESSION[CART_SESSION_NAME]["time"];
			$e = time();

			// 60分経過していたら、SESSIONを破棄してカート画面へリダイレクトする
			if ($e-$s > 60*60) {
				unset($_SESSION[CART_SESSION_NAME]);
				$this->redirect("/cart/list");
				return;
			}
		}
	}

	/**
	 * ControllerBaseから継承するメソッド
	 * ※本クラスを継承したクラスでこのメソッドを継承すると上書きされるので注意！
	 * @see ControllerBase::preAction()
	 */
	public function preAction() {


		if($_SERVER["SERVER_NAME"]==DUMMY_ROOT_URL){
			header("location:".LOCATION_ROOT_URL.$_SERVER['REQUEST_URI']);
			exit;
		}

		$commonDao=new CommonDao();
		$dao = new MemberDao();

		$member=$this->getMemberSession();

    	// 会員ログイン中
		if (isset($_SESSION[MEMBER_SESSION_NAME])) {
			$member = $_SESSION[MEMBER_SESSION_NAME];
			$this->view->assign("login_member", $member);

		}

		//スタイルシート選択
		$tmp=$commonDao->get_data_tbl("site_config","config_key","site_color");
		$ColorArr=CommonArray::$siteColorFile_array;
		$cssFileName=$ColorArr[$tmp[0][config_value]];
		$this->view->assign("cssFileName", $cssFileName);


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
		$this->view->assign("messages", $this->getMessages());
	}

	/**
	 * (non-PHPdoc)
	 * @see ControllerBase::isLogin()
	 */
	protected function isLogin() {
		if (!isset($_SESSION[MEMBER_SESSION_NAME])) {
			return false;
		}
		return true;
	}

	/**
	 * ログインチェック(ログインしていない場合はログインページへ飛ばす)
	 */
	protected function loginCheck() {
		if (!$this->isLogin()) {
			header("Location:  /");
		}
	}

	/**
	 * ログインセッションからMemberを取得する
	 */
	protected function getMemberSession() {
		if (isset($_SESSION[MEMBER_SESSION_NAME])) {
			return $_SESSION[MEMBER_SESSION_NAME];
		}
		return false;
	}

	/**
	 * ログインセッションにMemberを保存する
	 * @param Member $member
	 */
	protected function setMemberSession($member) {

		$_SESSION[MEMBER_SESSION_NAME] = $member;//変更禁止
		$_SESSION[MEMBER_SESSION_FBID] = $member;
	}

	/**
	 * ログインセッションを破棄する
	 */
	protected function deleteMemberSession() {
		unset($_SESSION[MEMBER_SESSION_NAME]);
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

	public function getRedirectPath() {
		$redirect_path = null;
		if (isset($_SESSION["redirect_path"])) {
			$redirect_path = unserialize($_SESSION["redirect_path"]);
			unset($_SESSION["redirect_path"]);
		}
		return $redirect_path;
	}

	public function setRedirectPath($redirect_path) {
	    $_SESSION["redirect_path"] = serialize($redirect_path);
	}

	/**
	 * システム設定値を取得する
	 * @param String $config_key
	 */
	public function getSiteConfigValue($config_key) {
		foreach ($this->configs as $config) {
			if ($config->getConfigKey() == $config_key) {
				return $config->getConfigValue();
			}
		}
		return null;
	}

	public function getKeywords(){
	    return $this->keywords;
	}

	public function setKeywords($keywords){
	    $this->keywords = $keywords;
	    $this->view->assign("keywords", $this->keywords);
	}

	public function getDescription(){
	    return $this->description;
	}

	public function setDescription($description){
	    $this->description = $description;
	    $this->view->assign("description", $this->description);
	}

	public function getTitle(){
	    return $this->title;
	}

	public function setTitle($title){
	    $this->title = $title;
	    $this->view->assign("title", $this->title);
	}

	//広告を取得（サイドバー）
	public function getAd(){

		$adDao=new AdDao();

		//TOP右
		$search=array();
		$search["p_point"]=0;
		$search["v_point"]=0;
		$toprightAdArr=$adDao->getAdList($search);

		//TOP左
		$search=array();
		$search["p_point"]=0;
		$search["v_point"]=1;
		$topleftAdArr=$adDao->getAdList($search);

		//下層右
		$search=array();
		$search["p_point"]=1;
		$search["v_point"]=0;
		$subleftAdArr=$adDao->getAdList($search);

		//下層右
		$search=array();
		$search["p_point"]=1;
		$search["v_point"]=1;
		$subrightAdArr=$adDao->getAdList($search);

		return array($toprightAdArr,$topleftAdArr,$subrightAdArr,$subleftAdArr);

	}



//フォームチェック用関数
	function check($data,$checkdata) {

		//必須チェック
		$nullRet=$this->chkNull($data,$checkdata);

		foreach($checkdata["string"] as $key => $val){
		//入力データを取得
		$input = $data[$key];
		//チェック用データの取得
		$inputmaxLen = $checkdata["max"][$key];
		$inputminLen = $checkdata["min"][$key];
		$inputChk = $checkdata["chk"][$key];
		$inputType = $checkdata["type"][$key];
		$string = $checkdata["string"][$key];

		//入力されているものに関していチェックを行う
		if($input != ""){
			if($inputType == "text" || $inputType == "textarea"){
				$ret=0;
				$ret=chkString($input, $inputChk,$inputmaxLen,$inputminLen);

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

					if($checkdata["type"][$key]=="radio" || $checkdata["type"][$key]=="check"){
						$this->addMessage($key, $string."にチェックしてください。");
					}
					else if($checkdata["type"][$key]=="pull"){
						$this->addMessage($key, $string."を選択してください。");
					}
					else{
						$this->addMessage($key, $string."を入力してください。");
					}
				}
			}

		}
	}

	//====-- ホワイトニングBarスペシャル

	//------ 予約情報から予約可能かチェックするための
	function chkReserve($reserve_datail){

		$commonDao = new CommonDao();
		$reserveDao = new ReserveDAO();

		//ご希望コースの所要時間
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_datail[menu_no]);
		$rtimes=$tmp[0][times];//所要時間
		$input_data[use_count]=$tmp[0][use_count];//ご希望メニューが何回分のチケットを使うか


		$rsv_date=explode("/",$reserve_datail[reserve_date]);
		if($reserve_datail[end_time]){
			$ins[end_time]=$reserve_datail[end_time];
		}
		else{
			$endTmp=explode(":", $reserve_datail[start_time]);
			$ins[end_time]=date("H:i",mktime($endTmp[0],$endTmp[1]+$rtimes,0,$rsv_date[1],$rsv_date[2],$rsv_date[0]));
			$reserve_datail[end_time]=$ins[end_time];
		}


		$ins[shop_no]=$reserve_datail[shop_no];
		$ins[reserve_date]=$reserve_datail[reserve_date];
		$ins[start_time]=$reserve_datail[start_time];
		$ins[number]=$reserve_datail[number];

		//店舗のブース数
		$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins[shop_no],"booth"));
		$shop_booth_cnt=$tmp[0][attr_value];


		//新規予約の場合は、単に予約時間から予約数をチェック
		//予約済みで詳細番号がある場合の変更は、自分の番号から予約番号を出して、自分の予約番号以外の予約数をカウント。ブース数から予約数を引いて、自分の希望数が
		//残りの枠に入るようならOK.

		if(isset($reserve_datail[detail_no])){
			$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",key($reserve_datail[detail_no]));
			$ins[reserve_no]=$tmp[0][reserve_no];
//			$ima_number=$tmp[0][number];

			$ret=$reserveDao->getReserveExistCount($ins,$shop_booth_cnt);
			if(!$ret){
				return array(false,$reserve_datail);
			}

/*
			//$reserve_count_s=$reserveDao->getReserveExistCount($ins,"start");
			$reserve_count_s=$reserveDao->getReserveExistCount($ins,$shop_booth_cnt);
			if($shop_booth_cnt-$reserve_count_s<$reserve_datail[number]){
				return array(false,$reserve_datail);
			}
*/

/*
			$reserve_count_s=$reserveDao->getReserveExistCount($ins,"start");
			$reserve_count_e=$reserveDao->getReserveExistCount($ins,"end");

			if($shop_booth_cnt-$reserve_count_s<$reserve_datail[number] || $shop_booth_cnt-$reserve_count_e<$reserve_datail[number]){
				return array(false,$reserve_datail);
			}
*/

		}
		else{
			//-----新規予約の場合のチェック -----------------------

			//予約希望時間帯現在の予約数
			$ret=$reserveDao->getReserveCount($ins,$shop_booth_cnt);
			if(!$ret){
				return array(false,$reserve_datail);
			}


//			if($shop_booth_cnt<($reserve_datail[number]+$reserve_count)){
//				return array(false,$reserve_datail);
//			}


/*
			//開始時と終了時共にブースの余裕があればOK
			$reserve_count_s=$reserveDao->getReserveCount($ins,"start");
			$reserve_count_e=$reserveDao->getReserveCount($ins,"end");

			if($shop_booth_cnt<($reserve_datail[number]+$reserve_count_s+$reserve_count_e)){
				return array(false,$reserve_datail);
			}

			if($shop_booth_cnt<($reserve_datail[number]+$reserve_count_s) || $shop_booth_cnt<($reserve_datail[number]+$reserve_count_e)){
//				return array(false,$reserve_datail);
			}
*/
		}

		return array(true,$reserve_datail);

	}
}
?>