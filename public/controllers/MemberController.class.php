<?php
class MemberController extends AppRootController {


	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();


	}

	/**
	 * トップページ表示
	 */
	public function displayAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();


		$commonDao = new CommonDao();


		$this->view->assign("login_member", $login_member);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/mypage.tpl");

		return;


	}

	/**
	 * 予約中の一覧
	 */
	public function listAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$this->view->assign("login_member", $login_member);

		$commonDao = new CommonDao();
		$memberDao = new MemberDAO();
		$shopDao = new ShopDAO();
		$reserveDao = new ReserveDAO();

		if($_POST[cancel]){

			$no=key($_POST[cancel]);

			//予約一時間前であればキャンセルはできない
			$resTmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
			$r_date=$resTmp[0][reserve_date]." ".$resTmp[0][start_time];
			$tdyTime=date("Y-m-d H:i:s",strtotime("+1 hour"));
			if($tdyTime>=$r_date){
					$errmsg="大変申し訳ございません。予約1時間前以内のキャンセルは出来ません。";
			}
			else{


				$ret=$reserveDao->cancelUpData($no);
				if($ret){

					//コース購入の終了フラグの変更(予約時に規定回数になり、コース終了フラグが立っている場合があるので、それを外す）
					$memberDao->changeFinishFlgInfo($no);


					$msg="キャンセル処理を行いました。<br />再度のご予約をお待ちしております";


					//キャンセルメール
					$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
					$input_data=$tmp[0];
					$input_data[name]=$login_member[name];
					$input_data[email]=$login_member[email];
					$rtmp=$commonDao->get_data_tbl("member_reserve","reserve_no",$input_data[reserve_no]);
					$input_data[number]=$rtmp[0][number];


					//ユーザーへ
					$this->send_auto_mail_cancel($input_data);


					//運営者へ
					//メール設定がされている場合は、そのメールに
					//メール設定がれていない場合は、本部に
					$tmp=$commonDao->get_data_tbl("shop","shop_no",$input_data[shop_no]);
					if($tmp[0][send_email]){
						$shop_send_mail=$tmp[0][send_email];
					}
					else{
						$shop_send_mail=SITE_ADMIN_EMAIL;
					}

					//店舗名
					$input_data[shop_name]=$shopDao->getShopName($input_data[shop_no]);


					$this->view->assign("input_data", $input_data);
					$subject = "[" . STR_SITE_TITLE . "]会員様のご予約キャンセル";
					$mailBody = $this->view->fetch("mail/cancel.tpl");

					$mailfrom="From:" .mb_encode_mimeheader(MAIL_FROM_NAME) ."<".MAIL_FROM.">";
					send_mail($shop_send_mail, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

				}
				else{

					$errmsg="キャンセル処理に失敗しました。お手数ですが、再度キャンセル処理をお願いします<br />";

				}
			}


		}
		elseif(isset($_GET[err])){
			//変更処理が1時間前エラーで戻ってきた場合(reserve/listから戻ってくる)

			$errmsg="大変申し訳ございません。予約1時間前以内の変更は出来ません。";

		}

		$this->view->assign("msg", $msg);
		$this->view->assign("errmsg", $errmsg);

		$arr=$memberDao->getReserveCourseInfo($login_member[member_id]);
		for($i=0;$i<count($arr);$i++){
			$arr[$i][youbi]=getYoubi($arr[$i][reserve_date]);
		}

		$this->view->assign("arr", $arr);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/list.tpl");

		return;
	}

	/**
	 * 履歴一覧
	 */
	public function historyAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$this->view->assign("login_member", $login_member);

		$commonDao = new CommonDao();
		$memberDao = new MemberDAO();

		$member_id=$login_member[member_id];

		$buyCourseArr=$memberDao->getCourseInfoAll($member_id);

		$this->view->assign("buyCourseArr", $buyCourseArr);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/history.tpl");

		return;
	}

	/**
	 *  予約可能な一覧
	 */
	public function reserveAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$this->view->assign("login_member", $login_member);

		//予約ボタンを押されたら、ログイン状態であれば会員予約にするため、ここでワンクッションおいれ、リダイレクト
		if($_POST){
			header("location:/reserve/list/");
			exit;
		}

		$member_id=$login_member[member_id];

		$commonDao = new CommonDao();
		$memberDao = new MemberDAO();
		$reserveDao = new ReserveDAO();

		//購入済みのコースで、予約可能なもを取得
