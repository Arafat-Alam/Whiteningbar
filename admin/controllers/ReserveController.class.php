<?php
class ReserveController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();


	}

	/**
	 *  予約一覧表示・検索
	 */
	public function listAction() {
		$arr =  array();
		$sort = null;
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);
		
		$search = null;
		$search_flag = false;
		$limit=ADMIN_V_CNT;
			
		
		$dao = new ReserveDAO();
		$shopDao = new ShopDAO();
		$commonDao = new CommonDao();
		
		//$_REQUEST['page'] = 1;
		if(isset($_REQUEST['page'])){
			$page = $_REQUEST['page'];
		} /// comment by arafat
		// 検索送信ボタンが押下されているか？
		
		if (isset($_POST["sbm_search"])) {

			@$search['shop_no']=$_POST['shop_no'];
			// $search['start_date']=$_POST['start_date'];
			// $search['end_date']=$_POST['end_date'];
			@$search['ins_start']=$_POST['ins_start'];
			@$search['ins_end']=$_POST['ins_end'];
			@$search['name']=$_POST['name'];
			@$search['course_no']=$_POST['course_no'];
			@$search['menu_no']=$_POST['menu_no'];
			@$search['orderby']=$_POST['orderby'];
			@$search['visit_flg_parts']=1;//予約中、来店のみ。
			
			//ソート
			if (isset($_POST['orderby'])) {

				if($_POST['orderby']==1){
				$sort="reserve_date desc, start_time desc";
				}
				else if($_POST['orderby']==2){
					$sort="reserve_date, start_time";
				}
				else if($_POST['orderby']==3){
					$sort="r.insert_date desc";
				}
				else if($_POST['orderby']==4){
					$sort="r.insert_date";
				}
				else{
					$sort="reserve_date desc, start_time desc";
				}
			}
			
			if (isset($_POST['orderSelect']) && $_POST['orderSelect'] <> 'none' && $_POST['orderSelect'] != null) {
				if ($_POST['orderSelect'] == 'shop') {
					$sort="".$_POST['orderSelect']." ASC, reserve_date DESC, start_time DESC ";
				}else{
					$sort="".$_POST['orderSelect']." DESC, start_time DESC";
				}
				$this->view->assign('ord', $_POST['orderSelect']);
			}else{
				$sort="reserve_date DESC, start_time DESC";
			}

			$search['page']=1;

			$_SESSION['search_jyoken']=$search;
			$_SESSION['sort']=$sort;
		}
	 	else if (isset($_POST["submit_today"])) {

			$search['start_date']=date("Y-m-d");
			$search['end_date']=date("Y-m-d");
			$search['visit_flg_parts']=1;//予約中、来店のみ。

			$search['page']=1;

			$_SESSION['search_jyoken']=$search;
		}
		// ページ番号が渡されたか？
		else if (isset($page)) {
			// ページングによる遷移
			$search = $_SESSION['search_jyoken'];
			$sort = $_SESSION['sort'];
			// $search['page']=$this->request->getParam("page");
			$search['page']=$page;

		}
		else if(isset($_POST['submit'])){
			$search = $_SESSION['search_jyoken'];
			$sort = $_SESSION['sort'];

			//更新処理
			$ins['tel_flg']=$_POST['tel_flg'];
			$ins['kanri_comment']=$_POST['kanri_comment'];
			$wfi['reserve_no']=$_POST['reserve_no'];

			$ret=$commonDao->updateData2("member_reserve", $ins, $wfi);



		}
		else if(isset($_POST['csv'])){
			$search = $_SESSION['search_jyoken'];
			$sort = $_SESSION['sort'];
			$limit="";
		}
		else if($_POST || isset($_GET['back'])){
			$search = $_SESSION['search_jyoken'];
			$sort = $_SESSION['sort'];
			echo "dsf";
			exit();
//			$limit=ADMIN_V_CNT;

		}
		else {
			// sessionに検索条件が保存されている場合

			if(isset($_SESSION['search_jyoken'])) unset($_SESSION['search_jyoken']);
			$search['start_date']=date("Y-m-d");
			$search['end_date']=date("Y-m-d");
			$search['page']=1;
			$search['visit_flg_parts']=1;//予約中、来店のみ。
			
			/*if (isset($_GET['orderby']) && $_GET['orderby'] <> 'none') {
				if ($_GET['orderby'] == 'shop') {
					$sort="".$_GET['orderby']." ASC, reserve_date DESC, start_time DESC ";
				}else{
					$sort="".$_GET['orderby']." DESC, start_time DESC";
				}
				$this->view->assign('ord', $_GET['orderby']);
			}else{
				$sort="reserve_date DESC, start_time DESC";
			}*/


			$_SESSION['search_jyoken']=$search;
			$_SESSION['sort']=$sort;
		}

		//店舗
		$tmp=$commonDao->get_data_tbl("shop");
		$shopArr=makePulldownTableList($tmp,"shop_no","name",1);
		$this->view->assign("shopArr", $shopArr);
		
		//$arr = $shopArr;

		//
		if($login_admin['shop_no']>0){
			//店舗ログインなので、該当店舗の予約のみで検索
			$search["shop_no"]=$login_admin['shop_no'];
		}


		$total_cnt=$dao->searchCount($search);


		$lastPage = 0;
		if($limit!="" && $total_cnt>$limit){
			list($page_navi,$lastPage) = get_page_navi2($total_cnt, $limit, $search['page'], "/reserve/list/");
			$this->view->assign("navi", $page_navi);
		}
		$this->view->assign("lastPage", $lastPage);
		//店舗名とメニュー名を取得する
		list($arr,$to,$from) = $dao->search($search,$sort,$limit);
			// echo "<pre>"; print_r($arr);
 			$to = $to+$from;
			if ($to > $total_cnt) {
				$to = $total_cnt;
			}
		
		// echo $from.','.$to;
		//exit();
		if ($to > 0) {
			$from = $from + 1;
		}
		$this->view->assign('to', $to);
		$this->view->assign('from', $from);
		for($i=0;$i<count($arr);$i++){
			@$arr[$i]['shop_name']=$shopDao->getShopName($arr[$i]['shop']);
			@$arr[$i]['menu_name']=$shopDao->getMenuName($arr[$i]['menu_no']);
		}

		//CSV出力
		//ダウンロード処理
		// echo "string";exit();
		if(isset($_POST['csv'])){

			//iPadであれば文字コード変換をしない
			$isiPad = (bool) strpos($_SERVER['HTTP_USER_AGENT'],'iPad');


			$txt="予約番号,予約日,時間,お申込者,予約店舗,メニュー,人数,管理メモ\n";
			if(!$isiPad){
				$txt=mb_convert_encoding($txt,"SJIS","UTF-8");
			}
			for($i=0;$i<count($arr);$i++){
				$csvTmp=array();
				$csvTmp[]=$arr[$i]['reserve_no'];
				$csvTmp[]=$arr[$i]['reserve_date'];
				$csvTmp[]=$arr[$i]['start_time'];
				if(!$isiPad){
					$csvTmp[]=mb_convert_encoding($arr[$i]['name'],"SJIS","UTF-8");
					$csvTmp[]=mb_convert_encoding($arr[$i]['shop_name'],"SJIS","UTF-8");
					$csvTmp[]=mb_convert_encoding($arr[$i]['menu_name'],"SJIS","UTF-8");
				}
				else{
					$csvTmp[]=$arr[$i]['name'];
					$csvTmp[]=$arr[$i]['shop_name'];
					$csvTmp[]=$arr[$i]['menu_name'];
				}
				$csvTmp[]=$arr[$i]['number'];
				if(!$isiPad){
					$csvTmp[]='"'.mb_convert_encoding($arr[$i]['kanri_comment'],"SJIS","UTF-8").'"';
				}
				else{
					$csvTmp[]=str_replace("\n","",$arr[$i]['kanri_comment']);
//					$csvTmp[]=$arr[$i][kanri_comment];
				}

				$csvArr[]=implode(",",$csvTmp);
			}


			$csvF=$txt.implode("\n", $csvArr);
			$fname="reserve.csv";
			execDownloadNoFile($csvF, $fname);

		}


		//電話対応配列
		$telArr=CommonArray::$adminReserveTel_array;
		$this->view->assign("telArr", $telArr);


		//コース
		$tmp=$commonDao->get_data_tbl("mst_course","","","v_order");
		$courseArr=makePulldownTableList($tmp,"course_no", "name",1);
		$this->view->assign("courseArr", $courseArr);


		$this->view->assign("arr", $arr);
		$this->view->assign("total_cnt", $total_cnt);
		
		$this->view->assign("search", $search);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("reserve/list.tpl");
		return;
	}


	/**
	 * 予約情報更新
	 */
	public function editAction() {


		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);


		$dao = new ReserveDAO();
		$commonDao = new CommonDao();

		$reserve_no=$_GET['reserve_no'];

		if(!$reserve_no || $reserve_no==""){
			$this->addMessage("error","予約番号が取得できませんでした");
			$this->setTemplatePath("error.tpl");
			return;
		}

		$search['reserve_no']=$reserve_no;

		if($_POST['submit']){

			//編集処理
			$input_data=$_POST;
			$ins['tel_flg']=$input_data['tel_flg'];
			$ins['kanri_comment']=$input_data['kanri_comment'];
			$wfi['reserve_no']=$input_data['reserve_no'];

			$ret=$commonDao->updateData2("member_reserve", $ins, $wfi);
			if($ret){
				$this->addMessage("info","予約情報を更新しました。");
			}
			else{
				$this->addMessage("error","予約情報更新に失敗しました");
			}

				$this->view->assign("finish_flg", 1);

		}


		$tmp=$dao->search($search);
		$input_data=$tmp[0];

		//来店予約者名
		$dtmp=$commonDao->get_data_tbl("member_reserve_detail","reserve_no",$input_data['reserve_no'],"no");

		for($i=0;$i<count($dtmp);$i++){

			if($dtmp[$i]['member_id']>0){
				$tmp=$commonDao->get_data_tbl("member","member_id",$dtmp[$i]['member_id']);
				$input_data['detail'][$i]=$tmp[0];
			}
			else{
				$input_data['detail'][$i]['name']="お名前未定";
				$input_data['detail'][$i]['member_id']="0";
			}

			$input_data['detail'][$i]['no']=$dtmp[$i]['no'];

		}

		//顧客情報
		$tmp=$commonDao->get_data_tbl("member","member_id",$input_data['member_id']);
		$db_memberArr=$tmp[0];
		$this->view->assign("db_memberArr", $db_memberArr);


		//コース番号からそのコースに該当するメニューをチョイス
		$sql="select c.*,b.coupon_id from member_buy as b,mst_course as c where b.course_no=c.course_no and b.buy_no=".$input_data['buy_no'];
		$tmp=$commonDao->get_sql($sql);
		$db_courseArr=$tmp[0];//購入コース情報
		//クーポン名取得
		$tmp=$commonDao->get_data_tbl("mst_category1","id",$db_courseArr['coupon_id']);
		$db_courseArr['coupon_name']=$tmp[0]['name'];
		$this->view->assign("db_courseArr", $db_courseArr);



		//メニュー名
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$input_data['menu_no']);
		$input_data['menu_name']=$tmp[0]['name'];

		//店舗
		$tmp=$commonDao->get_data_tbl("shop","shop_no",$input_data['shop_no']);
		$input_data['shop_name']=$tmp[0]['name'];



		//電話対応配列
		$telArr=CommonArray::$adminReserveTel_array;
		$this->view->assign("telArr", $telArr);


		//予約時間の分のプルダウン用配列
		$timeArr=CommonArray::$rsv_time_array;
		$this->view->assign("timeArr", $timeArr);

		$this->view->assign("input_data", $input_data);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("reserve/edit.tpl");
		return;


	}

	/**
	 *	予約　来店者の詳細情報　
	 */
	public function detailAction() {
		$payArr = '';
		$dao = new ReserveDAO();
		$memberDao = new MemberDAO();
		$commonDao = new CommonDao();
		$reserveDao = new ReserveDAO();
		// print_r($_REQUEST);exit();
//		$member_id=$_POST['member_id'];
		$no=$_REQUEST['no'];//予約詳細番号
//		$reserve_no=$_REQUEST['reserve_no'];


		if(!$no || $no==""){
			$this->addMessage("error","予約詳細が取得できませんでした");
			$this->setTemplatePath("error.tpl");
			return;
		}

		//カレンダーでの詳細編集の場合のみ
		if($_POST['dt'] && $_POST['dt']!=0){
			$param="?dt=".$_POST['dt'];
			$this->view->assign("param", $param);
			$this->view->assign("dt", $_POST['dt']);
			$_SESSION['reserve_value']['dt']=$_POST['dt'];
		}
		else if(isset($_SESSION['reserve_value']['dt'])){
			$param="?dt=".$_SESSION['reserve_value']['dt'];
			$this->view->assign("param", $param);
			$this->view->assign("dt", $_SESSION['reserve_value']['dt']);

		}

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();

		//削除処理(カレンダーからの予約削除）
		if(isset($_POST['del_submit'])){


			//reserve_noをだす
			$tmp=$commonDao->get_data_tbl("member_reserve_detail", "no", $no);

			$reserve_no=$tmp[0]['reserve_no'];

			//該当の予約がコース購入の場合、とりあえず・・・購入コースは終了フラグを外しておけば問題ない。(使用期限を超えていなければ）
			$rTmp=$commonDao->get_data_tbl("member_reserve_detail", "reserve_no", $reserve_no);

			for($i=0;$i<count($rTmp);$i++){

				$delNo=$rTmp[$i]['no'];
				//いったんキャンセルにしてからのフラグ変更（回数を数える時にキャンセル扱いしないと回数に入るので）
				$commonDao->updateData("member_reserve_detail", "visit_flg", "99", "no", $delNo);
				$memberDao->changeFinishFlgInfo($delNo);


				//削除する予約のログを取得する
				$delfi=array();
				$delfi['member_id']=$rTmp[$i]['member_id'];
				$delfi['reserve_no']=$reserve_no;
				$delfi['detail_no']=$delNo;
				$delfi['reserve_date']=$rTmp[$i]['reserve_date'];
				$delfi['start_time']=$rTmp[$i]['start_time'];
				$delfi['act']="カレンダーからの予約削除処理";
				$delfi['user_id']=$login_admin['user_id'];
				$delfi['insert_date']=date("Y-m-d H:i:s");
				$commonDao->InsertItemData2("reserve_del_history", $delfi);

			}

			$commonDao->del_Data("member_reserve_detail", "reserve_no", $reserve_no);
			$commonDao->del_Data("member_reserve", "reserve_no", $reserve_no);
			//2回連続の場合の削除
			$commonDao->del_Data("member_reserve_detail", "p_no", $no);

			//削除ヒストリー


			$this->addMessage("error","予約を削除しました。");
			$this->view->assign("finish_flg", 1);
			$this->view->assign("del_flg", 1);

		}



		//詳細表示のみ
		$db_data=$dao->getDetailInfo($no);

		if(isset($_POST['submit'])){
			$input_data=$_POST;
			$baseData=CommonChkArray::$rsvDetailCheckData;
			

			if($input_data['visit_flg']!=99){//キャンセルの場合は必要無し
				// $this->check($input_data,$baseData);
				//１．メニュー選択プルダウンが表示されて、メニュー選択された場合は該当メニューの所要時間でブースの空きがあるかを再チェック
				//２．連続コースにした場合、メニューチケットが余っているかチェック（メニュー選択時、チケット残を取得して、選択可能なメニューだけを出すようにするのでチェック不要）
				if($input_data['menu_no']){
					$tmp=explode(":",$input_data['start_time']);
					$input_data['hour']=$tmp[0];
					$input_data['minute']=$tmp[1];

					list($chkResult,$input_data)=$this->chkReserve($input_data);

					if(!$chkResult){
						$this->addMessage("error","大変申し訳ございません。ご予約がいっぱいで予約が出来ません");
					}
				}
			}
				

			//-------------- ここまで -----------------------------------
			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
				$this->view->assign("finish_flg", 1);
			}
			else{

				//変更前のデータ取得
				//予約番号取得
				$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
				$oldReserveArr=$tmp[0];
				$rtmp=$commonDao->get_data_tbl("member_reserve","reserve_no",$tmp[0]['reserve_no']);
				$oldReserveArr['number']=$rtmp[0]['number'];
				//----------------------------------------------
				//フォーム内容更新処理
				foreach($baseData['dbstring'] as $key=>$val){
						$fi[$key]=$input_data[$key];
				}

				//メニュープルダウンの場合は登録
				if($input_data['menu_no']){
					$fi['menu_no']=$input_data['menu_no'];
				}

				//未定だった来店者が決まったら（新規予約やお連れ様）
				if($input_data['member_id']){
					$fi['member_id']=$input_data['member_id'];//member_reserve_detail 更新用配列

					if(!$_SESSION['reserve_value']['buy_no']){
						//コース購入処理をしていないのでコース購入を行う 2014.9.9add
						//予約カレンダーからのコース未購入の購入処理
							//メニュー情報
							$mtmp=$commonDao->get_data_tbl("mst_menu","menu_no",$input_data['menu_no']);

							//選択したコースの使用期限を出す
							$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$mtmp[0]['course_no']);
							$limit_month=$ctmp[0]['limit_month'];

							//登録データ
							$ins['member_id']=$input_data['member_id'];
							$ins['shop_no']=$db_data['shop_no'];
							$ins['course_no']=$mtmp[0]['course_no'];
							$ins['fee']=$ctmp[0]['fee'];
							$ins['total_fee']=$ctmp[0]['fee'];
							//ご招待コースの場合は期限を入れない
							if($ctmp[0]['invite_flg']==0){//通常コース
								$ins['limit_date']=date("Y-m-d",mktime(0,0,0,date("m")+$limit_month,date("d"),date("Y")));
							}
							$ins['insert_date']=date("Y-m-d H:i:s");
							$ins['update_date']=date("Y-m-d H:i:s");
							$buy_no=$commonDao->InsertItemData2("member_buy", $ins);

							$fi['buy_no']=$buy_no;//member_reserve_detail 更新用配列
					}
					else if($input_data['buy_no']){
						$fi['buy_no']=$input_data['buy_no'];
					}
				}

				$wfi['no']=$no;

				//暫定処置 予約終了時間が入っていない場合はここで入れる//2015.01.08 //start_timeとend_timeが同じ場合も 2015.04.14 add
				if($fi['end_time']==""){
					//ご希望コースの所要時間
					$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$fi['menu_no']);
					$rtimes=$tmp[0]['times'];//所要時間
					$rsv_date=explode("-",$fi['reserve_date']);
					$rsv_time=explode(":",$fi['start_time']);

					$fi['end_time']=date("H:i:00",mktime($rsv_time[0],$rsv_time[1]+$rtimes,0,$rsv_date[1],$rsv_date[2],$rsv_date[0]));//menuと希望期間から終了時間を出す
				}


				$ret=$commonDao->updateData2("member_reserve_detail", $fi, $wfi);

				if($ret){

					if($input_data['visit_flg']!=99){//キャンセルの場合は必要無し
						//予約の日時が変わっている場合、お連れ様も同時に変更させる必要があるので。チェック
						if($oldReserveArr['reserve_date']<>$input_data['reserve_date'] || $oldReserveArr['start_time']<>$input_data['start_time']){
							$fi=array();
							$fi['reserve_date']=$input_data['reserve_date'];
							$fi['start_time']=$input_data['start_time'];
							$fi['end_time']=$input_data['end_time'];
							$rwfi['reserve_no']=$oldReserveArr['reserve_no'];
							$commonDao->updateData2("member_reserve_detail", $fi, $rwfi);

						}
					}

					if($input_data['visit_flg']!=99){


						//========== 予約人数の変更であれば、detailの変更が必要になる。==================
						//人数が増えた場合は、予約を増やす
						//人数が減った場合は、減った場合の予約を取り消す（キャンセルで良いかな）
							if($oldReserveArr['number']<$input_data['number']){//予約人数が増えた
								$loop=$input_data['number']-$oldReserveArr['number'];
								for($i=0;$i<$loop;$i++){
									//詳細
									$fi=array();
									$fi['reserve_no']=$oldReserveArr['reserve_no'];
									$fi['menu_no']=$input_data['menu_no'];
									$fi['insert_date']=date("Y-m-d H:i:s");
									$fi['update_date']=date("Y-m-d H:i:s");
									//フォーム内容更新処理
									foreach($baseData['dbstring'] as $key=>$val){
											$fi[$key]=$input_data[$key];
									}
									$commonDao->InsertItemData2("member_reserve_detail", $fi);
								}

								//サマリー 人数変更//2015.01.08
								$fi=array();
								$fi['number']=$input_data['number'];
								$swfi['reserve_no']=$oldReserveArr['reserve_no'];
								$commonDao->updateData2("member_reserve",$fi,$swfi);

							}
							else if($oldReserveArr['number']>$input_data['number']){//予約人数が減った
								//該当の予約番号で、予約データを減った分だけ取得して、キャンセル扱いいする（会員が割り振られていない場合）
								$fi=array();
								$fi['reserve_no']=$oldReserveArr['reserve_no'];
								$fi['member_id']=0;
								$fi['visit_flg']=0;
								$dtmp=$commonDao->get_data_tbl2("member_reserve_detail",$fi,"buy_no asc");
								$loop=$oldReserveArr['number']-$input_data['number'];

								if($dtmp){//2015.01.08
									for($i=0;$i<$loop;$i++){
										$fi=array();
										$fi['visit_flg']=99;

										$wfi['no']=$dtmp[$i]['no'];
										$commonDao->updateData2("member_reserve_detail",$fi,$wfi);
									}

									//サマリー 人数変更 変更するデータがあった場合のみ//2015.01.08
									$fi=array();
									$fi['number']=$input_data['number'];
									$swfi['reserve_no']=$oldReserveArr['reserve_no'];
									$commonDao->updateData2("member_reserve",$fi,$swfi);
								}
							}

						//========= ここまで =========================================
					}
					else if($input_data['visit_flg']==99){
						//キャンセルした予約がお連れ様もいる予約だった場合には、サマリーの人数を減らす必要がある。

						$mrTmp=$commonDao->get_data_tbl("member_reserve","reserve_no", $oldReserveArr['reserve_no']);
						if($mrTmp[0]['number']>1){
							//人数を減らす

							$fi=array();
							$swfi=array();
							$fi['number']=$mrTmp[0]['number']-1;
							$swfi['reserve_no']=$oldReserveArr['reserve_no'];
							$commonDao->updateData2("member_reserve",$fi,$swfi);

						}

					}
						//もし、メニュー変更で連続コースを選択した場合、メニュー使用カウント分のレコードを入れる 複数回コースは予約時には1人しか予約出来ないので複数人チェックは不要
						//連続コースから1回分コースに変更した場合は、連続分のカウント用レコードを削除する
						if($input_data['menu_no']){

							if($input_data['visit_flg']!=99){//キャンセルの場合は必要無し

								//当初予定の回数よりも増えた場合 カウント用レコードの追加
								if($db_data['use_count']<$input_data['use_count']){
										$ccc=$input_data['use_count']-$db_data['use_count'];
										$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
										$fi=$tmp[0];
										for($i=0;$i<$ccc;$i++){
											$fi['no']="";
											$fi['reserve_no']="";
											$fi['p_no']=$no;
											$commonDao->InsertItemData2("member_reserve_detail", $fi);
										}

										//finishチェック
										$memberDao->getCourseCountCheck($db_data['buy_no']);//2015.04.14 add
								}

								//当初の予定よりも減った場合 不要なカウント用レコードは削除
								if($db_data['use_count']>$input_data['use_count']){
										$ccc=$db_data['use_count']-$input_data['use_count'];

										for($i=0;$i<$ccc;$i++){
											$tmp=$commonDao->get_data_tbl("member_reserve_detail","p_no",$no,"no",1);
											$commonDao->del_Data("member_reserve_detail", "no", $tmp[0]['no']);

											//finishチェック
											$memberDao->getCourseCountCheck($db_data['buy_no']);//2015.04.14 add

											//削除予約レコードのreserve_noを取得
											$tmptmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
											//削除する予約のログを取得する
											$delfi=array();
											$delfi['member_id']=$tmp[0]['member_id'];
											$delfi['reserve_no']=$tmptmp[0]['reserve_no'];
											$delfi['detail_no']=$tmp[0]['no'];
											$delfi['reserve_date']=$tmp[0]['reserve_date'];
											$delfi['start_time']=$tmp[0]['start_time'];
											$delfi['act']="連続コースから1回コースへの変更に伴う削除";
											$delfi['user_id']=$login_admin['user_id'];
											$delfi['insert_date']=date("Y-m-d H:i:s");
											$commonDao->InsertItemData2("reserve_del_history", $delfi);

										}
		//							}
								}

								//未購入のコースの予約の場合、メニューが変われば、未購入のコースの番号も変更となるので修正
								if($db_data['fee_flg']==0){
									//選択したメニューの親コース番号取得
									$mtmp=$commonDao->get_data_tbl("mst_menu","menu_no",$input_data['menu_no']);
									$course_no=$mtmp[0]['course_no'];

									//値段も変わる
									$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$course_no);
									$ufi['course_no']=$course_no;
									$ufi['fee']=$ctmp[0]['fee'];
									$ufi['total_fee']=$ctmp[0]['fee'];
									$uwfi['buy_no']=$db_data['buy_no'];

									$commonDao->updateData2("member_buy", $ufi,$uwfi);

									//$commonDao->updateData("member_buy", "course_no", $course_no, "buy_no", $db_data['buy_no']);
								}
							}

						//キャンセルの場合、使用期限が過ぎていなければ、コースのfinish_flg=0にする。（0であっても、０にしておいて間違いはない）
						if($input_data['visit_flg']==99){
							$ret=$reserveDao->cancelUpData($no);//2回連続用のダミーレコードもキャンセルにする
							if($ret){
								$memberDao->changeFinishFlgInfo($no);
							}
						}

						//来店チェックが入った場合のチェック。
						//該当コースが規定回数に達したらコースのfinish_flg=0にする
						if($input_data['visit_flg']==1){
							$memberDao->getCourseCountCheck($db_data['buy_no']);
						}

						//コース料金支払済みにチェックされていたら、料金支払とし、関連処理を行う
						//会員登録して、予約をした人は、コース購入は行っているが、未払い状態
						//来店時にコース購入料金を払うので、その時に各種処理を行う

						//会員支払項目チェックにより、支払った料金を計算して、入れる
						$commonDao->del_Data("member_pay", "detail_no", $input_data['no']);
						$total_fee=0;
						if($input_data['pay']){
							foreach($input_data['pay'] as $key=>$val){
								$tmp=$commonDao->get_data_tbl("mst_category2","id",$key);
								$fi=array();
								$fi['detail_no']=$input_data['no'];
								$fi['id']=$key;
								$fi['fee']=$tmp[0]['fee'];

								//購入日は予約日とする
								//$fi['buy_date']=date("Y-m-d H:i:s");
								$fi['buy_date']=$input_data['reserve_date']." ".$input_data['start_time'];
								$commonDao->InsertItemData2("member_pay", $fi);

								//金額をプラス
								$total_fee=$total_fee+$tmp[0]['fee'];
							}
						}
						//来店時に支払った合計を会員の予約詳細に入れる
						$fi=array();
						$fi['fee']=$total_fee;
						$ret=$commonDao->updateData2("member_reserve_detail", $fi, $wfi);

						//詳細表示のみ再取得
						$db_data=$dao->getDetailInfo($no);

						$this->addMessage("info","来店者の詳細を更新しました");

						if($_POST['ref']=="cal"){
							header("location:/calendar/list/".$param);
							exit;
						}
					}



				}

				else{
						$this->addMessage("info","来店者の詳細の更新エラーです");
				}

				if($_SESSION['reserve_value']) unset($_SESSION['reserve_value']);

				$this->view->assign("finish_flg", 1);

			}
		}
		else{
			if(isset($_SESSION['r_input_data'])) unset($_SESSION['r_input_data']);
			$input_data=$dao->getDetailInfo($no);//変更項目分

			//顧客検索で選択した会員
			if(isset($_SESSION['reserve_value']['member_id'])){
				$input_data['member_name']=$memberDao->getMemberName($_SESSION['reserve_value']['member_id']);
				$input_data['member_id']=$_SESSION['reserve_value']['member_id'];
			}
		}

		$_SESSION['r_input_data']=$input_data;
