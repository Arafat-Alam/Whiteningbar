<?php
class MemberController extends AppRootController {



	/**
	 * 応募一覧
	 */
	public function displayAction() {


		$commonDao=new CommonDao();
		$memberDao=new MemberDAO();

		// ログイン中のManagerを取得
		$login_manager = $this->getManagerSession();
		$company_id=$login_manager[company_id];



		//checkされた応募者の選考状況をそれぞれのプルダウンの値に変更
		if($_POST[submit]){

			if($_POST[sellct_flg]){
				foreach($_POST[sellct_flg] as $key=>$val){

					//現在のapply_statusを取得
					$ntmp=$commonDao->get_data_tbl("member_apply",array("apply_no","company_id"), array($key,$company_id));
					if($ntmp[0][apply_status]<2){
						$commonDao->updateData("member_apply", "select_flg", $val, array("apply_no","company_id"), array($key,$company_id));

						if($val==99){
							$commonDao->updateData("member_apply", "apply_status", 99, array("apply_no","company_id"), array($key,$company_id));
						}

					}
				}
			}

			$msg="応募者の選考状況を変更しました";

		}
		//checkされた応募者の選考状況を同じ値に変更
		else if($_POST[all_change]){

			$select_flg=$_POST[all_sellct_flg];

			for($i=0;$i<count($_POST[apply_no]);$i++){
				$apply_no=$_POST[apply_no][$i];

				//現在のapply_statusを取得
				$ntmp=$commonDao->get_data_tbl("member_apply",array("apply_no","company_id"), array($apply_no,$company_id));
				if($ntmp[0][apply_status]<2){
					$commonDao->updateData("member_apply", "select_flg", $select_flg, array("apply_no","company_id"), array($apply_no,$company_id));
					if($select_flg==99){
						$commonDao->updateData("member_apply", "apply_status", 99, array("apply_no","company_id"), array($apply_no,$company_id));
					}
				}
			}
			$msg="チェックされた応募者の選考状況を全て変更しました";
		}
		//不採用に変更
		else if($_POST[apply_ng]){

			$apply_no=key($_POST[apply_ng]);
			$select_flg=$_POST[sellct_flg][$no];
			$commonDao->updateData("member_apply", "apply_status", 99, array("apply_no","company_id"), array($apply_no,$company_id));

			$msg="不採用に変更しました";

		}
/*
		//採用に変更
		else if($_POST[apply_ok]){

			$no=key($_POST[apply_ok]);
			$select_flg=$_POST[sellct_flg][$no];
			$commonDao->updateData("member_apply", "apply_status", 2, "no", $no);

			$msg="採用に変更しました";

			//運営者にメール送信
			$this->view->assign("company_name", $login_manager[company_name]);
			$subject = "[" . SITE_TITLE . "]内定がありました。";
			$mailBody = $this->view->fetch("mail/apply_ok.tpl");
			$mailfrom="From:" .mb_encode_mimeheader(MAIL_FROM_NAME) ."<".MAIL_FROM.">";
			send_mail(SITE_ADMIN_EMAIL, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

		}
*/
		//雇用形態

		//選考状況
		$selectArr=CommonArray::$select_array;
		//応募ステータス
		$statusArr=CommonArray::$apply_array;
		//応募者取得
		$memberArr=$memberDao->getApplyInfo($company_id);

		for($i=0;$i<count($memberArr);$i++){
			//生年月日から年齢を出す
			$birth=$memberArr[$i][birth_year].$memberArr[$i][birth_month].$memberArr[$i][birth_day];
			$memberArr[$i][age]= (int) ((date('Ymd')-$birth)/10000);

			//採用となっている場合の、雇用形態
			$tmp=$employArr=$commonDao->get_data_tbl("mst_employ","id",$memberArr[$i][employ_id]);
			$memberArr[$i][employ_str]=$tmp[0][name];

//			$memberArr[$i][status]=$statusArr[$memberArr[$i][apply_status]];

		}

		$this->view->assign("selectArr", $selectArr);
		$this->view->assign("statusArr", $statusArr);
		$this->view->assign("memberArr", $memberArr);
		$this->view->assign("total_cnt", count($memberArr));

		$this->view->assign("submit_msg", $msg);


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("member-apply.tpl");
		return;


    }


