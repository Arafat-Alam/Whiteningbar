<?php
class ShopController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();



	}

	/**
	 *  店舗一覧表示・検索
	 */
	public function listAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$search = null;
		$search_flag = false;
		$limit=ADMIN_V_CNT;

		$commonDao = new CommonDao();

		//削除処理
		if($_POST['delete_dummy']){
			foreach($_POST['delete_dummy'] as $key=>$val){
				//削除
				$ret=$commonDao->del_Data("shop","shop_no",$val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("error","店舗削除エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックした店舗を削除しました");
			}
		}

		//非表示処理
		if($_POST['view_flg']){
			//まずは全てをクリア
			$commonDao->updateData("shop", "view_flg", 0,"","");

			foreach($_POST['view_flg'] as $key=>$val){
				//チェックのあるものを表示フラグ
				$ret=$commonDao->updateData("shop", "view_flg", 1,"shop_no", $val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("error","エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックした内容を更新しました");
			}
		}

		$page = $_REQUEST["page"];

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {
			$search['page']=1;

			$_SESSION['search_jyoken']=$search;
		}
		// ページ番号が渡されたか？
		else if ($page) {
			// ページングによる遷移
			$search = $_SESSION['search_jyoken'];
			$search['page']=$this->request->getParam("page");

		}
		else if($_POST){
			$search = $_SESSION['search_jyoken'];
			$search['page']=$this->request->getParam("page");

		}
		else {
			// sessionに検索条件が保存されている場合
			if($_SESSION['search_jyoken']) unset($_SESSION['search_jyoken']);
			$search['page']=1;

		}

//		$total_cnt=$dao->searchCount($search);
//		list($page_navi,$lastPage) = get_page_navi2($total_cnt, $limit, $search['page'], "/company/list/");
//		$company=$dao->search($search,"insert_date desc",$limit);
		$shopArr=$commonDao->get_data_tbl("shop");


		$this->view->assign("shopArr", $shopArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("shop/list.tpl");
		return;
	}


	/**
	 * 店舗情報 新規/更新
	 */
	public function editAction() {
		$msg = '';
		// $input_data = '';
		$commonDao = new CommonDao();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		@$shop_no = $_REQUEST['shop_no'];

		//ログイン者が該当の店舗の閲覧、編集権限をもっているかチェック





		//チェック用配列
		$baseData=CommonChkArray::$shopCheckData;

		if(isset($_POST['submit'])){

			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//---------------- 入力チェック ---------------------------
			//基本事項
			$this->check($input_data,$baseData);
			// exit();
			//-------------- ここまで -----------------------------------

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {

				//基本事項
				foreach($baseData['dbstring'] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}

				if(!$shop_no){

					//識別ID
					$tmp=$commonDao->get_data_tbl("shop");
//					$dkey[]="spid";
//					$dval[]=count($tmp)+1;

					$ret=$commonDao->InsertItemData("shop",$dkey,$dval);
					if($ret){
						$commonDao->updateData("shop","spid",$ret,"shop_no",$ret);//判別の番号
						$this->addMessage("info","店舗情報を登録しました");

						$input_data['shop_no']=$ret;
					}
					else{
						$this->addMessage("error","店舗情報の登録エラーです");
					}
				}
				else{

					$ret=$commonDao->updateData("shop",$dkey,$dval,"shop_no",$shop_no);
					if($ret){
						$this->addMessage("info","店舗情報を更新しました");
					}
					else{
						$this->addMessage("error","店舗情報の更新エラーです");
					}
				}
			}
		}
		else if(isset($_GET['sn']) || $login_admin['shop_no']>0){


			if($_GET['sn']){
				$sn=$_GET['sn'];
			}
			else{
				$sn=$login_admin['shop_no'];
			}

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$sn);
			$input_data=$tmp[0];

		}
		else{

		}


		$this->view->assign("msg", $msg);
		@$this->view->assign("input_data", $input_data);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("shop/edit.tpl");
		return;
	}


	/**
	 * 店舗 営業情報の設定
	 */
	public function operateAction() {

		$commonDao = new CommonDAO();
		$dao = new ShopDAO();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		if($_REQUEST['sn']){
			$shop_no=$_REQUEST['sn'];
		}
		else{
			$shop_no=$login_admin['shop_no'];
		}



		//店舗指定が無い場合にはエラー
		if(!$shop_no){
			$this->addMessage("error","店舗が指定されていません");
			// テンプレート表示
	        $this->setTemplatePath("error.tpl");
			return;

		}


		//曜日配列
		$weekArr=CommonArray::$weekday_array;
		$this->view->assign("weekArr", $weekArr);

		$baseData=CommonChkArray::$operateCheckData;


		if($_POST['submit']){

			//$_SESSION["input_data"]=$_POST;
			$input_data=$_POST;

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

				$ret=$dao->InsertAttrData($shop_no, $baseData, $input_data);

				if($ret){
					$this->addMessage("info","営業情報を登録しました");

					$input_data['shop_no']=$ret;
				}
				else{
					$this->addMessage("error","営業情報登録エラーです");
				}
			}
		}
		else if($shop_no){

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("shop_attr","shop_no",$shop_no);

			for($i=0;$i<count($tmp);$i++){
				$attr_key=$tmp[$i]['attr_key'];
				$attr_value=$tmp[$i]['attr_value'];

				if($attr_key=="days"){
					$input_data[$attr_key][]=$attr_value;
				}
				else{
					$input_data[$attr_key]=$attr_value;
				}

			}
		}
		else{


		}

		//時間
		$hourArr=makePulldownList("7","23","1");
		//分
		$minuArr=array(""=>"","00"=>"00","15"=>"15","30"=>"30","45"=>"45");

		$this->view->assign("hourArr", $hourArr);
		$this->view->assign("minuArr", $minuArr);


		$this->view->assign("msg", $msg);
		$this->view->assign("input_data", $input_data);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("shop/operate.tpl");
		return;
	}

	/**
	 *  コース一覧表示・検索
	 */
	public function courseAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$search = null;
		$search_flag = false;
		$limit=ADMIN_V_CNT;
		$tbl="mst_course";
		$orderKey="course_no";

		$commonDao = new CommonDao();

		//削除処理
		if($_POST['delete_dummy']){

			foreach($_POST['delete_dummy'] as $key=>$val){
				//削除
				$ret=$commonDao->del_Data("mst_course","course_no",$val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("error","コース削除エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックしたコースを削除しました");
			}
		}
		$page = $_REQUEST["page"];

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {
			$search['page']=1;

			$_SESSION['search_jyoken']=$search;
		}
		// ページ番号が渡されたか？
		else if ($page) {
			// ページングによる遷移
			$search = $_SESSION['search_jyoken'];
			$search['page']=$this->request->getParam("page");

		}
		//表示順変更 一つUP
		else if($_POST[ "exec" ]=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from $tbl where v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, $orderKey, $ret[0][$orderKey]);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;

				$commonDao->updateData($tbl, "v_order", $v_order, $orderKey, $targetId);

			}
		}
		//表示順変更　一つダウン
		else if($_POST[ "exec" ]=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where v_order > " . $order." order by v_order limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, $orderKey, $ret[0][$orderKey]);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, $orderKey, $targetId);

			}
		}
		else if($_POST){
			$search = $_SESSION['search_jyoken'];
			$search['page']=$this->request->getParam("page");

		}
		else {
			// sessionに検索条件が保存されている場合
			if($_SESSION['search_jyoken']) unset($_SESSION['search_jyoken']);
			$search['page']=1;

		}

