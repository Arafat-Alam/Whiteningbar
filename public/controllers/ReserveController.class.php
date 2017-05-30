<?php
class ReserveController extends AppRootController {


	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

		require_once sprintf("%s/dao/Category1Dao.class.php", MODEL_PATH);

	}

	/**
	 * 予約画面の表示
	 */
	public function displayAction() {


		$commonDao = new CommonDao();

		$login_member=$this->getMemberSession();


		//店舗
		$tmp=$commonDao->get_data_tbl("shop","view_flg","1","shop_no");
		$shopArr=makePulldownTableList($tmp, "shop_no", "name",1);

		//初回用メニュー
		$menuArr=$commonDao->get_data_tbl("mst_menu","kind_flg","0","menu_no");



		$this->view->assign("shopArr", $shopArr);
		$this->view->assign("menuArr", $menuArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();


		$this->setTemplatePath("reserve/index.tpl");

		return;

	}

	/**
	 * 予約画面の表示
	 */
	public function listAction() {


		$commonDao = new CommonDao();
		$memberDao = new MemberDAO();
		$reserveDao = new ReserveDAO();

		$login_member=$this->getMemberSession();

		//マイページの予約から予約画面に入った時に、ログインが切れていたら、ログインのし直し
		if($_POST[reserve] && !$login_member){
			header("location:/");
			exit;

		}

		$reserve_menu_no="0";//初期値
		//ログイン後のマイページからの予約の場合は、コースに紐づいているメニューを表示
		if($login_member){

			if($_POST[detail_no] || $_GET[dback]){//MyPageから予約の変更の場合

				if($_POST){
					$detail_no=key($_POST[detail_no]);

					//変更が出来ない時間帯であれば、エラーで戻す（予約1時間前以内は変更不可）
					$resTmp=$commonDao->get_data_tbl("member_reserve_detail","no",$detail_no);
					$r_date=$resTmp[0][reserve_date]." ".$resTmp[0][start_time];
					$tdyTime=date("Y-m-d H:i:s",strtotime("+1 hour"));
					if($tdyTime>=$r_date){
							$errmsg="大変申し訳ございません。予約1時間前以内のキャンセルは出来ません。";

							header("location:/member/list/?err");
							exit;
					}

				}
				else{
					$detail_no=$_GET[dback];
				}


				if($_GET[dback]){
					$search=$_SESSION["reserve_input_data"];
				}
				else{

					$search=$reserveDao->getDetailInfo($detail_no);
					$search[reserve_time]=$search[start_time];//最初の頃に作成した新規予約チェックに合わせるため
					$_SESSION["reserve_input_data"]=$search;

				}
				$reserve_menu_no=$search[menu_no];
				$buy_no=$search[buy_no];

/*
				//現在の予約申し込み状況詳細取得
				$search=$reserveDao->getDetailInfo($detail_no);
				$search[reserve_time]=$search[start_time];//最初の頃に作成した新規予約チェックに合わせるため
				$buy_no=$search[buy_no];

				//現在予約中のメニュー　メニュー候補を出す時にチケット残に対して表示するメニューを決定するが、
				//予約の変更の場合は、予約中のメニューは表示させる。
				$reserve_menu_no=$search[menu_no];
				$_SESSION["reserve_input_data"]=$search;
*/
			}
			else{

				if($_POST[reserve]){
					$buy_no=key($_POST[reserve]);
				}else if($_POST){
					$buy_no=$_POST[buy_no];
				}
				else{
					$buy_no=$_GET[back];
				}


				if($_SESSION["reserve_input_data"] && !isset($_GET[back])) unset($_SESSION["reserve_input_data"]);
			}

			if($buy_no){

				//未購入(であり、予約内容変更)の場合は、使用可能無メニューは変更可能とする
				//未購入でも、予約後キャンセルして、再度同じコース内のメニューを予約する時は、使用可能メニューを表示
				$btmp=$commonDao->get_data_tbl("member_buy","buy_no",$buy_no);
				if($btmp[0][fee_flg]==0 && $detail_no){

					//未購入のメニューが初回用であれば、初回用メニューを表示
					$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$detail_no);
					$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$tmp[0][menu_no]);
					if($tmp[0][kind_flg]==0){
						//初回メニュー取得
						$menuArr=$commonDao->get_data_tbl("mst_menu",array("view_flg","kind_flg"),array("1","0"),"v_order");
					}
					else{
						//２回以降メニュー取得
						$menuArr=$commonDao->get_data_tbl("mst_menu",array("view_flg","kind_flg"),array("1","1"),"v_order");
					}
				}
				else{

					//使用可能なメニューを表示
					$menuArr=$memberDao->getUseMenuInfo($buy_no,$reserve_menu_no);
				}

			}
			else{
				//２回以降メニュー取得
				$menuArr=$commonDao->get_data_tbl("mst_menu",array("view_flg","kind_flg"),array("1","1"),"v_order");
			}

	//		$menuArr=makePulldownTableList($tmp, "menu_no", "name");
	//		$this->view->assign("menuArr", $menuArr);

			$this->view->assign("buy_no", $buy_no);
			$this->view->assign("detail_no", $detail_no);

		}
		else{
			//初回用メニュー取得
			$menuArr=$commonDao->get_data_tbl("mst_menu",array("view_flg","kind_flg"),array("1","0"),"v_order");

		}

		if($_POST[submit]){

			$_SESSION["reserve_input_data"]=$_POST;
			$search=$_SESSION["reserve_input_data"];

			//---------------- 入力チェック ---------------------------
			$baseData=CommonChkArray::$reserveCheckData;
			$this->check($search,$baseData);

			//予約の日付のチェック
			//予約の日付、時間が過去であればエラー
			if($search[reserve_date] && $search[reserve_time]){
				$tdy=date("Y/m/d H:i");
				$r_date=$search[reserve_date]." ".$search[reserve_time];
				if($tdy>=$r_date){
					$this->addMessage("reserve_date", "ご予約希望の日時をご確認ください。過去の日時になっています");
				}

				//現在時刻よりも１時間以内の予約時間の場合はNGとする2014.10.15add
				$tdyTime=date("Y/m/d H:i",strtotime("+1 hour"));
				if($tdyTime>=$r_date){
					$this->addMessage("reserve_date", "大変申し訳ございません。ご希望時間の1時間以上前にご予約をお願いいたします。");
				}


				//----------- 予約日付の曜日が店舗の休日であればエラー-----------------------
				if($search[shop_no]){
					$chkArr[dtTmp]=explode("/",$search[reserve_date]);//予約日をばらす
					$chkArr[timeTmp]=explode(":",$search[reserve_time]);//予約時間をばらす

					$youbi=date(N,mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));
					$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"days"));
					$list = array();
					if($tmp){
						foreach ($tmp as $a) {
						    $list[] = $a['attr_value'];
						}
					}
					if($list){
						if(!in_array($youbi, $list)){
							$this->addMessage("reserve_date", "ご予約希望日は店舗の休日となっております。<br />申し訳ございませんが、他の日をご指定ください");

						}
					}
					//店舗の予約ブロック日付や時間に入っていないか？add 2014.10
					list($result,$retTmp,$flg)=$reserveDao->chkBlockReserve($search, $chkArr);
					if(!$result){

						if($flg==1){
							$this->addMessage("reserve_date", "ご希望日の日時は予約が出来ません<br />
								大変申し訳ございませんが、他の日時でご予約をお願いいたします");
							//ご予約が出来ない時間は".$retTmp[0][start_date]." ".$retTmp[0][start_time]."～".
							//$retTmp[0][end_date]." ".$retTmp[0][end_time]."です");

						}
						else if($flg==4){

							$this->addMessage("reserve_date", "ご希望の日時は予約が出来ません<br />
								大変申し訳ございませんが、他の日時でご予約をお願いいたします");
							//	ご予約が出来ない時間は".$retTmp[0][start_date]." ".$retTmp[0][start_time]."～".
							//$retTmp[0][end_date]." ".$retTmp[0][end_time]."です<br />
						}
						else if($flg==2){

							$this->addMessage("reserve_date", "ご希望の時間では予約が出来ません<br />
							大変申し訳ございませんが、他の時間でご予約をお願いいたします");
							//ご予約が出来ない時間は".$retTmp[0][start_time]."～".$retTmp[0][end_time]."です");
						}
						else if($flg==3){

							$this->addMessage("reserve_date", "ご希望の時間では予約が出来ません<br />
								大変申し訳ございませんが、他の時間でご予約をお願いいたします");
							//ご予約が出来ない時間は".$retTmp[0][start_time]."～".$retTmp[0][end_time]."です。<br />
						}

					}
				}
			}

				//ご希望コースの所要時間
				$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$search[menu_no]);
				$chkArr[rtimes]=$tmp[0][times];//所要時間

				//------------ 店舗の営業終了時間からメニューの所要時間を引く。その時間を超える予約時間は表示させない。--------------
				//そして、営業開始時間前の時間は表示させない。
//				$youbi=date(N);//月曜を1とする日付数値
				$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"to_".$youbi."_h"));
				if($tmpH[0][attr_value]!=""){//曜日の営業時間設定がある場合
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"to_".$youbi."_m"));

				}
				else{
					$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"to_def_h"));
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"to_def_m"));
				}
				//営業終了時間から、選択したメニューの所要時間を引いた時間
				$shopEndTime=mktime($tmpH[0][attr_value], $tmpM[0][attr_value]-$chkArr[rtimes],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]);


				//選択したメニューの終了時間が営業時間を超える場合はエラー
				//この場合は、差し引いた時間が、希望日時よりも早い時間（最終の予約可能時間）であれば、NG


				$aaa=date("Y/m/d H:i",mktime($tmpH[0][attr_value], $tmpM[0][attr_value]-$chkArr[rtimes],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));
        		if($aaa<$r_date){
        			$this->addMessage("reserve_time", "ご予約希望日時は店舗の営業時間を過ぎてしまうため、ご予約できません");
        		}

        		//---営業開始前の予約になっていないか----------------------
				$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_".$youbi."_h"));
				if($tmpH[0][attr_value]!=""){//曜日の営業時間設定がある場合
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_".$youbi."_m"));

				}
				else{
					$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_def_h"));
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_def_m"));
				}
				//営業開始時間
				$shopStartTime=mktime($tmpH[0][attr_value], $tmpM[0][attr_value],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]);

        		//希望予約時間
				$aaa=mktime($chkArr[timeTmp][0], $chkArr[timeTmp][1],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]);
        		if($aaa<$shopStartTime){
        			$this->addMessage("reserve_time", "ご予約希望日時は店舗の営業時間前のため、ご予約できません");
        		}


			//-------------- ここまで -----------------------------------
			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {

				//店舗のブース数
				$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"booth"));
				$chkArr[shop_booth_cnt]=$tmp[0][attr_value];
