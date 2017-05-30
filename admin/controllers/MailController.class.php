<?php
class MailController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();


	}

	public function displayAction() {


	}

	/**
	 * テンプレート選択
	 *
	 */
	public function listAction() {

		$admin = $this->getAdminSession();

		$commonDao = new CommonDao();

		if(isset($_POST["sbm_delete"])){//更新ボタンが押されているか
			if($_POST['delete']){
				foreach($_POST['delete'] as $key=>$val){
					//データの削除
					$commonDao->del_Data("mail_template","template_no",$val);
				}
				$this->addMessage("info","チェックしたテンプレートを削除しました");
			}
		}


		$arr=$commonDao->get_data_tbl("mail_template","","","template_no desc");//納品時にデフォルトメールを入れておく事
/*
		if(!$arr){
			//テンプレートが入っていない場合は、デフォルトを入れる
			$tmp=$commonDao->get_data_tbl("site_config","config_key","mail_template");

			$fi['company_id']=$login_member['company_id'];
			$fi[title]=$tmp[0][config_name];
			$fi['mail_text']=$tmp[0][config_value];
			$fi['insert_date']=date("Y-m-d H:i:s");
			$fi['update_date']=date("Y-m-d H:i:s");

			$commonDao->InsertItemData2("mail_template", $fi);

			$arr=$commonDao->get_data_tbl("mail_template","company_id",$login_member['company_id'],"template_no desc");

		}
*/
		$this->view->assign("arr", $arr);

		$this->setTemplatePath("maildeliver/list.tpl");
		return;


	}

	/**
	 * 編集
	 *
	 */
	public function editAction() {

		$admin = $this->getAdminSession();

		$commonDao = new CommonDao();

		if($_POST['submit']){
			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];


			//入力チェック
			$formVa=CommonChkArray::$mailTemplateCheckData;
			$ret=!$this->check($_POST,$formVa);

			if (count($this->getMessages()) >0) {
				foreach($this->getMessages() as $msg){
					$result_messages[$msg->getMessageLevel()]=$msg->getMessageBody();
				}
				$this->view->assign("result_messages", $result_messages);
			}
			else {

				//フォーム入力用データ
				foreach($formVa['dbstring'] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}

				if($input_data['template_no']){
					$ret=$commonDao->updateData("mail_template",$dkey,$dval,"template_no",$input_data['template_no']);

				}
				else{

					$dkey[]="insert_date";
					$dval[]=date("Y-m-d H:i:s");
					$dkey[]="update_date";
					$dval[]=date("Y-m-d H:i:s");
					$ret=$commonDao->InsertItemData("mail_template",$dkey,$dval);

				}

				if(!$ret){
					$this->addMessage("error","メールテンプレートの更新に失敗しました");
				}
				else{

					//成功

					//セッション廃棄
					if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
					if($_SESSION['TMP_FUP']) unset($_SESSION['TMP_FUP']);

					$this->addMessage("info","メールテンプレートを更新しました");


				}
				$this->view->assign("result_messages", $result_messages);

			}

		}
		else if($_REQUEST['template_no']){

			$template_no=$_REQUEST['template_no'];
			$tmp=$commonDao->get_data_tbl("mail_template","template_no",$template_no);
			$input_data=$tmp[0];


		}
		else{
			//新規作成
			if($_SESSION["input_data"]) unset($_SESSION["input_data"]);

		}

		$this->view->assign("input_data", $input_data);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("maildeliver/edit.tpl");
		return;


	}

	/**
	 * 署名
	 *
	 */
	public function sigAction() {

		$admin = $this->getAdminSession();

		$commonDao = new CommonDao();


		if($_POST['submit']){

			$commonDao->del_Data("mail_sig","","");
			$fi['company_id']=$login_member['company_id'];
			$fi['sig']=$_POST['sig'];
			$fi['insert_date']=date("Y-m-d H:i:s");
			$ret=$commonDao->InsertItemData2("mail_sig",$fi);

			$this->addMessage("info","署名を更新しました");

		}


		$tmp=$commonDao->get_data_tbl("mail_sig");
		$this->view->assign("input_data", $tmp[0]);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("maildeliver/sig.tpl");
		return;


	}

	/**
	 * メール配信 配信先の検索、決定
	 *
	 */
	public function magazinAction() {

		@$page = $_REQUEST["page"];
		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);


		$commonDao = new CommonDao();
		$dao = new MemberDAO();

		//年
		$yearArr=makeYearList("1945","-10",1);
		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);
		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);//16263

		if(isset($_POST['sbm_search'])){//検索ボタン

			$input_data=$_POST;

			$search['name']=$input_data['name'];
			$search['year']=$input_data['year'];
			$search['month']=$input_data['month'];
			$search['day']=$input_data['day'];
			$search['sex']=$input_data['sex'];
			$search['mail_flg']=1;
			$search['start_date']=$input_data['start_date'];
			$search['end_date']=$input_data['end_date'];
			$search['course_no']=$input_data['course_no'];

			$search['page']=1;

			$_SESSION["search_condition"]=$search;


		}
		else if (isset($page)) {		// ページ番号が渡されたか？
			// ページングによる遷移
			$search = $_SESSION["search_condition"];
			$search['page']=$this->request->getParam("page");

		}
		else if (isset($_POST['back'])) {//メール本文表示から宛先変更ボタンを押して戻ってくる個所
			// ページングによる遷移
			$search = $_SESSION["search_condition"];
			$search['page']=1;

			//メール本文をセッションに
			$_SESSION['mail_text']=$_POST['mail'];
			$_SESSION['subject']=$_POST['subject'];

			if($_SESSION['member_id']) $oemArr=$_SESSION['member_id'];
			if($_SESSION['template_no']) $template_no=$_SESSION['template_no'];

		}
		else if(isset($_POST['address_submit'])){//宛先決定ボタン
			//アドレスをsessionにいれる
			$template_no=$_POST['template_no'];

			if(!$_POST['member_id']){

				$this->addMessage("error","宛先が選択されていません。");
			}
			else{


				$_SESSION['member_id']=$_POST['member_id'];

				if(!$_SESSION['template_no'] || $_POST['template_no']!=$_SESSION['template_no']){

					$_SESSION['template_no']=$_POST['template_no'];

					//選択したテンプレート情報
					$tmp=$commonDao->get_data_tbl("mail_template","template_no",$_POST['template_no']);
					$template_mail_text=$tmp[0]['mail_text'];
					$template_subject=$tmp[0]['subject'];

				}
				else{

					$template_subject=$_SESSION['subject'];
					$template_mail_text=$_SESSION['mail_text'];
				}

				//署名
				$tmp=$commonDao->get_data_tbl("mail_sig");
				$sigArr=$tmp[0];

				$this->view->assign("template_subject", $template_subject);
				$this->view->assign("template_mail_text", $template_mail_text);
				$this->view->assign("sigArr", $sigArr);

				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("maildeliver/delivery_mail.tpl");
				return;
			}

		}
		else if(isset($_POST['send_submit'])){

			//メール
			//フォームの情報
			$templateArr['mail_text']=$_POST['mail'];
			$templateArr['subject']=$_POST['subject'];
			$sigArr['sig']=$_POST['sig'];

			//メール履歴に入れる
			$templateArr['insert_date']=date("Y-m-d H:i:s");
			$send_no=$commonDao->InsertItemData2("mail_history", $templateArr);

			//最初に選択したテンプレート情報
//			$tmp=$commonDao->get_data_tbl("mail_template","template_no",$_SESSION['template_no']);
//			$templateArr=$tmp[0];

			//メールを送信する
			$mailBody=$templateArr['mail_text']."\n\n\n";

			$magazinBody="※メルマガ不要な方は配信停止の設定をお願いいたします※\n";
			$magazinBody.=ROOT_URL."member/magazin_login/\n\n";


			if($_SESSION['member_id']){
				foreach($_SESSION['member_id'] as $item){
					$tmp=$commonDao->get_data_tbl("member","member_id",$item);
					$oemArr=$tmp[0];

						$mailHead=$oemArr['name']."様\n\n";

						$sendmailBody=$mailHead.$mailBody.$magazinBody.$sigArr['sig'];

						$subject = $templateArr['subject'];
						send_mail($oemArr['email'], MAIL_FROM, MAIL_FROM_NAME, $subject, $sendmailBody,"",RETURN_EMAIL);

						//送信先履歴
						$fi=array();
						$fi['send_no']=$send_no;
						$fi['member_id']=$item;
						$commonDao->InsertItemData2("mail_history_detail", $fi);

				}

				if($_SESSION['member_id']) unset($_SESSION['member_id']);
				if($_SESSION['template_no']) unset($_SESSION['template_no']);

				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("maildeliver/delivery_fini.tpl");
				return;

			}


		}
		else{

//			$oemArr=array();
//			if($_SESSION['member_id']) $oemArr=$_SESSION['member_id'];

			if(isset($_SESSION['member_id'])) unset($_SESSION['member_id']);
			if(isset($_SESSION['template_no'])) unset($_SESSION['template_no']);
			if(isset($_SESSION['mail_text'])) unset($_SESSION['mail_text']);
			if(isset($_SESSION['subject'])) unset($_SESSION['subject']);


		}

		//テンプレート
		$tmp=$commonDao->get_data_tbl("mail_template","","","template_no desc");
		$templateArr=makePulldownTableList($tmp,"template_no","title");

		$this->view->assign("templateArr", $templateArr);


		if($login_admin['shop_no']>0){
			$search['shop_no']=$login_admin['shop_no'];
		}

		//登録購入コース取得
		$tmp=$commonDao->get_data_tbl("mst_course","","","v_order");

		$courseArr=makePulldownTableList($tmp,"course_no","name",1);
