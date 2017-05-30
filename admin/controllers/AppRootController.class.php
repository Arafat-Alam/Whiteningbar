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
		require_once sprintf("%s/dao/SiteAdminDao.class.php", MODEL_PATH);

		require_once sprintf("%s/dao/CommonDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/MemberDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/Category1Dao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/Category2Dao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/ShopDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/ReserveDao.class.php", MODEL_PATH);

		session_start();
	}

	/**
	 * ControllerBaseから継承するメソッド
	 * ※本クラスを継承したクラスでこのメソッドを継承すると上書きされるので注意！
	 * @see ControllerBase::preAction()
	 */
	public function preAction() {

		// ログインしていない場合




		//arafat
		/*if (!$this->isLogin()) {
			if ($this->controller != "admin" && $this->action != "login") {
				header("Location:  /admin/login");
			}
		}*/

		// ログイン中の管理者情報を設定
		//$admin = $_SESSION['SITE_ADMIN_SESSION_NAME'];
		//$this->view->assign("login_admin", $admin);

		// 共通メソッドの登録
		//$this->view->register_function("html_escape", "html_escape");
		//arafat


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
		if (!isset($_SESSION['SITE_ADMIN_SESSION_NAME'])) {
			return false;
		}
		return true;
	}

	/**
	 * ログインセッションからSiteAdminを取得する
	 */
	protected function getAdminSession() {
		if (isset($_SESSION['SITE_ADMIN_SESSION_NAME'])) {
			return $_SESSION['SITE_ADMIN_SESSION_NAME'];
		}
		header("location: /admin/login/");
		return false;
	}

	/**
	 * ログインセッションにSiteAdminを保存する
	 * @param SiteAdmin $admin
	 */
	protected function setAdminSession($admin = null) {

		$_SESSION['SITE_ADMIN_SESSION_NAME'] = $admin;

		/*$admin = array(
		'0' => '1',
		'admin_no' => '1',
		'1' => 'admin',
		'user_id' => 'admin',
		'2' => 'f4f91a6538d92db0243421e2e62f921ce4a775a7d279d0bdd60e0b8b335f1ad0',
		'password' => 'f4f91a6538d92db0243421e2e62f921ce4a775a7d279d0bdd60e0b8b335f1ad0',
		'3' => 'yokoyama@pbeldad.com',
		'email' => 'yokoyama@pbeldad.com',
		'4' => '管理者',
		'user_name' => '管理者',
		'5' => 'admin',
		'admin_type' => 'admin',
		'6' => 'active',
		'status' => 'active',
		'7' => '0',
		'shop_no ' => '0',
		'8' => '0',
		'reserve_auth_type' => '0',
		'9' => '0',
		'member_auth_type' => '0',
		'10' => '',
		'insert_date' => '',
		'11' => '2013-04-12 09:33:58',
		'update_date' => '2013-04-12 09:33:58'
		);*/
	}

	/**
	 * ログインセッションを破棄する
	 */
	protected function deleteAdminSession() {
		unset($_SESSION['SITE_ADMIN_SESSION_NAME']);
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
		@$nullRet = $this->chkNull($data,$checkdata);

	
		foreach($checkdata["string"] as $key => $val){
		//入力データを取得
		@$input = $data[$key];
		//チェック用データの取得
		@$inputmaxLen = $checkdata["max"][$key];
		@$inputminLen = $checkdata["min"][$key];
		@$inputChk = $checkdata["chk"][$key];
		@$inputType = $checkdata["type"][$key];
		@$string = $checkdata["string"][$key];

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
		// echo "<pre>";print_r($checkdata);
			$string = $checkdata["string"][$key];
			if($y == "1"){
				@$input = trim($data[$key]);

				if($input == ""){
					$this->addMessage($key, $string."を入力してください。");

				}
			}

		}
	}

	//SoiteConfig取得関数
	function getConfigValue($config_key){
		$commonDao = new CommonDao();

		$db_conne = CommonArray::$ecm_db_array;
		$commonDao->set_db($db_conne);

		// $tmp=$commonDao->get_sql("select config_value from site_config where config_key='" .$config_key."'");
		$tmp=$commonDao->get_sql("select config_value from site_config where config_key='5'");

		return $tmp[0]['config_value'];
	}


	//====-- ホワイトニングBarスペシャル

	//------ 予約情報から予約可能かチェックするための
	function chkReserve($reserve_datail){
		$commonDao = new CommonDao();
		$reserveDao = new ReserveDAO();

		//ご希望コースの所要時間
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_datail['menu_no']);
		$rtimes=$tmp[0]['times'];//所要時間
		$reserve_datail['use_count']=$tmp[0]['use_count'];//ご希望メニューが何回分のチケットを使うか

		$rsv_date=explode("/",$reserve_datail['reserve_date']);
		if(count($rsv_date)!=3){
			$rsv_date=explode("-",$reserve_datail['reserve_date']);
		}
		$ins['end_time']=date("H:i:00",mktime($reserve_datail['hour'],$reserve_datail['minute']+$rtimes,0,$rsv_date[1],$rsv_date[2],$rsv_date[0]));//menuと希望期間から終了時間を出す
		$r_date=mktime($reserve_datail['hour'],$reserve_datail['minute']+$rtimes,0,$rsv_date[1],$rsv_date[2],$rsv_date[0]);//終了時間を出す
		if(!isset($reserve_datail['end_time'])){
				$reserve_datail['end_time']=$ins['end_time'];
		}

		$ins['shop_no']=$reserve_datail['shop_no'];
		$ins['reserve_date']=$reserve_datail['reserve_date'];
		$ins['start_time']=$reserve_datail['hour'].":".$reserve_datail['minute'];
		$ins['number']=$reserve_datail['number'];

		//店舗のブース数
		$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins['shop_no'],"booth"));
		$shop_booth_cnt=$tmp[0]['attr_value'];

		//店舗の営業終了時間とコース終了時間で比較する
				//------------ 店舗の営業終了時間からメニューの所要時間を引く。その時間を超える予約時間は表示させない。--------------
				//そして、営業開始時間前の時間は表示させない。
				//$youbi=date(N);//月曜を1とする日付数値
				$youbi=date("w",mktime(0,0,0,$rsv_date[1],$rsv_date[2],$rsv_date[0]));
				$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins['shop_no'],"to_".$youbi."_h"));
				if(isset($tmpH[0]['attr_value']) && $tmpH[0]['attr_value']!=""){//曜日の営業時間設定がある場合
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins['shop_no'],"to_".$youbi."_m"));
				}
				else{
					$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins['shop_no'],"to_def_h"));
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins['shop_no'],"to_def_m"));
				}
				$aaa=mktime($tmpH[0]['attr_value'], $tmpM[0]['attr_value'],0,$rsv_date[1],$rsv_date[2],$rsv_date[0]);
				if($aaa<$r_date){
					//$this->addMessage("reserve_time", "ご予約希望日時は店舗の営業時間を過ぎてしまうため、ご予約できません");
					return array(false,$reserve_datail);
        		}

