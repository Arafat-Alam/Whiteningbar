<?php
class ReportController extends AppRootController {

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
	 *   売り上げ明細
	 */
	public function listAction() {
		$arr = null;
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$shop_no=0;
		if($login_admin['shop_no']>0){
			$search['reserve_shop_no']=$login_admin['shop_no'];
		}

		$commonDao= new CommonDao();
		$memberDao= new MemberDAO();

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search=$_POST;
			if($login_admin['shop_no']>0){
				$search['reserve_shop_no']=$login_admin['shop_no'];
			}

			//差分
			$timestamp1 = strtotime($search['start_date']);
			$timestamp2 = strtotime($search['end_date']);
			// 何秒離れているかを計算
			$seconddiff = abs($timestamp2 - $timestamp1);
			// 日数に変換
			$daydiff = $seconddiff / (60 * 60 * 24);


			$sdt=explode("-",$search['end_date']);

			//1日から末日までの情報を取得
			for($i=0;$i<=$daydiff;$i++){
				$search['reserve_date']=date("Y-m-d",mktime(0,0,0,$sdt[1],$sdt[2]-$i,$sdt[0]));
				$memberDao->searchBuy($search,$search['reserve_date']);
			}
			$arr=$memberDao->getDetailReport();
			// echo "<pre>"; print_r($arr);exit();


			$_SESSION['result_arr']=$arr;

/*
			$search['start_date']=$_POST['start_date'];
			$search['end_date']=$_POST['end_date'];
			$search['page']=1;

			$_SESSION['search_jyoken']=$search;
*/
		}
		else if($_POST){
			$search = $_SESSION['search_jyoken'];

			$arr=$_SESSION['result_arr'];

		}
		else {
			// sessionに検索条件が保存されている場合

			if(isset($_SESSION['search_jyoken'])) unset($_SESSION['search_jyoken']);
			$search['page']=1;

			//デフォルト
			$search['start_date']=date("Y-m-d");
			$search['end_date']=date("Y-m-d");

		}
		// echo "<pre>"; print_r($arr);exit();
		
		$this->view->assign("arr", $arr);
		$this->view->assign("search", $search);

		//ダウンロード処理
		$txt="売上日,項目,実売上,クーポン料金,コース料金";
		$txt=mb_convert_encoding($txt,"SJIS","UTF-8")."\n";
		if(isset($_POST['csv'])){

			for($i=0;$i<count($arr);$i++){
				$csvTmp=array();
				$aaa=explode(" ", $arr[$i]['buy_date']);
				$csvTmp[]=$aaa[0];
				$csvTmp[]=mb_convert_encoding($arr[$i]['course_name'],"SJIS","UTF-8");
				$csvTmp[]=$arr[$i]['total_fee'];
				$csvTmp[]=$arr[$i]['discount'];
				$csvTmp[]=$arr[$i]['fee'];

				$csvArr[]=implode(",",$csvTmp);

			}

			$csvF=$txt.implode("\n", $csvArr);
			$fname="sales_report.csv";
			execDownloadNoFile($csvF, $fname);

		}


/*
		//登録購入コース取得
		$tmp=$commonDao->get_data_tbl("mst_course","","","v_order");
		$courseArr=makePulldownTableList($tmp,"course_no","name");
		array_unshift($courseArr, "--");
		$this->view->assign("courseArr", $courseArr);

		//年月日プルダウン
		$yearArr=makeYearList("2014","2",1);
		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);


		$this->view->assign("resuArr", $resuArr);
*/
		$this->setTemplatePath("report/list.tpl");