//		$total_cnt=$dao->searchCount($search);
//		list($page_navi,$lastPage) = get_page_navi2($total_cnt, $limit, $search['page'], "/company/list/");
//		$company=$dao->search($search,"insert_date desc",$limit);
		$shopArr=$commonDao->get_data_tbl("mst_course","","","v_order");


		$this->view->assign("shopArr", $shopArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("shop/course.tpl");
		return;
	}


	/**
	 *  コース 新規/更新
	 */
	public function courseEditAction() {

		$commonDao = new CommonDAO();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$shop_no=$_REQUEST['shop_no'];

		//チェック用配列
		$baseData=CommonChkArray::$courseCheckData;


		if($_POST['submit']){

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
				foreach($baseData['dbstring'] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}

				if(!$_POST['course_no']){

					//v_order
					$tmp=$commonDao->get_data_tbl("mst_course");
					$dkey[]="v_order";
					$dval[]=count($tmp)+1;

					$ret=$commonDao->InsertItemData("mst_course",$dkey,$dval);
					if($ret){



						$this->addMessage("info","コース情報を登録しました");

						$input_data['course_no']=$ret;
					}
					else{
						$this->addMessage("error","コース情報の登録エラーです");
					}
				}
				else{

					$ret=$commonDao->updateData("mst_course",$dkey,$dval,"course_no",$_POST['course_no']);
					if($ret){
						$this->addMessage("info","コース情報を更新しました");
					}
					else{
						$this->addMessage("error","コース情報の更新エラーです");
					}
				}
			}
		}
		else if(isset($_GET['copy']) && $_GET['sn']){

			//DBに登録されているコピー元の情報取得
			$tmp=$commonDao->get_data_tbl("mst_course","course_no",$_GET['sn']);
			$input_data=$tmp[0];
			$input_data['course_no']="";

			$copy=1;

		}
		else if($_GET['sn']){

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("mst_course","course_no",$_GET['sn']);
			$input_data=$tmp[0];


		}
		else{

		}


		$this->view->assign("copy", $copy);
		$this->view->assign("input_data", $input_data);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("shop/course-edit.tpl");
		return;
	}


	/**
	 *  コース一覧表示・検索
	 */
	public function menuAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$search = null;
		$search_flag = false;
		$limit=ADMIN_V_CNT;
		$tbl="mst_menu";
		$orderKey="menu_no";

		$commonDao = new CommonDao();

		//削除処理
		if($_POST['upsubmit']){

			foreach($_POST['delete_dummy'] as $key=>$val){
				//削除
				$ret=$commonDao->del_Data("mst_menu","menu_no",$val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("error","メニュー削除エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックしたメニューを削除しました");
			}
		}
		$page = $_REQUEST["page"];

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {
			$search['page']=1;

			$_SESSION['search_jyoken']=$search;
		}
		// ページ番号が渡されたか？
		else if ($page) {
			// ページングによる遷移
			$search = $_SESSION['search_jyoken'];
			$search['page']=$this->request->getParam("page");

		}
		//表示順変更 一つUP
		else if($_POST[ "exec" ]=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from $tbl where v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, $orderKey, $ret[0][$orderKey]);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;

				$commonDao->updateData($tbl, "v_order", $v_order, $orderKey, $targetId);

			}
		}
		//表示順変更　一つダウン
		else if($_POST[ "exec" ]=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where v_order > " . $order." order by v_order limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, $orderKey, $ret[0][$orderKey]);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, $orderKey, $targetId);

			}
		}
		else if($_POST){
			$search = $_SESSION['search_jyoken'];
			$search['page']=$this->request->getParam("page");

		}
		else {
			// sessionに検索条件が保存されている場合
			if($_SESSION['search_jyoken']) unset($_SESSION['search_jyoken']);
			$search['page']=1;

		}