/*
		if($db_data['fee_flg']==0 && $db_data['menu_no']==0){
			//menu全取得
			$tmp=$commonDao->get_data_tbl("mst_menu","view_flg","1","v_order");
		}
		else if($db_data['fee_flg']==0 && $db_data['menu_no']!=0){

			//コースは未購入だが、メニューが決まっている（お連れ様の場合）
			$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$db_data['menu_no']);

		}
*/

		//1003作業中　メニューの変更を可能にする
		if($db_data['fee_flg']==0){

			//menu全取得
//			$tmp=$commonDao->get_data_tbl("mst_menu","view_flg","1","v_order");
			$tmp=$commonDao->get_data_tbl("mst_menu","","","v_order");

		}
		else{

			//予約のみ（未購入のコースがある場合は、変更可能にしておいて、コース名の表示を非表示にする
			//初めて会員登録して、コースを購入直後の場合には、申込メニューが未登録なので、プルダウン表示となる。
			//↑訂正：メニューは変更可能にしておく
	//		if($db_data['menu_name']==""){
				//
				//$tmp=$commonDao->get_data_tbl("mst_menu","course_no",$db_data['course_no']);
				$tmp=$memberDao->getUseMenuInfoAdmin($db_data['buy_no'],$db_data['menu_no']);//使用可能なメニュー取得（残チケットに対して）
	//		}
		}
		$menuArr=makePulldownTableList($tmp, "menu_no", "name",1);
		$this->view->assign("menuArr", $menuArr);


		//会員であれば情報取得
		if($db_data['member_id']!=0){
			$search['member_id']=$db_data['member_id'];
			$tmp=$memberDao->search($search);
			$memArr=$tmp[0];

			//コース消費
			$tmp=$memberDao->getCourseInfo($db_data['member_id']);
			$memArr['reserve']=$tmp;

		}
		else{
			//サブウィンドで選択した顧客が既に該当メニューのコースを購入していたら、表示させる（予約処理確定時に紐付も必要）
			//無い場合は、コース未購入と表示
			if($input_data['member_id']){
				//$db_data['menu_no']

				$tmp=$commonDao->get_data_tbl("mst_menu","menu_no", $db_data['menu_no']);
				$course_no=$tmp[0]['course_no'];
				$tmp=$memberDao->getCourseInfo($input_data['member_id'], $db_data['shop_no']);
				for($i=0;$i<count($tmp);$i++){
					if($tmp[$i]['course_no']==$course_no){
						$courseTmp[]=$tmp[$i];
					}
				}
				if($courseTmp){
					$courseArr=makePulldownTableList($courseTmp, "buy_no", "name");
					$this->view->assign("courseArr", $courseArr);
				}
			}

		}


		$sql = "select count(msd.`no`) as total_absence,msd.member_id from member_reserve_detail as msd where msd.member_id=".$input_data['member_id']." and msd.visit_flg=2 group by msd.member_id";
		$data = $commonDao->get_sql($sql);
		if ($data) {
			$this->view->assign("total_absence", $data[0]['total_absence']);
		}
		// echo "<pre>"; print_r($data); exit();

		//来店時にお客様が支払った項目を取得（前回チェックされているもの）
		$tmp=$commonDao->get_data_tbl("member_pay","detail_no",$no);
		for($i=0;$i<count($tmp);$i++){
			$payArr[]=$tmp[$i]['id'];
		}
		$this->view->assign("payArr", $payArr);

