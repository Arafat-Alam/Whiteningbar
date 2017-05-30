<?php
class NewsController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

	}

	public function displayAction() {


		if(!$this->getAdminSession()){

			header("location:/");
			exit;

		}
		return;


	}


	/**
	 *   ニュース一覧
	 */
	public function listAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao= new CommonDao();

		if(isset($_POST['regist'])){
			$display_flg_change=false;
			foreach($_POST['display_flg'] as $key=>$val){
				if($val!=$_POST['display_flg_org'][$key]){
					//変更されていたら更新する
					$commonDao->updateData("news", "display_flg", $val, "news_no", $key);
					$display_flg_change=true;
				}
			}
			if($display_flg_change){
				$this->addMessage("info","お知らせの表示/非表示を切り替えました");
			}

		}
		if(isset($_POST['delete_dummy'])){

			foreach($_POST['delete_dummy'] as $key=>$val){
				//削除

				$tmp=$commonDao->get_data_tbl("news","news_no", $val);
				$nArr=$tmp[0];

				$commonDao->del_Data("news", "news_no", $val);

				//画像があれば削除する
				if($nArr['img_name']!=""){
					if(file_exists(DIR_IMG_NEWS.$nArr['img_name'])){
						unlink(DIR_IMG_NEWS.$nArr['img_name']);
					}
				}

			}
			$this->addMessage("info","チェックしたお知らせを削除しました");


		}
/*	
		//メッセージ
		if (count($this->getMessages()) >0) {

			foreach($this->getMessages() as $err_msg){
				$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
			}

			$this->view->assign("result_messages", $result_messages);
		}
*/
		$resuArr=$commonDao->get_data_tbl("news","","","news_date desc");
		// echo "<pre>"; print_r($resuArr); exit();
		$this->view->assign("resuArr", $resuArr);
		// echo date('Ymdhms');exit();
		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("news-list.tpl");

		return;

	}


	/**
	 *  登録・修正
	 */
	public function editAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao= new CommonDao();

		if (isset($_GET['news_no'])) {
			$news_no=$_GET['news_no'];
		}

		$checkData=CommonChkArray::$newsCheckData;

		if(isset($_POST['regist'])){

			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//ファイルアップ
			if(is_uploaded_file($_FILES["up_file"]["tmp_name"])){
				$temp_up_fname = date("His",time())."_".$_FILES["up_file"]["name"];//
				$_SESSION['TMP_FUP']=$temp_up_fname;
				//最初は仮フォルダに入れておく
				// copy($_FILES["up_file"]['tmp_name'],DIR_IMG_TMP.$temp_up_fname);
				copy($_FILES["up_file"]['tmp_name'],"../../public/htdocs/user_data/tmp/".$temp_up_fname);
			}
			
			//入力チェック
			$ret=!$this->check($input_data,$checkData);

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {

				if($_SESSION['TMP_FUP']){
					$input_data['img_name']=$_SESSION['TMP_FUP'];//画像
				}

				//フォーム入力用データ
				foreach($checkData['dbstring'] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$_SESSION["input_data"][$key];
				}

				//画像
				if($_SESSION['TMP_FUP']){
					$dkey[]="img_name";
					$dval[]=$_SESSION['TMP_FUP'];
				}

				//登録
				if(!$news_no){

					//新規登録
					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H:i:s");
					$dkey[]="update_date";
					$dval[]=date("Y-m-d H:i:s");

					$ret=$commonDao->InsertItemData("news",$dkey,$dval);

				}
				else{
					//変更処理

					//削除チェックがあれば消す
					if($_POST['del']){

						//削除の処理
						if(file_exists(DIR_IMG_NEWS.$_POST['del'])){
							unlink(DIR_IMG_NEWS.$_POST['del']);
						}

						$dkey[]="img_name";
						$dval[]="";
					}

					$ret=$commonDao->updateData("news", $dkey, $dval, "news_no", $news_no);
				}

				$upErrFlg="1";
				if($ret && $_SESSION['TMP_FUP']){
					//画像正式アップ
					// copy(DIR_IMG_TMP.$_SESSION['TMP_FUP'],DIR_IMG_NEWS.$_SESSION['TMP_FUP']);
					copy("../../public/htdocs/user_data/tmp/".$_SESSION['TMP_FUP'],"../../public/htdocs/user_data/img_news/".$_SESSION['TMP_FUP']);
					unlink("../../public/htdocs/user_data/tmp/".$_SESSION['TMP_FUP']);

/*					//リサイズ
							//画像別サイズ作成
							$photoArr=CommonArray::$photo_array;
							$photoWArr=CommonArray::$photoW_array;
							$photoHArr=CommonArray::$photoH_array;
							$moto=DIR_IMG_NEWS.$_SESSION['TMP_FUP'];

							foreach($photoArr as $key=>$val){
								$newDir=DIR_IMG_NEWS.$val."_".$_SESSION['TMP_FUP'];
								resize_image($moto,$newDir,$photoWArr[$key],$photoHArr[$key]);
							}
*/

				}else if(!$ret){

					$upErrFlg=99;

				}

				if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
				if($_SESSION['TMP_FUP']) unset($_SESSION['TMP_FUP']);

				header("location:/news/list/");
				exit;

			}


		}
		else if(isset($_REQUEST['news_no'])){

			if(isset($_SESSION["input_data"]))  unset($_SESSION["input_data"]);
			if(isset($_SESSION['TMP_FUP']))		unset($_SESSION['TMP_FUP']);


			//データ取得
			$ret=$commonDao->get_data_tbl("news","news_no",$news_no);
			$input_data=$ret[0];



		}
		else{

			//表示デフォルト
			$input_data['news_flg']=1;
			$input_data['display_flg']=1;
			$input_data['news_date']=date("Y/m/d" );


			if(isset($_SESSION["input_data"]))  unset($_SESSION["input_data"]);
			if(isset($_SESSION['TMP_FUP'])) 	unset($_SESSION['TMP_FUP']);

		}
		if (isset($upErrFlg)) {
			$this->view->assign("upErrFlg", $upErrFlg);
		}
		$this->view->assign("input_data", $input_data);

		$this->setTemplatePath("news-edit.tpl");
		return;

	}


}
?>


