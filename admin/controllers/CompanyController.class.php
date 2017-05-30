<?php
class CompanyController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();


/*
		require_once sprintf("%s/structure/member/Member.class.php", MODEL_PATH);
		require_once sprintf("%s/structure/member/MemberPassword.class.php", MODEL_PATH);
		require_once sprintf("%s/structure/member/MemberExtAttr.class.php", MODEL_PATH);
		require_once sprintf("%s/condition/member/MemberSearchCondition.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/member/MemberDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/member/MemberPasswordDao.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/member/MemberExtAttrDao.class.php", MODEL_PATH);
*/


	}

	/**
	 *  法人一覧表示・検索
	 */
	public function listAction() {

		$search = null;
		$search_flag = false;
		$limit=ADMIN_V_CNT;

		$dao = new OwnerDAO();
		$commonDao = new CommonDao();

		//凍結/開始処理
		if($_POST[stop_dummy]){

			foreach($_POST[stop_dummy] as $key=>$val){
				//削除
				$ret=$commonDao->updateData("owner","stat",$val,"owner_id",$key);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("info","更新エラーがあります。");
			}
			else{
				$this->addMessage("info","更新しました");
			}
		}

		//削除処理
		if($_POST[delete_dummy]){

			foreach($_POST[delete_dummy] as $key=>$val){
				//削除
				$ret=$dao->delData($val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("info","オーナー削除エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックしたオーナーを削除しました");
			}
		}
		$page = $_REQUEST["page"];

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search[owner_id]=$_POST[owner_id];
			$search[owner_name]=$_POST[owner_name];
			$search[email]=$_POST[email];
			if($_POST[admit_flg]!=""){
				$search[admit_flg]=$_POST[admit_flg];
			}
			$search[page]=1;

			$_SESSION[search_jyoken]=$search;
		}
		// ページ番号が渡されたか？
		else if ($page) {
			// ページングによる遷移
			$search = $_SESSION[search_jyoken];
			$search[page]=$this->request->getParam("page");

		}
		else if($_POST){
			$search = $_SESSION[search_jyoken];
			$search[page]=$this->request->getParam("page");

		}
		else {
			// sessionに検索条件が保存されている場合

			if($_SESSION[search_jyoken]) unset($_SESSION[search_jyoken]);
			$search[page]=1;

		}
		$total_cnt=$dao->searchCount($search);

		if($total_cnt>$limit){
			list($page_navi,$lastPage) = get_page_navi2($total_cnt, $limit, $search[page], "/company/list/");
		}
		$company=$dao->search($search,"insert_date desc",$limit);


		$this->view->assign("company", $company);
		$this->view->assign("total_cnt", $total_cnt);
		$this->view->assign("navi", $page_navi);
		$this->view->assign("lastPage", $lastPage);
		$this->view->assign("search", $search);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("company-list.tpl");
		return;
	}


	/**
	 * 法人情報更新
	 */
	public function editAction() {

		$dao = new OwnerDAO();
		$commonDao = new CommonDAO();
		$pointDao = new PointDao();

		// ログイン中のadmin情報を取得
		$admin = $this->getAdminSession();
		$owner_id=$_REQUEST[owner_id];

		//config
		$prefArr=CommonArray::$pref_text_array;
		$thresholdArr=CommonArray::$threshold_array;


		//チェック用配列
		$baseData=CommonChkArray::$ownerModifyCheckData;


		if($_POST[modify]){

			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//---------------- 入力チェック ---------------------------
			//基本事項
			$this->check($input_data,$baseData);
			//-------------- ここまで -----------------------------------

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {

				//基本事項
				foreach($baseData[dbstring] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}
				//上限値による凍結設定・解除
				$freeze_set=-1;
				// オーナーに紐づくFBページを取得
				$result_all_fbp = $commonDao->get_data_tbl("fbpage", "owner_id", $owner_id);
				$likes_month_total = 0;
				foreach($result_all_fbp as $item){
					//今月の「いいね」数を集計
					$target_month=date("Ym");
					$ret=$pointDao->getPointTotal($target_month,$item[fbpage_id]);
					if(count($ret)>0){
						$likes_month_total+=$ret[0][cnt];
					}
				}
				//現在の支払金額を計算
				$pay_month_total = $likes_month_total * LIKE_EXCHANGE_RATE ;
				// 上限を超えそうか？上限値の９０％を超えていたらFBページのステータスを凍結にする
				if ($pay_month_total >= $input_data[threshold]* 0.9){//上限値超えそう
					//if($input_data[freeze_flg]==0){	//現在未凍結なら変更
						$dkey[]="freeze_flg";
						$dval[]=1;
						$freeze_set=1;
					//}
				}else{	//上限値を下回っている
					//if($input_data[freeze_flg]==1){	//現在凍結中なら変更
						$dkey[]="freeze_flg";
						$dval[]=0;
						$freeze_set=0;
					//}
				}

				$ret=$dao->upItemData($dkey,$dval,"owner_id",$owner_id,$freeze_set);
				if($ret){
					$msg="オーナー情報を更新しました";
					$this->addMessage("info","オーナー情報を更新しました");
				}
				else{
					$msg="オーナー情報の更新エラーです";
					$this->addMessage("info","オーナー情報の更新エラーです");
				}
			}
		}
		else{

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("owner","owner_id",$owner_id);
			$input_data=$tmp[0];
		}


		$this->view->assign("msg", $msg);
		$this->view->assign("input_data", $input_data);
		$this->view->assign("prefArr", $prefArr);
		$this->view->assign("thresholdArr", $thresholdArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("company-edit.tpl");
		return;
	}

	/**
	 * FB情報
	 */
	public function fbAction() {

		$commonDao = new CommonDAO();

		$owner_id=$_REQUEST[owner_id];

		//オーナー情報
		$tmp=$commonDao->get_data_tbl("owner","owner_id",$owner_id);
		$ownerArr=$tmp[0];


		//凍結/開始処理
		if($_POST[stop_dummy]){

			foreach($_POST[stop_dummy] as $key=>$val){
				//削除
				$ret=$commonDao->updateData("fbpage","stat",$val,"fbpage_id",$key);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("info","更新エラーがあります。");
			}
			else{
				$this->addMessage("info","更新しました");
			}
		}

		//削除処理
		if($_POST[delete_dummy]){

			foreach($_POST[delete_dummy] as $key=>$val){
				//削除
				$ret=$commonDao->del_Data("fbpage","fbpage_id",$val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("info","facebookページ削除エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックしたfacebookページを削除しました");
			}
		}

		//config
		$prefArr=CommonArray::$pref_text_array;

		//FB情報
		$arr=$commonDao->get_data_tbl("fbpage","owner_id",$owner_id);
		for($i=0;$i<count($arr);$i++){
			$arr[$i][pref_str]=$prefArr[$arr[$i][pref]];
		}


		$this->view->assign("arr", $arr);
		$this->view->assign("ownerArr", $ownerArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("company-fb.tpl");
		return;


	}

	/**
	 * 請求・支払履歴
	 */
	public function historyAction() {

		$commonDao = new CommonDAO();

		$owner_id=$_REQUEST[owner_id];

		//オーナー情報
		$tmp=$commonDao->get_data_tbl("owner","owner_id",$owner_id);
		$ownerArr=$tmp[0];

		if($_REQUEST["page"]){
			$page = $_REQUEST["page"];
		}
		else{
			$page=1;
		}


		//-----支払履歴-----------

		//総数
		$tmp=$commonDao->get_data_tbl("owner_billing","owner_id",$owner_id);
		$total_cnt=count($tmp);

		//page
		if($total_cnt>ADMIN_V_CNT){
			list($page_navi,$lastPage) = get_page_navi2($total_cnt, ADMIN_V_CNT, $page, "/company/history/?owner_id=".$owner_id,10,"&lsaquo; Prev","Next &rsaquo;","&");
		}
		$arr=$commonDao->get_data_tbl("owner_billing","owner_id",$owner_id,"bill_id desc",ADMIN_V_CNT,$page);
		for($i=0;$i<count($arr);$i++){
			$arr[$i][pref_str]=$prefArr[$arr[$i][pref]];
		}


		$this->view->assign("total_cnt", $total_cnt);
		$this->view->assign("page_navi", $page_navi);
		$this->view->assign("lastPage", $lastPage);
		$this->view->assign("arr", $arr);
		$this->view->assign("ownerArr", $ownerArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("company-history.tpl");
		return;


	}

}
?>