/*
		//クーポン
		$tmp=$commonDao->get_data_tbl("mst_category1","cflag",1,"v_order");
		$couPaArr=makePulldownTableList($tmp, "id", "name",1);
		$this->view->assign("couPaArr", $couPaArr);
*/
		//会員支払項目
		$memPayArr=$commonDao->get_data_tbl("mst_category2","cflag",1,"v_order");
//		$memPayArr=makePulldownTableList($tmp, "id", "name",1);
		$this->view->assign("memPayArr", $memPayArr);


		//店舗プルダウン
		//マイページのコース購入中の予約の場合は、店舗は購入した店舗のみ
		if($db_data['buy_no']){
			$tmp=$commonDao->get_data_tbl("member_buy","buy_no",$db_data['buy_no']);
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$tmp[0]['shop_no'],"shop_no");
			$shopArr=makePulldownTableList($tmp, "shop_no", "name");
		}
		else{
			$tmp=$commonDao->get_data_tbl("shop","","","shop_no");
			$shopArr=makePulldownTableList($tmp, "shop_no", "name",1);
		}
		$this->view->assign("shopArr", $shopArr);

		//担当者
		if($login_admin['shop_no']>0){
			$tmp=$commonDao->get_data_tbl("shop_staff",array("shop_no","view_flg"),array($login_admin['shop_no'],1));
		}
		else{
			//$tmp=$commonDao->get_data_tbl("shop_staff","view_flg","1");
			$tmp=$commonDao->get_data_tbl("shop_staff",array("shop_no","view_flg"),array($input_data['shop_no'],1));


		}
		$staffArr=makePulldownTableList($tmp,"staff_no","name",1);
		$this->view->assign("staffArr", $staffArr);

		//電話対応配列
		$telArr=CommonArray::$adminReserveTel_array;
		$this->view->assign("telArr", $telArr);



		//カレンダーでの詳細編集の場合のみ
