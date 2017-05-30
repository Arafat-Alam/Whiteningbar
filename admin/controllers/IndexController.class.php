<?php
class IndexController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
	}

	// トップページ表示
    public function displayAction() {

		// ログイン中のadmin情報を取得


		//arafat
		$login_admin = $this->getAdminSession();
		if (count($login_admin) <= 1) {
				header("location: /admin/login/");
			return;
		}
		$this->view->assign("login_admin", $login_admin);
		$this->view->assign("shopNo", $login_admin['shop_no']);

		//アフィリエイト用であれば、アフィリエイト画面に飛ばす
		//arafat
		// $login_admin = $this->getAdminSession();
		/*echo $login_admin['shop_no'];
		exit();*/
		if($login_admin['shop_no']=="-2"){
			echo "string";
			exit();
			//header("location:/affiliate/list/");
			header("location:/whiteningbar/admin/htdocs/?controller=affiliate&action=list");
			exit;
		}

		/*echo "<pre>";
		print_r($login_admin);
		exit();*/


    	$commonDao=new CommonDao();
    	$reserveDao=new ReserveDAO();

    	//ニュース取得





    	//arafat
    	$newsArr=$commonDao->get_data_tbl("news","display_flg",1,"news_date desc , news_no desc");
    	 // $fileType = mime_content_type();
    	// echo "<pre>"; print_r($newsArr);exit();
		$this->view->assign("newsArr", $newsArr);
		$this->view->assign("path", DIR_IMG_NEWS);


		$tdyY=date("Y");
		$tdyM=date("m");
		$tdyD=date("d");

		//今日を挟んで三日間と今月を挟んで三カ月の予約数

		if($login_admin['shop_no']>0){//該当店舗分

			$shopArr=$commonDao->get_data_tbl("shop","shop_no",$login_admin['shop_no']);
			$shop_no=$shopArr[0]['shop_no'];
			$shop_name=$shopArr[0]['name'];

			$dayArr[$shop_no]['name']=$shop_name;
			$monArr[$shop_no]['name']=$shop_name;

			for($i=-1;$i<2;$i++){
				//三日間
				$ins['reserve_date']=date("Y-m-d",mktime(0,0,0,$tdyM,$tdyD+$i,$tdyY));
				$ins['shop_no']=$login_admin['shop_no'];

				$dayArr[$shop_no]['count'][]=$reserveDao->getTotalReserveCount($ins);

				//三カ月
				//$ins[reserve_date]=date("Y-m",mktime(0,0,0,$tdyM+$i,$tdyD,$tdyY));
				$ins['reserve_date']=date("Y-m",mktime(0,0,0,$tdyM+($i+1),0,$tdyY));//2/28があるので、3月を基準に先月を考える場合はこのようにする
				$ins['shop_no']=$login_admin['shop_no'];
				$monArr[$shop_no]['count'][]=$reserveDao->getTotalReserveCount($ins);
			}
		}
		else{
			//全店舗分

				$shopArr=$commonDao->get_data_tbl("shop","","","shop_no");
				for($j=0;$j<count($shopArr);$j++){

					$shop_no=$shopArr[$j]['shop_no'];
					$shop_name=$shopArr[$j]['name'];

					$dayArr[$shop_no]['name']=$shop_name;
					$monArr[$shop_no]['name']=$shop_name;

					for($i=-1;$i<2;$i++){
						//三日間
						$ins['reserve_date']=date("Y-m-d",mktime(0,0,0,$tdyM,$tdyD+$i,$tdyY));
						$ins['shop_no']=$shopArr[$j]['shop_no'];
						$dayArr[$shop_no]['count'][]=$reserveDao->getTotalReserveCount($ins);

						//三カ月
						$ins['reserve_date']=date("Y-m",mktime(0,0,0,$tdyM+($i+1),0,$tdyY));//2/28があるので、3月を基準に先月を考える場合はこのようにする
//						$ins[shop_no]=$shopArr[$j][shop_no];
						$monArr[$shop_no]['count'][]=$reserveDao->getTotalReserveCount($ins);
					}
				}

		}

$this->view->assign("dayArr", $dayArr);
$this->view->assign("monArr", $monArr);
$this->view->assign("index", 'index');


    	// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();
		//arafat






        $this->setTemplatePath("index.tpl");
        return;
	}


}
?>