	/**
	 * Web履歴詳細
	 */
	public function detailAction() {


		$commonDao=new CommonDao();
		$memberDao=new MemberDAO();

		// ログイン中のManagerを取得
		$login_manager = $this->getManagerSession();
		$company_id=$login_manager[company_id];
		$apply_no=makeGetRequest($_GET[apn]);

		//応募番号があっているか
		$tmp=$commonDao->get_data_tbl("member_apply",array(apply_no,company_id),array($apply_no,$company_id));
		if(!$tmp){

			//エラー
			// HTTPヘッダ情報出力
			$this->outHttpResponseHeader();
			$this->setTemplatePath("member-apply_err.tpl");
			return;
		}
		else{

			//初めての閲覧の場合は、apply_statusを選考中に変更
			if($tmp[0][apply_status]==0){

				$commonDao->updateData("member_apply", "apply_status", 1, array(apply_no,company_id),array($apply_no,$company_id));

			}



			//応募企業情報
			//応募した求人NO　job_no
			//応募した雇用形態 employ_id
			for($i=0;$i<count($tmp);$i++){

				$job_no=$tmp[$i][job_no];
				$employ_id=$tmp[$i][employ_id];

				$ret=$commonDao->get_data_tbl("job_offer","job_no",$job_no);
				$job_result[$i][pr]=$ret[0][pr];
				$ret=$commonDao->get_data_tbl("mst_employ","id",$employ_id);
				$job_result[$i][name]=$ret[0][name];

			}
			$this->view->assign("job_result", $job_result);

		}

		$extData=CommonChkArray::$memberExtCheckData;
		$historyData=CommonChkArray::$memberHistoryCheckData;
		$baseData=CommonChkArray::$memberLoginBaseCheckData;

		$tmp=$commonDao->get_data_tbl("member_apply_person","apply_no",$apply_no);


				//プロフィール
				$tmp=$commonDao->get_data_tbl("member","member_id",$tmp[0][member_id]);
				$input_data=$tmp[0];


				//属性情報
				$tmp=$commonDao->get_data_tbl("member_ext_attrs","data_type",$apply_no);
				for($i=0;$i<count($tmp);$i++){
						$input_data[$tmp[$i][attr_key]]=$tmp[$i][attr_value1];
				}
				//職務経歴
				$tmp=$commonDao->get_data_tbl("member_job_tbl","apply_no",$apply_no);
				for($i=0;$i<count($tmp);$i++){
					foreach($historyData[dbstring] as $key=>$val){
						$input_data[job][$i][$key]=$tmp[$i][$key];
					}
				}

				//------ スキルシート -------
				//keyが中カテゴリのid で 値が実績スキル
				//中カテまでのスキル
				$tmp=$commonDao->get_data_tbl("member_skill_tbl",array("apply_no","s_id"),array($apply_no,"0"));
				for($i=0;$i<count($tmp);$i++){
					if($tmp[$i][exp_flg]!=0)
						$skill[skill][$tmp[$i][m_id]]=$tmp[$i][exp_flg];
				}
				//小カテまでのスキルと補足
				$tmp=$commonDao->get_data_tbl("member_skill_tbl",array("apply_no","exp_flg"),array($apply_no,"0"));
				for($i=0;$i<count($tmp);$i++){
					if($tmp[$i][s_id]==0){
						$skill[skill_comment]=$tmp[$i][comment];
					}
					else{
						$sss=$commonDao->get_data_tbl("mst_skill","id",$tmp[$i][s_id]);
						$skill[chk_skill][$sss[0][parentid]][$i]=$tmp[$i][s_id];//keyが中カテゴリのid で 値が実績スキル
					}
				}
//				$_SESSION[SKILL]=$skill;

				//スキルシート
				if($skill){

					//skillのkeyから　大カテが同じものを配列にする(スキル登録がradioボタンの項目）
					if($skill[skill]){
						foreach($skill[skill] as $key=>$val){

							//$key(中カテ）からデータ取得
							if($val>0){
								$tmp=$commonDao->get_data_tbl("mst_skill","id",$key);
								$pid=$tmp[0][parentid];//大カテ
								$btmp=$commonDao->get_data_tbl("mst_skill","id",$pid);//小カテ
								$skArr[$pid][name][$key]=$tmp[0][name];
								$skArr[$pid][skill][$key]=$skillArr[$val];

								$skArr[$pid][b_name]=$btmp[0][name];
							}
						}
					}
					//chk_skillのkeyから　大カテが同じものを配列にする(スキル登録がチェックボックスの項目）
					if($skill[chk_skill]){
						foreach($skill[chk_skill] as $key=>$val){//$keyは大カテゴリのID
								$btmp=$commonDao->get_data_tbl("mst_skill","id",$key);//小カテ

							foreach($skill[chk_skill][$key] as $key2=>$item){
								$stmp=$commonDao->get_data_tbl("mst_skill","id",$item);//小カテ
								$skArr[$key][name][$key2]=$stmp[0][name];
								$skArr[$key][b_name]=$btmp[0][name];
							}
						}
					}
					$input_data[skill_comment]=$skill[skill_comment];
				}

				//職務経歴　職種、雇用の日本語化
				if($input_data[job]){
					foreach($input_data[job] as $key=>$item){
						//職務経歴　職種
						$tmp=$commonDao->get_data_tbl("mst_exp","id",$item[exp_id]);
						$input_data[job][$key][exp_str]=$tmp[0][name];

						//雇用
						$tmp=$commonDao->get_data_tbl("mst_employ","id",$item[employ_id]);
						$input_data[job][$key][employ_str]=$tmp[0][name];
					}
				}

				//最終学歴
				$input_data[last_flg_str]=$lastEduArr[$input_data[last_flg]];

				//県名
				$input_data[pref_str]=$prefArr[$input_data[pref]];

				//タグ無効化処理
				$input_data=makeGetRequest($input_data);

				$this->view->assign("skArr", $skArr);
				$this->view->assign("input_data", $input_data);



		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("member-apply_detail.tpl");
		return;


    }

