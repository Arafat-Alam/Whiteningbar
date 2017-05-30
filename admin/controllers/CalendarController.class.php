<?php
class CalendarController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

	}

	public function displayAction() {

		header("location:/calendar/list/");
		exit;
	}

	public function listAction() {
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign('login_admin', $login_admin);
		$login_shop_no=$ins['shop_no']=0;
		if($login_admin['shop_no']>0){
			$login_shop_no=$login_admin['shop_no'];

			//予約数カウント用
			$ins['shop_no']=$login_shop_no;
		}


		$commonDao = new CommonDao();
		$reserveDao = new ReserveDAO();

		$rsvTimeArr=CommonArray::$rsv_timeCount_array;
		$rsvPxArr=CommonArray::$rsv_timePx_array;
		$rsvTypeArr=CommonArray::$rsv_timeType_array;

		//menuのカラーナンバー
		$menuColorArr=CommonArray::$menuColor_array;
		if(!isset($_GET['back'])){
			if(isset($_SESSION['reserve_value'])) unset($_SESSION['reserve_value']);
			//カレンダーからの顧客検索、初めての方登録で使用している。不要なので、残っていたら消す		
		}

		if(isset($_GET['dt'])){
			$dtTmp=explode(",",$_GET['dt']);
			$tdy=$dtTmp[0]."-".sprintf("%02d", $dtTmp[1])."-".sprintf("%02d", $dtTmp[2]);
			 $tdyYM=$dtTmp[0]."-".sprintf("%02d", $dtTmp[1]);
			$v_date=$dtTmp[0]."年".sprintf("%02d", $dtTmp[1])."月".sprintf("%02d", $dtTmp[2])."日";
			$caltdy=sprintf("%02d", $dtTmp[1])."/".$dtTmp[0];
		}
		else{

			//本日
			$tdy=date("Y-m-d");
			$tdyYM=date("Y-m");
			$v_date=date("Y年m月d日");
			$caltdy=date("m/Y");
			//
		}

		//---- 表示用 月日曜日-----------------
		$youbi=getYoubi($tdy);
		$v_date=$v_date."（".$youbi."）";
		$this->view->assign("reserve_date", $tdy);
		$this->view->assign("caltdy", $caltdy);
		//---------------------------------------
		//---- 予約日-----------------
		$this->view->assign("v_date", $v_date);
		$this->view->assign("tddate", $tdy);
		//---------------------------------------
		//------ カレンダー表示該当日の予約数 と 該当月の予約数-------
		$ins['reserve_date']=$tdy;
		$reseveCountArr['day']=$reserveDao->getTotalReserveCount($ins);
		$ins['reserve_date']=$tdyYM;
		$reseveCountArr['mon']=$reserveDao->getTotalReserveCount($ins);
		$this->view->assign("reseveCountArr", $reseveCountArr);
		//-----------------------------------------------

		//予約が入っている（入っていた）日付を出す
		//YAHOO.widget.Calendar　の日付 selected用に変更
		$ymTmp=explode("-",$tdyYM);

		//前後半年分を出してみる
		//前の月
		for($i=90;$i>=1;$i--){
			 $rdt=date("Y-m-d",mktime(0,0,0,$ymTmp[1],0-$i,$ymTmp[0]));
			if($login_shop_no>0){
				$sql="select * from member_reserve_detail where shop_no=".$login_shop_no." and reserve_date = '".$rdt."' and visit_flg<>99";
			}
			else{
				$sql="select * from member_reserve_detail where reserve_date = '".$rdt."' and visit_flg<>99";
			}
			$tmp=$commonDao->get_sql($sql);
			if($tmp){
				$rArrTmp[]=date("m/d/Y",mktime(0,0,0,$ymTmp[1],0-$i,$ymTmp[0]));
			}
			break;
		}

		for($i=1;$i<=90;$i++){
			$rdt=date("Y-m-d",mktime(0,0,0,$ymTmp[1],0+$i,$ymTmp[0]));
			if($login_shop_no>0){
				$sql="select * from member_reserve_detail where shop_no=".$login_shop_no." and reserve_date = '".$rdt."' and visit_flg<>99";
			}
			else{
				$sql="select * from member_reserve_detail where reserve_date = '".$rdt."' and visit_flg<>99";
			}

			/*
			if($login_shop_no>0){
				$sql="select * from member_reserve_detail where shop_no=".$login_shop_no." and reserve_date = '".$tdyYM."-".sprintf("%02d", $i)."' and visit_flg<>99";
			}
			else{
				$sql="select * from member_reserve_detail where reserve_date = '".$tdyYM."-".sprintf("%02d", $i)."' and visit_flg<>99";
			}
*/
			$tmp=$commonDao->get_sql($sql);
			if($tmp){
				//$rArrTmp[]=$ymTmp[1]."/".(0+$i)."/".$ymTmp[0];
				$rArrTmp[]=date("m/d/Y",mktime(0,0,0,$ymTmp[1],0+$i,$ymTmp[0]));
			}
			break;
		}
		if($rArrTmp)
			$yahooSelDate=implode(",",$rArrTmp);
		$this->view->assign("yahooSelDate", $yahooSelDate);


		//店舗
		if($login_shop_no>0){
			$shopArr=$commonDao->get_data_tbl("shop","shop_no",$login_shop_no,"shop_no");
		}
		else{
			$shopArr=$commonDao->get_data_tbl("shop","","","shop_no");
		}

		for($i=0;$i<count($shopArr);$i++){

			$arrRsv[$i]['dt']="0";
			if(isset($_GET['dt'])){
				$arrRsv[$i]['dt']=$_GET['dt'];
			}

			$arr[$i]=$shopArr[$i];

			$shop_no=$shopArr[$i]['shop_no'];
			//ブース数
			$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"booth"));
			@$arr[$i]['booth']=$tmp[0]['attr_value'];

			$getSql = "select * from daily_weather_info where shop_no='$shop_no' and date='$tdy'";

			$tmp = $commonDao->get_sql($getSql);
			@$arr[$i]['weather']=$tmp[0]['weather'];
