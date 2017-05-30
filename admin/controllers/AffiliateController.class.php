<?php
class AffiliateController extends AppRootController {

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
	 *   アフィリエイトレポート表示
	 */
	public function listAction() {
		$resuArr = '';
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao= new CommonDao();
		$reserveDao= new ReserveDAO();

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search['start_date']=$_POST['start_date'];
			$search['end_date']=$_POST['end_date'];
			$search['r_start_date']=$_POST['r_start_date'];
			$search['r_end_date']=$_POST['r_end_date'];
			$search['d_reserve_no']=$_POST['d_reserve_no'];
			$search['page']=1;

			$_SESSION['search_jyoken']=$search;
		}
		else if($_POST){
			$search = $_SESSION['search_jyoken'];
			$search['page']=$this->request->getParam("page");

		}
		else {
			// sessionに検索条件が保存されている場合

			if(isset($_SESSION['search_jyoken'])) unset($_SESSION['search_jyoken']);
			$search['page']=1;

			//デフォルトは本日
			$search['start_date']=date("Y/m/d");
			$search['end_date']=date("Y/m/d");

		}

		$search['regist_flg']=1;

//		$total_cnt=$memberDao->searchBuyCount($search);
//		if($total_cnt>ADMIN_V_CNT){
//			list($page_navi,$lastPage) = get_page_navi2($total_cnt, ADMIN_V_CNT, $search['page'], "/report/list/");
//		}
		$arr=$reserveDao->search2($search,"m.insert_date desc");
		for($i=0;$i<count($arr);$i++){

			//今回の予約が初めてかどうか（この予約以前に予約があるかどうか）
			$reserve_date=$arr[$i]['reserve_date'];
			$member_id=$arr[$i]['member_id'];
			$kind_flg="";
			if($reserveDao->chkFirstReserve($arr[$i])){
				$kind_flg="初";
			}
/*
			//予約メニューが初回かどうか
			$mtmp=$commonDao->get_data_tbl("mst_menu","menu_no",$arr[$i][menu_no]);
			$kind_flg="";
			if($mtmp[0][kind_flg]=="0"){
				$kind_flg="初";
			}
*/
			$arr[$i]['kind_flg']=$kind_flg;
		}

		$this->view->assign("arr", $arr);
//		$this->view->assign("total_cnt", $total_cnt);
//		$this->view->assign("navi", $page_navi);
		$this->view->assign("search", $search);

		//ダウンロード処理

		if(isset($_POST['csv'])){
			$txt="予約番号,予約を行った日時,施術日,名前,来店状況,初回フラグ,予約店舗";
			$txt=mb_convert_encoding($txt,"SJIS","UTF-8")."\n";

			$viArr=CommonArray::$visit_arr;

			for($i=0;$i<count($arr);$i++){

//				$kind_flg=mb_convert_encoding("初","SJIS","UTF-8");
				$csvTmp=array();
				$csvTmp[]=$arr[$i]['reserve_no'];
				$csvTmp[]=$arr[$i]['insert_date'];
				$csvTmp[]=$arr[$i]['reserve_date']." ".$arr[$i]['start_time'];
				$csvTmp[]=mb_convert_encoding($arr[$i]['name'],"SJIS","UTF-8");
				$visit_flg=$arr[$i]['visit_flg'];
				$csvTmp[]=mb_convert_encoding($viArr[$visit_flg],"SJIS","UTF-8");
				$csvTmp[]=mb_convert_encoding($arr[$i]['kind_flg'],"SJIS","UTF-8");
				$csvTmp[]=mb_convert_encoding($arr[$i]['shop_name'],"SJIS","UTF-8");

				$csvArr[]=implode(",",$csvTmp);

			}

			$csvF=$txt.implode("\n", $csvArr);
			$fname="affiliate_report.csv";
			execDownloadNoFile($csvF, $fname);

		}
/*
		//年月日プルダウン
		$yearArr=makeYearList("2014","2",1);
		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);
*/

		$this->view->assign("resuArr", $resuArr);

		$this->setTemplatePath("affiliate/list.tpl");

		return;

	}



}
?>