/*
		if($_POST['dt'] && $_POST['dt']!=0){
			$param="?dt=".$_POST['dt'];
			$this->view->assign("param", $param);
			$this->view->assign("dt", $_POST['dt']);

		}
*/		
		$tmp=$commonDao->get_data_tbl("mst_category1","cflag",1,"v_order");
		$couPaArr=makePulldownTableList($tmp, "id", "name",1);
		$this->view->assign("couPaArr", $couPaArr);
		$buy_date=date("Y-m-d");
		$this->view->assign("buy_date", $buy_date);
		
		$this->view->assign("memArr", $memArr);
		$this->view->assign("input_data", $input_data);
		$this->view->assign("db_data", $db_data);
		// echo "<pre>ssafas";print_r($db_data);exit();

		// for unpaid list
		$arr=$this->unpaidMember($memArr['member_no'],$memArr['name']);
		$this->view->assign("arr", $arr);
		

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		if($_REQUEST['ref']=="cal"){
			$this->setTemplatePath("calendar/edit.tpl");
		}
		else{
			$this->setTemplatePath("reserve/detail.tpl");//未使用状態
		}

		return;

	}

//===================get member id wise unpaid list============
	public function unpaidMember($member_no='', $name='' ){
		$wh='';
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);
		

		$dao = new MemberDao();
		$commonDao = new CommonDao();
		$shopDao = new ShopDAO();

		$search['member_no'] = $member_no;
		$search['name'] = $name;

		if($login_admin['shop_no'] >0){
			$wh = " and b.shop_no=".$login_admin['shop_no'];
			
		}
		
		if(isset($search)){

			$tmp=array();

			$tbl=",member as m ";

			$whTmp[]=" b.member_id=m.member_id";

			//名前
			if($search["name"]){
				$tmp[]="m.name like '%".addslashes($search["name"])."%'";
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
				where b.buy_no=d.buy_no and reserve_no>0 and b.fee_flg=0".$wh.$where;


			$arr=$commonDao->get_sql($sql);
		

			for($i=0;$i<count($arr);$i++){

				$tmp = $commonDao->get_data_tbl("member","member_id",$arr[$i]['member_id']);

				$arr[$i]['name']=$tmp[0]['name'];
				$arr[$i]['name_kana']=$tmp[0]['name_kana'];
				$arr[$i]['tel']=$tmp[0]['tel'];
				$arr[$i]['member_no']=$tmp[0]['member_no'];

				$tmp=$commonDao->get_data_tbl("shop","shop_no",$arr[$i]['shop_no']);
				$arr[$i]['shop_name']=$tmp[0]['name'];

				$tmp=$commonDao->get_data_tbl("mst_course","course_no",$arr[$i]['course_no']);
				$arr[$i]['course_name']=$tmp[0]['name'];
				$arr[$i]['fee']=$tmp[0]['fee'];

				//該当のbuy_noで予約されている情報の取得
				$arrTmp=array();
	//			$reTmp=$commonDao->get_data_tbl("member_reserve_detail","buy_no",$arr[$i]['buy_no']);
				$reTmp=$commonDao->get_sql("select * from member_reserve_detail where reserve_no>0 and buy_no=".$arr[$i]['buy_no']);


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
		}
		return $arr;
}

//==================end ========================
	/**
	 * 予約　来店者詳細からの顧客検索＆選択
	 */
	public function member_searchAction() {
		$page = 1;
		$dao = new MemberDAO();
		$reserveDao = new ReserveDAO();
		$commonDao = new CommonDAO();
		$memberDao = new MemberDAO();

		// ログイン中のadmin情報を取得
		$admin = $this->getAdminSession();
		@$no= $_REQUEST['no'];//member_reserve_detail.no
		if($no){
			//$noの情報
			$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
			$detailDbArr=$tmp[0];
		}

		@$page = $_REQUEST["page"];

		//メンバーの選択
		if(isset($_POST['choice'])){
			$member_id=key($_POST['choice']);//選択した顧客
			$_SESSION['reserve_value']['member_id']=$member_id;
			// echo $no;

			if(isset($no)){//予約が入っていて、その予約が誰かを選択する場合
				//連れの場合、一緒に行く人と同じ人を選択していない？
				$tmp=$commonDao->get_data_tbl("member_reserve_detail",array("reserve_no","member_id"),array($detailDbArr['reserve_no'], $member_id));
				if($tmp){
					$this->addMessage("error","選択した顧客は同じ日時に予約済みです");
				}
				else{
					//$fi['member_id']=$member_id;
					//$fi['buy_no']=$_POST['buy_no'][$fi['member_id']];//
					//$fi['menu_no']=$_POST['menu_no'];//
					//$wfi['no']=$no;
					//予約詳細にmember_idを入れる
					//$commonDao->updateData2("member_reserve_detail", $fi, $wfi);

					//選択コースに対する、予約の回数をカウント（キャンセルを除いて）
					//規定回数の予約が入ったら、そのコースは終了となる。（キャンセルになったら、解除を行う。）
					//$dao->getCourseCountCheck($fi['buy_no']);

					//顧客一覧からの予約　予約管理カレンダーの予約済みで、予約詳細で会員を選択する場合
					$onl="onLoad='setOpener()'";
					$this->view->assign("onl", $onl);
					$this->view->assign("no", $no);
				}

			}
			else{
				//予約新規登録で、登録する会員とメニューやクーポンをを選んだのみ（まだ予約はしていない）カレンダーからの新規予約登録
				//選択した会員情報やコース、メニューを送る

//				$_SESSION['reserve_value']['buy_no']=$_POST['buy_no'][$member_id];
//				$_SESSION['reserve_value']['menu_no']=$_POST['menu_noa'];

				$onl="onLoad='setOpener2()'";
				$this->view->assign("onl", $onl);


			}
			echo $onl;
		}

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search=$_POST;
			$search['page']=1;

			$_SESSION['search_condition']=$search;

		}
		// ページ番号が渡されたか？
		else if ($page) {
			// ページングによる遷移
			$search = isset($_SESSION["search_condition"]);
			$search['page']=$this->request->getParam("page");
			$search['page'] = $page;

		}
		else {
			// sessionに検索条件が保存されている場合

			if(isset($_SESSION["search_condition"])) unset($_SESSION["search_condition"]);
			$search['page']=1;

		}

		$total_cnt=$dao->searchCount($search);
		if($total_cnt>ADMIN_V_CNT){
			list($page_navi,$lastPage) = get_page_navi2($total_cnt, ADMIN_V_CNT, $search['page'], "/reserve/member_search/");
		}
		$members=$dao->search($search,"insert_date desc",ADMIN_V_CNT);
		//購入済みで使用可能なコースを取得
		for($i=0;$i<count($members);$i++){
			//$tmp=$reserveDao->getUseCourseInfo($members[$i]['member_id']);
			$tmp=$memberDao->getCourseInfo($members[$i]['member_id']);
			$members[$i]['reserve']=$tmp;
			$members[$i]['courseArr']=makePulldownTableList($tmp, "buy_no", "name",0);

			//コース消費
			// $tmp=$memberDao->getCourseInfo($members[$i]['member_id']);
		}
		$this->view->assign("members", $members);
		$this->view->assign("total_cnt", $total_cnt);
		$this->view->assign("navi", $page_navi);
		$this->view->assign("lastPage", $lastPage);
		$this->view->assign("search", $search);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("calendar/member_search.tpl");

/*
		if($_REQUEST[ref]=="cal" || $_REQUEST[ref]=="calres"){
			$this->setTemplatePath("calendar/member_search.tpl");
		}
		else{
       		$this->setTemplatePath("reserve/member_search.tpl");
		}
*/
	}


	/**
	 * 管理者からの
	 * 予約情報登録
	 *
	 */
	public function adminEditAction() {

		$dao = new ReserveDAO();
		$memberDao = new MemberDAO();
		$commonDao = new CommonDao();

		$buy_no=$_REQUEST['buy_no'];//購入コース
		$member_id=$_REQUEST['member_id'];//会員ID

		if(!$buy_no || !$member_id){
			$this->addMessage("error","必要なデータが取得できません。");
			$this->setTemplatePath("error.tpl");
			return;
		}

		//会員IDと購入番号の組み合わせチェック
		$tmp=$commonDao->get_data_tbl("member_buy",array('buy_no','member_id'),array($buy_no,$member_id));
		if(!$tmp){
			$this->addMessage("error","パラメータエラーです。最初からやり直してください。");
			$this->setTemplatePath("error.tpl");
			return;
		}


		if($_POST['submit']){

			//チェック用配列
			$baseData=CommonChkArray::$rsvAdminCheckData;

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

				//

				//-------------予約可能かチェック--------------
				list($chkResult,$input_data)=$this->chkReserve($input_data);

				if(!$chkResult){
					$this->addMessage("error","ご希望の時間帯に予約があり、予約できません");
				}
				else{
					//予約を登録する。

					//基本事項
					foreach($baseData['dbstring'] as $key=>$val){
						$dkey[]=$key;
						$dval[]=$input_data[$key];;
					}

					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H::i:s");
					$dkey[]="update_date";
					$dval[]=date("Y-m-d H::i:s");

					$ret=$dao->InsertItemData($dkey, $dval, $input_data,$input_data['end_time']);

					if($ret){

						//規定回数に達したら、購入コース終了

						//選択コースに対する、予約の回数をカウント（キャンセルを除いて）
						//規定回数の予約が入ったら、そのコースは終了となる。（キャンセルになったら、解除を行う。）
						$memberDao->getCourseCountCheck($buy_no);

						$this->addMessage("info","ご希望の時間帯に予約を行いました");
					}
					else{
						$this->addMessage("error","予約登録に失敗しました");
					}

				}

				$this->view->assign("finish_flg", 1);

			}
		}

		//顧客情報
		$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);
		$db_memberArr=$tmp[0];
		$this->view->assign("db_memberArr", $db_memberArr);

		//コース番号からそのコースに該当するメニューをチョイス
		$sql="select c.*,b.coupon_id from member_buy as b,mst_course as c where b.course_no=c.course_no and b.buy_no=".$buy_no;
		$tmp=$commonDao->get_sql($sql);
		$db_courseArr=$tmp[0];//購入コース情報



		//クーポン名取得
		$tmp=$commonDao->get_data_tbl("mst_category1","id",$db_courseArr['coupon_id']);
		$db_courseArr['coupon_name']=$tmp[0]['name'];
		$this->view->assign("db_courseArr", $db_courseArr);


		//メニュー情報取得
		$menutmp=$commonDao->get_data_tbl("mst_menu","course_no",$db_courseArr['course_no']);

		//使用するコースの残チケットにより、選べるメニューを変える
		$tmp=$memberDao->getCourseCntInfo($buy_no);
		$zan=$db_courseArr['number']-count($tmp);

		for($i=0;$i<count($menutmp);$i++){
			if($menutmp[$i]['use_count']<=$zan){
				$tmp[]=$menutmp[$i];
			}
		}
		$menuArr=makePulldownTableList($tmp, "menu_no", "name");
		$this->view->assign("menuArr", $menuArr);


		$telArr=CommonArray::$adminReserveTel_array;
		$this->view->assign("telArr", $telArr);


		//店舗
		$tmp=$commonDao->get_data_tbl("shop");
		$shopArr=makePulldownTableList($tmp,"shop_no","name",0);
		$this->view->assign("shopArr", $shopArr);


		//予約時間の分のプルダウン用配列
		$timeArr=CommonArray::$rsv_time_array;
		$this->view->assign("timeArr", $timeArr);

		$this->view->assign("input_data", $input_data);
		$this->view->assign("buy_no", $buy_no);
		$this->view->assign("member_id", $member_id);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("reserve/admin_edit.tpl");
		return;


	}

	/**
	 *
	 *	選択した店舗からブース数を取得
	 *選択した店舗から営業時間を取得
	 *
	 */
	public function getBoothAction() {

		$commonDao = new CommonDao();

		$shop_no=$_REQUEST['shop_no'];
		$menu_no=$_REQUEST['menu_no'];


		//メニューが選択されている場合（menu_no>0)はmenu人数をチェック
		//二人以上の場合は、その人数で決め打ちとする。
		//ブース数プルダウンは店舗が決まっていて、
		//メニューが決まっていない、または、メニューが決まっている場合は人数が一人の時（二人以上の場合は、決め打ちとする）
		if($menu_no>0){
			$sql="select m.number as number, c.number as c_number from mst_menu as m, mst_course as c where m.menu_no=".$menu_no." and c.course_no=m.course_no";
			$tmp=$commonDao->get_sql($sql);

			$number=$tmp[0]['number'];
			$c_number=$tmp[0]['c_number'];
		}
		if($number>=2){
			$data["html_str"]="<div id='menu_msg'>ご選択のメニューの人数は".$number."人でのお申込みとなっております</div>";
			$boothArr=array($number=>$number);
		}
		else if($c_number>1){
			//コースが複数回の場合は人数は一人しか選べないようにする。
			$boothArr=array(1=>1);
		}
		else{
			//ブース数
			$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"booth"));
			$boothArr=makePulldownList(1, $tmp[0]['attr_value']);
		}

		$this->view->assign("boothArr", $boothArr);