/*
			//表示用の配列作成
			for($j=10;$j<=21;$j++){
				for($k=0;$k<$arr[$i]['booth'];$k++){
					$arrRsv[$i]['rsv'][$k][$j][0]="";
				}
			}
*/
			$arrRsv[$i]['shop_no']=$shop_no;


			//各店舗の各ブースずつで配列を作成する
			for($k=1;$k<=$arr[$i]['booth'];$k++){//ブース数
				$lastEndTime="";
				for($j=10;$j<=22;$j++){//時間
					for($rr=1;$rr<=count($rsvTimeArr);$rr++){//スタート時間（15分単位）でLOOP  各ブースには各時間の各スタート時間開始の予約は一つあれば良い
						$arrRsv[$i]['rsv'][$k][$j][$rr]="";//['rsv'][ブース数][時間][スタート時間]の全配列が出来上がる

//						$offsetTmp[$i][$k][$j][$rr]=0;

						//各ブースごと、予約スタート時間が同じものを一つずつ取得していく。ただし、前の予約の終了時間に被らないスタート時間で探す

						$search=array();
						$start=$rsvTimeArr[$rr];
						$search['reserve_date']=$tdy;
						$search['start_time']=$j.":".$start;
						$search['shop_no']=$shop_no;
						$search['visit_flg_parts']=1;

						$sql = "select * from shop_block as sb where sb.shop_no='".$arrRsv[$i]['shop_no']."' and '".$tdy."' between sb.start_date and case when sb.end_date = 0000-00-00 then sb.start_date else sb.end_date end and sb.start_time='".$search['start_time']."' and sb.booth_no='".$k."'";
						$tmp = $commonDao->get_sql($sql);

						if ($tmp) {
							$arrRsv[$i]['rsv'][$k][$j][$rr]['no']=$tmp[0]['no'];
							$arrRsv[$i]['rsv'][$k][$j][$rr]['shop_no']=$arrRsv[$i]['shop_no'];
							$arrRsv[$i]['rsv'][$k][$j][$rr]['menu_no']=69;
							$arrRsv[$i]['rsv'][$k][$j][$rr]['reserve_date']=$tdy;
							$arrRsv[$i]['rsv'][$k][$j][$rr]['start_time']=$tmp[0]['start_time'];
							$arrRsv[$i]['rsv'][$k][$j][$rr]['end_time']=$tmp[0]['end_time'];
							$arrRsv[$i]['rsv'][$k][$j][$rr]['menu_name']='ブースは閉鎖されています まで '.$tmp[0]['end_time'];
							$arrRsv[$i]['rsv'][$k][$j][$rr]['px']=2;
							$arrRsv[$i]['rsv'][$k][$j][$rr]['bg']='red';
							$rsv_time= intval(strtotime($tmp[0]['end_time']) - strtotime($tmp[0]['start_time']))/60;
							$width = 25*($rsv_time/15);
							$arrRsv[$i]['rsv'][$k][$j][$rr]['blockWidth']='width : '.$width.'% !important; color: White;';
							// $arrRsv[$i]['rsv'][$k][$j][$rr]['rsv_type']=5;
							
						}else{

							@$tmp=$reserveDao->search3($search,$lastEndTime,"start_time desc,no",1,$offsetTmp[$i][$j][$rr]);//スタート時間で検索
							
							if($tmp){//該当する予約がある（前の予約時間に被らない予約）

								$arrRsv[$i]['rsv'][$k][$j][$rr]=$tmp[0];
								@$offsetTmp[$i][$j][$rr]=$offsetTmp[$i][$j][$rr]+1;

								$lastEndTime=$tmp[0]['end_time'];//次の予約取得に使用する


									//お連れ様がいたら人数を表示させる
									$rtmp=$commonDao->get_data_tbl("member_reserve","reserve_no",$tmp[0]['reserve_no']);
	//								if($rtmp[0]['number']>1){
										$arrRsv[$i]['rsv'][$k][$j][$rr]['numb']=$rtmp[0]['number'];
	//								}

									//所要時間
									$rsv_time= intval(strtotime($tmp[0]['end_time']) - strtotime($tmp[0]['start_time']))/60;
									$arrRsv[$i]['rsv'][$k][$j][$rr]['rsv_type']=$rsvTypeArr[$rsv_time];

									//開始時間によるPX決定
									$stmp=explode(":",$tmp[0]['start_time']);
									$arrRsv[$i]['rsv'][$k][$j][$rr]['px']=$rsvPxArr[$stmp[1]];


									//メニューカラー等メニュー情報
									$menuTmp=$commonDao->get_data_tbl("mst_menu","menu_no",$tmp[0]['menu_no']);
									if($menuTmp){
										$arrRsv[$i]['rsv'][$k][$j][$rr]['bg']=$menuColorArr[$menuTmp[0]['color_no']];
										$arrRsv[$i]['rsv'][$k][$j][$rr]['menu_name']=$menuTmp[0]['name'];

									}
									else{
										$arrRsv[$i]['rsv'][$k][$j][$rr]['bg']="#c0c0c0";
										$arrRsv[$i]['rsv'][$k][$j][$rr]['menu_name']="";
									}

							}
							else{

							}
						}

					}
				}
			}

		}
