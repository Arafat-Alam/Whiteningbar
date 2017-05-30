<?php
class MemberController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

		require_once sprintf("%s/dao/MemberDao.class.php", MODEL_PATH);

	}

	/**
	 * 会員一覧表示・検索
	 */
	public function listAction() {
		// $page_navi = '';
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$search = null;

		$search_flag = false;
		$limit=ADMIN_V_CNT;

		$dao = new MemberDao();
		$commonDao = new CommonDao();
		$shopDao = new ShopDAO();
		if (isset($_REQUEST["page"])) { 
			$page = $_REQUEST["page"]; 
		}
		

		if($login_admin['shop_no']>0){
			//店舗ログインなので、該当店舗の予約のみで検索
			$search["shop_no"]=$login_admin['shop_no'];
		}

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {
			if($_POST['shop_no']){
				$search['shop_no']=$_POST['shop_no'];
			}
			$search['name']=$_POST['name'];
			$search['member_no']=$_POST['member_no'];
			$search['tel']=$_POST['tel'];
			@$search['member_flg']=$_POST['member_flg'];
			//$search['last_reserve_date']=$_POST['last_reserve_date'];

			$search['page']=1;

			$_SESSION['search_condition'] = $search;


		}
		// ページ番号が渡されたか？
		else if (isset($page)) {
			// ページングによる遷移
			if(isset($_SESSION["search_condition"])){ 
				$search = $_SESSION["search_condition"];
			}
				// echo $search['page']=$this->request->getParam("page");
				$search['page'] = $page;

		}
		else if (isset($_GET['back'])) {
			// ページングによる遷移
			if(isset($_SESSION["search_condition"])){ $search = $_SESSION["search_condition"];}
			$search['page']=1;

		}
		else if(isset($_POST['delete_dummy'])){	//削除処理

			$member_id=key($_POST['delete_dummy']);
			//削除
			$ret=$dao->delete($member_id);
			if(!$ret){
				$this->addMessage("error","会員削除エラーがあります。");
			}
			else{
				$this->addMessage("info","ご指定の会員を削除にしました");
			}

			if(isset($_SESSION["search_condition"])){ $search = $_SESSION["search_condition"];}

		}
		else if(isset($_POST['submit'])){//管理コメント更新

			$member_id=key($_POST['kanri_comment']);
			$commonDao->updateData("member", "kanri_comment", $_POST['kanri_comment'][$member_id], "member_id", $member_id);

			$this->addMessage("info","管理コメントを更新しました");

			if(isset($_SESSION["search_condition"])){ $search = $_SESSION["search_condition"];}

		}
		else if($_POST){
			if(isset($_SESSION["search_condition"])){ $search = $_SESSION["search_condition"];}
			$limit="";

		}
		else {
			// sessionに検索条件が保存されている場合

			if(isset($_SESSION['search_condition'])) unset($_SESSION['search_condition']);
			
			if(isset($_POST['shop_no'])>0){
				$search['shop_no']=$_POST['shop_no'];//デフォルト ログインしているSHOP
			}
			$search['page']=1;

		}
		$total_cnt=$dao->searchCount($search);
		
//		$countTmp=$dao->search($search);
//		$total_cnt=count($countTmp);

		if($limit!= "" && $total_cnt>$limit){
			list($page_navi,$lastPage) = get_page_navi2($total_cnt, $limit, $search['page'], "/member/list/");
		}

		if (isset($_GET['orderby']) && $_GET['orderby'] != 'none') {
			if ($_GET['orderby'] == 'name') {
				$sort = "".$_GET['orderby']." ASC";
			}else{
				$sort = "".$_GET['orderby']." DESC";
			}

			$this->view->assign('ord', $_GET['orderby']);
		}else{
			$sort = 'name ASC';
		}
		// $members=$dao->search($search,"insert_date desc",$limit);
		$members=$dao->search($search,$sort,$limit);
		//購入、来店状況
		for($i=0;$i<count($members);$i++){
			$tmp=$dao->getCourseInfo($members[$i]['member_id']);
			$members[$i]['reserve']=$tmp;

			//本日以降の予約があるか
			$sql="select * from member_reserve_detail where visit_flg=0 and member_id=".$members[$i]['member_id']." and reserve_date>='".date("Y-m-d")."'";
			$tmp=$commonDao->get_sql($sql);
			if($tmp){
				$members[$i]['rplan']=1;//本日以降の予定あり
			}
		}

		//CSV出力
		//ダウンロード処理
		if(isset($_POST['csv']) || isset($_POST['csv_history'])){

			//iPadであれば文字コード変換をしない
			$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');

			if(isset($_POST['csv_history'])){
				$txt="お名前,おなまえ,会員NO,登録店舗,email,郵便番号,都道府県,住所,電話番号,誕生日,性別,歯磨き粉,備考,管理メモ,購入コース,予約履歴,購入コース,予約履歴,....\n";
			}
			else{
				$txt="お名前,おなまえ,会員NO,登録店舗,email,郵便番号,都道府県,住所,電話番号,誕生日,性別,歯磨き粉,備考,管理メモ\n";
			}
				if(!$isiPad){
				$txt=mb_convert_encoding($txt,"SJIS","UTF-8");
			}

			for($i=0;$i<count($members);$i++){
				$csvTmp=array();
				if(!$isiPad){
					$csvTmp[]=mb_convert_encoding($members[$i]['name'],"SJIS","UTF-8");
					$csvTmp[]=mb_convert_encoding($members[$i]['name_kana'],"SJIS","UTF-8");
				}
				else{
					$csvTmp[]=$members[$i]['name'];
					$csvTmp[]=$members[$i]['name_kana'];

				}
				$csvTmp[]=$members[$i]['member_no'];
				$shop_name=$shopDao->getShopName($members[$i]['shop_no']);
				if(!$isiPad){
					$csvTmp[]=mb_convert_encoding($shop_name,"SJIS","UTF-8");
				}
				else{
					$csvTmp[]=$shop_name;
				}
				$csvTmp[]=$members[$i]['email'];
				$csvTmp[]="=".'"'.$members[$i]['zip'].'"';
				$pref_name=get_pref_name($members[$i]['pref']);
				if(!$isiPad){
					$csvTmp[]=mb_convert_encoding($pref_name,"SJIS","UTF-8");
					$address1=mb_convert_encoding($members[$i]['address1'],"SJIS","UTF-8");
					$address2=mb_convert_encoding($members[$i]['address2'],"SJIS","UTF-8");
				}
				else{
					$csvTmp[]=$pref_name;
					$csvTmp[]=$members[$i]['address1'];
					$csvTmp[]=$members[$i]['address1'];
				}
				$csvTmp[]=$address1.$address2;
				$csvTmp[]="=".'"'.$members[$i]['tel'].'"';
				$csvTmp[]=$members[$i]['year']."/".$members[$i]['month']."/".$members[$i]['day'];
				if($members[$i]['sex']==1){
					$sex="男性";
				}
				else if($members[$i]['sex']==2){
					$sex="女性";
				}
				else{
					$sex="-";
				}
				if(!$isiPad){
					$csvTmp[]=mb_convert_encoding($sex,"SJIS","UTF-8");
				}
				else{
					$csvTmp[]=$sex;
				}

				if($members[$i]['tooth_flg']==1){
					$tooth_flg="1種類";
				}
				else if($members[$i]['sex']==2){
					$tooth_flg="2種類";
				}
				else{
					$tooth_flg="-";
				}
				if(!$isiPad){
					$csvTmp[]=mb_convert_encoding($tooth_flg,"SJIS","UTF-8");
					$csvTmp[]='"'.mb_convert_encoding($members[$i]['comment'],"SJIS","UTF-8").'"';
					$csvTmp[]='"'.mb_convert_encoding($members[$i]['kanri_comment'],"SJIS","UTF-8").'"';

				}
				else{
					$csvTmp[]=$tooth_flg;
					$csvTmp[]=$members[$i]['comment'];
					$csvTmp[]=$members[$i]['kanri_comment'];

				}

				//履歴付きCSVの場合に
				if(isset($_POST['csv_history'])){
					$rTmp=$this->getHistoryCSV($members[$i]['member_id'],$isiPad);
					if($rTmp){
						$mergeTmp=array_merge($csvTmp, $rTmp);
						$csvTmp=$mergeTmp;
					}

				}

				$csvArr[]=implode(",",$csvTmp);
			}

			$csvF=$txt.implode("\n", $csvArr);
			$fname="member.csv";
			execDownloadNoFile($csvF, $fname);
		}



		//店舗
		$tmp=$commonDao->get_data_tbl("shop");
		$shopArr=makePulldownTableList($tmp,"shop_no","name",1);
		$this->view->assign("shopArr", $shopArr);
		

		$this->view->assign("members", $members);
		$this->view->assign("total_cnt", $total_cnt);
		@$this->view->assign("navi", $page_navi);
		@$this->view->assign("lastPage", $lastPage);
		$this->view->assign("search", $search);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("member/list.tpl");
		return;
	}

	/**
	 * 	コース料金支払済みにチェックされていたら、料金支払とし、関連処理を行う
		会員登録して、予約をした人は、コース購入は行っているが、未払い状態
		来店時にコース購入料金を払うので、その時に各種処理を行う

	 */
	public function unpaidAction() {

		$wh= '';
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$search = null;
		$search_flag = false;

		$dao = new MemberDao();
		$commonDao = new CommonDao();

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search['name']=$_POST['name'];
			$search['member_no']=$_POST['member_no'];

			$_SESSION['search_condition']=$search;

		}
		else if(isset($_POST['submit'])){
			// exit();
			$input_data=$_POST;

			$buy_no=$_POST['buy_no'];
			$tmp=$commonDao->get_data_tbl("member_buy","buy_no",$buy_no);
			$db_data=$tmp[0];

			//購入日とする日
			if($_POST['buy_date']!=""){
				$buy_date=$_POST['buy_date'];
			}
			else{
				$buy_date=date("Y-m-d");
			}

			//選択したコースの使用期限を出す
			$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$db_data['course_no']);
			if($ctmp[0]['invite_flg']==0){//通常コースであれば期限を入れる（招待コースは入れない）
				$limit_month=$ctmp[0]['limit_month'];

				$bdt=explode("-",$buy_date);
				$ins[]="limit_date='".date("Y-m-d",mktime(0,0,0,$bdt[1]+$limit_month,$bdt[2],$bdt[0]))."'";

				//$ins[]="limit_date='".date("Y-m-d",mktime(0,0,0,date("m")+$limit_month,date("d"),date("Y")))."'";
			}
			//購入日（売上日となる）
			//$ins[]="buy_date='".date("Y-m-d")."'";
			$ins[]="buy_date='".$buy_date."'";

			//クーポンがあれば  クーポン利用時　割引用クーポンか
			if($input_data['coupon_id']>0){
				$couponTmp=$commonDao->get_data_tbl("mst_category1","id",$input_data['coupon_id']);
				//割引と合計金額を訂正登録
				$ins[]="discount=".$couponTmp[0]['fee'];

				$ins[]="total_fee=".($ctmp[0]['fee']-$couponTmp[0]['fee']);
				$ins[]="coupon_id=".$input_data['coupon_id'];
			}

			$ins[]="fee_flg=1";

			$setStr=implode(",",$ins);

			$sql="update member_buy set $setStr where buy_no=".$buy_no;
			$commonDao->run_sql($sql);
			//$sql="update member_buy set $setStr where buy_no=(select bno from (select b.buy_no as bno from member_buy as b,member_reserve_detail as d where b.buy_no=d.buy_no and d.no=".$no." ) as tmp1)";
			//$commonDao->run_sql($sql);

				$this->addMessage("info", "選択した未払いのコースを購入済みにしました。");

		}
		else if(isset($_POST['del_submit'])){
			//未購入コースと予約を完全にDBから削除する
			$buy_no=$_POST['buy_no'];

			$this->delUnpayCourse($buy_no);

			$this->addMessage("info", "未払いコース購入と予約を削除しました。");


		}
		else{
			if(isset($_SESSION['search_condition'])) unset($_SESSION['search_condition']);
		}



		if(isset($_SESSION['search_condition'])){
			$search = $_SESSION['search_condition'];
		}

		if($login_admin['shop_no']>0){
			$wh = " and b.shop_no=".$login_admin['shop_no'];
		}

		if(isset($search)){

			$tmp=array();

			$tbl=",member as m ";

			$whTmp[]=" b.member_id=m.member_id";

			//名前
			if($search["name"]){
				$tmp[]="concat(m.name,m.name_kana) like '%".addslashes($search["name"])."%'";
				$tmp[]="m.name_kana like '%".addslashes($search["name"])."%'";
				$whTmp[]="(".implode(" or ",$tmp).")";

			}
			if($search["member_no"]){
				$whTmp[]="m.member_no like '%".addslashes($search["member_no"])."%'";
			}

			if($whTmp){
				$where=" and ".implode(" and ",$whTmp);
			}

		}


		if($search){
	//		$sql="select distinct d.*,b.course_no from member_buy as b,member_reserve_detail as d $tbl
	//			where b.buy_no=d.buy_no and reserve_no>0 and b.fee_flg=0".$wh.$where;
			
			$sql="select distinct b.* from member_buy as b,member_reserve_detail as d $tbl
				where b.buy_no=d.buy_no and reserve_no>0 and b.fee_flg=0 and d.visit_flg<>99".$wh.$where;

			$arr=$commonDao->get_sql($sql);

			for($i=0;$i<count($arr);$i++){

				$tmp = $commonDao->get_data_tbl("member","member_id",$arr[$i]['member_id']);

				$arr[$i]['name']=$tmp[0]['name'];
				$arr[$i]['name_kana']=$tmp[0]['name_kana'];
				$arr[$i]['tel']=$tmp[0]['tel'];
				$arr[$i]['member_no']=$tmp[0]['member_no'];

				$tmp=$commonDao->get_data_tbl("shop","shop_no",$arr[$i]['shop_no']);
				@$arr[$i]['shop_name']=$tmp[0]['name'];

				$tmp=$commonDao->get_data_tbl("mst_course","course_no",$arr[$i]['course_no']);
				$arr[$i]['course_name']=$tmp[0]['name'];
				$arr[$i]['fee']=$tmp[0]['fee'];

				//該当のbuy_noで予約されている情報の取得
				$arrTmp=array();
	//			$reTmp=$commonDao->get_data_tbl("member_reserve_detail","buy_no",$arr[$i]['buy_no']);
				$reTmp=$commonDao->get_sql("select * from member_reserve_detail where reserve_no>0 and visit_flg<>99 and buy_no=".$arr[$i]['buy_no']);


				for($j=0;$j<count($reTmp);$j++){

					$reserve_date=str_replace("-","/",$reTmp[$j]['reserve_date']);
					$startTmp=explode(":",$reTmp[$j]['start_time']);

					//メニュー名
					if($reTmp[$j]['visit_flg']==99){
						$arrTmp[]="キャンセル<br />(".$reserve_date." ".$startTmp[0].":".$startTmp[1].")";
					}
					else{
						$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reTmp[$j]['menu_no']);
						$arrTmp[]=$tmp[0]['name']."<br />(".$reserve_date." ".$startTmp[0].":".$startTmp[1].")";
					}

				}
				if($arrTmp){
					$arr[$i]['menu_name']=implode("<br />",$arrTmp);
				}

	//			$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$arr[$i]['menu_no']);
	//			$arr[$i]['menu_name']=$tmp[0]['name'];


			}
			
			//デフォルト日付
			$buy_date=date("Y-m-d");
			$this->view->assign("buy_date", $buy_date);

			$this->view->assign("arr", $arr);
			$this->view->assign("search", $search);
			$this->view->assign("total_count", count($arr));

			//クーポン
			$tmp=$commonDao->get_data_tbl("mst_category1","cflag",1,"v_order");
			$couPaArr=makePulldownTableList($tmp, "id", "name",1);
			$this->view->assign("couPaArr", $couPaArr);
		}

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		// for go back to calender
		if (isset($_POST['path'])) {
			header("Location:".$_POST['path']);
			
		}else{
		//end
			$this->setTemplatePath("member/unpaid.tpl");
		}
		return;


	}
	/**
	 * 会員情報更新
	 */
	public function editAction() {
		$member_id = null;
		$dao = new MemberDAO();
		$commonDao = new CommonDAO();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);


		if(isset($_REQUEST['member_id'])) $member_id = $_REQUEST['member_id'];

		//config
		$prefArr=CommonArray::$pref_text_array;


		//購入
		if(isset($_POST['course_submit'])){

			$buy_data=$_POST;

			//購入処理
			$ret=$this->setCourseBuy($buy_data, $member_id);
/*
			//選択したコースの使用期限を出す
			$tmp=$commonDao->get_data_tbl("mst_course","course_no",$buy_data['course_no']);
			$limit_month=$tmp[0]['limit_month'];

			$ins['member_id']=$member_id;
			$ins['course_no']=$buy_data['course_no'];
			$ins['limit_date']=date("Y-m-d",mktime(0,0,0,date("m")+$limit_month,date("d"),date("Y")));//使用期限は確認の事
			$ins['insert_date']=date("Y-m-d");
			$ins['update_date']=date("Y-m-d");
			$ret=$commonDao->InsertItemData2("member_buy", $ins);
*/
			if($ret){
				$this->addMessage("info","コース購入しました");
			}
			else{
				$this->addMessage("error","コース購入エラーです");
			}

			$this->view->assign("finish_flg", 1);

		}

		//管理データ編集
		if(isset($_POST['kanri_submit'])){

			$kanri_data=$_POST;

			//更新処理
			$kanriData=CommonChkArray::$memberOptionAdminCheckData;//フォームを分けたので
			foreach($kanriData['dbstring'] as $key=>$val){
				$fi[$key]=$kanri_data[$key];
			}
			$wfi['member_id']=$member_id;

			$ret=$commonDao->updateData2("member", $fi, $wfi);

			if($ret){
				$this->addMessage("info","管理データの更新が完了しました");
			}
			else{
				$this->addMessage("error","管理データ更新エラーです");
			}

			$this->view->assign("finish_flg", 1);

		}

		//パスワード変更
		if(isset($_POST['pass_submit'])){

			$inp=$_POST;
			//$memberPasswordCheckData
			$baseData=CommonChkArray::$memberPasswordAdminCheckData;
			$this->check($inp,$baseData);
			if (count($this->getMessages()) >0) {
				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

			}
			else{
				if($inp['password']!=$inp['password2']){
					$this->addMessage("password","パスワードとパスワード確認の入力内容が違っています。");
					$result_messages['password']="パスワードとパスワード確認の入力内容が違っています。";

				}
				else{

					$dval['password']=to_hash($inp['password']);
					$wfi['member_id']=$member_id;

					$ret=$commonDao->updateData2("member", $dval, $wfi);
					if($ret){
						$this->addMessage("info","パスワードを更新しました");
						unset($inp);
					}
					else{
						$this->addMessage("error","パスワードの更新エラーです");
					}
				}

				$this->view->assign("finish_flg", 1);

			}


				$this->view->assign("result_messages", $result_messages);
				$this->view->assign("inp", $inp);

		}



		if(isset($_POST['submit'])){

			$_SESSION["input_data"]=$_POST;
			$input_data = $_SESSION["input_data"];
			

			//---------------- 入力チェック ---------------------------
			//基本事項
			if(isset($input_data['member_id'])){//修正
				$baseData=CommonChkArray::$memberModifyCheckData;
				//重複チェック
				$sql="select * from member where email='".$input_data['email']."' and member_id<>".$member_id;
				$tmp=$commonDao->get_sql($sql);

			}
			else{
				$baseData = CommonChkArray::$memberRegistAdminCheckData;
				$sql = "select * from member where email='".$input_data['email']."'";
				$tmp=$commonDao->get_sql($sql);
			}
			if($tmp){
				$this->addMessage("email","既に登録済みのメールアドレスです");
			}


			// echo "<pre>";  print_r($baseData);  exit();
			$this->check($input_data,$baseData);

			//-------------- ここまで -----------------------------------
			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
				
			}
			else {
				//管理画面用項目
//				$kanriData=CommonChkArray::$memberOptionAdminCheckData;//フォームを分けたので

				$input_data['shop_no']=$input_data['spid'];//途中からshop_noも入れる事にしたので、ここで調整

				//基本事項
				foreach($baseData['dbstring'] as $key=>$val){
					if($key=="password"){
						$dkey[]=$key;
						$dval[]=to_hash($input_data[$key]);
					}
					else{
						$dkey[]=$key;
						$dval[]=$input_data[$key];
					}
				}
/*
				foreach($kanriData['dbstring'] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}
*/
				if($input_data['member_id']){//修正
					$ret=$dao->upItemData($dkey,$dval,"member_id",$member_id);
					if($ret){
						$this->addMessage("info","顧客情報を更新しました");
					}
					else{
						$this->addMessage("error","顧客情報の更新エラーです");
					}
				}
				else{
					//----------- 新規登録 ------------

					//コース購入チェックがあれば

					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H:i:s");

					list($ret,$reserve_no)=$dao->InsertItemData($dkey, $dval,$input_data);

					if($ret){

						//購入処理
						if($input_data['course_no']>0){
							$ret=$this->setCourseBuy($input_data, $ret);
							if(!$ret){
								$this->addMessage("error","コース購入の処理に失敗しました。<br />お手数ですが、顧客管理の編集から購入処理を行ってください。");
							}
						}

						$this->addMessage("info","顧客情報を登録しました");
					}
					else{
						$this->addMessage("error","顧客情報の登録エラーです");
					}
				}

				$this->view->assign("finish_flg", 1);


			}
		}
		else if(isset($member_id)){
			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);
			if($tmp){
				$input_data=$tmp[0];
				$db_data=$tmp[0];
				$kanri_data=$tmp[0];

				//購入済みのコースを取得
//				$buyCourseArr=$dao->getCourseInfo($member_id);
//				$this->view->assign("buyCourseArr", $buyCourseArr);

				//店舗名
				$shopTmp=$commonDao->get_data_tbl("shop","shop_no",$tmp[0]['shop_no']);
				$db_data['shop_name']=$shopTmp[0]['name'];

			}
			else{

				$this->addMessage("error","該当の顧客はいません。");
        		$this->setTemplatePath("error.tpl");
				return;

			}

		}
		else{
			//新規登録

			//デフォルト
			$input_data['sex']=2;
			$input_data['mail_flg']=1;
			$input_data['year']="1980";

		}

		if(isset($member_id)){

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);
			if($tmp){
//				$input_data=$tmp[0];
				$db_data=$tmp[0];
				$kanri_data=$tmp[0];

				//店舗名
				$shopTmp=$commonDao->get_data_tbl("shop","shop_no",$tmp[0]['shop_no']);
				$db_data['shop_name']=$shopTmp[0]['name'];

			}