//		$total_cnt=$dao->searchCount($search);
//		list($page_navi,$lastPage) = get_page_navi2($total_cnt, $limit, $search['page'], "/company/list/");
//		$company=$dao->search($search,"insert_date desc",$limit);
		$shopArr=$commonDao->get_data_tbl("mst_menu","","","v_order");

		//表示色
		$colorArr=CommonArray::$menuColor_array;
		for($i=0;$i<count($shopArr);$i++){

			//コース名
			$tmp=$commonDao->get_data_tbl("mst_course","course_no",$shopArr[$i]['course_no']);
			$shopArr[$i]['course_name']=$tmp[0]['name'];

			$shopArr[$i]['view_color']=$colorArr[$shopArr[$i]['color_no']];

		}

		$this->view->assign("shopArr", $shopArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("shop/menu.tpl");
		return;
	}


	/**
	 *  メニュー 新規/更新
	 */
	public function menuEditAction() {

		$commonDao = new CommonDAO();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$shop_no=$_REQUEST['shop_no'];

		//チェック用配列
		$baseData=CommonChkArray::$menuCheckData;

		if($_POST['submit']){

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
				foreach($baseData['dbstring'] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}

				if(!$_POST['menu_no']){

					//v_order
					$tmp=$commonDao->get_data_tbl("mst_menu");
					$dkey[]="v_order";
					$dval[]=count($tmp)+1;

					$ret=$commonDao->InsertItemData("mst_menu",$dkey,$dval);
					if($ret){



						$this->addMessage("info","メニュー情報を登録しました");

						$input_data['menu_no']=$ret;
					}
					else{
						$this->addMessage("error","メニュー情報の登録エラーです");
					}
				}
				else{

					$ret=$commonDao->updateData("mst_menu",$dkey,$dval,"menu_no",$_POST['menu_no']);
					if($ret){
						$this->addMessage("info","メニュー情報を更新しました");
					}
					else{
						$this->addMessage("error","メニュー情報の更新エラーです");
					}
				}
			}
		}
		else if(isset($_GET['copy']) && $_GET['sn']){

			//DBに登録されているコピー元の情報取得
			$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$_GET['sn']);
			$input_data=$tmp[0];
			$input_data['menu_no']="";

			$copy=1;

		}
		else if($_GET['sn']){

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$_GET['sn']);
			$input_data=$tmp[0];


		}
		else{
			//デフォルト
			$input_data['use_count']=1;
			$input_data['number']=1;
			$input_data['kind_flg']=0;
			$input_data['color_no']=1;
		}


		//登録中のコース
		$tmp=$commonDao->get_data_tbl("mst_course","","","v_order");
		$courseArr=makePulldownTableList($tmp,"course_no","name");
		$this->view->assign("courseArr", $courseArr);

		//表示色
		$colorArr=CommonArray::$menuColor_array;
		$this->view->assign("colorArr", $colorArr);

		//所要時間
		$menuTimeArr=CommonArray::$menu_time_array;
		$this->view->assign("menuTimeArr", $menuTimeArr);


		$this->view->assign("copy", $copy);
		$this->view->assign("input_data", $input_data);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("shop/menu-edit.tpl");
		return;
	}

	/**
	 *  メニュー 新規/更新
	 */
	public function enqueteAction() {

		$commonDao = new CommonDAO();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$shop_no=$_REQUEST['shop_no'];



		//------表示順を変更するクエリに必要-------
		$tbl="mst_form_set";
		$orderKey="komoku_no";
		//--------------------------------------------


		//削除処理
		if($_POST['delete_dummy']){

			foreach($_POST['delete_dummy'] as $key=>$val){
				//削除
				$ret=$commonDao->del_Data("mst_form_set","komoku_no",$val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("error","アンケート項目削除エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックしたアンケート項目を削除しました");
			}
		}



		//チェック用配列
		$baseData=CommonChkArray::$formSetCheckData;


		if(isset($_POST['sbm_save'])){

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
				foreach($baseData['dbstring'] as $key=>$val){
					$dkey[$key]=$input_data[$key];;
				}

				if(!$_POST['komoku_no']){

					//v_order
					$tmp=$commonDao->get_data_tbl("mst_form_set","form_flg","1");
					$dkey['v_order']=count($tmp)+1;

					$dkey['form_flg']="1";

					$ret=$commonDao->InsertItemData2("mst_form_set",$dkey);
					if($ret){
						//選択肢項目
						if($input_data['opt']){
							$this->putOption($ret, $input_data);
						}

						$this->addMessage("info","アンケート項目を登録しました");

						$input_data['course_no']=$ret;
					}
					else{
						$this->addMessage("error","アンケート項目の登録エラーです");
					}
				}
				else{
					$wfi['komoku_no']=$_POST['komoku_no'];
					$ret=$commonDao->updateData2("mst_form_set",$dkey,$wfi);
					if($ret){
						//選択肢項目
						if($input_data['opt']){
							$this->putOption($_POST['komoku_no'], $input_data);
						}

						$this->addMessage("info","アンケート項目を更新しました");
					}
					else{
						$this->addMessage("error","アンケート項目の更新エラーです");
					}
				}
			}
		}
		//表示順変更 一つUP
		else if($_POST[ "exec" ]=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from $tbl where v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, $orderKey, $ret[0][$orderKey]);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;

				$commonDao->updateData($tbl, "v_order", $v_order, $orderKey, $targetId);

			}
		}
		//表示順変更　一つダウン
		else if($_POST[ "exec" ]=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where v_order > " . $order." limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, $orderKey, $ret[0][$orderKey]);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, $orderKey, $targetId);

			}
		}
		else if($_GET['sn']){

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("mst_form_set","komoku_no",$_GET['sn']);
			$input_data=$tmp[0];
			$tmp=$commonDao->get_data_tbl("form_set_value","komoku_no",$_GET['sn']);
			for($i=0;$i<count($tmp);$i++){
				$input_data['opt'][]=$tmp[$i]['name'];
			}

		}
		else{
			//デフォルト
			$input_data['status']=1;
			$input_data['form_type']=1;
			$input_data['in_min']=0;
			$input_data['in_max']=0;
			$input_data['in_chk']=0;

		}

		//一覧
		$arr=$commonDao->get_data_tbl("mst_form_set","","","v_order");
		$this->view->assign("arr", $arr);


		$makeformArr=CommonArray::$makeForm_array;
		$this->view->assign("makeformArr", $makeformArr);


		$this->view->assign("input_data", $input_data);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("shop/enquete.tpl");
		return;
	}


	function putOption($komoku_no, $input_data){

		$commonDao = new CommonDao();
		$commonDao->del_Data("form_set_value", "komoku_no", $komoku_no);
		foreach($input_data['opt'] as $key=>$val){
			if($val){
				$fi=array();
				$fi['komoku_no']=$komoku_no;
				$fi['name']=$val;
				$commonDao->InsertItemData2("form_set_value", $fi);
			}
		}

		return true;
	}


	/**
	 *  店舗の担当者一覧
	 */
	public function staffAction() {
		$search = '';

		$commonDao= new CommonDao();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);


		//削除,表示非表示　更新処理
		if(isset($_POST['modify'])){

			//更新
			foreach($_POST['modi_view_flg'] as $key=>$val){
				$fi=array();
				$wfi=array();

				$fi['view_flg']=$val;
				$wfi['staff_no']=$key;

				$commonDao->updateData2("shop_staff", $fi, $wfi);
			}

			//削除
			if($_POST['delete_dummy']){
				foreach($_POST['delete_dummy'] as $key=>$val){
					$staff_no=$val;

					$commonDao->del_Data("shop_staff", "staff_no", $val);

				}

			}

				$this->addMessage("info", "担当者一覧を更新しました");

		}

