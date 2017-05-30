<?php
class MypageController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();

		require_once("src/facebook.php");

	}

	/**
	 *  登録情報変更 表示
	 */
	public function displayAction() {

/*
		$this->loginCheck();
		$login_member=$this->getMemberSession();

		$member_id=$login_member[member_id];

		$commonDao = new CommonDao();
		$dao = new MemberDao();

		$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);
		$memArr=$tmp[0];

		$this->view->assign("memArr", $memArr);
*/

		$commonDao = new CommonDao();

		$this->loginCheck();

		$login_member=$this->getMemberSession();
//		print_r_with_pre($login_member);

		if($login_member[login_type]!="member"){//メンバーとしてのログインでなければNG
			header("location:/");
		}

		//換金履歴
		$reqArr=$commonDao->get_data_tbl("user_request","member_id",$login_member[member_id],"insert_date desc");
		$this->view->assign("reqArr", $reqArr);

		//ポイント履歴
		$sql="select * from point_record as r where r.member_id=".$login_member[member_id]." and r.stat>=0 order by r.insert_date desc";
		$poArr=$commonDao->get_sql($sql);

		$this->view->assign("poArr", $poArr);



		//良いねしたページ最新5件
		$sql="select * from point_record as r, fbpage as f where r.fbpage_id=f.fbpage_id and r.member_id=".$login_member[member_id]." and f.stat=1 and r.stat>=0 order by r.insert_date desc LIMIT 5 OFFSET 0";
		$arr=$commonDao->get_sql($sql);

		for($i=0;$i<count($arr);$i++){

			// アイコンURL作成
			$url = "https://graph.facebook.com/" . $arr[$i][fbpage_id] . "/picture/?type=large";
			$arr[$i][img_url] = $url;

			// いいねボタン用URL作成
			$url = "https://www.facebook.com/" . $arr[$i][fbpage_id];
			$arr[$i][url] = $url;
		}

		$this->view->assign("arr", $arr);


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/index.tpl");
		return;

	}

	/**
	 *  登録情報変更
	 */
	public function editAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$member_id=$login_member[member_id];

		$commonDao = new CommonDao();
		$dao = new MemberDao();


		//config
		$prefArr=CommonArray::$pref_text_array;

		if($_POST[conf_x]){


			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			//---------------- 入力チェック ---------------------------
			//基本事項
			if($input_data[bank_category]==0){
			//銀行の場合
				$baseData=CommonChkArray::$memberRegistCheckBankData;
			}
			else{
				$baseData=CommonChkArray::$memberRegistCheckYucyoData;
			}
			$this->check($input_data,$baseData);


			//-------------- ここまで -----------------------------------

			if (count($this->getMessages()) >0) {

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);
			}
			else {

				//都道府県名
				$input_data[pref]=get_pref_name($input_data[pref]);


				$this->view->assign("input_data", $input_data);

				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("mypage/edit_conf.tpl");
				return;


			}

		}
		else if($_POST[submit_x]){

			$input_data=$_SESSION["input_data"];

			if($input_data){

				if($input_data[bank_category]==0){
					$baseData=CommonChkArray::$memberRegistCheckBankData;
				}
				else{
					$baseData=CommonChkArray::$memberRegistCheckYucyoData;
				}

				//基本事項
				foreach($baseData[dbstring] as $key=>$val){
					$dkey[]=$key;
					$dval[]=$input_data[$key];
				}

				$ret=$dao->upItemData($dkey,$dval,"member_id",$input_data[member_id]);
				if($ret){
					$this->view->assign("msg", "登録情報の更新が完了しました。");
					//セッションの更新
					$member=$commonDao->get_data_tbl("member","member_id",$input_data[member_id]);
					$member[0][login_type]="member";
					$this->setMemberSession($member[0]);

					//登録用セッションの破棄
					unset($_SESSION["input_data"]);
					$this->redirect("/mypage/edit_fini/");
				}
				else{
					$this->redirect("/mypage/edit_fini/?err=1");
				}

				if($_SESSION["input_data"]) unset($_SESSION["input_data"]);

				//都道府県名
				$input_data[pref]=get_pref_name($input_data[pref]);
			}
			else{

					$this->view->assign("msg", "登録情報の更新に失敗しました。");

			}
				$this->view->assign("input_data", $input_data);

				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();

				$this->setTemplatePath("mypage/edit_fini.tpl");
				return;


		}
		else if($_POST[back_x]){

			$input_data=$_SESSION["input_data"];

		}
		else{

			if($_SESSION["input_data"]) unset($_SESSION["input_data"]);

			//DBに登録されている情報取得
			$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);
			$input_data=$tmp[0];

		}

		//年月日プルダウン
		$yearArr=makeYearList("1940",0,1);
		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);

		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);


		$this->view->assign("msg", $msg);
		$this->view->assign("input_data", $input_data);
		$this->view->assign("prefArr", $prefArr);


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/edit.tpl");
		return;

	}

	/**
	 * 登録情報更新完了
	 */
	public function edit_finiAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$member_id=$login_member[member_id];

		if(isset($_GET[err])){
			$msg= "ユーザー情報の更新に失敗しました。";
		}else{
			$msg= "ユーザー情報の更新が完了しました。";
		}

		$this->view->assign("msg", $msg);

		//都道府県名
		$login_member[pref]=get_pref_name($login_member[pref]);
		$this->view->assign("input_data", $login_member);
		$this->view->assign("prefArr", $prefArr);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/edit_fini.tpl");
		return;

	}
	/**
	 * ログイン
	 */
	public function loginAction() {

		$commonDao=new CommonDao();

		$login_member=$this->getMemberSession();
		if($login_member[login_type]=="member"){//オーナーとしてのログイン済みであれば、マイページへ
			header("location:/mypage/");
			exit;
		}

			//facebook login
//			if($_POST[facebook_x]){

				$facebookConfig=CommonArray::$facebook_config;
				$facebook = new Facebook($facebookConfig);

				$authURL = $facebook->getLoginUrl (array ('scope'        => 'email,user_birthday'
	                                                  , 'redirect_uri' => $facebookConfig[redirect]));


	 				header ("Location: " . $authURL);
					exit;
//			}


		// HTTPヘッダ情報出力
//		$this->outHttpResponseHeader();

//		$this->setTemplatePath("login.tpl");
//		return;

	}

	/**
	 * Facebookログイン
	 */
	public function facebookRedirctAction() {

		$commonDao=new CommonDao();
		$dao=new MemberDAO();

//		require_once("src/facebook.php");

		$facebookConfig=CommonArray::$facebook_config;
		$facebook = new Facebook($facebookConfig);

		if($facebook->getUser()){

				$user = $facebook->api ('/me', 'GET', array ('locale' => 'ja_JP'));

				$logoutUrl = $facebook->getLogoutUrl();
//				echo "<a href='".$logoutUrl."'>ログアウト</a>";


				$user = $facebook->api ('/me', 'GET', array ('locale' => 'ja_JP'));
				$birthday = explode ('/', $user['birthday']);
				$year  = $birthday[2];
				$month = $birthday[0];
				$day   = $birthday[1];

				$member[name]=$user['name'];
				$member[email]=$user['email'];
				$member[dob_year]=$year;
				$member[dob_month]=$month;
				$member[dob_day]=$day;
				$member[insert_date]=date("Y-m-d H:i:s");
				$member[update_date]=date("Y-m-d H:i:s");
				$userId = $facebook->getUser();
				$member[member_id]=$userId;

//				$member[facebook_flg]=1;


				//$userIdで判断　登録済みかどうか
				$ret=$commonDao->get_data_tbl("member","member_id",$member[member_id]);

				if(!$ret){	//未登録の場合
					//ユーザー情報の新規登録
					$member[stat]=1;
					$member[login_date]=date("Y-m-d H:i:s");
					$member[point]=LOGIN_POINT;
					$retNo=$commonDao->InsertItemData2("member", $member);
					$ret=$commonDao->get_data_tbl("member","member_id",$member[member_id]);

					//ログインポイントを入れる
					$ins=array();
					$ins[member_id]=$member[member_id];
					$ins[point]=LOGIN_POINT;
					$ins[point_flg]=LOGIN_POINT_FLG;//ログイン
					$ins[point_status]=1;
					$ins[insert_date]=date("Y-m-d H:i:s");
					$ins[update_date]=date("Y-m-d H:i:s");

					$commonDao->InsertItemData2("point_record",$ins);

					//ログファイルに書き込み
					write_point_log($member[member_id],"新規登録時ログインポイント",LOGIN_POINT);
				}
				else{

					//アカウント停止状態であれば、エラーメッセージを出して終わり
					if($ret[0][stat]!=1){

						header("location:".ROOT_URL."mypage/err/");
						exit;

					}


					//本日最初のログインか
					$tmp=explode(" ",$ret[0][login_date]);
					if($tmp[0]!=date("Y-m-d")){//本日最初
						//ログインポイントを入れる
						$ins=array();
						$ins[member_id]=$member[member_id];
						$ins[point]=LOGIN_POINT;
						$ins[point_flg]=LOGIN_POINT_FLG;//ログイン
						$ins[point_status]=1;
						$ins[insert_date]=date("Y-m-d H:i:s");
						$ins[update_date]=date("Y-m-d H:i:s");

						$commonDao->InsertItemData2("point_record",$ins);

//						$sql="update member set point=point+".LOGIN_POINT." where member_id=".$member[member_id];//なぜかエラーになる
//						$commonDao->get_sql($sql);

						//ログインポイント加算
						$upins[point]=$ret[0][point]+LOGIN_POINT;

						//ログファイルに書き込み
						write_point_log($member[member_id],"ログインポイント",LOGIN_POINT);

					}

					$upins[login_date]=date("Y-m-d H:i:s");
					$upwh[member_id]=$member[member_id];
					$commonDao->updateData2("member",$upins,$upwh);//最終ログイン日とログインポイント（日ごとの最初のログインポイント）


				}

				$member=$ret[0];
				$member[login_type]="member";


				$this->setMemberSession($member);
				header("location:".ROOT_URL."mypage/");
				exit;

		}
		else{

			echo "error";


		}
	}

	/**
	 * ログインエラー
	 */
	public function errAction() {

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("err.tpl");
		return;

	}

	/**
	 * ポイント交換
	 */
	public function changeAction() {

		$commonDao=new CommonDao();

		$login_member=$this->getMemberSession();

		//念のため、最新を取得
		$tmp=$commonDao->get_data_tbl("member","member_id",$login_member[member_id]);
		$point=$tmp[0][point];
		$this->view->assign("point", $point);

		if($_POST[conf]){

			$pt=$_POST[pt];

			$this->view->assign("pt", $pt);

			// HTTPヘッダ情報出力
			$this->outHttpResponseHeader();

			$this->setTemplatePath("mypage/change_conf.tpl");
			return;


		}
		else if($_POST[submit]){

			$pt=$_POST[pt]."000";

			//memberからpointを引く
			$ins[point]=$point-$pt;
			$wh[member_id]=$login_member[member_id];

			$commonDao->updateData2("member",$ins,$wh);

			//セッションデータの取り直し
			$ret=$commonDao->get_data_tbl("member","member_id",$login_member[member_id]);
			$member=$ret[0];
			$member[login_type]="member";

			$this->setMemberSession($member);

			//ポイント履歴に請求として入れておく
			$ins=array();
			$ins[member_id]=$login_member[member_id];
			$ins[stat]="0";
			$ins[point]=-$pt;
			$ins[point_flg]=BILL_POINT_FLG;
			$ins[insert_date]=date("Y-m-d H:i:s");
			$ins[update_date]=date("Y-m-d H:i:s");

			$commonDao->InsertItemData2("point_record",$ins);

			//請求テーブル
			$ins=array();
			$ins[member_id]=$login_member[member_id];
			$ins[point]=$pt;
			$ins[insert_date]=date("Y-m-d H:i:s");
			$ins[update_date]=date("Y-m-d H:i:s");
			$commonDao->InsertItemData2("user_request",$ins);

			//ログファイルに書き込み
			write_point_log($login_member[member_id],"換金",-$pt);

			//サイドバーのポイントの関係上、完了ページをとばす

			header("location:/mypage/changeFinish/");
			exit;



		}
		else if($_POST[back]){

			$pt=$_POST[pt];

		}
		else{


		}


		$loop=floor($point/1000);

		//換金ptのプルダウン作成用
		for($i=1;$i<=$loop;$i++){
			$lpArr[$i]=$i;
		}


		$this->view->assign("pt", $pt);
		$this->view->assign("lpArr", $lpArr);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/change.tpl");
		return;


	}

	/**
	 * 換金完了ページ
	 */
	public function changeFinishAction() {


			// HTTPヘッダ情報出力
			$this->outHttpResponseHeader();

			$this->setTemplatePath("mypage/change_fini.tpl");
			return;


	}

	/**
	 * ログアウト
	 */
	public function logoutAction() {

		$this->deleteMemberSession();
		$redirect_path=ROOT_URL;
		$this->redirect($redirect_path);


	}


