//		$tmp=$commonDao->get_data_tbl2("member_reserve_detail",$ins);

		//新規予約の場合は、単に予約時間から予約数をチェック
		//予約済みで詳細番号がある場合の変更は、自分の番号から予約番号を出して、自分の予約番号以外の予約数をカウント。ブース数から予約数を引いて、自分の希望数が
		//残りの枠に入るようならOK.
		if(isset($reserve_datail['no']) && $reserve_datail['no']>0){

			$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$reserve_datail['no']);
			$ins['reserve_no']=$tmp[0]['reserve_no'];
//			$ima_number=$tmp[0]['number'];

			$ret=$reserveDao->getReserveExistCount($ins,$shop_booth_cnt);
			if(!$ret){
				return array(false,$reserve_datail);
			}

/*
			$reserve_count_s=$reserveDao->getReserveExistCount($ins,"start");
			$reserve_count_e=$reserveDao->getReserveExistCount($ins,"end");

			if($shop_booth_cnt-$reserve_count_s<$reserve_datail['number'] || $shop_booth_cnt-$reserve_count_e<$reserve_datail['number']){
				return array(false,$reserve_datail);
			}
*/
		}
		else{
			//-----新規予約の場合のチェック -----------------------

			//予約希望時間帯現在の予約数

			//予約希望時間帯現在の予約数
			$ret=$reserveDao->getReserveCount($ins,$shop_booth_cnt);
			if(!$ret){
				return array(false,$reserve_datail);
			}

/*
			$reserve_count=$reserveDao->getReserveCount($ins,"");

			if($shop_booth_cnt<($reserve_datail['number']+$reserve_count)){
				return array(false,$reserve_datail);
			}
*/
/*
			$reserve_count_s=$reserveDao->getReserveCount($ins,"start");
			$reserve_count_e=$reserveDao->getReserveCount($ins,"end");

			if($shop_booth_cnt<($reserve_datail['number']+$reserve_count_s+$reserve_count_e)){
				return array(false,$reserve_datail);
			}
*/
/*
			if($shop_booth_cnt<($reserve_datail['number']+$reserve_count_s) || $shop_booth_cnt<($reserve_datail['number']+$reserve_count_e)){
				return array(false,$reserve_datail);
			}
*/
		}

		return array(true,$reserve_datail);

	}




}
?>