//		if(isset($_POST['sbm_save'])){
		if(isset($_POST['mode'])){

			$mode = $_REQUEST["mode"];
			$op = "登録";
			$admin_obj=$_POST;

			$input_data=$_POST;

			//入力チェック
//			$checkData=CommonChkArray::$adminNewCheckData;
			//入力チェック
//			$ret=!$this->check($admin_obj,$checkData);


			if (count($this->getMessages()) >0) {
				$this->setSessionMessage();

				//$this->view->assign("result_messages", $result_messages);
			}
			else {

				$ins['name']=$_POST['name'];
				$ins['shop_no']=$_POST['shop_no'];
				$ins['view_flg']=$_POST['view_flg'];

				if($mode=="add"){
					//新規登録
					$commonDao->InsertItemData2("shop_staff",$ins);

				}
				else{
					$op = "更新";
					$staff_no = $_REQUEST["staff_no"];
					//$admin_obj = $dao->getAdmin($admin_no);

					$uwhere['staff_no']=$staff_no;
					$commonDao->updateData2("shop_staff",$ins,$uwhere);
				}

				$this->addMessage("info", "担当者を" . $op . "しました");
				$admin_obj=array();
				$mode="add";
			}

		}
		else if(isset($_REQUEST["s"]) && isset($_REQUEST["ss"])){

			$fi['staff_no']=$_REQUEST["s"];
			$fi['shop_no']=$_REQUEST["ss"];


			$tmp=$commonDao->get_data_tbl2("shop_staff",$fi);
			$admin_obj=$tmp[0];

			$mode = "update";

		}
		else{
			//デフォルトチェック
			$admin_obj['view_flg']="1";

			$mode = "add";

		}


		//---------- 検索 管理一覧--------------------------------------------

		if($login_admin['shop_no']>0){
			$search['shop_no']=$login_admin['shop_no'];
		}

		$admins = $commonDao->get_data_tbl2("shop_staff",$search);

		for($i=0;$i<count($admins);$i++){
			//店舗
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$admins[$i]['shop_no']);
			if($tmp){
				$admins[$i]['shop_name']=$tmp[0]['name'];
			}
			else{
				$admins[$i]['shop_name']=$addArr[$admins[$i]['shop_no']];
			}

		}
		$this->view->assign("admins", $admins);


		//店舗
		if($login_admin['shop_no']>0){
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$login_admin['shop_no']);
		}
		else{
			$tmp=$commonDao->get_data_tbl("shop");
		}
		$shopArr=makePulldownTableList($tmp,"shop_no","name");

		//編集用
		$this->view->assign("shopArr", $shopArr);


		$this->view->assign("admin_obj", $admin_obj);
		$this->view->assign("mode", $mode);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("shop/staff.tpl");
		return;


	}


	/**
	 *  店舗のブロック一覧
	 */
	public function blockAction() {
		$input_data = array();

		$commonDao = new CommonDAO();
		$dao = new ShopDAO();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		if($_REQUEST['sn']){
			$shop_no=$_REQUEST['sn'];
		}
		else{
			$shop_no=$login_admin['shop_no'];
		}

		$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"booth"));
		@$boothArr['booth']=$tmp[0]['attr_value'];
		
		$this->view->assign('boothArr',$boothArr);

		//店舗指定が無い場合にはエラー
		if(!$shop_no){
			$this->addMessage("error","店舗が指定されていません");
			// テンプレート表示
	        $this->setTemplatePath("error.tpl");
			return;

		}

		//削除処理
		if(isset($_POST['del_submit'])){
			foreach($_POST['delete_dummy'] as $key=>$val){
				//削除
				$ret=$commonDao->del_Data("shop_block","no",$val);
				if(!$ret){
					$delFlg=1;
				}
			}
			if($delFlg==1){
				$this->addMessage("error","削除エラーがあります。");
			}
			else{
				$this->addMessage("info","チェックした予約ブロック時間を削除しました");
			}
		}


		if(isset($_POST['submit'])){

			$input_data=$_POST;


			if($input_data['kind_flg']==1){//日付設定
				$baseData=CommonChkArray::$blockDateCheckData;
			}
			else if($input_data['kind_flg']==2){
				$baseData=CommonChkArray::$blockTimeCheckData;
			}
			else{
				$baseData=CommonChkArray::$blockRepeatCheckData;
			}

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

				foreach($baseData['dbstring'] as $key=>$val){
					if($input_data['kind_flg']==2 && $key=="start_date"){
						$fi[$key]=$input_data['start_date_t'];
					}
					else if($input_data['kind_flg']==2 && $key=="start_time"){
						$fi[$key]=$input_data['start_time_t'];
					}
					else if($input_data['kind_flg']==2 && $key=="end_time"){
						$fi[$key]=$input_data['end_time_t'];
					}
					else if($input_data['kind_flg']==3 && $key=="start_date"){
						$fi[$key]=$input_data['start_date_r'];
					}
					else if($input_data['kind_flg']==3 && $key=="end_date"){
						$fi[$key]=$input_data['end_date_r'];
					}
					else if($input_data['kind_flg']==3 && $key=="start_time"){
						$fi[$key]=$input_data['start_time_r'];
					}
					else if($input_data['kind_flg']==3 && $key=="end_time"){
						$fi[$key]=$input_data['end_time_r'];
					}
					else{
						$fi[$key]=$input_data[$key];
					}
				}
				
				if($input_data['kind_flg']==1 && $input_data['end_date']==""){
					$fi['end_date']=$input_data['start_date'];
				}

				if($input_data['no'] || $input_data['no_t'] || $input_data['no_r']){//編集

					if($input_data['kind_flg']==1){
						$wfi['no']=$input_data['no'];
					}
					else if($input_data['kind_flg']==2){
						$wfi['no']=$input_data['no_t'];
					}
					else{
						$wfi['no']=$input_data['no_r'];
					}
					$ret=$commonDao->updateData2("shop_block", $fi, $wfi);

				}
				else{
					//新規
					$fi['shop_no']=$shop_no;
					$ret=$commonDao->InsertItemData2("shop_block", $fi);

				}

				if($ret){
					$this->addMessage("info","予約ブロック情報を登録しました");

					$input_data['shop_no']=$ret;
				}
				else{
					$this->addMessage("error","予約ブロック情報登録エラーです");
				}
			}
		}
		else if(isset($_GET['modify'])){

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("shop_block","no",$_GET['modify']);
			$input_data=$tmp[0];

			if($input_data['kind_flg']==1){//日付


			}
			else if($input_data['kind_flg']==2){//時間
				$input_data['no_t']=$input_data['no'];
				$input_data['start_date_t']=$input_data['start_date'];
				$input_data['start_time_t']=$input_data['start_time'];
				$input_data['end_time_t']=$input_data['end_time'];

				$input_data['start_date']="";
				$input_data['end_date']="";
				$input_data['start_time']="";
				$input_data['end_time']="";

			}
			else{//リピート
				$input_data['no_r']=$input_data['no'];
				$input_data['start_date_r']=$input_data['start_date'];
				$input_data['end_date_r']=$input_data['end_date'];
				$input_data['start_time_r']=$input_data['start_time'];
				$input_data['end_time_r']=$input_data['end_time'];

				$input_data['start_date']="";
				$input_data['end_date']="";
				$input_data['start_time']="";
				$input_data['end_time']="";

			}


		}
		else{


		}

		if($shop_no){

			//DBに登録されている情報取得
			$arr=$commonDao->get_data_tbl("shop_block","shop_no",$shop_no);
		}


		$this->view->assign("arr", $arr);
		$this->view->assign("input_data", $input_data);
		$this->view->assign("shop_no", $shop_no);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("shop/block.tpl");
		return;


	}


}
?>