//--------------- 以下未使用のはず -----------------------------------------------------

	/**
	 *  パスワード変更
	 */
	public function passwdAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$member_id=$login_member[member_id];

		$commonDao = new CommonDao();

		if($_POST){

			$input_data=$_POST;

			//旧パスチェック
			if($input_data[oldpassword]==""){
				$this->addMessage("oldpassword","現在のパスワードを入力して下さい。");
			}
			else{
				$tmp=$commonDao->get_data_tbl("member",array("member_id","password"),array($member_id,to_hash($input_data[oldpassword])));
				if(!$tmp){
					$this->addMessage("oldpassword","現在のパスワードが違っています。");
				}
			}

			if($input_data[password]==""){
				$this->addMessage("password","新パスワードを入力して下さい。");
			}

			if( $input_data[password]!= $input_data[password2]){
				$this->addMessage("password","新パスワードと確認用新パスワードが違っています。");
			}
			if (count($this->getMessages()) >0) {
				foreach($this->getMessages() as $msg){
					$result_messages[$msg->getMessageLevel()]=$msg->getMessageBody();
				}
			}
			else {
				$ret=$commonDao->updateData("member","password",to_hash($input_data[password]),"member_id",$member_id);
				if($ret){


					$this->setTemplatePath("mypage/password-complete.tpl");
					return;

				}
				else{
					$this->addMessage("resultmsg","パスワード変更エラーです");
				}
			}
		}
		else{

		}

		$this->view->assign("result_messages", $result_messages);
		$this->view->assign("input_data", $input_data);

		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/password.tpl");
		return;

	}

	/**
	 *  退会処理
	 */
	public function resignAction() {

		$this->loginCheck();
		$login_member=$this->getMemberSession();
		$member_id=$login_member[member_id];

		$commonDao = new CommonDao();
		$memDao = new MemberDao();

		$resignArr=CommonArray::$resign_array;

		//会員情報の取得
		$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);
		$memArr=$tmp[0];
		$this->view->assign("memArr", $memArr);


		if($_POST){
			if(!$_POST[chk]){
				$this->addMessage("err","退会理由を選択してください");

				foreach($this->getMessages() as $msg){
					$result_messages[$msg->getMessageLevel()]=$msg->getMessageBody();
				}
				$this->view->assign("result_messages", $result_messages);


			}
			else{
				$input_data=$_POST;
				$tmp=array();
				foreach($input_data[chk] as $item){
					$reason="";
					if($item==5 && $input_data[reason]!="") $reason=" (".$input_data[reason].")";
					$tmp[]="・".$resignArr[$item].$reason;
				}
				$input_data[resign]=implode("\n", $tmp);

				//退会処理 関連情報を全て削除
				$memDao->delete($member_id);

				//メール送信
				$this->view->assign("memArr", $memArr);
				$this->view->assign("input_data", $input_data);
				$subject = "[" . STR_SITE_TITLE . "]退会のご連絡";
				$mailBody = $this->view->fetch("mail/resign_admin.tpl");
				send_mail(SITE_ADMIN_EMAIL, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
//				send_mail("ksuzuki@apice-tec.co.jp", MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

				//セッション廃棄
				if($this->getMemberSession()) $this->deleteMemberSession();
//				if($_COOKIE['login_info']) {
//					setcookie("login_info", "", time() - 1800);
//				}

				header("location:/mypage/resignComplete");
				exit;

			}

		}


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/resign.tpl");
		return;

	}

	/**
	 *  退会処理
	 */
	public function resignCompleteAction() {


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/resign-complete.tpl");
		return;

	}


	/**
	 * ユーザー情報新規登録
	 * 項目： 名前、フリガナ、生年月日、住所、メールアドレス、振り込み口座
	 */
	public function registAction() {

		$commonDao = new CommonDao();
		$dao = new OwnerDao();

		$formVa=CommonChkArray::$memberRegistCheckData;

echo "FBID = ". $_SESSION[MEMBER_SESSION_FBID] . "<br>";

		if(isset($_POST[confirm_x])){
			// 入力完了してSubmitした次の画面。
			// 入力チェック、重複チェックをして問題が無ければconfirm画面を出す。
			// 問題があればアラートを出して再表示

			// 入力データをセッション変数に保持
			$_SESSION["input_data"]=$_POST;
			$input_data=$_SESSION["input_data"];

			$_SESSION["input_data"]["member_id"] = $_SESSION[MEMBER_SESSION_FBID];

			echo "hello, here's confirm_x section.<br>";

			//入力チェック
			$ret=!$this->check($_POST,$formVa);

			//重複チェック
/*
			$ret=$commonDao->get_data_tbl("member","email",$input_data[email]);
			if($ret){
				$this->addMessage("email", "既に登録済みのメールアドレスです。");
			}
*/

			// 銀行とゆうちょで必須項目分けてチェックする。


			if (count($this->getMessages()) >0) {
				// エラーメッセージあった場合
				// echo "you've gotta error msgs??.<br>";
				foreach($this->getMessages() as $msg){
					$result_messages[$msg->getMessageLevel()]=$msg->getMessageBody();
				}
				$this->view->assign("result_messages", $result_messages);
				var_dump($result_messages);

			}else{
				// 全部オッケーの場合。regist_confirmを呼び出す。
				echo "Alright. let's move on to confirmation page.<br>";
				var_dump($input_data);
				// echo "input_data.pref=" . $input_data[pref] . " pref_text_array=" . $pref_text_array[$input_data[pref]];
				$prefArr=CommonArray::$pref_text_array;

				$this->view->assign("input_data", $input_data);
				$this->view->assign("pref", $prefArr[$input_data[pref]]);

				// 確認テキスト作成
				if ($input_data[bank_category] == 0){  // 銀行の場合
					$acc_type = ($input_data[bank_account_type] == "0") ? "当座" : "普通";
					$bank_detail_text = $input_data[bank_company] . "銀行<br>"
									. $input_data[bank_branch] . "支店(" . $input_data[bank_branch_id] . ")<br>"
									. $acc_type . ": " . $input_data[bank_account] . "<br>"
									. "名義人名: " . $input_data[bank_holder];
				}else{  // ゆうちょの場合
					$bank_detail_text = "ゆうちょ銀行<br>"
									. "記号: " . $input_data[yucho_account1] . "<br>番号:" . $input_data[yucho_account2] . "<br>"
									. "名義人名: " . $input_data[bank_holder];
				}
				$this->view->assign("bank_detail", $bank_detail_text);

				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();
				$this->setTemplatePath("mypage/regist_confirm.tpl");
				return;

			}

		}else if(isset($_POST[submit_x])){
			// 確認画面でOKを押された場合。
			// 実際のデータ入力を行う

			$input_data=$_SESSION["input_data"];

				//フォーム入力用データ
				foreach($formVa[dbstring] as $key=>$val){
					$inval=$input_data[$key];
					$dkey[]=$key;
					$dval[]=$inval;
				}

				$dkey[]="insert_date";
				$dval[]=date("Y-m-d H:i:s");
				$dkey[]="update_date";
				$dval[]=date("Y-m-d H:i:s");

				// set FBID as an owner_id
				// $dkey[] = "member_id";
				// $dval[] = $_SESSION[MEMBER_SESSION_FBID];
				var_dump($dkey);
				var_dump($dval);

				$ret=$commonDao->InsertItemData("member", $dkey,$dval);

				if($ret<0){
					// 登録エラー
					// var_dump($ret);
					$this->view->assign("msgFlg", 2);
					$this->setTemplatePath("mypage/regist_fini.tpl");

					return;
				}else{

					$msg="会員の登録が完了しました";

					//ユーザーにメール送信
/* 必要かわからないので取りあえず無し
					$this->view->assign("input_data", $input_data);

					$subject = "[" . STR_SITE_TITLE . "]会員登録完了のお知らせ";
					$mailBody = $this->view->fetch("mail/regist.tpl");
					send_mail($input_data[email], MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);
*/

					//セッション廃棄
					if($_SESSION["input_data"]) unset($_SESSION["input_data"]);
					if($_SESSION[TMP_FUP]) unset($_SESSION[TMP_FUP]);

				}

				// HTTPヘッダ情報出力
				$this->outHttpResponseHeader();
				$this->setTemplatePath("mypage/regist_fini.tpl");
				return;


		}else if(isset($_POST[back_x])){
			// 入力しなおしのボタンを押された時

			// 入力データをセッションから再取得
			$input_data=$_SESSION["input_data"];

		}


		//年月プルダウン
		$yearArr=makeNendoYearPastList(-18,50,2,1);//誕生日の西暦　年度で表示する西暦を変える
		$monthArr=makeMonthList(1);
		$dayArr=makeDayList(1);
		$this->view->assign("yearArr", $yearArr);
		$this->view->assign("monthArr", $monthArr);
		$this->view->assign("dayArr", $dayArr);


		$this->view->assign("input_data", $input_data);


		// 都道府県プルダウン
		$prefArr=CommonArray::$pref_text_array;
		$this->view->assign("prefArr", $prefArr);


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("mypage/regist.tpl");
		return;

	}

}
?>