	public function subAction() {


		// ログイン中のManagerを取得
		$login_manager = $this->getManagerSession();
		$company_id=$login_manager[company_id];

		$commonDao=new CommonDao();
		$memberDao=new MemberDAO();

		$apply_no=$_REQUEST[apply_no];

		if($_POST){

			$employ_id=$_POST[employ_id];//採用とする雇用
			$commonDao->updateData("member_apply", "apply_status","2", array("apply_no","employ_id","company_id"), array($apply_no, $employ_id,$company_id));

			$tmp=$employArr=$commonDao->get_data_tbl("mst_employ","id",$employ_id);
			$this->view->assign("employ_str", $tmp[0][name]);

			//メール送信
			$this->view->assign("login_manager", $login_manager);
			$subject = "[" . STR_SITE_TITLE . "]掲載企業から内定者がでました！";
			$mailBody = $this->view->fetch("mail/decide_admin.tpl");
			send_mail(SITE_ADMIN_EMAIL, MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

		}
		else{

			$memArr=$commonDao->get_data_tbl("member_apply","apply_no",$apply_no);
			for($i=0;$i<count($memArr);$i++){
				$tmp=$employArr=$commonDao->get_data_tbl("mst_employ","id",$memArr[$i][employ_id]);
				$applyArr[$memArr[$i][employ_id]]=$tmp[0][name];
			}

			//デフォルト
			$input_data[employ_id]=$memArr[0][employ_id];

			$this->view->assign("input_data", $input_data);
			$this->view->assign("applyArr", $applyArr);
			$this->view->assign("apply_no", $apply_no);

		}


		// HTTPヘッダ情報出力
		$this->outHttpResponseHeader();

		$this->setTemplatePath("member-apply_sub.tpl");
		return;

	}

}
?>
