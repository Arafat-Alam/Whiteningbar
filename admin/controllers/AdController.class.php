<?php
class AdController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

	}


	/**
	 * 広告TOP
	 */
	public function displayAction() {







		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("ad/ad_top.tpl");
		return;

	}


	/**
	 * 一覧表示・検索
	 */
	public function listAction() {

		$dao=new adDao();
		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];

		$adArr['p_point']=$_REQUEST['pp'];
		$adArr['v_point']=$_REQUEST['vp'];

		$this->view->assign("adArr", $adArr);

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "ad_no" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$dao->getCategoryList(" where a.v_order < " . $order,"limit 1","order by a.v_order desc");
			if($ret){

//				$up=new Employ();
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）

				//$up->setOrder($order);
				//$tmpObj=$ret[0];
				$ad_no=$ret[0]['ad_no'];

				//$dao->update($up,$tmpObj->getId());

				$commonDao->updateData("mst_ad", "v_order", $order, "ad_no", $ad_no);



				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
//				$up=new Employ();
				$changeOrder=$order-1;
//				$tmpObj=$ret[0];

				//$dao->update($up,$targetId);
				$commonDao->updateData("mst_ad", "v_order", $changeOrder, "ad_no", $targetId);


			}

		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "ad_no" ];
			$order = $_POST[ "value" ];

			$ret=$dao->getCategoryList(" where a.v_order > " . $order,"limit 1");
			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）

				//$up->setOrder($order);
				//$tmpObj=$ret[0];
				//$dao->update($up,$tmpObj->getId());

				$ad_no=$ret[0]['ad_no'];
				$commonDao->updateData("mst_ad", "v_order", $order, "ad_no", $ad_no);


				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				//$up=new Employ();
				//$up->setOrder($order+1);
				//$tmpObj=$ret[0];
				//$dao->update($up,$targetId);

				$changeOrder=$order+1;
				$commonDao->updateData("mst_ad", "v_order", $changeOrder, "ad_no", $targetId);


			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "ad_no" ];
			$ad=$commonDao->get_data_tbl("mst_ad", "ad_no", $targetId);
			$commonDao->del_Data("mst_ad", "ad_no", $targetId);

			//画像を削除
			unlink(DIR_IMG_AD.$ad[0]['img_name']);

			//ソート順を変更する
			$retArr=$commonDao->get_data_tbl("mst_ad","","","v_order asc");
			$v_order=0;
			foreach($retArr as $item){
				$v_order++;
				$commonDao->updateData("mst_ad", "v_order", $v_order, "ad_no", $item['ad_no']);
			}


			$msg="広告バナーを削除しました。";

		}


		//$cateArr=$dao->getCategoryList();

		$cateArr=$commonDao->get_data_tbl("mst_ad",array("p_point","v_point"),array($adArr['p_point'],$adArr['v_point'])," v_order asc");


		//親カテゴリーの数を数える
		$pidcount=count($cateArr);

		//親カテゴリーの調整
		$oya=0;
		foreach($cateArr as $key=>$val){

				$oya++;
				//$id->setMainup(1);
				//$id->setMaindown(1);
				$cateArr[$key]['mainup']=1;
				$cateArr[$key]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					//$id->setMaindown(0);//▼を表示しない
					$cateArr[$key]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					//$id->setMainup(0);//▲を表示しない
					$cateArr[$key]['mainup']=0;;//▲を表示しない
				}

		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		$this->setTemplatePath("ad/list.tpl");
		return;
	}

	/**
	 * 登録・更新
	 */
	public function editAction() {

		$dao=new adDao();
		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];

		$adArr['p_point']=$_REQUEST['pp'];
		$adArr['v_point']=$_REQUEST['vp'];

		$this->view->assign("adArr", $adArr);

		//バナーNo
		$ad_no=$_REQUEST['ad_no'];


		$checkData=CommonChkArray::$AdCheckData;

		if($_POST['regist']){

			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//ファイルアップ
			if(is_uploaded_file($_FILES["up_file"]["tmp_name"])){
				$temp_up_fname = $i.date("His",time())."_".$_FILES["up_file"]["name"];//
				$_SESSION['TMP_FUP']=$temp_up_fname;
				//最初は仮フォルダに入れておく
				copy($_FILES["up_file"]['tmp_name'],DIR_IMG_TMP.$temp_up_fname);
			}

			//入力チェック
			$ret=!$this->check($input_data,$checkData);
			if(!$_SESSION['TMP_FUP'] && $input_data['img_name']==""){
				$this->addMessage("file","バナーをアップしてください");
			}

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $msg){
					$result_messages[$msg->getMessageLevel()]=$msg->getMessageBody();
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

				//バナー
				if($_SESSION['TMP_FUP']){
					$dkey[]="img_name";
					$dval[]=$_SESSION['TMP_FUP'];
				}

				//バナー登録
				if(!$ad_no){

				//新規登録

					//ソート順は一番後ろにする
					$ordTmp=$commonDao->get_data_tbl("mst_ad",array("p_point","v_point"),array($adArr['p_point'],$adArr['v_point']),"v_order desc" ,1);
					$v_order=$ordTmp[0]['v_order']+1;

					$dkey[]="v_order";
					$dval[]=$v_order;

					$dkey[]="ad_id";
					$dval[]=time().get_random_string(10);
					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H:i:s");
					$dkey[]="update_date";
					$dval[]=date("Y-m-d H:i:s");

					$ret=$commonDao->InsertItemData("mst_ad",$dkey,$dval);

/*
					$fi[v_order]=$v_order;
					$fi[ad_id]=time().get_random_string(10);
					$fi[insert_date]=date("Y-m-d H:i:s");
					$fi[update_date]=date("Y-m-d H:i:s");

					$ret=$commonDao->InsertItemData2("mst_ad",$fi);
					$input_data[ad_no]=$ret;
*/
				}
				else{
		//変更処理
					$ret=$commonDao->updateData("mst_ad", $dkey, $dval, "ad_no", $ad_no);


				}

				$upErrFlg="1";
				if($ret && $_SESSION['TMP_FUP']){
					//画像正式アップ
					copy(DIR_IMG_TMP.$_SESSION['TMP_FUP'],DIR_IMG_AD.$_SESSION['TMP_FUP']);
					unlink(DIR_IMG_TMP.$_SESSION['TMP_FUP']);
				}else if(!$ret){

					$upErrFlg=99;

				}

				if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
				if($_SESSION['TMP_FUP']) unset($_SESSION['TMP_FUP']);

			}



		}
		else if($_REQUEST['ad_no']){

			if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
			if($_SESSION['TMP_FUP']) unset($_SESSION['TMP_FUP']);


			//データ取得
			$ret=$commonDao->get_data_tbl("mst_ad","ad_no",$ad_no);
			$input_data=$ret[0];

			//画像



		}
		else{

			//表示デフォルト
			$input_data['view_flg']=1;
			$input_data['view_start']=date("Y/m/d 00:00:00" );
 			$input_data['view_end']=date("Y/m/d 23:59:59" );


			if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
			if($_SESSION['TMP_FUP']) unset($_SESSION['TMP_FUP']);

		}


		$this->view->assign("upErrFlg", $upErrFlg);
		$this->view->assign("input_data", $input_data);

		$this->setTemplatePath("ad/edit.tpl");
		return;

	}
}
?>