		return;

	}

	/**
	 *   レポート表示
	 *
	 *   月次
	 *   該当月の日ごとのレポート
	 */
	public function monthAction() {
		$arr = array();
		$totalArr = array();

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$shop_no=0;
		if($login_admin['shop_no']>0){
			$search['shop_no']=$login_admin['shop_no'];
		}

		$commonDao= new CommonDao();
		$memberDao= new MemberDAO();


		// echo "<pre>"; print_r($_POST);
		if(isset($_POST['sbm_search'])){
			$search['f_year']=$_POST['f_year'];
			$search['f_month']=$_POST['f_month'];
			$search['t_year']=$_POST['t_year'];
			$search['t_month']=$_POST['t_month'];

			if (isset($_POST['shop_no']) && $_POST['shop_no']>0) {
				$search['shop_no']=$_POST['shop_no'];
				$this->view->assign("shop_no", $search['shop_no']);
			}


			//fの初日
			@$timestamp1=mktime(0,0,0,$search['f_month'],$i,$search['f_year']);
			//tの末日
			$timestamp2 =mktime(23,59,59,$search['t_month']+1,0,$search['t_year']);

			$seconddiff = abs($timestamp2  - $timestamp1);
			$daydiff = $seconddiff / (60 * 60 * 24)-1;
			for($i=0;$i<$daydiff;$i++){

				$search['buy_date']=date("Y-m-d",mktime(0,0,0,$search['f_month'],1+$i,$search['f_year']));
				$arr[]=$memberDao->searchBuyDay($search,$search['buy_date'],$login_admin);
			}
			// echo "<pre>"; print_r($arr); exit();

/*
			//fの末日を出す
			$lastDay=date("d",mktime(0,0,0,$search['f_month']+1,0,$search['f_year']));
			//1日から末日までの情報を取得
			for($i=1;$i<=$lastDay;$i++){
				$search['buy_date']=date("Y-m-d",mktime(0,0,0,$search['f_month'],$i,$search['f_year']));
				$arr[]=$memberDao->searchBuyDay($search,$search['buy_date'],$login_admin);
			}

			//fとtの月が違っていたらtの方も取得
			if($search['f_month']!=$search['t_month']){
				$lastDay=date("d",mktime(0,0,0,$'search'['t_month']+1,0,$search['t_year']));
				//1日から末日までの情報を取得
				for($i=1;$i<=$lastDay;$i++){
					$search['buy_date']=date'("'Y-m-d",mktime(0,0,0,$search['t_month'],$i,$search['t_year']));
					$arr[]=$memberDao->searchBuyDay($search,$search['buy_date'],$login_admin);
				}
			}
*/

			$totalArr=$memberDao->getTotalReport();

			$_SESSION['result_arr']=$arr;
			$_SESSION['result_totalarr']=$totalArr;

		}
		else if(isset($_POST['sbm_search2'])){//月選択
			$search['mon']=$_POST['mon'];

			if (isset($_POST['shop_no1']) && $_POST['shop_no1']>0) {
				$search['shop_no']=$_POST['shop_no1'];
				$this->view->assign("shop_no1", $search['shop_no']);
			}

			$tY=date("Y");
			$tM=date("m");
			$tD=date("d");
			$tdy=date("Y-m");
			$tdym=date("Y-m-d");

			//指定月の末日を出す
			$lastDay=date("d",mktime(0,0,0,$tM-$_POST['mon']+1,0,$tY));
			// echo date("Y-m-t", strtotime($tdym)); // for last date by td;
			
			//1日から末日までの情報を取得
			for($i=1;$i<=$lastDay;$i++){
				$search['buy_date']=date("Y-m-d",mktime(0,0,0,$tM-$_POST['mon'],$i,$tY));
				$arr[]=$memberDao->searchBuyDay($search,$search['buy_date'],$login_admin);			
			}
			// echo "<pre>"; print_r($arr); exit();
			$totalArr=$memberDao->getTotalReport();


			$_SESSION['result_arr']=$arr;
			$_SESSION['result_totalarr']=$totalArr;

			//デフォルト
			$search['f_year']=date("Y");
			$search['f_month']=date("m");
			$search['t_year']=date("Y");
			$search['t_month']=date("m");

		}
		else if($_POST){
			$arr=$_SESSION['result_arr'];
			$totalArr=$_SESSION['result_totalarr'];

		}
		else{
			//デフォルト
			$search['f_year']=date("Y");
			$search['f_month']=date("m");
			$search['t_year']=date("Y");
			$search['t_month']=date("m");



		}


		//招待コース

		//１回コースでの割引をふく


		//登録コース取得（複数回）
		$courseArr=$commonDao->get_data_tbl("mst_course","","","v_order");
		$this->view->assign("courseArr", $courseArr);

		if(isset($_POST['csv'])){
			$this->makeDownload($courseArr,$arr,$totalArr);

		}
		if ($login_admin['shop_no']==0) {
			$shopArr = $commonDao->get_data_tbl("shop");
			$this->view->assign("shopArr", $shopArr);
		}
		

		//年月日プルダウン
		$yearArr=makeYearList("2014","2");
		$monthArr=makeMonthList(0);
		// echo "<pre>"; print_r($arr); exit();

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("arr", $arr);
		$this->view->assign("totalArr", $totalArr);
		$this->view->assign("search", $search);

		$this->setTemplatePath("report/month.tpl");

		return;


	}

	/**
	 *   レポート表示
	 *
	 *   月次
	 *   該当月の日ごとのレポート
	 */
	public function dailyAction() {


		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$shop_no=0;
		if($login_admin['shop_no']>0){
			$search['shop_no']=$login_admin['shop_no'];
		}

		$commonDao= new CommonDao();
		$memberDao= new MemberDAO();


		if(isset($_POST['sbm_search'])){

			$search['start_date']=$_POST['start_date'];
			$search['end_date']=$_POST['end_date'];

			//差分
			$timestamp1 = strtotime($search['start_date']);
			$timestamp2 = strtotime($search['end_date']);
			// 何秒離れているかを計算
			$seconddiff = abs($timestamp2 - $timestamp1);
			// 日数に変換
			$daydiff = $seconddiff / (60 * 60 * 24);

			$sdt=explode("-",$search['start_date']);

			//1日から末日までの情報を取得
			for($i=0;$i<=$daydiff;$i++){
				$search['buy_date']=date("Y-m-d",mktime(0,0,0,$sdt[1],$sdt[2]+$i,$sdt[0]));
				$arr[]=$memberDao->searchBuyDay($search,$search['buy_date'],$login_admin);
			}

			$totalArr=$memberDao->getTotalReport();
			// echo "<pre>"; print_r($totalArr);exit();

			$_SESSION['result_arr']=$arr;
			$_SESSION['result_totalarr']=$totalArr;

		}
		else if($_POST){
			$arr=$_SESSION['result_arr'];
			$totalArr=$_SESSION['result_totalarr'];

		}
		else{
			//デフォルト
			$search['start_date']=date("Y-m-d");
			$search['end_date']=date("Y-m-d");

		}

		//登録コース取得
		$courseArr=$commonDao->get_data_tbl("mst_course","","","v_order");
		$this->view->assign("courseArr", $courseArr);


		if(isset($_POST['csv'])){
			$this->makeDownload($courseArr,$arr,$totalArr);

		}

		// echo "<pre>"; print_r($totalArr);exit();
		$this->view->assign("arr", $arr);
		$this->view->assign("totalArr", $totalArr);
		$this->view->assign("search", $search);

		$this->setTemplatePath("report/daily.tpl");

		return;

	}

	public function makeDownload($courseArr,$arr,$totalArr) {


		//ダウンロード処理
		$txt1="日付,純売上,総来客数,キャンセル,";
		$txt3=",他（金額）,割引合計金額";
		foreach($courseArr as $val){
			$txt2tmp[]=$val['name'];
		}
		$txt2=implode(",",$txt2tmp);
		$txt=$txt1.$txt2.$txt3;

		$txt=mb_convert_encoding($txt,"SJIS","UTF-8")."\n";

			for($i=0;$i<count($arr);$i++){
				$csvTmp=array();
				$csvTmp[]=$arr[$i]['dt'];
				$csvTmp[]=$arr[$i]['total_fee'];
				$csvTmp[]=$arr[$i]['total_count'];
				$csvTmp[]=$arr[$i]['cancel_count'];

				foreach($arr[$i]['course_fee'] as $val){
					$csvTmp[]=$val;
				}
				$csvTmp[]=$arr[$i]['other_fee'];
				$csvTmp[]=$arr[$i]['discount'];

				$csvArr[]=implode(",",$csvTmp);

			}

			//TOTAL
			$csvTmp=array();
			$csvTmp[]=mb_convert_encoding("合計","SJIS","UTF-8");
			$csvTmp[]=$totalArr['total_fee'];
			$csvTmp[]=$totalArr['total_count'];
			$csvTmp[]=$totalArr['cancel_count'];

			foreach($totalArr['course_fee'] as $val){
				$csvTmp[]=$val;
			}
			$csvTmp[]=$totalArr['other_fee'];
			$csvTmp[]=$totalArr['discount'];

			$csvArr[]=implode(",",$csvTmp);

			$csvF=$txt.implode("\n", $csvArr);
			$fname="sales_report.csv";
			execDownloadNoFile($csvF, $fname);



	}


	public function graphAction() {
		$search='';
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$shop_no=0;
		if($login_admin['shop_no']>0){
			$search['shop_no']=$login_admin['shop_no'];
		}

		$commonDao= new CommonDao();
		$memberDao= new MemberDAO();

		$year = date('Y');

		if (isset($_POST['sbm_search'])) {
			$year = $_POST['year']; 
			if (isset($_POST['shop_no']) && $_POST['shop_no'] != '') {
				$search['shop_no'] = $_POST['shop_no'];
				$this->view->assign("shop_no", $search['shop_no']);
			}
		}

		for ($j=1; $j <= 12; $j++) { 
			$start_date=1;
			$end_date=31;
			$memberDao->getYearGraphData($year,$j,$start_date,$end_date,$search);
		}

		$arr = $memberDao->getGraphData();

		$yearArr = array();
		$tdyear = date('Y');

		for ($i=$tdyear; $i >= 2013 ; $i--) { 
			$yearArr[] = $i;
		}
		$tmp=$commonDao->get_data_tbl("shop");
		$shopArr=makePulldownTableList($tmp,"shop_no","name",1);
		$this->view->assign("shopArr", $shopArr);

		$this->view->assign("arr", $arr);
		$this->view->assign("year", $year);
		$this->view->assign("yearArr", $yearArr);

		$this->setTemplatePath("report/graph.tpl");
		return;
	}

	public function menuTrendAction() {
		$commonDao= new CommonDao();
		$memberDao= new MemberDAO();
		$search = '';
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		if($login_admin['shop_no']>0){
			$search['shop_no']=$login_admin['shop_no'];
		}

		if (isset($_POST['sbm_search'])) {
			$search['f_year']=$_POST['f_year'];
			$search['f_month']=$_POST['f_month'];
			$search['t_year']=$_POST['t_year'];
			$search['t_month']=$_POST['t_month'];
			if ($search['f_year']>$search['t_year']) {
				$this->view->assign("error", "Please Select Correct Date Order");
			}
			$this->view->assign("search", $search);

			$search['f_date'] = $search['f_year'].'-'.$search['f_month'].'-01';
			$search['t_date'] = $search['t_year'].'-'.$search['t_month'].'-31';
			
			if (isset($_POST['shop_no']) && $_POST['shop_no']>0) {
				$search['shop_no']=$_POST['shop_no'];
				$this->view->assign("shop_no", $search['shop_no']);
			}
		}

		$arr = $memberDao->getMenuTrendData($search);

		if ($login_admin['shop_no']==0) {
			$shopArr = $commonDao->get_data_tbl("shop");
			$this->view->assign("shopArr", $shopArr);
		}
		$yearArr=makeYearList("2013","2");
		$monthArr=makeMonthList(0);
		// echo "<pre>"; print_r($arr); exit();

		@$this->view->assign("arr", $arr);
		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);

		$this->setTemplatePath("report/menuTrend.tpl");
		return;
	}

	public function saleDataAction(){
		
		$where = '';
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao= new CommonDao();
		$memberDao= new MemberDAO();

		$shop_no=0;
		if($login_admin['shop_no']>0){
			$search['reserve_shop_no']=$login_admin['shop_no'];
		}

		if ($login_admin['shop_no']==0) {
			$shopArr = $commonDao->get_data_tbl("shop");
			$this->view->assign("shopArr", $shopArr);
		}


		if (isset($_POST["sbm_search"])) {

			$search=$_POST;
			if($login_admin['shop_no']>0){
				$search['reserve_shop_no']=$login_admin['shop_no'];
			}
			if (isset($search['shop_no']) && $search['shop_no'] != 0) {
				$where = "and shop_no = '".$search['shop_no']."'";
				$this->view->assign("shop_no", $search['shop_no']);
			}

			//差分
			$timestamp1 = strtotime($search['start_date']);
			$timestamp2 = strtotime($search['end_date']);
			$this->view->assign("search",$search);
			// 何秒離れているかを計算
			$seconddiff = abs($timestamp2 - $timestamp1);
			// 日数に変換
			$daydiff = $seconddiff / (60 * 60 * 24);


			$sdt=explode("-",$search['start_date']);
			$dataArr[] = array();
			//1日から末日までの情報を取得
			$maxTotal = array();
			for($i=0;$i<=$daydiff;$i++){
				/* making date */
				$search['reserve_date']=date("Y-m-d",mktime(0,0,0,$sdt[1],$sdt[2]+$i,$sdt[0]));
				
				$day=getYoubi($search['reserve_date']);	
				/* Get date wise Total visitor */
				$sql = "select count(mrd.`no`) as totalVisitor from member_reserve_detail as mrd where mrd.reserve_date = '".$search['reserve_date']."' ".$where." and mrd.p_no=0 and mrd.visit_flg<>99;";
				$visitor = $commonDao->get_sql($sql);
				/* Get Date Wise cancel Visit */
				$sql = "select count(mrd.`no`) as totalCancel from member_reserve_detail as mrd where mrd.reserve_date = '".$search['reserve_date']."' ".$where." and mrd.p_no=0 and mrd.visit_flg=99;";
				$cancel = $commonDao->get_sql($sql);

				if (isset($search['shop_no']) && $search['shop_no'] != 0) {
					$sql = "select weather from daily_weather_info as dwi where dwi.shop_no=".$search['shop_no']." and dwi.`date`='".$search['reserve_date']."'";
					$weather = $commonDao->get_sql($sql);
					// echo "<pre>"; print_r($weather); exit();
				}				

				/* for get date wise total courses details & total fee & discount */
				$sql = "select count(mb.course_no) as courseSale,sum(mb.total_fee) as courseTotalFee,sum(mb.discount) as courseTotalDiscount,mb.* from member_buy as mb, mst_course as mc where mb.buy_date = '".$search['reserve_date']."' ".$where." and mc.course_no=mb.course_no group by mb.course_no";
				$tmp = $commonDao->get_sql($sql);

				$course = $commonDao->get_data_tbl("mst_course");
				$this->view->assign("course", $course);
				// echo "<pre>"; print_r($cancel); exit();  //echo "<br><br><hr><br><br>";
				$totalCancelVisit=$totalVisitor=0;
				for($a=0; $a < count($course); $a++){
					$totalFee = $totalDiscount = 0;	
					for ($j=0; $j < count($tmp) ; $j++) {
						if ($course[$a]['course_no']==$tmp[$j]['course_no']) {
							$dataArr[$tmp[$j]['buy_date']][$tmp[$j]['course_no']] = $tmp[$j]['courseSale'];
							$totalFee = $tmp[$j]['courseTotalFee']+$totalFee;
							$totalDiscount = $tmp[$j]['courseTotalDiscount']+$totalDiscount;
							$dataArr[$tmp[$j]['buy_date']]['totalFee'] = $totalFee;
							$dataArr[$tmp[$j]['buy_date']]['totalDiscount'] = $totalDiscount;
							$totalVisitor = $dataArr[$tmp[$j]['buy_date']]['totalVisitor'] = $visitor[0]['totalVisitor'];
							$totalCancelVisit = $dataArr[$tmp[$j]['buy_date']]['totalCancelVisit'] = $cancel[0]['totalCancel'];
							$dataArr[$tmp[$j]['buy_date']]['day'] = $day;
							if (isset($weather)) {
								@$dataArr[$tmp[$j]['buy_date']]['weather'] = $weather[0]['weather'];
							}else{	
								@$dataArr[$tmp[$j]['buy_date']]['weather'] = '';
							}
							break;
						}else{
							@$dataArr[$tmp[$j]['buy_date']][$course[$a]['course_no']] = 0;
							@$totalFee = $tmp[$j]['courseTotalFee']+$totalFee;
							@$totalDiscount = $tmp[$j]['courseTotalDiscount']+$totalDiscount;
							@$dataArr[$tmp[$j]['buy_date']]['totalFee'] = $totalFee;
							@$dataArr[$tmp[$j]['buy_date']]['totalDiscount'] = $totalDiscount;
							@$dataArr[$tmp[$j]['buy_date']]['totalVisitor'] = $visitor[0]['totalVisitor'];
							@$dataArr[$tmp[$j]['buy_date']]['totalCancelVisit'] = $cancel[0]['totalCancel'];
							@$dataArr[$tmp[$j]['buy_date']]['day'] = $day;
							if (isset($weather)) {
								@$dataArr[$tmp[$j]['buy_date']]['weather'] = $weather[0]['weather'];
							}else{	
								@$dataArr[$tmp[$j]['buy_date']]['weather'] = '';
							}
						}
					}
					 @$maxTotal[$course[$a]['course_no']] = $maxTotal[$course[$a]['course_no']]+$dataArr[$search['reserve_date']][$course[$a]['course_no']];
				}
				@$maxTotal['totalFee'] = $totalFee + $maxTotal['totalFee'];
				@$maxTotal['totalDiscount'] = $totalDiscount + $maxTotal['totalDiscount'];
				@$maxTotal['totalVisitor'] = $totalVisitor + $maxTotal['totalVisitor'];
				@$maxTotal['totalCancel'] = $totalCancelVisit + $maxTotal['totalCancel'];
			}
			// echo "<pre>"; print_r($dataArr); exit();
			$_SESSION['dataArr'] = $dataArr;
			$_SESSION['maxTotal'] = $maxTotal;

			$this->view->assign("maxTotal", $maxTotal);
			$this->view->assign("dataArr", $dataArr);
			// exit();			
		}

		if (isset($_POST['csv'])) {
			 
			 // $this->downloadCsv($dataArr,$maxTotal);
			 header("Location: /report/downloadCsv/");
		}

		$this->setTemplatePath("report/saleData.tpl");
		return;
	}

	public function downloadCsvAction(){
		$dataArr = $_SESSION['dataArr'];
			 $maxTotal = $_SESSION['maxTotal'];
		$this->view->assign("maxTotal", $maxTotal);
		$this->view->assign("dataArr", $dataArr);
		$this->setTemplatePath("report/csvData.tpl");
	}
}
?>