/*
		//ブース数
		$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"booth"));
		$boothArr=makePulldownList(1, $tmp[0]['attr_value']);
		$this->view->assign("boothArr", $boothArr);
*/


		//営業時間を取得して、予約時間のプルダウンを作成
		$tmp1=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"from_def_h"));
		$tmp2=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"to_def_h"));
		$timeArr=makePulldownList($tmp1[0]['attr_value'], $tmp2[0]['attr_value']);
		$this->view->assign("timeArr", $timeArr);

		$this->view->assign("input_data", $_SESSION['r_input_data']);

		$data["html"] = $this->view->fetch("reserve/shop_booth_list.tpl");
		$data["time_html"] = $this->view->fetch("reserve/shop_time_list.tpl");

		echo json_encode($data);
		return;

	}


	/**
	 *
	 *	選択したコースから紐づいているメニューを取得してプルダウン作成
	 *
	 */
	public function getMenuListAction() {

		$commonDao = new CommonDao();
		$memberDao = new MemberDAO();

		$buy_no=$_REQUEST['buy_no'];//購入番号
		$input_data['menu_no']=$_REQUEST['menu_no'];//購入番号


	/**
	 * 購入したコースのbuy_noに対して
	 *
	 * 残っている残回数に対して、使用可能なメニューを取得する
	 *
	 * 例えば残回数が１なのに、２回連続のメニューは使用不可能である
	 *
	 */
/*
	public function getUseMenuInfo($buy_no,$select_menu_no="0") {

		$commonDao = new CommonDao();

		$sql="select m.* from mst_menu as m,member_buy as b where m.course_no=b.course_no and m.view_flg=1 and b.buy_no=".$buy_no;

		$menutmp=$commonDao->get_sql($sql);
		//使用するコースの残チケットにより、選べるメニューを変える
		$tmp=$this->getCourseCntInfo($buy_no);
		$cnt=count($tmp);
		if(!$tmp){
				$sql="select c.number from member_buy as b, mst_course as c where b.course_no=c.course_no and b.buy_no=".$buy_no;
				$tmp=$commonDao->get_sql($sql);
		}
		$zan=$tmp[0]['number']-$cnt;
		for($i=0;$i<count($menutmp);$i++){

			//修正の場合、現在選択中のメニューはチケット残は関係なく、表示可能
			if($select_menu_no>0){
				$menuArr[]=$menutmp[$i];
			}
			else if($menutmp[$i]['use_count']<=$zan){//チケットが余っていたら
				$menuArr[]=$menutmp[$i];
			}
		}
		return $menuArr;
	}
*/

//		$sql="select m.* from member_buy as b, mst_menu as m where b.course_no=m.course_no and m.view_flg=1 and b.buy_no=".$buy_no." order by v_order";
		$sql="select m.* from member_buy as b, mst_menu as m where b.course_no=m.course_no and b.buy_no=".$buy_no." order by v_order";
		$menutmp=$commonDao->get_sql($sql);
		$tmp=$memberDao->getCourseCntInfo($buy_no);
		$cnt=count($tmp);
		if(!$tmp){
				$sql="select c.number from member_buy as b, mst_course as c where b.course_no=c.course_no and b.buy_no=".$buy_no;
				$tmp=$commonDao->get_sql($sql);
		}
		$zan=$tmp[0]['number']-$cnt;
		for($i=0;$i<count($menutmp);$i++){
			if($menutmp[$i]['use_count']<=$zan){//チケットが余っていたら
				$menuArrTmp[]=$menutmp[$i];
			}
		}

		$menuArr=makePulldownTableList($menuArrTmp, "menu_no", "name");
			$this->view->assign("menuArr", $menuArr);
			$this->view->assign("input_data", $input_data);
			$data["html"] = $this->view->fetch("reserve/menu_list.tpl");

		//選択した購入コースで使用されているクーポンがあれば
		$sql="select c.name from member_buy as b, mst_category1 as c where b.coupon_id=c.id and b.buy_no=".$buy_no;
		$tmp=$commonDao->get_sql($sql);
			$this->view->assign("coupon_name", $tmp[0]['name']);
			$data["html_coupon"] = $this->view->fetch("reserve/coupon_name.tpl");
/*
			if($tmp){
			$this->view->assign("coupon_name", $tmp[0]['name']);
			$data["html_coupon"] = $this->view->fetch("reserve/coupon_name.tpl");
//			$data["html_coupon"]=$tmp[0]['name'];
		}
		else{
//			$data["html_coupon"]="";
		}
*/
		echo json_encode($data);
		return;

	}

	/**
	 *
	 *	選択したコースから紐づいているメニューを取得してプルダウン作成
	 *
	 */
	public function getMenuList2Action() {

		$commonDao = new CommonDao();

		$input_data['course_no']=$_REQUEST['course_no'];//
		$input_data['menu_no']=$_REQUEST['menu_no'];//

//		$tmp=$commonDao->get_data_tbl("mst_menu",array("course_no","view_flg"),array($input_data['course_no'],1),"v_order");
		$tmp=$commonDao->get_data_tbl("mst_menu",array("course_no"),array($input_data['course_no']),"v_order");
		$menuArr=makePulldownTableList($tmp,"menu_no", "name");
		$this->view->assign("menuArr", $menuArr);

		$this->view->assign("input_data", $input_data);

		$data = $this->view->fetch("reserve/menu_list.tpl");
		echo($data);
		return;

	}

	/**
	 *
	 *	表示可能なメニューを全て表示
	 *
	 */
	public function getMenuListAllAction() {

		$commonDao = new CommonDao();

		$input_data['menu_no']=$_REQUEST['menu_no'];//

//		$tmp=$commonDao->get_data_tbl("mst_menu","view_flg",1,"v_order");
		$tmp=$commonDao->get_data_tbl("mst_menu","","","v_order");
		$menuArr=makePulldownTableList($tmp,"menu_no", "name");
		$this->view->assign("menuArr", $menuArr);

		$this->view->assign("input_data", $input_data);

		// $data["html"] = $this->view->fetch("reserve/menu_list.tpl");

		$data = $this->setTemplatePath("reserve/menu_list.tpl");
		print_r($data);
		return;

	}

	/**
	 *
	 *	member情報
	 *
	 */
	public function getMemberInfoAction() {

		$commonDao = new CommonDao();
		$memberDao = new MemberDAO();

		$tmp=$commonDao->get_data_tbl("member","member_id",$_REQUEST['member_id']);
		$memArr=$tmp[0];

		//コース
		//コース消費
		$tmp=$memberDao->getCourseInfo($_REQUEST['member_id']);
		if($tmp){
			foreach($tmp as $key=>$val){
				@$res.=$val['name']."/残".$val['zan']."回"."<br />";
			}
		}

		$memArr['reserve']= isset($res);


		echo json_encode($memArr);
		return;

	}


	//------ 予約情報から予約可能かチェックするための
