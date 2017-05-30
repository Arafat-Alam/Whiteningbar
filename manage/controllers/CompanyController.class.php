<?php
class CompanyController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

		require_once sprintf("%s/dao/CompanyDao.class.php", MODEL_PATH);
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
	 * 求人票一覧
	 */
	public function jobAction() {

		$dao = new JobDAO();
		$commonDao = new CommonDAO();

		// ログイン中のManagerを取得
		$login_manager = $this->getManagerSession();
		$company_id=$login_manager[company_id];

		$search[company_id]=$company_id;


		if($_POST[delete_dummy]){

			foreach($_POST[delete_dummy] as $key=>$val){
				//削除
				$dao->delData($val);

			}
			$this->addMessage("delete","チェックした求人票を削除にしました");

		}

		$page = $_REQUEST["page"];

		// 検索送信ボタンが押下されているか？
		if (isset($_POST["sbm_search"])) {

			$search[name]=$_POST[name];
			$search[tanto_name]=$_POST[tanto_name];
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
/*
		else if($_POST){
			$search = $_SESSION[search_jyoken];
			$search[page]=$this->request->getParam("page");

		}
*/
		else {
			// sessionに検索条件が保存されている場合
			if($_SESSION[search_jyoken]) unset($_SESSION[search_jyoken]);
			$search[page]=1;
		}

		$total_cnt=$dao->searchCount($search);

		$page_navi = get_page_navi($total_cnt, ADMIN_V_CNT, $search[page], "/company/job/");
		$company=$dao->search($search,"insert_date desc",ADMIN_V_CNT);


		$this->view->assign("company", $company);
		$this->view->assign("total_cnt", $total_cnt);
		$this->view->assign("navi", $page_navi);
		$this->view->assign("search", $search);


		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("job-list.tpl");
		return;






	}


	/**
	 * 求人票
	 */
	public function job_editAction() {

		$dao = new JobDAO();
		$commonDao = new CommonDAO();

		// ログイン中のManagerを取得
		$login_manager = $this->getManagerSession();
		$company_id=$login_manager[company_id];

		$job_no=$_REQUEST[job_no];

		$page = $_REQUEST["page"];

			$tbl_cnt_t=2;//仮置き場
			$tbl_cnt_y=2;//仮置き場

		//configでの配列取得
		$salaryArr=CommonArray::$salary_array;//給与種類
		$traficArr=CommonArray::$trafic_array;//交通費
		$tryArr=CommonArray::$try_array;//研修・試用期間
		$salalryHourArr=CommonArray::$salaryHour_array;//時給
		$salalryDayArr=CommonArray::$salaryDay_array;//日給
		$salalryMonthArr=CommonArray::$salarymonth_array;//月給
		$salalryYearArr=CommonArray::$salaryyear_array;//年棒

		//チェック用配列
		$baseData=CommonChkArray::$jobBaseCheckData;
		$jobJyokenData=CommonChkArray::$jobJyokenCheckData;

		if($_POST[submit]){


			//大きすぎてアップできない
			for($i=0;$i<=5;$i++){
				if($_FILES["file_t"]['error'][$i]==1){
					$this->addMessage("img", "画像ファイルサイズが大きすぎます。");
				}
			}

			//ファイルアップ　縦画像
			for($i=0;$i<=5;$i++){
				if(is_uploaded_file($_FILES["file_t"]["tmp_name"][$i])){
					$temp_up_fname = $i.date("His",time())."_".$_FILES["file_t"]["name"][$i];//
					//画像サイズ
					if(filesize($_FILES["file_t"]['tmp_name'][$i]) > (100*1024)){
						$fs=filesize($_FILES["file_t"]['tmp_name'][$i]);
						$this->addMessage("img", ($i+1)."番目の画像ファイルは100KB以下を選択してください（画像サイズ:".$fs."byte)");
					}
					/*
					mb_regex_encoding("UTF-8");
					//if (!mb_ereg("^[0-9a-zA-Z\-\_\.:/~#=&\?- ]*$",$_FILES["file_t"]['name'][$i])){
					if( preg_match( "/[一-龠]+|[ぁ-ん]+|[ァ-ヴー]+|[ａ-ｚＡ-Ｚ０-９]+/u", $_FILES["file_t"]['name'][$i] ) === 1 ) {
						//日本語だったら 名前の付け替え
						$imgt=explode(".",$_FILES["file_t"]["name"][$i]);
						$temp_up_fname = $i."_".date("His",time()).".".$imgt[1];//
					}
					*/
					$_SESSION[TMP_FUP][$i]=$temp_up_fname;
					//最初は仮フォルダに入れておく
					copy($_FILES["file_t"]['tmp_name'][$i],DIR_IMG_TMP.$temp_up_fname);
				}
			}

//			$_SESSION["input_data"]=$_POST;
			$input_data=$_POST;

			//---------------- 入力チェック ---------------------------
			//基本事項
			$this->check($input_data,$baseData);
			//-------------- ここまで -----------------------------------

			//---- 入力チェックで出来ない個所のチェック ------------------------
			//勤務地
			if(!$input_data[place]){
				$this->addMessage("place", "勤務地を選択してください。");
			}
			if(!$input_data[interview_flg] && $input_data[interview]==""){
				$this->addMessage("interview", "面接地を選択または入力して下さい");
			}
			//雇用条件1の必須
			foreach($jobJyokenData[string] as $key=>$val){
				if($input_data[$key][0]==""){
					$this->addMessage($key, $val."を入力して下さい");
				}
			}
			//雇用条件１の応募資格
			if(!$input_data[shikaku_flg][0] && $input_data[shikaku_add][0]==""){
				$this->addMessage("shikaku_add", "応募資格を選択または入力して下さい");
			}
			//TOP画像
			if(!$_SESSION[TMP_FUP][0] && $input_data[file_t][0]==""){
				$this->addMessage("file_t_0", "TOPページ 新着一覧画像をアップしてください");
			}
			//検索結果画像
			if(!$_SESSION[TMP_FUP][1] && $input_data[file_t][1]==""){
				$this->addMessage("file_t_1", "検索結果画像をアップしてください");
			}
			//詳細ページメイン画像
			if(!$_SESSION[TMP_FUP][2] && $input_data[file_t][2]==""){
				$this->addMessage("file_t_2", "詳細ページメイン画像をアップしてください");
			}
			if($input_data[comment_t][2]==""){
				$this->addMessage("comment_t_2", "詳細ページメインコメントを入力してください");
			}


			//-------------------------------------------------------------------


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

				if($input_data[job_no]){
					$ret=$dao->upItemData($dkey,$dval,"job_no",$input_data[job_no]);
				}
				else{

					$dkey[]="company_id";
					$dval[]=$company_id;
					$dkey[]="view_flg";
					$dval[]=JOB_ADMIT;//承認作業を行うか行わないか。
					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H:i:s");

					$ret=$dao->InsertItemData($dkey,$dval);
					$input_data[job_no]=$ret;
				}

				if($ret){

					//削除処理
//					for($i=0;$i<count($input_data[del_t]);$i++){
					if($input_data[del_t]){
						foreach($input_data[del_t] as $key=>$val){

							//$file_name=$input_data[file_t][$i];
							$file_name=$input_data[file_t][$key];
							//削除
							$commonDao->del_Data("job_images","img_no",$val);

							$input_data[file_t][$key]="";
							//ファイル削除
							if(is_file(DIR_IMG_JOB.$file_name)) unlink(DIR_IMG_JOB.$file_name);
						}
					}

					//====== 画像 正式アップ & 画像リサイズ作業 ===================
					//縦
					if($_SESSION[TMP_FUP]){
						foreach($_SESSION[TMP_FUP] as $key=>$val){
							//
							$ret=$commonDao->get_data_tbl("job_images",array("job_no","seq","sort"),array($input_data[job_no],$key,$key));

							//DB登録
							$ins=array();
							$ins[file_name]=$val;
							if($ret){
								$wfi[img_no]=$ret[0][img_no];
								$commonDao->updateData2("job_images", $ins,$wfi);
							}
							else{
								$ins[job_no]=$input_data[job_no];
								$ins[seq]=$key;
								$ins[sort]=$key;
								$commonDao->InsertItemData2("job_images", $ins);
							}

							//---リサイズ---
							//画像別サイズ作成
							$photoArr=CommonArray::$photo_array;
							$moto=DIR_IMG_TMP.$_SESSION[TMP_FUP][$key];
							$newDir=DIR_IMG_JOB.$_SESSION[TMP_FUP][$key];

							resize_image2($moto,$newDir,$photoArr[width][$key],$photoArr[height][$key]);

							//画像正式アップ
//							copy(DIR_IMG_TMP.$_SESSION[TMP_FUP][$key],DIR_IMG_MEMBER.$_SESSION[TMP_FUP]);
							//仮画像削除
							unlink(DIR_IMG_TMP.$_SESSION[TMP_FUP][$key]);

							$input_data[file_t][$key]=$_SESSION[TMP_FUP][$key];

						}
					}
					//コメントのみ入れ替える場合もあるので。。コメント
					//縦
					//foreach($input_data[comment_t] as $key=>$val){
					for($i=2;$i<=5;$i++){

						$ins=array();
						if($input_data[comment_t][$i]!=""){
							$ins[comment]=$input_data[comment_t][$i];
						}
						else{
							$ins[comment]="";
						}
						$ret=$commonDao->get_data_tbl("job_images",array("job_no","seq","sort"),array($input_data[job_no],$i,$i));

						if($ret){
								$wfi[img_no]=$ret[0][img_no];
								$commonDao->updateData2("job_images", $ins,$wfi);
						}
						else{
							if($input_data[comment_t][$i]){
								$ins[job_no]=$input_data[job_no];
								$ins[seq]=$i;
								$ins[sort]=$i;
								$commonDao->InsertItemData2("job_images", $ins);
							}
						}
/*
						if($input_data[comment_t][$i]){
							$ins=array();
							$ins[comment]=$val;
							$ret=$commonDao->get_data_tbl("job_images",array("job_no","seq","sort"),array($input_data[job_no],$key,$key));
							if($ret){
								$wfi[img_no]=$ret[0][img_no];
								$commonDao->updateData2("job_images", $ins,$wfi);
							}
							else{
								$ins[job_no]=$input_data[job_no];
								$ins[seq]=$key;
								$ins[sort]=$key;
								$commonDao->InsertItemData2("job_images", $ins);
							}
						}
*/
					}

					//*********** 求人票の属性情報の登録 ********************
					//データを消して再登録する
					$commonDao->del_Data("job_ext_attrs", "job_no", $input_data[job_no]);

					//勤務地
					for($i=0;$i<count($input_data[place]);$i++){
						$ins=array();
							$ins[job_no]=$input_data[job_no];
							$ins[attr_key]="place";
							$ins[attr_value1]=$input_data[place][$i];
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("job_ext_attrs", $ins);
					}

					//雇用条件 データを消して再登録
					$commonDao->del_Data("job_jyoken", "job_no", $input_data[job_no]);
					//条件
					for($i=0;$i<count($input_data[employ]);$i++){
						$ins=array();
						$ins[job_no]=$input_data[job_no];
						if($input_data[employ][$i]!=""){
							foreach($jobJyokenData[dbstring] as $key=>$val){
								$ins[$key]=$input_data[$key][$i];
							}
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("job_jyoken", $ins);
						}
					}

					//こだわり条件
					for($i=0;$i<count($input_data[character]);$i++){
						$ins=array();
							$ins[job_no]=$input_data[job_no];
							$ins[attr_key]="character";
							$ins[attr_value1]=$input_data[character][$i];
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("job_ext_attrs", $ins);
					}

					if($_SESSION[TMP_FUP]) unset($_SESSION[TMP_FUP]);

					$msg="求人票情報を更新しました";
				}
				else{
					$msg="求人票情報の更新エラーです";
				}

				$this->view->assign("msg", $msg);
				// テンプレート表示
		        $this->setTemplatePath("job-edit_fini.tpl");
				return;

			}
		}
		else{

			//セッション削除
			if($_SESSION[TMP_FUP]) unset($_SESSION[TMP_FUP]);

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("job_offer","job_no",$job_no);
			$input_data=$tmp[0];

			$tmp=$commonDao->get_data_tbl("job_jyoken","job_no",$job_no);
			foreach($tmp as $kk=>$item){
				foreach($item as $key=>$val){
					if($key!="job_no"){
						$input_data[$key][$kk]=$val;
					}
				}
			}

			//属性
			$tmp=$commonDao->get_data_tbl("job_ext_attrs","job_no",$job_no);
			for($i=0;$i<count($tmp);$i++){
				$attr_key=$tmp[$i][attr_key];
				if($tmp[$i][attr_value3]){
					$input_data[$attr_key]=$tmp[$i][attr_value3];
				}
				else{

					if($tmp[$i][seq]!=0){
						$seq=$tmp[$i][seq]-1;
						$input_data[$attr_key][$seq]=$tmp[$i][attr_value1];
					}
					else{
						$input_data[$attr_key]=$tmp[$i][attr_value1];
					}
				}
			}

			//縦画像
			$tmp=$commonDao->get_data_tbl("job_images",array("job_no"),array($job_no),"seq asc");
			for($i=0;$i<count($tmp);$i++){
				$input_data[file_t][$i]=$tmp[$i][file_name];
				$input_data[comment_t][$i]=$tmp[$i][comment];
				$input_data[img_no][$i]=$tmp[$i][img_no];
			}

			if(!$input_data){

				//新規デフォルト
				$input_data[apply_flg]=1;


			}

		}



		//職種取得
		$tmp=$commonDao->get_data_tbl("mst_category1","","","v_order ");
		for($i=0;$i<count($tmp);$i++){
			$category1Arr[$tmp[$i][id]]=$tmp[$i][name];
		}

		//勤務地取得
		$tmp=$commonDao->get_data_tbl("mst_place","","","v_order ");
		for($i=0;$i<count($tmp);$i++){
			$placeArr[$tmp[$i][id]]=$tmp[$i][name];
		}

		//雇用形態取得
		$tmp=$commonDao->get_data_tbl("mst_employ","","","v_order ");
		$employArr[""]="";
		for($i=0;$i<count($tmp);$i++){
			$employArr[$tmp[$i][id]]=$tmp[$i][name];
		}

		//こだわり条件
		$charaArr=$commonDao->get_category_sort("mst_character");


		$this->view->assign("category1Arr", $category1Arr);
		$this->view->assign("placeArr", $placeArr);
		$this->view->assign("employArr", $employArr);
		$this->view->assign("charaArr", $charaArr);

		$this->view->assign("msg", $msg);
		$this->view->assign("input_data", $input_data);
		$this->view->assign("salaryArr", $salaryArr);
		$this->view->assign("traficArr", $traficArr);
		$this->view->assign("tryArr", $tryArr);

		$this->view->assign("salalryHourArr", $salalryHourArr);
		$this->view->assign("salalryDayArr", $salalryDayArr);
		$this->view->assign("salalryMonthArr", $salalryMonthArr);
		$this->view->assign("salalryYearArr", $salalryYearArr);

		$this->view->assign("tbl_cnt_t", $tbl_cnt_t);
		$this->view->assign("tbl_cnt_y", $tbl_cnt_y);

		$this->view->assign("job_no", $job_no);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("job-edit.tpl");
		return;
	}


	/**
	 * 担当者情報変更
	 */
	public function passwdAction() {

		$dao = new CompanyDAO();
		$commonDao = new CommonDAO();

		// ログイン中の情報を取得
		$login_manager = $this->getManagerSession();

		if($_POST[modify]){

			$input_data=$_POST;

			//旧パスチェック
			$tmp=$commonDao->get_data_tbl("company",array("company_id","password"),array($login_manager[company_id],to_hash($input_data[oldpassword])));
			if(!$tmp){
				$this->addMessage("oldpsssword","旧パスワードが違っています。");

			}
			if($input_data[password]==""){
				$this->addMessage("psssword","新パスワードを入力して下さい。");

			}

			if( $input_data[password]!= $input_data[password2]){
				$this->addMessage("psssword","新パスワードと確認用新パスワードが違っています。");
			}
			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $item){

					$result_messages[$item->getMessageLevel()]=$item->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {

				$ret=$dao->upItemData("password",to_hash($input_data[password]),"company_id",$login_manager[company_id]);
				if($ret){
					$msg="パスワードを変更しました";
				}
				else{
					$msg="パスワード変更エラーです";

				}
			}

		}
		else{

		}

//		$tmp=$commonDao->get_data_tbl("company","company_id",$login_manager[company_id]);
//		$company=$tmp[0];

		$this->view->assign("msg", $msg);
		$this->view->assign("input_data", $input_data);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("company-passwd.tpl");
		return;


	}

	/**
	 * 法人情報更新
	 */
	public function editAction() {

		$dao = new CompanyDAO();
		$commonDao = new CommonDAO();



		// ログイン中の情報を取得
		$login_manager = $this->getManagerSession();

		$company_id=$login_manager[company_id];

		//configでの配列取得
		$licenseArr=CommonArray::$license_array;//許可番号
		$sales_monthArr=CommonArray::$sales_array;//売上月期
		$specialArr=CommonArray::$special_array;
		$prefArr=CommonArray::$pref_text_array;


		//チェック用配列
		$baseData=CommonChkArray::$companyAdminCheckData;
		$billData=CommonChkArray::$companyBillCheckData;
		$adData=CommonChkArray::$companyAdCheckData;

		if($_POST[modify]){

			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//大きすぎてアップできない
			if($_FILES["file"]['error']==1){
				$this->addMessage("img", "画像ファイルサイズが大きすぎます。");
			}
			//ファイルアップ　縦画像
			if(is_uploaded_file($_FILES["file"]["tmp_name"])){
				$temp_up_fname = date("His",time())."_".$_FILES["file"]["name"];//

				//画像サイズ
				if(filesize($_FILES["file"]['tmp_name']) > (100*1024)){
					$fs=filesize($_FILES["file"]['tmp_name']);
					$this->addMessage("img", "ロゴファイルは100KB以下を選択してください（画像サイズ:".$fs."byte)");
				}
				/*
				if (!mb_ereg("^[0-9a-zA-Z\-\_\.:/~#=&\?- ]*$",$_FILES["file"]['name'])){
					//日本語だったら 名前の付け替え
					$imgt=explode(".",$_FILES["file"]["name"]);
					$temp_up_fname = date("His",time()).".".$imgt[1];//
				}
				*/

				$_SESSION[TMP_FUP]=$temp_up_fname;
				//最初は仮フォルダに入れておく
				copy($_FILES["file"]['tmp_name'],DIR_IMG_TMP.$temp_up_fname);
			}

			//---------------- 入力チェック ---------------------------
			//基本事項
			$this->check($input_data,$baseData);
			//請求書
			if(!isset($input_data[bill_flg])){
				$this->check($input_data,$billData);
			}
			//広告用
//			if(!isset($input_data[ad_flg])){
//				$this->check($input_data,$adData);
//			}
			//-------------- ここまで -----------------------------------

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {



					//削除処理

					if($input_data[file_del]){
						$file_name=$input_data[file_del];
						//削除
						$dkey[]="logo";
						$dval[]="";
						$input_data[file]="";
						//ファイル削除
						if(file_exists(DIR_IMG_TATE_SMALL.$file_name)) unlink(DIR_IMG_TATE_SMALL.$file_name);
						if(file_exists(DIR_IMG_TATE_LARGE.$file_name)) unlink(DIR_IMG_TATE_LARGE.$file_name);
					}

					//====== 画像 正式アップ & 画像リサイズ作業 ===================
					//縦
					if($_SESSION[TMP_FUP]){
						$ret=$commonDao->get_data_tbl("job_images",array("job_no","seq","sort"),array($input_data[job_no],1,$key));

							//DB登録
							$dkey[]="logo";
							$dval[]=$_SESSION[TMP_FUP];

							//---リサイズ---
							//画像別サイズ作成
							$photoHArr=CommonArray::$photo_logo_array;
							$moto=DIR_IMG_TMP.$_SESSION[TMP_FUP];
							$newDir=DIR_IMG_LOGO.$_SESSION[TMP_FUP];
							resize_image2($moto,$newDir,$photoHArr[0],$photoHArr[1]);

							//画像正式アップ
//							copy(DIR_IMG_TMP.$_SESSION[TMP_FUP],DIR_IMG_LOGO.$_SESSION[TMP_FUP]);
							//仮画像削除
							unlink(DIR_IMG_TMP.$_SESSION[TMP_FUP]);

							$input_data[logo]=$_SESSION[TMP_FUP];
					}
				//基本事項
				foreach($baseData[dbstring] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}

				$ret=$dao->upItemData($dkey,$dval,"company_id",$company_id);
				if($ret){

					//データを消して再登録する
					$commonDao->del_Data("company_ext_attrs", company_id, $company_id);

					//--------- 請求書 -------------------
					$ins=array();
					$ins[company_id]=$input_data[company_id];
					$ins[attr_key]="bill_flg";
					$ins[attr_value1]=$input_data[bill_flg];
					$commonDao->InsertItemData2("company_ext_attrs", $ins);

//					if(!isset($input_data[bill_flg])){//会社と同じ住所ではない
						foreach($billData[dbstring] as $key=>$val){
							$ins=array();

							$str="attr_value1";
							if($adData[type][$key]=="textarea"){
								$str="attr_value3";
							}
							$ins[company_id]=$company_id;
							$ins[attr_key]=$key;
							$ins[$str]=$input_data[$key];
							$commonDao->InsertItemData2("company_ext_attrs", $ins);

						}
//					}

					//--------- 求人用 -------------------
					$ins=array();
					$ins[company_id]=$company_id;
					$ins[attr_key]="ad_flg";
					$ins[attr_value1]=$input_data[bill_flg];
					$commonDao->InsertItemData2("company_ext_attrs", $ins);

//					if(!isset($input_data[ad_flg])){//会社と同じ住所ではない
						foreach($adData[dbstring] as $key=>$val){
							$ins=array();

							$str="attr_value1";
							if($adData[type][$key]=="textarea"){
								$str="attr_value3";
							}
							$ins[company_id]=$input_data[company_id];
							$ins[attr_key]=$key;
							$ins[$str]=$input_data[$key];
							$commonDao->InsertItemData2("company_ext_attrs", $ins);
						}
//					}
					//::複数あるものに関しての登録
					//企業特性
					for($i=0;$i<count($input_data[special]);$i++){
							$ins=array();

							$ins[company_id]=$input_data[company_id];
							$ins[attr_key]="special";
							$ins[attr_value1]=$input_data[special][$i];
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("company_ext_attrs", $ins);
					}




					//許可番号
					for($i=0;$i<count($input_data[license]);$i++){
							$ins=array();

							$ins[company_id]=$input_data[company_id];
							$ins[attr_key]="license";
							$ins[attr_value1]=$input_data[license][$i];
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("company_ext_attrs", $ins);
					}
					//年間売上
					for($i=0;$i<count($input_data[sales_year]);$i++){
							$ins=array();

							$ins[company_id]=$input_data[company_id];
							$ins[attr_key]="sales_year";
							$ins[attr_value1]=$input_data[sales_year][$i];
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("company_ext_attrs", $ins);

							$ins=array();
							$ins[company_id]=$input_data[company_id];
							$ins[attr_key]="sales_month";
							$ins[attr_value1]=$input_data[sales_month][$i];
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("company_ext_attrs", $ins);

							$ins=array();
							$ins[company_id]=$input_data[company_id];
							$ins[attr_key]="sales";
							$ins[attr_value1]=$input_data[sales][$i];
							$ins[seq]=($i+1);
							$commonDao->InsertItemData2("company_ext_attrs", $ins);

					}
					$msg="法人情報を更新しました";
				}
				else{
					$msg="法人情報の更新エラーです";
				}
			}

			if($_SESSION[TMP_FUP]) unset($_SESSION[TMP_FUP]);

		}
		else{

			if($_SESSION[TMP_FUP]) unset($_SESSION[TMP_FUP]);

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("company","company_id",$company_id);
			$input_data=$tmp[0];

			//属性
			$tmp=$commonDao->get_data_tbl("company_ext_attrs","company_id",$company_id);
			for($i=0;$i<count($tmp);$i++){
				$attr_key=$tmp[$i][attr_key];
				if($tmp[$i][attr_value3]){
					$input_data[$attr_key]=$tmp[$i][attr_value3];
				}
				else{

					if($tmp[$i][seq]!=0){
						$seq=$tmp[$i][seq]-1;
						$input_data[$attr_key][$seq]=$tmp[$i][attr_value1];
					}
					else{
						$input_data[$attr_key]=$tmp[$i][attr_value1];
					}
				}


			}
		}

		//年月プルダウン
		$yearArr=makeYearList("1940",0,1);
		$monthArr=makeMonthList(1);


		//業種取得
		$tmp=$commonDao->get_data_tbl("mst_category2","","","v_order ");
		for($i=0;$i<count($tmp);$i++){
			$industryArr[$tmp[$i][id]]=$tmp[$i][name];
		}


		$this->view->assign("msg", $msg);
		$this->view->assign("input_data", $input_data);
		$this->view->assign("licenseArr", $licenseArr);
		$this->view->assign("sales_monthArr", $sales_monthArr);
		$this->view->assign("prefArr", $prefArr);
		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("industryArr", $industryArr);
		$this->view->assign("specialArr", $specialArr);

		// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        // テンプレート表示
        $this->setTemplatePath("company-edit.tpl");
		return;
	}

	/*
	 * 選択した給料制に対するプルダウンを取得して表示
	 *
	 *
	 */
	public function getSalaryChangeAction() {

		$data = array("result" => "success");
		$salary = $_REQUEST["salary"];
		$pno = $_REQUEST["pno"];
		$job_no = $_REQUEST["job_no"];

		//プルダウンを作成
		if($salary==1){
			$salaryArr=CommonArray::$salaryHour_array;
		}
		else if($salary==2){
			$salaryArr=CommonArray::$salaryDay_array;
		}
		else if($salary==3){
			$salaryArr=CommonArray::$salarymonth_array;
		}
		else if($salary==4){
			$salaryArr=CommonArray::$salaryyear_array;
		}

		$this->view->assign("salaryArr", $salaryArr);
		$this->view->assign("pno", ($pno-1));



		$commonDao = new CommonDao();
		if($job_no){
//			$tmp=$commonDao->get_data_tbl("job_ext_attrs",array(job_no,seq),array($job_no,$pno));
			$tmp=$commonDao->get_data_tbl("job_jyoken",array(job_no,seq),array($job_no,$pno));
			$input_data=$tmp[0];
			$this->view->assign("input_data", $input_data);
		}

		//id名
		$clsname="salary".$pno;
		$this->view->assign("clsname", $clsname);


		$data["html"] = $this->view->fetch("addSalaryPull.tpl");
//		$data["cnt"] = count($attr_group_list);
		echo json_encode($data);
		return;
	}

	/**
	 * admin（運営者）からのManage管理画面へのログイン失敗
	 */
	public function errorAction() {


			$this->setTemplatePath("admin_err.tpl");
			return;


	}

	/**
	 * リスト更新
	 */
	public function bulkUpdateAction() {
/*
		// ログイン中のAdminを取得
		$admin = $this->getAdminSession();

		$dao = new MemberDao();

		for ($i=0; $i<count($_REQUEST["member_no"]); $i++) {
			$member_obj = $dao->getMember($_REQUEST["member_no"][$i]);

			// 削除
			if ($_REQUEST["delete"][$i]=="t") {
				$dao->delete($member_obj);
				continue;
			}

			// ステータス
			if ($_REQUEST["disabled"][$i]=="t") {
				$member_obj->setStatus("disabled");
			}
			else {
				$member_obj->setStatus("active");
			}
			$dao->update($member_obj);
		}

		$this->addMessage(SYSTEM_MESSAGE_INFO, "会員一覧を更新しました");
		$this->setSessionMessage();
		$this->redirect("/member/list");
		return;
*/
	}


}
?>