// print_r_with_pre($arrRsv);
		
		


		// echo "<pre>";print_r($arr);exit();

		$this->view->assign("arr", $arr);
		$this->view->assign("arrRsv", $arrRsv);

		if (isset($_GET['back'])) {
			$this->view->assign("back", "back");
		}

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("calendar/index.tpl");
		return;

	}

	public function weeklyAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign('login_admin', $login_admin);

		$login_shop_no=0;
		if($login_admin['shop_no']>0){
			$login_shop_no=$login_admin['shop_no'];
		}


		$commonDao= new CommonDao();
		$reserveDao= new ReserveDAO();

		$rsvTimeArr=CommonArray::$rsv_timeCount_array;
		$rsvPxArr=CommonArray::$rsv_timePx_array;
		$rsvTypeArr=CommonArray::$rsv_timeType_array;

		//menuのカラーナンバー
		$menuColorArr=CommonArray::$menuColor_array;

		//本日
//		$tdy=date("Y-m-d");
//		$v_date=date("Y年m月d日");
		$tY=date("Y");
		$tM=date("m");
		$tD=date("d");

		//---------------------------------------

		for($ww=0;$ww<7;$ww++){

			$tdy=date("Y-m-d",mktime(0,0,0,$tM,$tD+$ww,$tY));
			$v_date=date("Y年m月d日",mktime(0,0,0,$tM,$tD+$ww,$tY));

			//---- 表示用 月日曜日-----------------
			$tdyArr[$ww] = $tdy;
			$youbi=getYoubi($tdy);
			$v_dateArr[$ww]=$v_date."（".$youbi."）";
			$this->view->assign("reserve_date", $tdyArr);
			$this->view->assign("v_dateArr", $v_dateArr);
			//---------------------------------------
			//------ カレンダー表示該当日の予約数 と 該当月の予約数-------
			$countins['reserve_date']=$tdy;
			if($login_shop_no>0){
				$countins['shop_no']=$login_shop_no;
			}else{
				$countins['shop_no']=0;
			}

			$reseveCountArr[$ww]['day']=$reserveDao->getTotalReserveCount($countins);
			$this->view->assign("reseveCountArr", $reseveCountArr);
			//-----------------------------------------------

		//店舗
		if($login_shop_no>0){
			$shopArr=$commonDao->get_data_tbl("shop","shop_no",$login_shop_no,"shop_no");
		}
		else{
			$shopArr=$commonDao->get_data_tbl("shop","","","shop_no");
		}

		for($i=0;$i<count($shopArr);$i++){

			$arr[$i]=$shopArr[$i];

			$shop_no=$shopArr[$i]['shop_no'];
			//ブース数
			$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"booth"));
			$arr[$i]['booth']=$tmp[0]['attr_value'];