//		$arr=$reserveDao->getUseCourseInfo($member_id);

		$arr=$memberDao->getCourseInfo($member_id);

		for($i=0;$i<count($arr);$i++){

			//予約中のコースの情報
			$tmp=$memberDao->getCourseCntInfo($arr[$i][buy_no]);
			$arr[$i][cnt]=count($tmp);
			if(!$tmp){
				//予約が０回の場合は取れない

				$sql="select c.number from member_buy as b, mst_course as c where b.course_no=c.course_no and b.buy_no=".$arr[$i][buy_no];
				$tmp=$commonDao->get_sql($sql);
			}

			$arr[$i][number]=$tmp[0][number];
			$arr[$i][zan]=$tmp[0][number]-$arr[$i][cnt];


		}

		//予約できるチケットが残っていなければ省く

		$this->view->assign("arr", $arr);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/reserve.tpl");

		return;
	}

	/**
	 *  予約内容の変更
	 *
	 *
	 *  未使用
	 */
	public function reserve_changeAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();

		$commonDao=new CommonDao();
		$memberDao = new MemberDAO();
		$reserveDao = new ReserveDAO();

		$no=$_REQUEST[no];
		//情報ゲット
		$input_data=$reserveDao->getDetailInfo($no);


		if($_POST[submit]){

			$input_data[menu_no]=$_POST[menu_no];
			$input_data[number]=$_POST[number];
			$input_data[reserve_date]=$_POST[reserve_date];
			$input_data[start_time]=$_POST[start_time];

			//空きチェック
			list($result,$input_data)=$this->chkReserve($input_data);
			if($result){


			}
			else{
				//予約不可
				$this->addMessage("error","大変申し訳ございません。ご希望の日時は予約が取れませんでした。");

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);



			}


		}

		//コース番号から該当メニューのプルダウン
		$tmp=$commonDao->get_data_tbl("mst_menu","course_no",$input_data[course_no]);
		$menuArr=makePulldownTableList($tmp, "menu_no", "name");
		$this->view->assign("menuArr", $menuArr);