//		$arrTmp=array("0"=>"--");
//		$courseArr=array_merge($arrTmp,$courseArrTmp);
//		array_unshift($courseArr, "--");
		$this->view->assign("courseArr", $courseArr);

//		$total_cnt=$clientDao->searchCount($search);
//		$page_navi = get_page_navi($total_cnt, V_CNT, $search['page'], "/mail/address/");
//		$arr=$clientDao->search($search,"insert_date desc",V_CNT);

		if(isset($_POST['sbm_search']) || isset($_POST['back'])){
			// echo "<pre>"; print_r($_POST);exit();
			$arr=$dao->search($search,"m.insert_date desc");
		}

		@$this->view->assign("oemArr", $oemArr);
		@$this->view->assign("arr", $arr);
		@$this->view->assign("page_navi", $page_navi);
		@$this->view->assign("search", $search);
		@$this->view->assign("template_no", $template_no);


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("maildeliver/magazin.tpl");
		return;
	}

	/**
	 * メール配信 配信先の検索、決定
	 *
	 */
	public function autoAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao = new CommonDao();

		if($_POST['submit']){

			$wfi['no']=$_POST['no'];
			$fi['mail_flg']=$_POST['mail_flg'];
			$ret=$commonDao->updateData2("mst_auto_mail", $fi, $wfi);
			if($ret){
				$this->addMessage("info","自動配信情報を変更しました");
			}
			else{
				$this->addMessage("error","自動配信情報の変更エラーです");
			}
		}

		//
		$arr=$commonDao->get_data_tbl("mst_auto_mail");
		$this->view->assign("arr", $arr);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("maildeliver/auto.tpl");
		return;

	}

	/**
	 * メール配信 配信先の検索、決定
	 *
	 */
	public function autoeditAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao = new CommonDao();

		$no=$_GET['no'];
		if(!$no){
			$this->addMessage("error","編集する自動配信メールが選択されていません");
			$this->setTemplatePath("error.tpl");
		}

		$no=makeGetRequest($no);

		if($_POST['submit']){

			if($_POST['subject']==""){
				$this->addMessage("error","メールのサブジェクトをご入力ください");

			}
			else{

				$fi['subject']=$_POST['subject'];
				$fi['header_text']=$_POST['header_text'];
				$fi['footer_text']=$_POST['footer_text'];

				$wfi['no']=$no;

				$ret=$commonDao->updateData2("mst_auto_mail", $fi, $wfi);
				if($ret){
					$this->addMessage("info","自動配信情報を変更しました");
				}
				else{
					$this->addMessage("error","自動配信情報の変更エラーです");
				}

			}
		}


		$arr=$commonDao->get_data_tbl("mst_auto_mail","no",$_GET['no']);
		$input_data=$arr[0];
		$this->view->assign("input_data", $input_data);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("maildeliver/autoedit.tpl");
		return;
	}

	/**
	 * ステップメール
	 *
	 */
	public function stepmailAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao = new CommonDao();

		if(isset($_POST['submit'])){

			$wfi['no']=$_POST['no'];
			$fi['mail_flg']=$_POST['mail_flg'];
			$ret=$commonDao->updateData2("mst_step_mail", $fi, $wfi);
			if($ret){
				$this->addMessage("info","ステップメール情報を変更しました");
			}
			else{
				$this->addMessage("error","ステップメール情報の変更エラーです");
			}
		}

		//
		$arr=$commonDao->get_data_tbl("mst_step_mail");
		//配信タイミングの表示調整
		$stepmailArr=CommonArray::$stepMail_array;
		for($i=0;$i<count($arr);$i++){

			$step_kind=$stepmailArr['kind'][$arr[$i]['step_kind']];
			$step_when=$stepmailArr['when'][$arr[$i]['step_when']];
			$step_time=$stepmailArr['time'][$arr[$i]['step_time']];

			$arr[$i]['timing_str']=$step_kind.$arr[$i]['step_long'].$step_time.$step_when;

		}



		$this->view->assign("arr", $arr);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("maildeliver/stepmail.tpl");
		return;

	}


	/**
	 * メール配信 配信先の検索、決定
	 *
	 */
	public function stepeditAction() {

		// ログイン中のadmin情報を取得
		$login_admin = $this->getAdminSession();
		$this->view->assign("login_admin", $login_admin);

		$commonDao = new CommonDao();

		$no=$_GET['no'];
		$no=makeGetRequest($no);

		$formVa=CommonChkArray::$stepMailCheckData;

		if($_POST['submit']){

			$input_data=$_POST;

			$ret=!$this->check($_POST,$formVa);
			if (count($this->getMessages()) >0) {
				foreach($this->getMessages() as $msg){
					$result_messages[$msg->getMessageLevel()]=$msg->getMessageBody();
				}
				$this->view->assign("result_messages", $result_messages);
			}
			else {

				//フォーム入力用データ
				foreach($formVa['dbstring'] as $key=>$val){
					$fi[$key]=$input_data[$key];
				}

				if($input_data['no']){

					$wfi['no']=$input_data['no'];
					$ret=$commonDao->updateData2("mst_step_mail", $fi, $wfi);
					if($ret){
						$this->addMessage("info","ステップメール情報を変更しました");
					}
					else{
						$this->addMessage("error","ステップメール情報の変更エラーです");
					}

				}
				else{
					$fi['mail_flg']=1;
					$fi['insert_date']=date("Y-m-d H:i:s");
					$fi['update_date']=date("Y-m-d H:i:s");

					$ret=$commonDao->InsertItemData2("mst_step_mail", $fi);
					if($ret){
						$this->addMessage("info","ステップメール情報を登録しました");
						$input_data['no']=$ret;
					}
					else{
						$this->addMessage("error","ステップメール情報の登録エラーです");
					}
				}

				$this->view->assign("fini_flg", 1);
			}
		}
		else if($no){
			$arr=$commonDao->get_data_tbl("mst_step_mail","no",$_GET['no']);
			$input_data=$arr[0];
		}
		else{


		}

		$stepArr=CommonArray::$stepMail_array;
		$this->view->assign("stepArr", $stepArr);

		//テンプレート
		$tmp=$commonDao->get_data_tbl("mail_template","","","template_no desc");
		$templateArr=makePulldownTableList($tmp,"template_no","title");
		$this->view->assign("templateArr", $templateArr);

		$this->view->assign("input_data", $input_data);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("maildeliver/stepedit.tpl");
		return;
	}

}
?>