/*
			//表示用の配列作成
			for($j=10;$j<=21;$j++){
				for($k=0;$k<$arr[$i]['booth'];$k++){
					$arrRsv[$ww][$i]['rsv'][$k][$j][0]="";

				}
			}
*/
			$arrRsv[$ww][$i]['shop_no']=$shop_no;

			//一週間
			//各店舗の各ブースずつで配列を作成する
			for($k=1;$k<=$arr[$i]['booth'];$k++){//ブース数
				$lastEndTime="";
				for($j=10;$j<=22;$j++){//時間
					for($rr=1;$rr<=count($rsvTimeArr);$rr++){//スタート時間（15分単位）でLOOP  各ブースには各時間の各スタート時間開始の予約は一つあれば良い
						$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]="";//['rsv'][ブース数][時間][スタート時間]の全配列が出来上がる

						//各ブースごと、予約スタート時間が同じものを一つずつ取得していく。ただし、前の予約の終了時間に被らないスタート時間で探す

						$search=array();
						$start=$rsvTimeArr[$rr];
						$search['reserve_date']=$tdy;
						$search['start_time']=$j.":".$start;
						$search['shop_no']=$shop_no;
						$search['visit_flg_parts']=1;

						@$tmp=$reserveDao->search3($search,$lastEndTime,"start_time desc,no",1,$offsetTmp[$ww][$i][$j][$rr]);//スタート時間で検索
						// echo "<pre>";print_r($tmp);

						if($tmp){//該当する予約がある（前の予約時間に被らない予約）

							@$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]=$tmp[0];
							@$offsetTmp[$ww][$i][$j][$rr]=$offsetTmp[$ww][$i][$j][$rr]+1;

							$lastEndTime=$tmp[0]['end_time'];//次の予約取得に使用する


								//お連れ様がいたら人数を表示させる
								$rtmp=$commonDao->get_data_tbl("member_reserve","reserve_no",$tmp[0]['reserve_no']);
//								if($rtmp[0]['number']>1){
									$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]['numb']=$rtmp[0]['number'];
//								}

								//所要時間
								$rsv_time= intval(strtotime($tmp[0]['end_time']) - strtotime($tmp[0]['start_time']))/60;
								$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]['rsv_type']=$rsvTypeArr[$rsv_time];

								//開始時間によるPX決定
								$stmp=explode(":",$tmp[0]['start_time']);
								$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]['px']=$rsvPxArr[$stmp[1]];


								//メニューカラー等メニュー情報
								$menuTmp=$commonDao->get_data_tbl("mst_menu","menu_no",$tmp[0]['menu_no']);
								if($menuTmp){
									$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]['bg']=$menuColorArr[$menuTmp['0']['color_no']];
									$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]['menu_name']=$menuTmp[0]['name'];

								}
								else{
									$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]['bg']="#c0c0c0";
									$arrRsv[$ww][$i]['rsv'][$k][$j][$rr]['menu_name']="";
								}

						}
						else{

						}
					}
				}
			}