/*
				$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_".$youbi."_h"));
				if($tmpH[0][attr_value]!=""){//曜日の営業時間設定がある場合
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_".$youbi."_m"));

				}
				else{
					$tmpH=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_def_h"));
					$tmpM=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($search[shop_no],"from_def_m"));
				}
				$shopStartTime=mktime($tmpH[0][attr_value], $tmpM[0][attr_value],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]);
*/
				//------------ 予約スケジュールチェック 予約日時の前後2時間の予約状況を表示 ---------------------------

				//希望の時間が空いてればそのまま予約処理に進む
				//空いていなければ、過去、未来二個ずつ空いている時間を表示する
				$chkArr[start_time]=date("H:i",mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));
				$ret=$this->checkReserve($chkArr, $search);
				$zanHopeArr=$this->getArrNg();
				if($ret==1){//予約可能　　登録ページへ進む
					$zanArr=$this->getArr();
					header("location:/reserve/regist/?reserve_detail=".$zanArr[0][detail]."&buy_no=".$buy_no."&detail_no=".$detail_no);
					exit;
				}

				//過去3時間
//				for($i=12;$i>=1;$i--){

				for($i=1;$i<=12;$i++){
					$plus=15*$i;

					//現在時刻よりも前の時間になったらbreak
					$nowchk=date("Y/m/d H:i",mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1]-$plus,0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));

					if($tdy>$nowchk){
						break;
					}

					//現在時刻の1時間以内の予約は出来ない
					if($tdyTime>$nowchk){
						break;
					}

					$chkArr[start_time]=date("H:i",mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1]-$plus,0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));
					$chkSstart_time=mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1]-$plus,0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]);

					//営業開始時間前はチェックしない
					if($chkSstart_time>=$shopStartTime){
						$ret=$this->checkReserve($chkArr, $search);
						if($ret==1){
							$zanArr=$this->getArr();
							if(count($zanArr)==2){
								break;
							}
						}
					}
				}

				if($zanArr){
					$arr=array_merge($zanArr,$zanHopeArr);
				}
				else{
					$arr=$zanHopeArr;
				}
				unset($zanArr);
				$this->setArr($zanArr);
				//未来3時間
				for($i=1;$i<=12;$i++){
					$plus=15*$i;
					$chkArr[start_time]=date("H:i",mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1]+$plus,0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));

					//現在時刻の1時間以内の予約は出来ない
					$nowchk=date("Y/m/d H:i",mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1]+$plus,0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));
					if($tdyTime<$nowchk){

						//店舗営業時間-メニュー所要時間とのチェック用
						$chkSstart_time=mktime($chkArr[timeTmp][0],$chkArr[timeTmp][1]+$plus,0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]);

						if($shopEndTime>=$chkSstart_time){

							$ret=$this->checkReserve($chkArr, $search);
							if($ret==1){
								$zanArr=$this->getArr();
								if(count($zanArr)==2){
									break;
								}
							}

						}
						else{
							break;
						}
					}
				}
				if($zanArr){
					$zanArr=array_merge($arr,$zanArr);
				}
				else{
					$zanArr=$arr;
				}

				//選択日時の曜日取得
				$weekjp_array = array('日', '月', '火', '水', '木', '金', '土');
				//タイムスタンプを取得
				$ptimestamp = mktime(0, 0, 0, $chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]);
				//曜日番号を取得
				$weekno = date('w', $ptimestamp);
				//日本語の曜日を出力
				$weekjp = $weekjp_array[$weekno];

			}

		}
		else if(isset($_GET[back]) || isset($_GET[dback])){
			$search=$_SESSION["reserve_input_data"];

		}
		else{

			if(!$login_member){
				if($_SESSION["reserve_input_data"]) unset($_SESSION["reserve_input_data"]);
			}
			if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
			if($_SESSION["survey_input_data"]) unset($_SESSION["survey_input_data"]);

		}



		//店舗プルダウン
		//マイページのコース購入中の予約の場合は、店舗は購入した店舗のみ
		if($buy_no){
			$tmp=$commonDao->get_data_tbl("member_buy","buy_no",$buy_no);
			$tmp=$commonDao->get_data_tbl("shop","shop_no",$tmp[0][shop_no],"shop_no");
			$shopArr=makePulldownTableList($tmp, "shop_no", "name");
		}
		else{
			$tmp=$commonDao->get_data_tbl("shop","view_flg","1","shop_no");
			$shopArr=makePulldownTableList($tmp, "shop_no", "name",1);
		}



		$this->view->assign("shopArr", $shopArr);
		$this->view->assign("menuArr", $menuArr);
		$this->view->assign("search", $search);
		$this->view->assign("weekjp", $weekjp);

		$this->view->assign("zanArr", $zanArr);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();


		$this->setTemplatePath("reserve/index.tpl");

		return;

	}

	/*  予約日時の予約チェック */
	function checkReserve($chkArr, $search){

		$dao=new ReserveDAO();
		$zanArr=$this->getArr();

		$zanCnt=count($zanArr);

			//終了時間
			$endTmp=explode(":", $chkArr[start_time]);
			$ins[end_time]=date("H:i",mktime($endTmp[0],$endTmp[1]+$chkArr[rtimes],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));

			$ins[shop_no]=$search[shop_no];
			$ins[reserve_date]=$search[reserve_date];
			$ins[start_time]=$chkArr[start_time];

			//予約希望時間帯現在の予約数(開始時間で見る）
			//$reserve_count=$dao->getReserveCount($ins,"start");

			//予約の変更の場合
			if($search[detail_no]){

				$search[start_time]=$chkArr[start_time];
				list($ret,$search)=$this->chkReserve($search);

				if($ret){

					//ブロックチェック
					list($result,$retTmp,$flg)=$dao->chkBlockReserve($search, $chkArr,"1");
					if(!$result){
						$zan="-99";
					}
					else{
						$zan="1";
					}
				}
				else{
					$zan="-99";
				}
			}
			else{

				$search[start_time]=$chkArr[start_time];

				list($ret,$search)=$this->chkReserve($search);
				if($ret){

					//ブロックチェック
					list($result,$retTmp,$flg)=$dao->chkBlockReserve($search, $chkArr,"1");
					if(!$result){
						$zan="-99";
					}
					else{
						$zan="1";
					}
				}
				else{
					$zan="-99";
				}
				//新規予約の場合
//				$reserve_count=$dao->getReserveCount3($ins);
//				$zan=$chkArr[shop_booth_cnt]-($search[number]+$reserve_count);


			}




			if($zan<0){//予約不可
//				$zanArr[$zanCnt][str]=$chkArr[start_time];
				$zanArrNg[$zanCnt][start_time]=$chkArr[start_time];
				$zanArrNg[$zanCnt][detail]="";

				$result=0;
				$this->setArrNg($zanArrNg);
			}
			else{
				$zanArr[$zanCnt][start_time]=$chkArr[start_time];
				$zanArr[$zanCnt][detail]=$ins[reserve_date]."_".$chkArr[start_time]."_".$ins[end_time]."_".$ins[shop_no]."_".$search[menu_no]."_".$search[number];
				$result=1;

				$this->setArr($zanArr);
			}

/*
			else if($zan==0){//今回の予約確定により、残りがなくなる場合は残りわずか
				$zanArr[$zanCnt][str]="1";
				$zanArr[$zanCnt][start_time]=$chkArr[start_time];
				$zanArr[$zanCnt][detail]=$ins[reserve_date]."_".$chkArr[start_time]."_".$ins[end_time]."_".$ins[shop_no]."_".$search[menu_no]."_".$search[number];
				$result=1;
			}
			else{//他は予約OK
				$zanArr[$zanCnt][str]="2";
				$zanArr[$zanCnt][start_time]=$chkArr[start_time];
				$zanArr[$zanCnt][detail]=$ins[reserve_date]."_".$chkArr[start_time]."_".$ins[end_time]."_".$ins[shop_no]."_".$search[menu_no]."_".$search[number];
				$result=1;
			}
*/


			return $result;
	}
	function setArr($arr){
		$this->arr=$arr;
	}
	function getArr(){
		return $this->arr;
	}
	function setArrNg($arr){
		$this->arrNg=$arr;
	}
	function getArrNg(){
		return $this->arrNg;
	}