/*
			else{

				$this->addMessage("error","該当の顧客はいません。");
        		$this->setTemplatePath("error.tpl");
				return;

			}
*/
		}

		//店舗
		if($login_admin['shop_no']>0){
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$login_admin['shop_no']);
		}
		else{
			$tmp=$commonDao->get_data_tbl("shop","","");
		}
		$shopArr=makePulldownTableList($tmp,"spid","name");
//		$shopBuyArr=makePulldownTableList($tmp,"shop_no","name");
		$this->view->assign("shopArr", $shopArr);
//		$this->view->assign("$shopBuyArr", $shopBuyArr);

		//登録購入コース取得
		$tmp=$commonDao->get_data_tbl("mst_course","view_flg","1","v_order");
		$courseArr=makePulldownTableList($tmp,"course_no","name");
		$this->view->assign("courseArr", $courseArr);

		//array_unshift($courseArr, "購入しない");

		$courseArr=makePulldownTableList2($tmp,"course_no","name","購入しない");
		$this->view->assign("courseArr2", $courseArr);

		//購入チェックデフォルト
		if(!isset($buy_data)){
			$buy_data['course_no']=$tmp[0]['course_no'];
		}
		$this->view->assign("buy_data", $buy_data);

		//クーポン
		$tmp=$commonDao->get_data_tbl("mst_category1","cflag",1,"v_order");
		$couPaArr=makePulldownTableList($tmp, "id", "name",1);
		$this->view->assign("couPaArr", $couPaArr);

		//登録時アンケート
		$enqArr=$commonDao->get_data_tbl("member_question","member_id",$member_id,"no");
		for($i=0;$i<count($enqArr);$i++){
			$tmp=$commonDao->get_data_tbl("mst_form_set","komoku_no",$enqArr[$i]['komoku_no']);
			$enqArr[$i]['enq_name']=$tmp[0]['name'];
			$enqArr[$i]['comment']=$tmp[0]['comment'];
		}
		$this->view->assign("enqArr", $enqArr);




		//年月日プルダウン
		$yearArr=makeYearList2("0","1945",1);


		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);

		if (isset($member_id)) {
			$this->view->assign("input_data", $input_data);
			$this->view->assign("db_data", $db_data);
			$this->view->assign("kanri_data", $kanri_data);
			$this->view->assign("prefArr", $prefArr);
			
		}



		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        if(!isset($member_id)){
        	$this->setTemplatePath("member/edit_new.tpl");
        }
        else{
        	$this->setTemplatePath("member/edit.tpl");
        }

		return;
	}

	/**
	 * 顧客購入/来店履歴
	 */
	public function historyAction() {

		$dao = new MemberDAO();
		$commonDao = new CommonDAO();

		// ログイン中のadmin情報を取得
		$admin = $this->getAdminSession();
		$member_id=$_REQUEST['member_id'];

		if(!$member_id || $member_id==""){
				$this->addMessage("error","顧客の特定が出来ません。");
        		$this->setTemplatePath("error.tpl");
				return;
		}

		//------ 未払い情報の削除 ------------------
		if(isset($_POST['un_submit'])){
			$buy_no=$_POST['buy_no'];

			$this->delUnpayCourse($buy_no);

			$this->addMessage("info", "未払いコース購入と予約を削除しました。");

		}
		else if(isset($_POST['submit'])){
		//------ 予約のない購入コースの削除 --------
			$buy_no=$_POST['buy_no'];

			$this->delUnpayCourse($buy_no);

			$this->addMessage("info", "購入コースを取り消しました。");

		}
		else if(isset($_POST['del'])){

			//キャンセルのデータを削除
			$detail_no=$_POST['detail_no'];
			$reserve_no=$_POST['reserve_no'];

			$mrdTmp=$commonDao->get_data_tbl("member_reserve_detail", "no", $detail_no);

			$commonDao->del_Data("member_reserve_detail", "no", $detail_no);

				// ログイン中のadmin情報を取得
				$login_admin = $this->getAdminSession();

				//削除する予約のログを取得する
				$delfi=array();
				$delfi['member_id']=$mrdTmp[0]['member_id'];
				$delfi['reserve_no']=$reserve_no;
				$delfi['detail_no']=$detail_no;
				$delfi['reserve_date']=$mrdTmp[0]['reserve_date'];
				$delfi['start_time']=$mrdTmp[0]['start_time'];
				$delfi['act']="キャンセルデータの削除処理：顧客の履歴より";
				$delfi['user_id']=$login_admin['user_id'];
				$delfi['insert_date']=date("Y-m-d H:i:s");
				$commonDao->InsertItemData2("reserve_del_history", $delfi);


			//reserve_noが他になければ、reserveも削除（お連れがいなければという事）
			$tmp=$commonDao->get_data_tbl("member_reserve_detail","reserve_no",$reserve_no);
			if(!$tmp){
				$commonDao->del_Data("member_reserve", "reserve_no", $reserve_no);
			}
			$this->addMessage("info", "履歴を削除しました");


		}


		$buyCourseArr=$dao->getCourseInfoAll($member_id);
		// echo "<pre>";print_r($buyCourseArr);exit();
		//member情報取得
		$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);
		$memArr=$tmp[0];
		$this->view->assign("memArr", $memArr);


		$this->view->assign("buyCourseArr", $buyCourseArr);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/history.tpl");

	}

	/**
	 * メルマガ一斉配信 未使用
	 */
	public function magazinAction() {

		$dao = new MemberDAO();
		$commonDao = new CommonDAO();

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search['name']=$_POST['name'];
			$search['page']=1;

			$_SESSION['search_condition']=$search;


		}



		//年月日プルダウン
		$yearArr=makeYearList("1945","-10",0);
		$monthArr=makeMonthList(0);
		$dayArr=makeDayList(0);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/magazin.tpl");

	}

	/**
	 * 予約　来店者詳細からの顧客登録
	 */
	public function member_registAction() {

		$dao = new MemberDAO();
		$commonDao = new CommonDAO();

		// ログイン中のadmin情報を取得
		$admin = $this->getAdminSession();

		//お連れ様の会員登録の場合　$noがある
		if($_REQUEST['no']){
			$no=$_REQUEST['no'];//member_reserve_detail.no
			//DB情報
			$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
			$db_data=$tmp[0];
			$shop_no=$db_data['shop_no'];
		}
		else if($_REQUEST['shop_no']){
			$shop_no=$_REQUEST['shop_no'];
		}

		//config
		$prefArr=CommonArray::$pref_text_array;
/*
		//予約アンケートの取得
		$setArr=$commonDao->get_data_tbl("mst_form_set","","","v_order ");
		//選択肢の項目を取得する（プルダウン,radio,checkboxの場合に使用）
		for($i=0;$i<count($setArr);$i++){
			if($setArr[$i][form_type]==3 || $setArr[$i][form_type]==4 || $setArr[$i][form_type]==5){
				$tmp=$commonDao->get_data_tbl("form_set_value","komoku_no",$setArr[$i]['komoku_no']);
				$setArr[$i][opt]=makePulldownTableList($tmp, "name", "name");;
			}
		}
		$this->view->assign("setArr", $setArr);
*/
		if($_POST['submit']){

			$_SESSION["input_data"]=$_POST;
			$_SESSION["survey_input_data"]=$_POST['enq'];
			$input_data=$_SESSION["input_data"];


			//---------------- 入力チェック ---------------------------
			if($_REQUEST['ref']=="cal" || $_REQUEST['ref']=="calres"){
				$baseData=CommonChkArray::$memberRegistCalCheckData;
			}
			else{
				$baseData=CommonChkArray::$memberRegistCheckData;
			}

			$this->check($input_data,$baseData);

			//アドレス重複チェック
			if($input_data['email']){
				$ret=$commonDao->get_data_tbl("member","email",$input_data['email']);
				if($ret){
					$this->addMessage("email","ご入力のメールアドレスは登録されています");
				}
			}


			//-------------- ここまで -----------------------------------
			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {
				if(!$input_data['spid']){
					$input_data['spid']=$input_data['shop_no'];//顧客一覧からの顧客登録に配列を合わせるための処理(途中からshop_noを入れる事にしたので・・綺麗では無い）
				}
//				$input_data['shop_no']=$input_data['shop_no'];

				//管理画面用項目
				$kanriData=CommonChkArray::$memberOptionAdminCheckData;

				//基本事項
				foreach($baseData['dbstring'] as $key=>$val){
					if($key=="password"){
						$dkey[]=$key;
						$dval[]=to_hash($input_data[$key]);
					}
					else{
						$dkey[]=$key;
						$dval[]=$input_data[$key];
					}
				}

				foreach($kanriData['dbstring'] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}

					//----------- 新規登録 ------------

					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H:i:s");

					list($ret,$reserve_no)=$dao->InsertItemData($dkey, $dval,$input_data);

					if($ret){

						$_SESSION['reserve_value']['member_id']=$ret;

						//予約詳細にmember_idを入れる
//						$commonDao->updateData("member_reserve_detail", "member_id", $ret, "no", $no);

						//購入処理
						if($input_data['course_no']>0){
							$buyret=$this->setCourseBuy($input_data, $ret);
							if(!$buyret){
								$this->addMessage("error","コース購入の処理に失敗しました。<br />お手数ですが、顧客管理の編集から購入処理を行ってください。");

							}
							else{
								$_SESSION['reserve_value']['buy_no']=$buyret;//購入番号
								//コース番号を入れる
//								$commonDao->updateData("member_reserve_detail", "buy_no", $buyret, "no", $no);
							}
						}

						if($no){
							//親ウィンドのリロード　予約管理カレンダーの予約は済んでいるが、お連れ様の場合の会員登録の場合
							$onl="onLoad='setOpener()'";
							$this->view->assign("onl", $onl);
							$this->view->assign("no", $no);

						}
						else{
							//$_SESSION['reserve_value']['member_id']=$ret;
							//親ウィンドのリロード 予約管理カレンダーの新規予約の会員登録の場合
							$onl="onLoad='setOpener2()'";
							$this->view->assign("onl", $onl);

						}

					}
					else{
						$this->addMessage("error","顧客情報の登録エラーです");
					}

				$this->view->assign("finish_flg", 1);


			}
		}
		else{
			//新規登録

			//デフォルト
			$input_data['sex']=2;
			$input_data['dm_flg']=1;
			$input_data['mail_flg']=1;

			//誕生日デフォルト
//			$input_data['year']=1980;
			//店舗
			$input_data['shop_no']=$shop_no;

		}

		//店舗
		$tmp=$commonDao->get_data_tbl("shop","","");
		$shopArr=makePulldownTableList($tmp,"spid","name");
		$this->view->assign("shopArr", $shopArr);

		//登録購入コース取得
		$noCourse=array(""=>"購入しない");
		$tmp=$commonDao->get_data_tbl("mst_course","view_flg","1","v_order");
		$courseArr=makePulldownTableList2($tmp,"course_no","name","購入しない");
//		$this->view->assign("courseArr", $courseArr);
//		array_unshift($courseArr, "購入しない");
//		$courseArr2=array_merge($noCourse,$courseArr);

		$this->view->assign("courseArr2", $courseArr);




		//購入チェックデフォルト
		if(!$buy_data){
			$buy_data['course_no']=$tmp[0]['course_no'];
		}
		$this->view->assign("buy_data", $buy_data);

		//クーポン
		$tmp=$commonDao->get_data_tbl("mst_category1","cflag",1,"v_order");
		$couPaArr=makePulldownTableList($tmp, "id", "name",1);
		$this->view->assign("couPaArr", $couPaArr);


		//年月日プルダウン
//		$yearArr=makeYearList("1945","-10",0);
		$yearArr=makeYearList2("0","1945",1);

		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);


		$this->view->assign("input_data", $input_data);
		$this->view->assign("db_data", $db_data);
		$this->view->assign("prefArr", $prefArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		if($_REQUEST['ref']=="cal" || $_REQUEST['ref']=="calres"){
			$this->setTemplatePath("calendar/member_regist.tpl");
		}
		else{
			$this->setTemplatePath("reserve/member_regist.tpl");
		}

		return;
	}

	function setCourseBuy($input_data,$member_id){

		$commonDao=new CommonDao();

			//選択したコースの使用期限を出す
			$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$input_data['course_no']);
			$limit_month=$ctmp[0]['limit_month'];

			//クーポン利用時　割引用クーポンか
			if($input_data['coupon_id']>0){
				$couponTmp=$commonDao->get_data_tbl("mst_category1","id",$input_data['coupon_id']);
			}
			else{
				$couponTmp[0]['fee']=0;
			}

			//登録データ
			$ins['member_id']=$member_id;
			$ins['shop_no']=$input_data['shop_no'];
			$ins['course_no']=$input_data['course_no'];
			$ins['coupon_id']=$input_data['coupon_id'];
			$ins['fee']=$ctmp[0]['fee'];
			$ins['discount']=$couponTmp[0]['fee'];
			$ins['total_fee']=$ctmp[0]['fee']-$couponTmp[0]['fee'];
			$ins['fee_flg']=1;

			//ご招待コースの場合は期限を入れない
			if($ctmp[0]['invite_flg']==0){//通常コース
				$ins['limit_date']=date("Y-m-d",mktime(0,0,0,date("m")+$limit_month,date("d"),date("Y")));
			}
			$ins['buy_date']=date("Y-m-d");
			$ins['insert_date']=date("Y-m-d H:i:s");
			$ins['update_date']=date("Y-m-d H:i:s");

			return $commonDao->InsertItemData2("member_buy", $ins);


	}

	/**
	 *
	 *	選択した親クーポンカテゴリから子クーポンを取得してプルダウン作成
	 *
	 */
	public function getCouponListAction() {

		$commonDao = new CommonDao();

		$p_coupon_id=$_REQUEST['p_coupon_id'];

		//
		if($p_coupon_id>0){
			$tmp=$commonDao->get_data_tbl("mst_category1","parentid",$p_coupon_id,"v_order");
			$arr=makePulldownTableList($tmp, "id", "name");

			if($_REQUEST['p_coupon_id']>0){
				$input_data['p_coupon_id']=$_REQUEST['p_coupon_id'];
				$this->view->assign("input_data", $input_data);
			}


			$this->view->assign("arr", $arr);
		$data = $this->setTemplatePath("member/coupon_list.tpl");
			// $data["html"] = $this->view->fetch("member/coupon_list.tpl");
		}
		 print_r($data);
		return;

	}


	function delUnpayCourse($buy_no){

		$commonDao = new CommonDao();

		$commonDao->del_Data("member_buy", "buy_no", $buy_no);

			// ログイン中のadmin情報を取得
			$login_admin = $this->getAdminSession();


			//購入番号で予約した一覧を出して、まず、その購入番号の予約自体は削除
			//お連れ様を含む予約ではない場合は予約は全て削除
			//お連れ様を含む予約の場合：お連れ様が購入番号が割り当て済みの場合は、消さない。お連れ様がまだ未定の場合は消す
			//最終的にdetailにキャンセル以外で残っている人数をmember_reserve.numberに入れる
			$dtmp=$commonDao->get_data_tbl("member_reserve_detail","buy_no",$buy_no);
			for($i=0;$i<count($dtmp);$i++){
				$reserve_no=$dtmp[$i]['reserve_no'];

				//まず、その購入番号を持っている予約は削除する
				$commonDao->del_Data("member_reserve_detail", array("buy_no","reserve_no"), array($buy_no,$reserve_no));

				//削除する予約のログを取得する
				$delfi=array();
				$delfi['member_id']=$dtmp[$i]['member_id'];
				$delfi['reserve_no']=$reserve_no;
				$delfi['detail_no']=$dtmp[$i]['no'];
				$delfi['reserve_date']=$dtmp[$i]['reserve_date'];
				$delfi['start_time']=$dtmp[$i]['start_time'];
				$delfi['act']="未払いコースの購入削除による予約削除：顧客の履歴より";
				$delfi['user_id']=$login_admin['user_id'];
				$delfi['insert_date']=date("Y-m-d H:i:s");
				$commonDao->InsertItemData2("reserve_del_history", $delfi);
/*
				$tmp=$commonDao->get_data_tbl("member_reserve_detail","reserve_no",$reserve_no);
				if($tmp[0][number]==1){
					$commonDao->del_Data("member_reserve_detail", "reserve_no",$reserve_no);
					$commonDao->del_Data("member_reserve", "reserve_no",$reserve_no);

					//削除する予約のログを取得する
					$delfi=array();
					$delfi['member_id']=$dtmp[$i]['member_id'];
					$delfi['reserve_no']=$reserve_no;
					$delfi['detail_no']=$dtmp[$i]['no'];
					$delfi['reserve_date']=$dtmp[$i]['reserve_date'];
					$delfi['start_time']=$dtmp[$i]['start_time'];
					$delfi['act']="未払いコースの購入削除による予約削除：顧客の履歴よりmember_reserve削除（detail削除は意味無し）";
					$delfi['user_id']=$login_admin['user_id'];
					$delfi['insert_date']=date("Y-m-d H:i:s");
					$commonDao->InsertItemData2("reserve_del_history", $delfi);
				}
				else{
*/
				    //複数人での申込時のチェック
				    //おなじ予約番号をもっている予約で、顧客名がまだ不明（buy_no=="")の場合は同時に削除。
				    //buy_no!=""(購入コース番号あり）の場合は、顧客がついているので、ここでは同時削除しない。（キャンセルしたければ、個別に行う）
					$othertmp=$commonDao->get_data_tbl("member_reserve_detail","reserve_no",$reserve_no);
					for($j=0;$j<count($othertmp);$j++){
						if($othertmp[$j]['buy_no']==0){//割り振られていないので消す
							$commonDao->del_Data("member_reserve_detail", "no", $othertmp[$j]['no']);

							//削除する予約のログを取得する
							$delfi=array();
							$delfi['member_id']=$dtmp[$i]['member_id'];
							$delfi['reserve_no']=$reserve_no;
							$delfi['detail_no']=$othertmp[$j]['no'];
							$delfi['reserve_date']=$dtmp[$i]['reserve_date'];
							$delfi['start_time']=$dtmp[$i]['start_time'];
							$delfi['act']="未払いコースの購入削除による予約削除：顧客の履歴より。お連れ様の削除";
							$delfi['user_id']=$login_admin['user_id'];
							$delfi['insert_date']=date("Y-m-d H:i:s");
							$commonDao->InsertItemData2("reserve_del_history", $delfi);

						}
					}
					//最終的な人数によりmember_reserveを消す　or 人数を変える
					$sql="select * from member_reserve_detail where reserve_no=".$reserve_no. " and visit_flg<>99";
					$zanTmp=$commonDao->get_sql($sql);
					if(!$zanTmp){
						$commonDao->del_Data("member_reserve", "reserve_no",$reserve_no);
					}
					else{
						$numb=count($zanTmp);
						$commonDao->updateData("member_reserve", "number", $numb, "reserve_no",$reserve_no);
					}

//				}

			}

		return true;

	}

	/**
	 *
	 *	選択した親クーポンカテゴリから子クーポンを取得してプルダウン作成
	 *
	 */
	public function getHistoryCSV($member_id,$isiPad) {

		$commonDao = new CommonDao();
		$dao = new MemberDao();

		//コース購入実績と来店日履歴
		$buyCourseArr=$dao->getCourseInfoAll($member_id);
		for($i=0;$i<count($buyCourseArr);$i++){

			$buy="";
			if($buyCourseArr[$i]['buy_date']=="0000-00-00"){
				$buy="(未払)";
			}
			else{
//				$buy=$buyCourseArr[$i]['buy_date'];
			}
			if(!$isiPad){
				$buy=mb_convert_encoding($buy,"SJIS","UTF-8");
				$shop_name=mb_convert_encoding($buyCourseArr[$i]['shop_name'],"SJIS","UTF-8");
				$course_name=mb_convert_encoding($buyCourseArr[$i]['name'],"SJIS","UTF-8");
			}
			else{
				$shop_name=$buyCourseArr[$i]['shop_name'];
				$course_name=$buyCourseArr[$i]['name'];

			}

			//コース名
			$ctmp[]=$course_name.$buy."(".$shop_name.")";

			//来店日
			$tmp=array();
			for($j=0;$j<count($buyCourseArr[$i]['reserve']);$j++){

				//状況
				if($buyCourseArr[$i]['reserve'][$j]['visit_flg']==0){
					$visit="ご予約中";
				}
				else if($buyCourseArr[$i]['reserve'][$j]['visit_flg']==1){
					$visit="ご来店";
				}
				else if($buyCourseArr[$i]['reserve'][$j]['visit_flg']==99){
					$visit="キャンセル";
				}

				if(!$isiPad){
					$visit=mb_convert_encoding($visit,"SJIS","UTF-8");
					$menu_name=mb_convert_encoding($buyCourseArr[$i]['reserve'][$j]['menu_name'],"SJIS","UTF-8");
				}
				else{
					$menu_name=$buyCourseArr[$i]['reserve'][$j]['menu_name'];
				}

				$start_time=substr($buyCourseArr[$i]['reserve'][$j]['start_time'],0,5);

				$tmp[]=$menu_name.$buyCourseArr[$i]['reserve'][$j]['reserve_date']." ".$start_time."(".$visit.")";

			}

			if($tmp){
				$ctmp[]=implode("/", $tmp);
			}

		}

		return $ctmp;

	}

	public function cancelAction(){

		$wh = $tbl = $where = '';
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$search = 1;
		$search_flag = false;

		$dao = new MemberDao();
		$commonDao = new CommonDao();

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search['name']=$_POST['name'];
			$search['member_no']=$_POST['member_no'];

			$_SESSION['search_condition']=$search;

		}
		/*else if(isset($_POST['submit'])){
			// exit();
			$input_data=$_POST;

			$buy_no=$_POST['buy_no'];
			$tmp=$commonDao->get_data_tbl("member_buy","buy_no",$buy_no);
			$db_data=$tmp[0];

			//購入日とする日
			if($_POST['buy_date']!=""){
				$buy_date=$_POST['buy_date'];
			}
			else{
				$buy_date=date("Y-m-d");
			}

			//選択したコースの使用期限を出す
			$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$db_data['course_no']);
			if($ctmp[0]['invite_flg']==0){//通常コースであれば期限を入れる（招待コースは入れない）
				$limit_month=$ctmp[0]['limit_month'];

				$bdt=explode("-",$buy_date);
				$ins[]="limit_date='".date("Y-m-d",mktime(0,0,0,$bdt[1]+$limit_month,$bdt[2],$bdt[0]))."'";

				//$ins[]="limit_date='".date("Y-m-d",mktime(0,0,0,date("m")+$limit_month,date("d"),date("Y")))."'";
			}
			//購入日（売上日となる）
			//$ins[]="buy_date='".date("Y-m-d")."'";
			$ins[]="buy_date='".$buy_date."'";

			//クーポンがあれば  クーポン利用時　割引用クーポンか
			if($input_data['coupon_id']>0){
				$couponTmp=$commonDao->get_data_tbl("mst_category1","id",$input_data['coupon_id']);
				//割引と合計金額を訂正登録
				$ins[]="discount=".$couponTmp[0]['fee'];

				$ins[]="total_fee=".($ctmp[0]['fee']-$couponTmp[0]['fee']);
				$ins[]="coupon_id=".$input_data['coupon_id'];
			}

			$ins[]="fee_flg=1";

			$setStr=implode(",",$ins);

			$sql="update member_buy set $setStr where buy_no=".$buy_no;
			$commonDao->run_sql($sql);
			//$sql="update member_buy set $setStr where buy_no=(select bno from (select b.buy_no as bno from member_buy as b,member_reserve_detail as d where b.buy_no=d.buy_no and d.no=".$no." ) as tmp1)";
			//$commonDao->run_sql($sql);

				$this->addMessage("info", "選択した未払いのコースを購入済みにしました。");

		}*/
		else if(isset($_POST['del_submit'])){
			//未購入コースと予約を完全にDBから削除する
			$buy_no=$_POST['buy_no'];

			$this->delUnpayCourse($buy_no);

			$this->addMessage("info", "未払いコース購入と予約を削除しました。");


		}
		else{
			if(isset($_SESSION['search_condition'])) unset($_SESSION['search_condition']);
		}



		if(isset($_SESSION['search_condition'])){
			$search = $_SESSION['search_condition'];
		}

		if($login_admin['shop_no']>0){
			$wh = " and b.shop_no=".$login_admin['shop_no'];
		}

		if(isset($search["name"]) || isset($search["member_no"])){

			$tmp=array();

			$tbl=",member as m ";

			$whTmp[]=" b.member_id=m.member_id";

			//名前
			if($search["name"]){
				$tmp[]="concat(m.name,m.name_kana) like '%".addslashes($search["name"])."%'";
				$tmp[]="m.name_kana like '%".addslashes($search["name"])."%'";
				$whTmp[]="(".implode(" or ",$tmp).")";

			}
			if($search["member_no"]){
				$whTmp[]="m.member_no like '%".addslashes($search["member_no"])."%'";
			}

			if($whTmp){
				$where=" and ".implode(" and ",$whTmp);
			}

		}


		if(isset($search)){
	//		$sql="select distinct d.*,b.course_no from member_buy as b,member_reserve_detail as d $tbl
	//			where b.buy_no=d.buy_no and reserve_no>0 and b.fee_flg=0".$wh.$where;
			
			$sql="select distinct b.* from member_buy as b,member_reserve_detail as d $tbl
				where b.buy_no=d.buy_no and reserve_no>0 and b.fee_flg=0 and d.visit_flg=99 limit 30".$wh.$where;

			$arr=$commonDao->get_sql($sql);

			for($i=0;$i<count($arr);$i++){

				$tmp = $commonDao->get_data_tbl("member","member_id",$arr[$i]['member_id']);

				$arr[$i]['name']=$tmp[0]['name'];
				$arr[$i]['name_kana']=$tmp[0]['name_kana'];
				$arr[$i]['tel']=$tmp[0]['tel'];
				$arr[$i]['member_no']=$tmp[0]['member_no'];

				$tmp=$commonDao->get_data_tbl("shop","shop_no",$arr[$i]['shop_no']);
				@$arr[$i]['shop_name']=$tmp[0]['name'];

				$tmp=$commonDao->get_data_tbl("mst_course","course_no",$arr[$i]['course_no']);
				// echo "<pre>";print_r($tmp);
				$arr[$i]['course_name']=$tmp[0]['name'];
				$arr[$i]['fee']=$tmp[0]['fee'];

				//該当のbuy_noで予約されている情報の取得
				$arrTmp=array();
	//			$reTmp=$commonDao->get_data_tbl("member_reserve_detail","buy_no",$arr[$i]['buy_no']);
				$reTmp=$commonDao->get_sql("select * from member_reserve_detail where reserve_no>0 and visit_flg=99 and buy_no=".$arr[$i]['buy_no']);
				// echo "<pre>"; print_r($reTmp); exit();

				for($j=0;$j<count($reTmp);$j++){

					$reserve_date=str_replace("-","/",$reTmp[$j]['reserve_date']);
					$startTmp=explode(":",$reTmp[$j]['start_time']);

					//メニュー名
					if($reTmp[$j]['visit_flg']==99){
						$arrTmp[]="キャンセル<br />(".$reserve_date." ".$startTmp[0].":".$startTmp[1].")";
					}
					else{
						$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reTmp[$j]['menu_no']);
						$arrTmp[]=$tmp[0]['name']."<br />(".$reserve_date." ".$startTmp[0].":".$startTmp[1].")";
					}

				}
				if($arrTmp){
					$arr[$i]['menu_name']=implode("<br />",$arrTmp);
				}


	//			$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$arr[$i]['menu_no']);
	//			$arr[$i]['menu_name']=$tmp[0]['name'];


			}
			
			//デフォルト日付
			$buy_date=date("Y-m-d");
			$this->view->assign("buy_date", $buy_date);

			$this->view->assign("arr", $arr);
			$this->view->assign("search", $search);
			$this->view->assign("total_count", count($arr));

			//クーポン
			/*$tmp=$commonDao->get_data_tbl("mst_category1","cflag",1,"v_order");
			$couPaArr=makePulldownTableList($tmp, "id", "name",1);
			$this->view->assign("couPaArr", $couPaArr);*/
		}




		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/cancelList.tpl");
		return;
	}

	public function noShowUpAction(){
		

		$wh= '';
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$search = null;
		$search_flag = false;

		$dao = new MemberDao();
		$commonDao = new CommonDao();

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search['name']=$_POST['name'];
			$search['member_no']=$_POST['member_no'];

			$_SESSION['search_condition']=$search;

		}
		/*else if(isset($_POST['submit'])){
			// exit();
			$input_data=$_POST;

			$buy_no=$_POST['buy_no'];
			$tmp=$commonDao->get_data_tbl("member_buy","buy_no",$buy_no);
			$db_data=$tmp[0];

			//購入日とする日
			if($_POST['buy_date']!=""){
				$buy_date=$_POST['buy_date'];
			}
			else{
				$buy_date=date("Y-m-d");
			}

			//選択したコースの使用期限を出す
			$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$db_data['course_no']);
			if($ctmp[0]['invite_flg']==0){//通常コースであれば期限を入れる（招待コースは入れない）
				$limit_month=$ctmp[0]['limit_month'];

				$bdt=explode("-",$buy_date);
				$ins[]="limit_date='".date("Y-m-d",mktime(0,0,0,$bdt[1]+$limit_month,$bdt[2],$bdt[0]))."'";

				//$ins[]="limit_date='".date("Y-m-d",mktime(0,0,0,date("m")+$limit_month,date("d"),date("Y")))."'";
			}
			//購入日（売上日となる）
			//$ins[]="buy_date='".date("Y-m-d")."'";
			$ins[]="buy_date='".$buy_date."'";

			//クーポンがあれば  クーポン利用時　割引用クーポンか
			if($input_data['coupon_id']>0){
				$couponTmp=$commonDao->get_data_tbl("mst_category1","id",$input_data['coupon_id']);
				//割引と合計金額を訂正登録
				$ins[]="discount=".$couponTmp[0]['fee'];

				$ins[]="total_fee=".($ctmp[0]['fee']-$couponTmp[0]['fee']);
				$ins[]="coupon_id=".$input_data['coupon_id'];
			}

			$ins[]="fee_flg=1";

			$setStr=implode(",",$ins);

			$sql="update member_buy set $setStr where buy_no=".$buy_no;
			$commonDao->run_sql($sql);
			//$sql="update member_buy set $setStr where buy_no=(select bno from (select b.buy_no as bno from member_buy as b,member_reserve_detail as d where b.buy_no=d.buy_no and d.no=".$no." ) as tmp1)";
			//$commonDao->run_sql($sql);

				$this->addMessage("info", "選択した未払いのコースを購入済みにしました。");

		}*/
		else if(isset($_POST['del_submit'])){
			//未購入コースと予約を完全にDBから削除する
			$buy_no=$_POST['buy_no'];

			$this->delUnpayCourse($buy_no);

			$this->addMessage("info", "未払いコース購入と予約を削除しました。");


		}
		else{
			if(isset($_SESSION['search_condition'])) unset($_SESSION['search_condition']);
		}



		if(isset($_SESSION['search_condition'])){
			$search = $_SESSION['search_condition'];
		}

		if($login_admin['shop_no']>0){
			$wh = " and b.shop_no=".$login_admin['shop_no'];
		}

		if(isset($search)){

			$tmp=array();

			$tbl=",member as m ";

			$whTmp[]=" b.member_id=m.member_id";

			//名前
			if($search["name"]){
				$tmp[]="concat(m.name,m.name_kana) like '%".addslashes($search["name"])."%'";
				$tmp[]="m.name_kana like '%".addslashes($search["name"])."%'";
				$whTmp[]="(".implode(" or ",$tmp).")";

			}
			if($search["member_no"]){
				$whTmp[]="m.member_no like '%".addslashes($search["member_no"])."%'";
			}

			if($whTmp){
				$where=" and ".implode(" and ",$whTmp);
			}

		}


		if($search){
	//		$sql="select distinct d.*,b.course_no from member_buy as b,member_reserve_detail as d $tbl
	//			where b.buy_no=d.buy_no and reserve_no>0 and b.fee_flg=0".$wh.$where;
			
			$sql="select distinct b.* from member_buy as b,member_reserve_detail as d $tbl
				where b.buy_no=d.buy_no and reserve_no>0 and b.fee_flg=0 and d.visit_flg=2".$wh.$where;

			$arr=$commonDao->get_sql($sql);

			for($i=0;$i<count($arr);$i++){

				$tmp = $commonDao->get_data_tbl("member","member_id",$arr[$i]['member_id']);

				$arr[$i]['name']=$tmp[0]['name'];
				$arr[$i]['name_kana']=$tmp[0]['name_kana'];
				$arr[$i]['tel']=$tmp[0]['tel'];
				$arr[$i]['member_no']=$tmp[0]['member_no'];

				$tmp=$commonDao->get_data_tbl("shop","shop_no",$arr[$i]['shop_no']);
				@$arr[$i]['shop_name']=$tmp[0]['name'];

				$tmp=$commonDao->get_data_tbl("mst_course","course_no",$arr[$i]['course_no']);
				$arr[$i]['course_name']=$tmp[0]['name'];
				$arr[$i]['fee']=$tmp[0]['fee'];

				//該当のbuy_noで予約されている情報の取得
				$arrTmp=array();
	//			$reTmp=$commonDao->get_data_tbl("member_reserve_detail","buy_no",$arr[$i]['buy_no']);
				$reTmp=$commonDao->get_sql("select * from member_reserve_detail where reserve_no>0 and visit_flg=2 and buy_no=".$arr[$i]['buy_no']);
				// echo "<pre>"; print_r($reTmp); exit();

				for($j=0;$j<count($reTmp);$j++){

					$reserve_date=str_replace("-","/",$reTmp[$j]['reserve_date']);
					$startTmp=explode(":",$reTmp[$j]['start_time']);

					//メニュー名
					if($reTmp[$j]['visit_flg']==99){
						$arrTmp[]="キャンセル<br />(".$reserve_date." ".$startTmp[0].":".$startTmp[1].")";
					}
					else{
						$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reTmp[$j]['menu_no']);
						$arrTmp[]=$tmp[0]['name']."<br />(".$reserve_date." ".$startTmp[0].":".$startTmp[1].")".$reTmp[$j]['no'];
					}

				}
				if($arrTmp){
					$arr[$i]['menu_name']=implode("<br />",$arrTmp);
				}


	//			$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$arr[$i]['menu_no']);
	//			$arr[$i]['menu_name']=$tmp[0]['name'];


			}

			//デフォルト日付
			$buy_date=date("Y-m-d");
			$this->view->assign("buy_date", $buy_date);

			$this->view->assign("arr", $arr);
			$this->view->assign("search", $search);
			$this->view->assign("total_count", count($arr));

			//クーポン
			/*$tmp=$commonDao->get_data_tbl("mst_category1","cflag",1,"v_order");
			$couPaArr=makePulldownTableList($tmp, "id", "name",1);
			$this->view->assign("couPaArr", $couPaArr);*/
		}

		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/noShowUpList.tpl");
		return;
	}
}
?>