//print_r_with_pre($arrRsv);

			}

		}
		// echo "<pre>";print_r($arr);exit();

		$this->view->assign("arr", $arr);
		$this->view->assign("arrRsv", $arrRsv);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("calendar/weekly.tpl");
		return;



	}


	/**
	 *
	 */
	public function reserveAction() {
		$memberDao = new MemberDAO();
		$commonDao = new CommonDao();
		$reserveDao = new ReserveDAO();

		//カレンダーに戻った時の日付パラメータ
		if(isset($_SESSION['reserve_value']['dt'])){
				$param="?dt=".$_SESSION['reserve_value']['dt'];
				$this->view->assign("param", $param);
				$this->view->assign("dt", $_SESSION['reserve_value']['dt']);
		}

		if(isset($_POST['submit'])){
			//新規予約
			//チェック用配列
			$baseData=CommonChkArray::$rsvAdminCheckData;
			$baseData2=CommonChkArray::$rsvDetailCalendarCheckData;

			$_SESSION["input_data"] = $_POST;
			$input_data=$_SESSION["input_data"];

			//---------------- 入力チェック ---------------------------
			//基本事項
			$this->check($input_data,$baseData2);

			//-------------- ここまで -----------------------------------

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {

				$timeTmp=explode(":",$input_data['start_time']);
				$input_data['hour']=$timeTmp[0];
				$input_data['minute']=$timeTmp[1];

				//-------------予約可能かチェック--------------	
				list($chkResult,$input_data)=$this->chkReserve($input_data);
				if(!$chkResult){
					$this->addMessage("error","ご希望の時間帯に予約があり、予約できません");
			
				}
				else{
					//予約を登録する。
					//基本事項
					foreach($baseData['dbstring'] as $key=>$val){
						@$dkey[]=$key;
						@$dval[]=$input_data[$key];;
					}

					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H::i:s");
					$dkey[]="update_date";
					$dval[]=date("Y-m-d H::i:s");
					
					if(isset($_POST['buy_no']) && $_POST['buy_no'] == ""){
						//借り購入する
						$input_data['buy_no']=$memberDao->InsertCourseData($input_data);
					}else{
						$input_data['buy_no']=$memberDao->getBuyNo($input_data);
					}
					$ret=$reserveDao->InsertItemData($dkey, $dval, $input_data,$input_data['end_time']);
					$input_data['reserve_no']=$ret;
					if($ret){

						//規定回数に達したら、購入コース終了

						//選択コースに対する、予約の回数をカウント（キャンセルを除いて）
						//規定回数の予約が入ったら、そのコースは終了となる。（キャンセルになったら、解除を行う。）
						@$memberDao->getCourseCountCheck($input_data['buy_no']);
						$this->addMessage("info","ご希望の時間帯に予約を行いました");

						//メール送信

						// $this->send_auto_mail($input_data); // comment by arafat 
						
						//カレンダーへ
						header("location:/calendar/list/".$param);
						exit;

					}
					else{
						$this->addMessage("error","予約登録に失敗しました");
					}
				}
					exit();
				$this->view->assign("finish_flg", 1);
			}



		}
		else if(isset($_GET['back'], $_SESSION['reserve_value'])){
			$input_data=$_SESSION['reserve_value'];

		}
		else{

			if(isset($_SESSION['reserve_value'])) unset($_SESSION['reserve_value']);

			@$input_data['shop_no']=$_REQUEST['shop_no'];
			@$input_data['hour']=$_REQUEST['hour'];
			@$input_data['minute']=$_REQUEST['minute'];
			@$input_data['reserve_date']=$_REQUEST['reserve_date'];

			@$input_data['start_time']=$_REQUEST['hour'].":".$_REQUEST['minute'];


			//カレンダーに戻った時の日付パラメータ
			if(isset($_POST['dt']) && $_POST['dt']!=0){
				@$input_data['dt']=$_POST['dt'];
				$_SESSION['reserve_value']['dt']=$_POST['dt'];

				$param="?dt=".$_POST['dt'];
				$this->view->assign("param", $param);
				$this->view->assign("dt", $_POST['dt']);

			}
			$_SESSION['reserve_value']=$input_data;
		}

		//ショップ情報取得
		$tmp=$commonDao->get_data_tbl("shop","shop_no",$input_data['shop_no']);
		@$shopInfo=$tmp[0];
		//ショップ情報からブース数プルダウン作成
		$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($input_data['shop_no'],"booth"));
		@$boothArr=makePulldownList(1, $tmp[0]['attr_value']);

		$this->view->assign("boothArr", $boothArr);
		$this->view->assign("shopInfo", $shopInfo);


		//購入したコース/メニュー コースが選択されていたらプルダウンとして表示　会員検索にて、コースを選択した場合
		//選択するコースが無い=初めての方で、コース未購入・会員様でも使えるコースがもうない場合