/*
	function checkReserve($chkArr, $search){

		$dao=new ReserveDAO();
		$zanArr=$this->getArr();

		$zanCnt=count($zanArr);

			//終了時間
			$endTmp=explode(":", $chkArr[start_time]);
			$ins[end_time]=date("H:i",mktime($endTmp[0],$endTmp[1]+$chkArr[rtimes],0,$chkArr[dtTmp][1],$chkArr[dtTmp][2],$chkArr[dtTmp][0]));

			$ins[shop_no]=$search[shop_no];
			$ins[reserve_date]=$search[reserve_date];
			$ins[start_time]=$chkArr[start_time];

			//予約希望時間帯現在の予約数(開始時間で見る）
			//$reserve_count=$dao->getReserveCount($ins,"start");
			$reserve_count=$dao->getReserveCount3($ins);

			$zan=$chkArr[shop_booth_cnt]-($search[number]+$reserve_count);
			if($zan<0){//予約不可
				$zanArr[$zanCnt][str]="0";
				$zanArr[$zanCnt][start_time]=$chkArr[start_time];
				$zanArr[$zanCnt][detail]="";
			}
			else if($zan==0){//今回の予約確定により、残りがなくなる場合は残りわずか
				$zanArr[$zanCnt][str]="1";
				$zanArr[$zanCnt][start_time]=$chkArr[start_time];
				$zanArr[$zanCnt][detail]=$ins[reserve_date]."_".$chkArr[start_time]."_".$ins[end_time]."_".$ins[shop_no]."_".$search[menu_no]."_".$search[number];
			}
			else{//他は予約OK
				$zanArr[$zanCnt][str]="2";
				$zanArr[$zanCnt][start_time]=$chkArr[start_time];
				$zanArr[$zanCnt][detail]=$ins[reserve_date]."_".$chkArr[start_time]."_".$ins[end_time]."_".$ins[shop_no]."_".$search[menu_no]."_".$search[number];
			}

			$this->setArr($zanArr);

			return true;
	}
*/



	/**
	 * 予約アンケートのフォーム表示と入力チェック等
	 *
	 * 現在未使用
	 *
	 */
	public function surveyAction() {


		$commonDao = new CommonDao();

		$login_member=$this->getMemberSession();

		//ログイン中の場合、登録は終わっているので、確認画面へ
		if($login_member){

			//予約内容のセッション
			$_SESSION[reserve_detail]=$_REQUEST[reserve_detail];

			$reserve_detail=$this->setReserveDetail();

			$this->view->assign("detail_no", $_REQUEST[detail_no]);
			$this->view->assign("buy_no", $_REQUEST[buy_no]);
			$this->view->assign("reserve_datail", $reserve_detail);



			// HTTPレスポンスヘッダ情報出力
				$this->outHttpResponseHeader();
				$this->setTemplatePath("reserve/reserve_confirm.tpl");
				return;

		}



		//予約アンケートの取得
		$setArr=$commonDao->get_data_tbl("mst_form_set","","","v_order ");

		if($_POST[submit]){

			//------ 入力チェック ------------
			$input_data=$_POST;
			$_SESSION["survey_input_data"]=$_POST;

			for($i=0;$i<count($setArr);$i++){
				$komoku_no=$setArr[$i][komoku_no];

				//必須チェック
				if($setArr[$i][status]==1){//必須
					if($setArr[$i][form_type]==5){
						if(count($input_data[no][$komoku_no])==0) $this->addMessage("err", $setArr[$i][name]."を選択してください。");
					}
					else{
						if($input_data[no][$komoku_no]==""){
							if($setArr[$i][form_type]<=2){
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."を入力してください。");
							}
							else{
								 $this->addMessage("err".$komoku_no, $setArr[$i][name]."を選択してください。");
							}
						}
					}
				}

				//入力チェック
/*
			"0" => "入力制限無し",
			"1" => "半角英数字のみ",
			"2" => "数字のみ",
			"5" => "数字と「-」",
			"12" => "数字と小数点",
			"7" => "全角ひらがなのみ",
			"6" => "全角カタカナのみ",
			"3" => "メールアドレス",
*/
				if($setArr[$i][form_type]<=2 && $input_data[no][$komoku_no]!=""){
					$chkNo=$setArr[$i][in_chk];
					$ret=chkString($input_data[no][$komoku_no],$chkNo,$setArr[$i][in_max],$setArr[$i][in_min]);

					if($ret != 0){
						if($ret == 1){
							$this->addMessage("err".$komoku_no, $setArr[$i][name]."に入力された文字数が長すぎます。".$setArr[$i][in_max]."文字以下で入力してください。");
						}elseif($ret == 5){
							$this->addMessage("err".$komoku_no, $setArr[$i][name]."に入力された文字数が短すぎます。".$setArr[$i][in_min]."文字以上で入力してください。");
						}else{
							if($inputChk == 1){
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."は半角英数で入力してください");
							}elseif($inputChk == 3){
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."を正しく入力してください");
							}elseif($inputChk == 6){
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."は全角カタカナで入力してください");
							}elseif($inputChk == 7){
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."は全角かなで入力してください");
							}elseif($inputChk == 12){
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."は半角数字と｢.｣で入力してください");
							}elseif($inputChk == 5){
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."は半角数字と｢-｣で入力してください");
							}else{
								$this->addMessage("err".$komoku_no, $setArr[$i][name]."は半角数字で入力してください");
							}
						}
					}
				}
			}

			if (count($this->getMessages()) >0) {
				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}
				$this->view->assign("result_messages", $result_messages);
			}
			else{
				//エラーが無ければ、登録フォームを出す

				header("location:/reserve/regist/");
				return;

			}

		}
		else{

			//会員登録確認画面から、予約画面に戻って、再度予約登録処理をした場合には、セッションが残っている。
			if($_SESSION["survey_input_data"]){
				$input_data=$_SESSION["survey_input_data"];
			}

			//予約内容のセッション
			$_SESSION[reserve_detail]=$_REQUEST[reserve_detail];
		}


		//選択肢の項目を取得する（プルダウン,radio,checkboxの場合に使用）
		for($i=0;$i<count($setArr);$i++){
			if($setArr[$i][form_type]==3 || $setArr[$i][form_type]==4 || $setArr[$i][form_type]==5){
				$tmp=$commonDao->get_data_tbl("form_set_value","komoku_no",$setArr[$i][komoku_no]);
				$setArr[$i][opt]=makePulldownTableList($tmp, "name", "name");;
			}
		}

		$this->view->assign("setArr", $setArr);
		$this->view->assign("input_data", $input_data);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("reserve/survey.tpl");

		return;


	}

	/**
	 * 会員登録処理
	 */
	public function registAction() {


		$login_member=$this->getMemberSession();

		$commonDao = new CommonDao();
		$shopDao=new ShopDao();
		$memberDao=new MemberDao();


/*
		//予約詳細データ
		if(!$_SESSION[reserve_detail]){

			//時間切れエラー/不正エラー

					$msg="大変申し訳ございません。タイムアウトエラーです。予約画面から始めてください";
					$this->view->assign("msg", $msg);


				// HTTPレスポンスヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("error.tpl");
				return;

		}
		else{

			//$ins[reserve_date]."_".$chkArr[start_time]."_".$ins[end_time]."_".$ins[shop_no]."_".$search[menu_no]."_".$search[number
			//予約日(yyyy/mm/dd)."_".予約開始時間(hh:ii)."_".予約終了時間(hh:ii)."_".店舗番号."_".メニュー番号."_".人数

			$reserve_datail=$this->setReserveDetail();
			$this->view->assign("reserve_datail", $reserve_datail);

		}
*/

		//ログイン中の場合、登録は終わっているので、確認画面へ
		if($login_member){

			//予約内容のセッション
			$_SESSION[reserve_detail]=$_REQUEST[reserve_detail];

			$reserve_detail=$this->setReserveDetail();

			if($_POST[detail_no]){
				$this->view->assign("detail_no", key($_POST[detail_no]));
			}
			else{
				$this->view->assign("detail_no", $_REQUEST[detail_no]);
			}
			$this->view->assign("buy_no", $_REQUEST[buy_no]);
			$this->view->assign("reserve_datail", $reserve_detail);




			// HTTPレスポンスヘッダ情報出力
				$this->outHttpResponseHeader();
				$this->setTemplatePath("reserve/reserve_confirm.tpl");
				return;

		}

		//予約情報セット
		if($_SESSION[reserve_detail]){
			$reserve_datail=$this->setReserveDetail();
			$this->view->assign("reserve_datail", $reserve_datail);
		}


		//必須項目情報の取得
		$memarr=$commonDao->get_data_tbl("member_require","","","no");
		$this->view->assign("memarr", $memarr);

		//config
		$prefArr=CommonArray::$pref_text_array;

		//基本事項
		$baseData=CommonChkArray::$memberRegistCheckData;

		if($_POST[confirm]){
			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//---------------- 入力チェック ---------------------------

			$this->check($input_data,$baseData);

			//email重複チェック
			$tmp=$commonDao->get_data_tbl("member","email",$input_data[email]);
			if($tmp){
				$this->addMessage("email","ご入力のメールアドレスは登録されています");
			}
			//パスワード
			if($input_data[password] && $input_data[password2]){
				if($input_data[password] != $input_data[password2]){
					$this->addMessage("password","パスワードと確認パスワードが違っています。");
				}
			}

			//必須チェック（管理画面の必須項目管理で設定されている）
			for($i=0;$i<count($memarr);$i++){

				$name=$memarr[$i][name];
				$req_flg=$memarr[$i][req_flg];
				$form_type=$memarr[$i][form_type];
				if($req_flg==1){//必須

					if($input_data[$name]==""){
						if($form_type==1){
							$this->addMessage($name, $memarr[$i][name_str]."を入力してください。");
						}
						else if($form_type==2){
							$this->addMessage($name, $memarr[$i][name_str]."を選択してください。");
						}
					}
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

				//都道府県名
				$input_data[pref_str]=get_pref_name($input_data[pref]);

				//確認画面の表示
				$this->view->assign("input_data", $input_data);

				// HTTPレスポンスヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("reserve/regist_confirm.tpl");
				return;



			}
		}
		else if($_POST[submit]){

			//予約情報セッションチェック
			//予約詳細データ
			if(!$_SESSION[reserve_detail]){
				//時間切れエラー/不正エラー
						$msg="大変申し訳ございません。タイムアウトエラーです。予約画面から始めてください";
						$this->view->assign("msg", $msg);
					// HTTPレスポンスヘッダ情報出力
					$this->outHttpResponseHeader();
					$this->setTemplatePath("error.tpl");
					return;
			}
			if($_SESSION["input_data"]){

				//登録直前に再度予約チェック タイムラグ　先に予約登録されている場合もあるので、再チェック
//				$chkResult=$this->chkReserve($reserve_datail);
				list($chkResult,$reserve_datail)=$this->chkReserve($reserve_datail);
				if(!$chkResult){
					//$this->addMessage("error","大変申し訳ございません。予約が埋まってしまいました。<br />予約画面から再度の予約をお願いいたします。");

					$msg="大変申し訳ございません。予約が埋まってしまいました。<br />予約画面から再度の予約をお願いいたします。";
					$this->view->assign("msg", $msg);

					// HTTPレスポンスヘッダ情報出力
					$this->outHttpResponseHeader();

					$this->setTemplatePath("error.tpl");
					return;

				}
				else{

					$input_data=$_SESSION["input_data"];

					//店舗番号が取得出来ない場合がまれにあるので・・回避処置
					$input_data[shop_no]=$reserve_datail[shop_no];//店舗番号を入れ直し


					//基本事項
					foreach($baseData[dbstring] as $key=>$val){
						if($key=="password"){
							$dkey[]=$key;
							$dval[]=to_hash($input_data[$key]);
						}
						else{
							$dkey[]=$key;
							$dval[]=$input_data[$key];
						}
					}

						//----------- 新規登録 ------------

						$dkey[]="insert_date";
						$dval[]=date("Y-m-d H:i:s");

						$input_data[spid]=$input_data[shop_no];//管理画面に合わせる。spidは会員NOの頭に付く番号

						//どこからの予約登録かを判定させるため
						$reserve_datail[regist_flg]=1;//ユーザー側から

						list($ret,$reserve_no)=$memberDao->InsertItemData($dkey, $dval,$input_data,$reserve_datail);
						$reserve_datail[reserve_no]=$reserve_no;

						if($ret){
							//登録者にメールを出す設定であれば出す
							$tmp=$commonDao->get_data_tbl("mst_auto_mail",array("no","mail_flg"),array(1,1));
							if($tmp){

								$input_data[pref_str]=get_pref_name($input_data[pref]);
								if($input_data[sex]==1){
									$input_data[sex_str]="男性";
								}
								else if($input_data[sex]==2){
									$input_data[sex_str]="女性";
								}

								$this->view->assign("input_data", $input_data);
								$this->view->assign("reserve_datail", $reserve_datail);
								$bodyMail = $this->view->fetch("mail/regist.tpl");

								//署名GET
								$sigtmp=$commonDao->get_data_tbl("mail_sig","","");
								$sig=$sigtmp[0][sig];


								$subject = $tmp[0][subject];
								$mailBody = $tmp[0][header_text].$bodyMail."\n\n".$tmp[0][footer_text]."\n\n".$sig;
								$mailfrom="From:" .mb_encode_mimeheader(MAIL_FROM_NAME) ."<".MAIL_FROM.">";
								send_mail($input_data[email], MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
							}

							//予約者にメールを出す設定であれば出す
							//運営者にメール
							$this->send_auto_mail($reserve_datail,$input_data);



							//ログイン状態にする

/*
							$ret=$commonDao->get_data_tbl2("member",$fi);
							if($ret){
								//ログイン成功
								$this->setMemberSession($ret[0]);
							}
*/






							if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
							if($_SESSION["reserve_input_data"]) unset($_SESSION["reserve_input_data"]);
							if($_SESSION["survey_input_data"]) unset($_SESSION["survey_input_data"]);


							$this->view->assign("reserve_no", $reserve_no);
							$this->view->assign("input_data", $input_data);
							$this->setTemplatePath("reserve/regist_finish.tpl");
							return;

						}
						else{

							$msg="大変申し訳ございません。予約登録エラーです。予約画面から再度の予約をお願いいたします。";
							$this->view->assign("msg", $msg);

							// HTTPレスポンスヘッダ情報出力
							$this->outHttpResponseHeader();

							$this->setTemplatePath("error.tpl");
							return;
						}
				}
			}
			else{

							$msg="大変申し訳ございません。タイムアウトエラーです。予約画面から再度の予約をお願いいたします。";
							$this->view->assign("msg", $msg);
				// HTTPレスポンスヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("error.tpl");
				return;
			}
		}
		else if($_POST[back]){

			$input_data=$_SESSION["input_data"];

		}
		else{
			//新規登録
			//会員登録確認画面から、予約画面に戻って、再度予約登録処理をした場合には、セッションが残っている。
			if($_SESSION["input_data"]){
				$input_data=$_SESSION["input_data"];
			}
			else{
				//デフォルト
//				$input_data[sex]=2;
//				$input_data[year]="1980";
			}

			$_SESSION[reserve_detail]=$_REQUEST[reserve_detail];

		}




		//年月日プルダウン
//		$yearArr=makeYearList("1945","-10",1);
		$yearArr=makeYearList2("0","1945",1);
		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);


		$this->view->assign("input_data", $input_data);
		$this->view->assign("prefArr", $prefArr);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("reserve/regist.tpl");

		return;


	}

	/**
	 *  会員登録済みのメンバーの予約処理（マイページから）
	 */
	public function memberAction() {


		$commonDao = new CommonDao();
		$reserveDao=new ReserveDao();
		$memberDao=new MemberDao();
		$login_member=$this->getMemberSession();

		//予約詳細データ
		if(!$_SESSION[reserve_detail]){

			//時間切れエラー/不正エラー

				$this->addMessage("error","タイムアウトエラーです。予約画面から始めてください");

				// HTTPレスポンスヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("error.tpl");
				return;

		}
		else{
			$reserve_datail=$this->setReserveDetail();

			//予約の変更のばあ
			if($_POST[detail_no]){
				$reserve_datail[detail_no][key($_POST[detail_no])]=key($_POST[detail_no]);//他の配列と合わせるため
			}
			$this->view->assign("reserve_datail", $reserve_datail);

		}

		//-------------予約可能かチェック  タイムラグがあるので、予約直前に再度チェック--------------
//		$chkResult=$this->chkReserve($reserve_datail);
		list($chkResult,$reserve_datail)=$this->chkReserve($reserve_datail);
		if(!$chkResult){
				$this->addMessage("error","大変申し訳ございません。予約が埋まってしまいました。<br />予約画面から再度の予約をお願いいたします。");
		}
		else{
			//予約中の予約内容を修正
			if($_POST[detail_no]){

				//予約番号取得
				$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",key($_POST[detail_no]));
				$oldReserveArr=$tmp[0];
				$rtmp=$commonDao->get_data_tbl("member_reserve","reserve_no",$tmp[0][reserve_no]);
				$oldReserveArr[number]=$rtmp[0][number];
				//変更前メニューのusr_count
				$oldMenuTmp=$commonDao->get_data_tbl("mst_menu","menu_no",$oldReserveArr[menu_no]);

				$reserve_no=$tmp[0][reserve_no];
				$reserve_datail[reserve_no]=$reserve_no;

				//サマリー
				$fi=array();
				$fi[number]=$reserve_datail[number];
				$wfi[reserve_no]=$reserve_no;

				$commonDao->updateData2("member_reserve",$fi,$wfi);


				//詳細
				$fi=array();
				$fi[menu_no]=$reserve_datail[menu_no];
				$fi[reserve_date]=$reserve_datail[reserve_date];
				$fi[start_time]=$reserve_datail[start_time];
				$fi[end_time]=$reserve_datail[end_time];

				$ret=$commonDao->updateData2("member_reserve_detail",$fi,$wfi);
				if(!$ret){
					$this->addMessage("error","予約変更エラーです。<br />大変申し訳ございませんが、もう一度、マイページから予約の変更処理をお願いいたします。");
					// HTTPレスポンスヘッダ情報出力
					$this->outHttpResponseHeader();

					$this->setTemplatePath("error.tpl");
					return;
				}

						//========== 予約人数の変更であれば、detailの変更が必要になる。==================
						//人数が増えた場合は、予約を増やす
						//人数が減った場合は、減った場合の予約を取り消す（キャンセルで良いかな）
						if($oldReserveArr[number]<$reserve_datail[number]){//予約人数が増えた

							$loop=$reserve_datail[number]-$oldReserveArr[number];

							for($i=0;$i<$loop;$i++){

								//詳細
								$fi=array();
								$fi[reserve_no]=$reserve_datail[reserve_no];
								$fi[shop_no]=$reserve_datail[shop_no];
								$fi[menu_no]=$reserve_datail[menu_no];
								$fi[reserve_date]=$reserve_datail[reserve_date];
								$fi[start_time]=$reserve_datail[start_time];
								$fi[end_time]=$reserve_datail[end_time];
								$fi[insert_date]=date("Y-m-d H:i:s");
								$fi[update_date]=date("Y-m-d H:i:s");
								$commonDao->InsertItemData2("member_reserve_detail", $fi);

							}

						}
						else if($oldReserveArr[number]>$reserve_datail[number]){//予約人数が減った
							//該当の予約番号で、member_idの予約データを減った分だけ取得して、キャンセル扱いいする
							$fi=array();
							$fi[reserve_no]=$reserve_datail[reserve_no];
							$fi[member_id]=0;
							$fi[visit_flg]=0;
							$dtmp=$commonDao->get_data_tbl2("member_reserve_detail",$fi,"no");

							$loop=$oldReserveArr[number]-$reserve_datail[number];
							for($i=0;$i<$loop;$i++){
								$fi=array();
								$fi[visit_flg]=99;
								$wfi[no]=$dtmp[$i][no];
								$commonDao->updateData2("member_reserve_detail",$fi,$wfi);

							}
						}

						//当初予定の回数よりも増えた場合 カウント用レコードの追加
						$menuTmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_datail[menu_no]);
						if($oldMenuTmp[0][use_count]<$menuTmp[0][use_count]){
								$ccc=$menuTmp[0][use_count]-$oldMenuTmp[0][use_count];
								$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",key($_POST[detail_no]));
								$fi=$tmp[0];

								for($i=0;$i<$ccc;$i++){
									$fi[no]="";
									$fi[reserve_no]="";
									$fi[p_no]=key($_POST[detail_no]);
									$commonDao->InsertItemData2("member_reserve_detail", $fi);
								}

											//finishチェック
											$memberDao->getCourseCountCheck($oldReserveArr[buy_no]);//2015.04.14 add

						}

						//当初の予定よりも減った場合 不要なカウント用レコードは削除
						if($oldMenuTmp[0][use_count]>$menuTmp[0][use_count]){
								$ccc=$oldMenuTmp[0][use_count]-$menuTmp[0][use_count];
								for($i=0;$i<$ccc;$i++){
									$tmp=$commonDao->get_data_tbl("member_reserve_detail","p_no",key($_POST[detail_no]),"no",1);
									$commonDao->del_Data("member_reserve_detail", "no", $tmp[0][no]);
								}

											//finishチェック
											$memberDao->getCourseCountCheck($oldReserveArr[buy_no]);//2015.04.14 add

						}

						//未購入のコースの予約の場合、メニューが変われば、未購入のコースの番号も変更となるので修正
						$buyTmp=$commonDao->get_data_tbl("member_buy","buy_no",$oldReserveArr[buy_no]);
						if($buyTmp[0][fee_flg]==0 && $reserve_datail[menu_no]<>$oldReserveArr[menu_no]){
							//選択したメニューの親コース番号取得
							$mtmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_datail[menu_no]);
							$course_no=$mtmp[0][course_no];

							//値段も変わる
							$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$course_no);
							$ufi[course_no]=$course_no;
							$ufi[fee]=$ctmp[0][fee];
							$ufi[total_fee]=$ctmp[0][fee];
							$uwfi[buy_no]=$oldReserveArr[buy_no];

							$commonDao->updateData2("member_buy", $ufi,$uwfi);
						}





				//予約変更メールを出す設定であればメール送信
				$this->send_auto_mail_change($reserve_datail, $oldReserveArr,$login_member);


				$this->view->assign("modi_str", "の変更");

			}
			else{

				$dkey[]="member_id";
				$dval[]=$login_member[member_id];
				$dkey[]="number";
				$dval[]=$reserve_datail[number];
				$dkey[]="insert_date";
				$dval[]=date("Y-m-d H:i:s");
				$dkey[]="update_date";
				$dval[]=date("Y-m-d H:i:s");


				//予約詳細登録用に不足データをセット（adminの予約データに合わせる為）
				$reserve_datail[member_id]=$login_member[member_id];
				//ユーザー側からの登録であるフラグ
				$reserve_datail[regist_flg]=1;

				if($_POST[buy_no]==""){
					//仮購入する
					$reserve_datail[buy_no]=$memberDao->InsertCourseData($reserve_datail);
				}
				else{
					$reserve_datail[buy_no]=$_POST[buy_no];
				}

				$ret=$reserveDao->InsertItemData($dkey, $dval, $reserve_datail,$reserve_datail[end_time]);
				$reserve_datail[reserve_no]=$ret;

				if($ret){

					//規定回数に達したら、購入コース終了

					//選択コースに対する、予約の回数をカウント（キャンセルを除いて）
					//規定回数の予約が入ったら、そのコースは終了となる。（キャンセルになったら、解除を行う。）
					$memberDao->getCourseCountCheck($reserve_datail[buy_no]);
					$this->addMessage("info","ご希望の時間帯に予約を行いました");

					//予約者にメールを出す設定であれば出す
					//メール送信
					$this->send_auto_mail($reserve_datail,$login_member);


					$this->view->assign("reserve_no", $ret);

				}
				else{
					$this->addMessage("error","予約登録エラーです。<br />大変申し訳ございませんが、予約画面から再度の予約をお願いいたします。");
					// HTTPレスポンスヘッダ情報出力
					$this->outHttpResponseHeader();

					$this->setTemplatePath("error.tpl");
					return;
				}
			}
		}

		$input_data[name]=$login_member[name];
		$input_data[name_kana]=$login_member[name_kana];
		$this->view->assign("input_data", $input_data);//未登録者の完了画面にあわせるため
		$this->view->assign("login_member", $login_member);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("reserve/regist_finish.tpl");

		return;


	}

	/**
	 *  メニュー番号から
	 *
	 *  コースの料金説明とメニューの説明を乗せる
	 *
	 */
	public function menu_detailAction() {


		$commonDao = new CommonDao();

		$menu_no=makeGetRequest($_GET[no]);

		$sql="select *,m.name as menu_name,c.name as course_name from mst_menu as m, mst_course as c where m.course_no=c.course_no and m.menu_no=".$menu_no;
		$tmp=$commonDao->get_sql($sql);

		$this->view->assign("arr", $tmp[0]);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("reserve/menu_detail.tpl");

		return;



	}


	/**
	 *
	 *	選択した店舗のブース数を取得してその数のプルダウンを作成する
	 *
	 *　ただし！
	 *　・ウェディングは必ず二人でのお申込み
	 *　・回数が一回のコースに紐ずくメニューの場合は、一人でお申し込みとなる
	 *
	 *
	 *
	 */
	public function getNumberAction() {

		$commonDao = new CommonDao();

		$shop_no=$_REQUEST[shop_no];
		$menu_no=$_REQUEST[menu_no];


		//メニューが選択されている場合（menu_no>0)はmenu人数をチェック
		//二人以上の場合は、その人数で決め打ちとする。
		//ブース数プルダウンは店舗が決まっていて、
		//メニューが決まっていない、または、メニューが決まっている場合は人数が一人の時（二人以上の場合は、決め打ちとする）
		if($menu_no>0){
			$sql="select m.number as number, c.number as c_number from mst_menu as m, mst_course as c where m.menu_no=".$menu_no." and c.course_no=m.course_no";
			$tmp=$commonDao->get_sql($sql);

			$number=$tmp[0][number];
			$c_number=$tmp[0][c_number];
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
			$boothArr=makePulldownList(1, $tmp[0][attr_value]);
		}

		$this->view->assign("search", $_SESSION["reserve_input_data"]);
		$this->view->assign("boothArr", $boothArr);


		$data["html"] = $this->view->fetch("addCategoryPull.tpl");

		echo json_encode($data);
		return;

	}


	//------ セッション情報を変数にセット
	function setReserveDetail(){


		$shopDao = new ShopDAO();
		$commonDao = new CommonDao();

		//予約画面から送られてくるパラメータ詳細
		//$ins[reserve_date]."_".$chkArr[start_time]."_".$ins[end_time]."_".$ins[shop_no]."_".$search[menu_no]."_".$search[number
		//予約日(yyyy/mm/dd)."_".予約開始時間(hh:ii)."_".予約終了時間(hh:ii)."_".店舗番号."_".メニュー番号."_".人数

		$reserve_datailTmp=$_SESSION[reserve_detail];
		$reserve_datail=explode("_",$reserve_datailTmp);

		//店舗名
		$reserve_datail[shop_name]=$shopDao->getShopName($reserve_datail[3]);
		$reserve_datail[shop_no]=$reserve_datail[3];

		//メニュー名
		$reserve_datail[menu_name]=$shopDao->getMenuName($reserve_datail[4]);
		$reserve_datail[menu_no]=$reserve_datail[4];

		//メニューのチケット使用回数
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_datail[4]);
		$reserve_datail[use_count]=$tmp[0][use_count];

		//人数
		$reserve_datail[number]=$reserve_datail[5];
		//予約日
		$reserve_datail[reserve_date]=$reserve_datail[0];
		$reserve_datail[start_time]=$reserve_datail[1];
		$reserve_datail[end_time]=$reserve_datail[2];

		return $reserve_datail;

	}

	//------ 予約情報から予約可能かチェックするための