//print_r_with_pre($input_data);



		$this->view->assign("input_data", $input_data);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/reserve_change.tpl");

		return;

	}

	/**
	 *  基本情報の変更
	 */
	public function editAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$this->view->assign("login_member", $login_member);

		$commonDao=new CommonDao();
		$memberDao = new MemberDAO();

		//config
		$prefArr=CommonArray::$pref_text_array;
		$this->view->assign("prefArr", $prefArr);

		if($_POST[submit]){

			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//---------------- 入力チェック ---------------------------
			//基本事項
			$baseData=CommonChkArray::$memberModifyCheckData;

			$this->check($input_data,$baseData);

			//アドレス重複チェック
			$sql="select * from member where email='".$input_data[email]."' and member_id<>".$login_member[member_id];
			$tmp=$commonDao->get_sql($sql);

			if($tmp){
				$this->addMessage("email","ご入力のメールアドレスは他の会員様が登録されています");
			}
			//-------------- ここまで -----------------------------------
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

					$ret=$memberDao->upItemData($dkey,$dval,"member_id",$login_member[member_id]);
					if($ret){

						$this->view->assign("finish_flg", 1);
						$tmp=$commonDao->get_data_tbl("member","member_id",$login_member[member_id]);

						//セッションデータの入れ替え
						if($this->getMemberSession()) $this->deleteMemberSession();
						$this->setMemberSession($tmp[0]);

						$this->view->assign("finish_flg", 1);

					}
					else{
						$this->view->assign("finish_flg", 99);

					}

					// HTTPヘッダ情報出力
					$this->outHttpResponseHeader();
					$this->setTemplatePath("member/edit_done.tpl");
					return;

			}
		}
		else{
			$input_data=$login_member;
		}

		//年月日プルダウン
		//$yearArr=makeYearList("1945","-10",0);
		$yearArr=makeYearList2("0","1945",1);

		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);


		$this->view->assign("input_data", $input_data);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/edit.tpl");

		return;


	}
	/**
	 *  パスワードの変更
	 */
	public function passeditAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$this->view->assign("login_member", $login_member);

		$commonDao=new CommonDao();
		$memberDao = new MemberDAO();

		//パスワード変更
		if($_POST[pass_submit]){

			$inp=$_POST;
			//$memberPasswordCheckData
			$baseData=CommonChkArray::$memberPasswordCheckData;
			$this->check($inp,$baseData);

			//旧パスワード
			$tmp=$commonDao->get_data_tbl("member",array("password","email"),array(to_hash($inp[old_password]),$login_member[email]));
			if(!$tmp){
				$this->addMessage("old_password","旧パスワードが違っています。");

			}
			if (count($this->getMessages())==0) {
				if($inp[password]!=$inp[password2]){
					$this->addMessage("password","パスワードとパスワード確認の入力内容が違っています。");
				}
				else{

					$dval[password]=to_hash($inp[password]);
					$wfi[member_id]=$login_member[member_id];

					$ret=$commonDao->updateData2("member", $dval, $wfi);
					if($ret){
						$this->view->assign("finish_flg", 1);
					}
					else{
						$this->view->assign("finish_flg", 99);
					}

					// HTTPヘッダ情報出力
					$this->outHttpResponseHeader();
					$this->setTemplatePath("member/edit_done.tpl");
					return;

				}
			}

			if (count($this->getMessages()) >0) {
				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}
			}

				$this->view->assign("result_messages", $result_messages);
				$this->view->assign("inp", $inp);

		}

		$this->view->assign("input_data", $login_member);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/passedit.tpl");

		return;


	}


	/**
	 *  ログアウト
	 */
	public function logoutAction() {

		if($this->getMemberSession()) $this->deleteMemberSession();

		header("location:/");
		exit;

	}


	/**
	 *  退会
	 */
	public function withdrawAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$this->view->assign("login_member", $login_member);

		$commonDao = new CommonDao();
		$memberDao = new MemberDao();

		if($_POST[submit]){

			//退会処理

			$ret=$memberDao->delete($login_member[member_id]);
			if($ret){
				//残っているコースは使用不可にする
				$fi=array();
				$fi[finish_flg]=1;
				$wfi[member_id]=$login_member[member_id];
				$commonDao->updateData2("member_buy", $fi, $wfi);

				//残っているメニューはキャンセルにする
				$fi=array();
				$fi[visit_flg]=99;
				$commonDao->updateData2("member_reserve_detail", $fi, $wfi);

				if($this->getMemberSession()) $this->deleteMemberSession();

				header("location:/member/withdrawDone/");
				exit;


			}
			else{

				$this->view->assign("finish_flg", 1);
				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();
				$this->setTemplatePath("member/withdraw_done.tpl");

				return;
			}


		}

		//残っているチケットが無いか予約が無いか？
		$tmp1=$commonDao->get_data_tbl("member_buy",array("member_id","finish_flg"),array($login_member[member_id],0));
		if($tmp1){
			$this->view->assign("finish_flg", 1);
		}

		$tmp2=$commonDao->get_data_tbl("member_reserve_detail",array("member_id","visit_flg"),array($login_member[member_id],0));
		if($tmp2){
			$this->view->assign("finish_flg", 2);
		}

		if(!$tmp1 && !$tmp2){

			$this->view->assign("finish_flg", 99);

		}

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();
		$this->setTemplatePath("member/withdraw_conf.tpl");

		return;

	}
	/**
	 * パスワードを忘れた方
	 */
	public function passwordAction() {

		$commonDao=new CommonDao();

		if($_POST){
			$email=$_POST[email];

			if($email==""){
				$result_messages="メールアドレスをご入力ください。";

				$this->view->assign("result_messages", $result_messages);
			}
			else{

				//メアドcheck
				$tmp=$commonDao->get_data_tbl("member","email",$email);
				if(!$tmp){
					$result_messages="ご入力のメールアドレスは登録されていません。";

					$this->view->assign("result_messages", $result_messages);

				}
				else{

					//仮パスワード発行
					$pass=substr((md5(date("YmdD His"))), 0, 8);

					$tmp1[]="password";
					$tmp2[]=to_hash($pass);

					$commonDao->updateData("member", "password", to_hash($pass), "member_id", $tmp[0][member_id]);

					$this->view->assign("input_data", $tmp[0]);
					$this->view->assign("pass", $pass);

					$subject = "[" . STR_SITE_TITLE . "]仮パスワード発行";
					$mailBody = $this->view->fetch("mail/password.tpl");
					send_mail($email, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

					//$mailfrom="From:" .mb_encode_mimeheader(MAIL_FROM_NAME) ."<MAIL_FROM>";
					//mb_send_mail($email, $subject, $mailBody,$mailfrom);

					$this->setTemplatePath("password_fini.tpl");
					return;

				}
			}
		}

		$this->view->assign("resMsg", $resMsg);
		$this->view->assign("email", $email);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("password.tpl");
		return;
	}

	/**
	 *  退会完了表示
	 */
	public function withdrawDoneAction() {



				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();
				$this->setTemplatePath("member/withdraw_done.tpl");

				return;



	}


	//キャンセルのメール
	function send_auto_mail_cancel($reserve_datail){

		$commonDao = new CommonDao();
		$shopDao = new ShopDAO();

		$tmp=$commonDao->get_data_tbl("mst_auto_mail",array("no","mail_flg"),array(5,1));
		if($tmp){

			//メニュー名
			$menu_name=$shopDao->getMenuName($reserve_datail[menu_no]);

			//店舗名
			$shop_name=$shopDao->getShopName($reserve_datail[shop_no]);

			$bodyMail.="\n\n◆予約番号：".$reserve_datail[reserve_no]."\n";
			$bodyMail.="◆予約日：".$reserve_datail[reserve_date]."\n";
			$bodyMail.="◆時間：".$reserve_datail[start_time]."～".$reserve_datail[end_time]."\n";
			$bodyMail.="◆人数：".$reserve_datail[number]."人"."\n";
			$bodyMail.="◆店舗：".$shop_name."\n";
			$bodyMail.="◆メニュー：".$menu_name."\n\n\n";


			//署名GET
			$sigtmp=$commonDao->get_data_tbl("mail_sig","","");
			$sig=$sigtmp[0][sig];

			$subject = $tmp[0][subject];
			$mailBody = $tmp[0][header_text].$bodyMail.$tmp[0][footer_text]."\n\n".$sig;
			$mailfrom="From:" .mb_encode_mimeheader(MAIL_FROM_NAME) ."<".MAIL_FROM.">";
			send_mail($reserve_datail[email], MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
		}

	}

	/**
	 * メルマガ配信停止処理用のログイン
	 */
	public function magazin_loginAction() {

		$commonDao = new CommonDao();


		if($_POST[submit]){

			$input_data=$_POST;
			if($_POST[email]=="" || $_POST[password]==""){

					$result_messages="メールアドレスとパスワードを入力してください。";

					$this->view->assign("result_messages", $result_messages);

			}
			else{

				$fi[email]=$_POST[email];
				$fi[password]=to_hash($_POST[password]);

				$ret=$commonDao->get_data_tbl2("member",$fi);
				if($ret){
					//ログイン成功
					$this->setMemberSession($ret[0]);
					header("location:/member/magazin/");
					exit;
				}
				else{
					//エラー
						$result_messages="メールアドレスまたはパスワードが違っています。ご確認ください。";

					$this->view->assign("result_messages", $result_messages);


				}
			}
		}

		$this->view->assign("input_data", $input_data);

		$this->setTemplatePath("member/magazin_login.tpl");
		return;
	}



	/**
	 * メルマガ配信停止処理用のログイン
	 */
	public function magazinAction() {

		$commonDao = new CommonDao();

		$login_member=$this->getMemberSession();

		if($_POST[submit]){

			$fi[mail_flg]=0;
			$wfi[member_id]=$login_member[member_id];
			$commonDao->updateData2("member", $fi, $wfi);

			$this->setTemplatePath("member/magazin_fini.tpl");
			return;

		}
		else{

			$input_data[email_flg]=1;

		}

		$this->view->assign("input_data", $input_data);

		$this->setTemplatePath("member/magazin.tpl");
		return;
	}


}
?>