//		if($input_data['buy_no']){
		if(isset($_GET['back'])){//初めての方を登録後、または、会員様選択後に戻ってきた場合
			//該当のメンバーが使用可能なコースをプルダウンにする
			$tmp=$memberDao->getCourseInfo($input_data['member_id'], $input_data['shop_no']);

			$courseArr=makePulldownTableList($tmp, "buy_no", "name");
			 // echo "<pre>";print_r($courseArr);exit();
			$this->view->assign("courseArr", $courseArr);
		}

		//メンバー情報
		if(isset($input_data['member_id'])){
			$search['member_id']=$input_data['member_id'];
			$tmp=$memberDao->search($search);
			$input_data['name']=$tmp[0]['name'];
			$input_data['name_kana']=$tmp[0]['name_kana'];
		}


		$telArr=CommonArray::$adminReserveTel_array;
		$this->view->assign("telArr", $telArr);

		$this->view->assign("input_data", $input_data);


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("calendar/reserve.tpl");
		return;

	}


	/**
	 *	カレンダーでのマウス移動による予約の変更
	 *
	 *  移動先での予約が可能かをチェック。
	 *  移動希望の予約番号に紐づいている予約（予約時に複数人で申し込み)の場合は、
	 *  その人たちが一緒に移動するので、その分も含めて、予約可否チェック
	 *
	 */
	public function changeReserveAction() {

		$login_admin = $this->getAdminSession();
		$this->view->assign('login_admin', $login_admin);

		$commonDao = new CommonDao();


		$bango=$_REQUEST['bango'];//移動先 カレンダー表示の上からの順番（各店舗のブースを上から通しで数えた番号）
		$tmp=explode(":", $_REQUEST['reserve']);//移動先の時間
		$reserve_datail['hour']=$tmp[0];
		$reserve_datail['minute']=$tmp[1];

		$tmp=explode("_",$_REQUEST['no']);
		$no=mb_substr($tmp[0],3);
		$reserve_datail['no']=$no;


		//移動先の店舗を取得（カレンダー作成と同じように配列を作成する事）
		if($login_admin['shop_no']>0){
			$shopArr=$commonDao->get_data_tbl("shop","shop_no",$login_admin['shop_no'],"shop_no");
		}
		else{
			$shopArr=$commonDao->get_data_tbl("shop","","","shop_no");
		}
		$bcnt=0;
		for($i=0;$i<count($shopArr);$i++){
			$shop_no=$shopArr[$i]['shop_no'];
			//ブース数
			$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($shop_no,"booth"));
			$bcnt=$bcnt+$tmp[0]['attr_value'];
			if($bcnt>$bango){//上から数えた移動先の番号に通しブース数が追いついたので、該当店舗
				break;
			}
		}
		$reserve_datail['shop_no']=$shop_no;

		//$noから予約番号を取得して、申し込み人数を取得
		//$tmp=$commonDao->get_data_tbl("member_search_detail","no",$no);
		$sql="select d.*,s.number from member_reserve_detail as d, member_reserve as s where d.reserve_no=s.reserve_no and d.no=".$no;
		$tmp=$commonDao->get_sql($sql);
		$reserve_datail['menu_no']=$tmp[0]['menu_no'];
		$reserve_datail['number']=$tmp[0]['number'];
		$reserve_no=$tmp[0]['reserve_no'];//予約番号

		$reserve_datail['reserve_date']=$tmp[0]['reserve_date'];

		//移動先で予約できるか？
		list($ret,$reserve_datail)=$this->chkReserve($reserve_datail);

		//出来るなら、変更
		if($ret){
			$fi['reserve_date']=$reserve_datail['reserve_date'];
			$fi['start_time']=$_REQUEST['reserve'];
			$fi['end_time']=$reserve_datail['end_time'];
			$fi['shop_no']=$reserve_datail['shop_no'];
			$wfi['reserve_no']=$reserve_no;

			$upret=$commonDao->updateData2("member_reserve_detail", $fi, $wfi);
			if($upret){
				$result="1";
			}
			else{
				$result="99";

			}
		}
		else{
		//無理なら、NGで戻す

			$result="99";

		}


		$data["html"] = $result;
		echo json_encode($data);
		return;

	}

	function send_auto_mail($reserve_datail){
		
		$commonDao = new CommonDao();
		$shopDao = new ShopDAO();

		$tmp=$commonDao->get_data_tbl("mst_auto_mail",array("no","mail_flg"),array(2,1));
		if($tmp){

			//メニュー名
			$menu_name=$shopDao->getMenuName($reserve_datail['menu_no']);
			//shopmei
			$shop_name=$shopDao->getShopName($reserve_datail['shop_no']);

			//メールアドレス
			$memTmp=$commonDao->get_data_tbl("member","member_id",$reserve_datail['member_id']);

			//署名GET
			$sigtmp=$commonDao->get_data_tbl("mail_sig","","");
			$sig=$sigtmp[0]['sig'];

			$bodyMail="\n\n\r<br>◆予約番号：".$reserve_datail['reserve_no']."\n\r<br>";
			$bodyMail.="◆予約日：".$reserve_datail['reserve_date']."\n\r<br>";
			$bodyMail.="◆時間：".$reserve_datail['hour'].":".$reserve_datail['minute']."～".$reserve_datail['end_time']."\n\r<br>";
			$bodyMail.="◆人数：".$reserve_datail['number']."人"."\n\r<br>";
			$bodyMail.="◆店舗：".$shop_name."\n\r<br>";
			$bodyMail.="◆メニュー：".$menu_name."\n\n\n\r<br>";


			$subject = $tmp[0]['subject'];
			$mailBody = $tmp[0]['header_text'].$bodyMail.$tmp[0]['footer_text']."\n\n\r<br>".$sig;
			$mailfrom="From:" .mb_encode_mimeheader(MAIL_FROM_NAME) ."<".MAIL_FROM.">";
			//send_mail($memTmp[0]['email'], MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
			
			// send_mail('arafatfci003@gmail.com', MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
		}

	}

	public function setWeatherAction(){
		
		$commonDao = new CommonDao();

		if (isset($_GET['date'])) {

			$this->view->assign("city",$_GET['city']);
			$this->view->assign("date",$_GET['date']);
			$this->view->assign("shop_no",$_GET['shop_no']);
		}

		if (isset($_POST['submit'])) {

			$tbl = 'daily_weather_info';

			$weather = $_POST['weather'];
			$shop_no = $_POST['shop_no'];
			$date = $_POST['date'];

			$dkey[] = 'weather';
			$dval[] = $weather;
			
			$dkey[] = 'shop_no';
			$dval[] = $shop_no;
			
			$dkey[] = 'date';
			$dval[] = $date;

			$getSql = "select * from daily_weather_info where shop_no='$shop_no' and date='$date'";
			$tmp = $commonDao->get_sql($getSql);
			
			if (isset($tmp[0])) {
				$id = $tmp[0]['id'];
				$insert = $commonDao->updateData($tbl,$dkey,$dval,'id',$id);
			}else{
				$insert = $commonDao->InsertItemData($tbl,$dkey,$dval);
			}
				
			header("location: /calendar/list");
		}
		$this->outHttpResponseHeader();

		$this->setTemplatePath("calendar/setWeather.tpl");
		return;
	}

}
?>