/*
 * AppRootCOntroller へ移動
 *
	function chkReserve($reserve_datail){

		$commonDao = new CommonDao();
		$reserveDao = new ReserveDAO();


		//ご希望コースの所要時間
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_datail['menu_no']);
		$rtimes=$tmp[0]['times'];//所要時間
		$input_data['use_count']=$tmp[0]['use_count'];//ご希望メニューが何回分のチケットを使うか


		$rsv_date=explode("/",$reserve_datail['reserve_date']);
		$ins['end_time']=date("H:i:00",mktime($reserve_datail['hour'],$reserve_datail['minute']+$rtimes,0,$rsv_date[1],$rsv_date[2],$rsv_date[0]));//menuと希望期間から終了時間を出す

		$ins['shop_no']=$reserve_datail['shop_no'];
		$ins['reserve_date']=$reserve_datail['reserve_date'];
		$ins['start_time']=$reserve_datail['hour'].":".$reserve_datail['minute'];

		$tmp=$commonDao->get_data_tbl2("member_reserve_detail",$ins);
		//予約希望時間帯現在の予約数
		$reserve_count=$reserveDao->getReserveCount($ins);

		//店舗のブース数
		$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins['shop_no'],"booth"));
		$shop_booth_cnt=$tmp[0]['attr_value'];

		if($shop_booth_cnt<($reserve_datail['number']+$reserve_count)){
			return array(false,$input_data);
		}


		return array(true,$input_data);

	}
*/

}
?>