/*
 * Appに移動
	function chkReserve($reserve_datail){

		$commonDao = new CommonDao();
		$reserveDao = new ReserveDAO();

		//ご希望コースの所要時間
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_datail[menu_no]);
		$rtimes=$tmp[0][times];//所要時間
		$input_data[use_count]=$tmp[0][use_count];//ご希望メニューが何回分のチケットを使うか


		$rsv_date=explode("/",$reserve_datail[reserve_date]);
		$ins[end_time]=$reserve_datail[end_time];

		$ins[shop_no]=$reserve_datail[shop_no];
		$ins[reserve_date]=$reserve_datail[reserve_date];
		$ins[start_time]=$reserve_datail[start_time];

		//店舗のブース数
		$tmp=$commonDao->get_data_tbl("shop_attr",array("shop_no","attr_key"),array($ins[shop_no],"booth"));
		$shop_booth_cnt=$tmp[0][attr_value];


		$tmp=$commonDao->get_data_tbl2("member_reserve_detail",$ins);
		//予約希望時間帯現在の予約数
		$reserve_count_s=$reserveDao->getReserveCount($ins,"start");
		$reserve_count_e=$reserveDao->getReserveCount($ins,"end");


		if($shop_booth_cnt<($reserve_datail[number]+$reserve_count_s) || $shop_booth_cnt<($reserve_datail[number]+$reserve_count_e)){
			return false;
		}


		return true;

	}
*/
	function send_auto_mail($reserve_datail,$input_data){

		$commonDao = new CommonDao();
		$shopDao = new ShopDAO();

		//メニュー名
		$menu_name=$shopDao->getMenuName($reserve_datail[menu_no]);

		$tmp=$commonDao->get_data_tbl("mst_auto_mail",array("no","mail_flg"),array(2,1));
		if($tmp){


			//署名GET
			$sigtmp=$commonDao->get_data_tbl("mail_sig","","");
			$sig=$sigtmp[0][sig];

			$bodyMail="\n\n◆予約番号：".$reserve_datail[reserve_no]."\n";
			$bodyMail.="◆予約日：".$reserve_datail[reserve_date]."\n";
			$bodyMail.="◆時間：".$reserve_datail[start_time]."～".$reserve_datail[end_time]."\n";
			$bodyMail.="◆人数：".$reserve_datail[number]."人"."\n";
			$bodyMail.="◆店舗：".$reserve_datail[shop_name]."\n";
			$bodyMail.="◆メニュー：".$menu_name."\n\n\n";


			$subject = $tmp[0][subject];
			$mailBody = $tmp[0][header_text].$bodyMail.$tmp[0][footer_text]."\n\n".$sig;
			send_mail($input_data[email], MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
		}

		//---- 運営にメール --------------
		//メール設定がされている場合は、そのメールに
		//メール設定がれていない場合は、本部に
		$tmp=$commonDao->get_data_tbl("shop","shop_no",$reserve_datail[shop_no]);
		if($tmp[0][send_email]){
			$shop_send_mail=$tmp[0][send_email];
		}
		else{
			$shop_send_mail=SITE_ADMIN_EMAIL;
		}


		$this->view->assign("input_data", $input_data);
		$this->view->assign("reserve_datail", $reserve_datail);
		$this->view->assign("menu_name", $menu_name);
		$subject = "[" . STR_SITE_TITLE . "]ご予約がありました";
		$mailBody = $this->view->fetch("mail/reserve.tpl");
		send_mail($shop_send_mail, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);


	}

	//予約変更のメール
	function send_auto_mail_change($reserve_datail,$oldReserveArr,$login_member){

		$commonDao = new CommonDao();
		$shopDao = new ShopDAO();

		$tmp=$commonDao->get_data_tbl("mst_auto_mail",array("no","mail_flg"),array(4,1));
		if($tmp){

			//メニュー名
			$menu_name=$shopDao->getMenuName($reserve_datail[menu_no]);

			$bodyMail="\n\n---変更後　予約詳細---\n\n";

			$bodyMail.="◆予約番号：".$reserve_datail[reserve_no]."\n";
			$bodyMail.="◆予約日：".$reserve_datail[reserve_date]."\n";
			$bodyMail.="◆時間：".$reserve_datail[start_time]."～".$reserve_datail[end_time]."\n";
			$bodyMail.="◆人数：".$reserve_datail[number]."人"."\n";
			$bodyMail.="◆店舗：".$reserve_datail[shop_name]."\n";
			$bodyMail.="◆メニュー：".$menu_name."\n\n\n";


			//旧予約情報
			//メニュー名
			$oldmenu_name=$shopDao->getMenuName($oldReserveArr[menu_no]);

			//店舗名
			$oldshop_name=$shopDao->getShopName($oldReserveArr[shop_no]);

			$bodyMail.="\n\n---変更前　予約詳細---\n\n";

			$bodyMail.="◆予約番号：".$oldReserveArr[reserve_no]."\n";
			$bodyMail.="◆予約日：".str_replace("-","/",$oldReserveArr[reserve_date])."\n";
			$bodyMail.="◆時間：".$oldReserveArr[start_time]."～".$oldReserveArr[end_time]."\n";
			$bodyMail.="◆人数：".$oldReserveArr[number]."人"."\n";
			$bodyMail.="◆店舗：".$oldshop_name."\n";
			$bodyMail.="◆メニュー：".$oldmenu_name."\n\n\n";


			//署名GET
			$sigtmp=$commonDao->get_data_tbl("mail_sig","","");
			$sig=$sigtmp[0][sig];

			$subject = $tmp[0][subject];
			$mailBody = $tmp[0][header_text].$bodyMail.$tmp[0][footer_text]."\n\n".$sig;
			send_mail($login_member[email], MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
		}

		//---- 運営にメール --------------
		//メール設定がされている場合は、そのメールに
		//メール設定がれていない場合は、本部に
		$tmp=$commonDao->get_data_tbl("shop","shop_no",$reserve_datail[shop_no]);
		if($tmp[0][send_email]){
			$shop_send_mail=$tmp[0][send_email];
		}
		else{
			$shop_send_mail=SITE_ADMIN_EMAIL;
		}

		$this->view->assign("input_data", $login_member);
		$this->view->assign("reserve_datail", $reserve_datail);
		$this->view->assign("oldReserveArr", $oldReserveArr);
		$this->view->assign("menu_name", $menu_name);
		$this->view->assign("oldmenu_name", $oldmenu_name);
		$this->view->assign("oldshop_name", $oldshop_name);
		$subject = "[" . STR_SITE_TITLE . "]ご予約の変更がありました";
		$mailBody = $this->view->fetch("mail/reserve_change.tpl");
		send_mail($shop_send_mail, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);



	}



}
?>
