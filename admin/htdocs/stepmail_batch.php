<?php

/*
 * ステップメール
 *
 * 10分毎起動でチェック＆メール送信
 *
 *
 *　日:1
 *  時間:2
 *  分:3
 *
 *　前:1
 *　後:2
 *
 *　最終来店:1
 *　コース購入:2
 *　予約日:3
 *　コース使用制限:4
 *
 *
 */
require_once("../require.php");
require_once sprintf("%s/dao/CommonDao.class.php", MODEL_PATH);
require_once sprintf("%s/dao/MemberDao.class.php", MODEL_PATH);

$commonDao = new CommonDao();

//ステップメール 配信するを取得

//分ごとのメール種類
$fi['mail_flg']=1;
$fi['step_time']=3;
$mArr=$commonDao->get_data_tbl2("mst_step_mail",$fi);
stepSendMail($mArr);



//時間ごと
$fi=array();
$fi['mail_flg']=1;
$fi['step_time']=2;
$hArr=$commonDao->get_data_tbl2("mst_step_mail",$fi);
stepSendMail($hArr);



// $fi=array();
// $fi['mail_flg']=1;
// $fi['step_time']=1;
// $dArr=$commonDao->get_data_tbl2("mst_step_mail",$fi);
// stepSendMail($dArr);

/*
 * ステップメール送信
 *
 * 1:最終来店はmember_reserve_detail で visit_flg=1(来店済み） のreserve_date 日付（予約日）
 * 2:コース購入 member_buy の　 insert_date　を見る
 * 3:予約日member_reserve_detail で visit_flg<>99(キャンセル以外） のreserve_date日付（予約日）
 * 4:購入コース利用期限 member_buyのlimit_date
 *
 *
 */
function stepSendMail($arr){

	$commonDao = new CommonDao();

$tdy=date("Y-m-d");
$yy=date("Y");
$mm=date("m");
$dd=date("d");
$hh=date("H");
$ii=date("i");
$ss=date("s");

	for($i=0;$i<count($arr);$i++){

		//該当データ取得条件を作る

		//前後1:前 2:後
		$sw=$arr[$i]['step_when'];

		//長さ
		$step_long=$arr[$i]['step_long'];

		if($arr[$i]['step_time']==2){//時間
			if($sw==1){//前
				$chkdttime=date("Y-m-d H:i:s", mktime($hh+$step_long,$ii,$ss,$mm,$dd,$yy));
				$chkdt=date("Y-m-d", mktime($hh+$step_long,$ii,$ss,$mm,$dd,$yy));
				$chktime=date("H:i:s", mktime($hh+$step_long,$ii,$ss,$mm,$dd,$yy));
				$chktime2=date("H:i", mktime($hh+$step_long,$ii,$ss,$mm,$dd,$yy));
				$chktime2plus=date("H:i", mktime($hh+$step_long,$ii+10,$ss,$mm,$dd,$yy));

			}
			else{//後ろ
				$chkdttime=date("Y-m-d H:i:s", mktime($hh-$step_long,$ii,$ss,$mm,$dd,$yy));
				$chkdt=date("Y-m-d", mktime($hh-$step_long,$ii,$ss,$mm,$dd,$yy));
				$chktime=date("H:i:s", mktime($hh-$step_long,$ii,$ss,$mm,$dd,$yy));
				$chktime2=date("H:i", mktime($hh-$step_long,$ii,$ss,$mm,$dd,$yy));
				$chktime2plus=date("H:i", mktime($hh-$step_long,$ii+10,$ss,$mm,$dd,$yy));

			}
		}
		else if($arr[$i]['step_time']==3){//分
			if($sw==1){
				$chkdttime=date("Y-m-d H:i:s", mktime($hh,$ii+$step_long,$ss,$mm,$dd,$yy));
				$chkdt=date("Y-m-d", mktime($hh,$ii+$step_long,$ss,$mm,$dd,$yy));
				$chktime=date("H:i:s", mktime($hh,$ii+$step_long,$ss,$mm,$dd,$yy));
				$chktime2=date("H:i", mktime($hh,$ii+$step_long,$ss,$mm,$dd,$yy));
				$chktime2plus=date("H:i", mktime($hh,$ii+$step_long+10,$ss,$mm,$dd,$yy));//指定の日時からプラス10分後の時間

			}
			else{
				$chkdttime=date("Y-m-d H:i:s", mktime($hh,$ii-$step_long,$ss,$mm,$dd,$yy));
				$chkdt=date("Y-m-d", mktime($hh,$ii-$step_long,$ss,$mm,$dd,$yy));
				$chktime=date("H:i:s", mktime($hh,$ii-$step_long,$ss,$mm,$dd,$yy));
				$chktime2=date("H:i", mktime($hh,$ii-$step_long,$ss,$mm,$dd,$yy));
				$chktime2plus=date("H:i", mktime($hh,$ii-$step_long+10,$ss,$mm,$dd,$yy));

			}
		}

		if($arr[$i]['step_kind']==1){//最終来店
			$sql="select * from member_reserve_detail where visit_flg=1 and reserve_date ='".$chkdt."'";

		}
		else if($arr[$i]['step_kind']==2){//コース購入
			$sql="select * from member_buy where insert_date between '".$chkdt." 00-00-00' and '".$chkdt." 23-59-59'";


		}
		else if($arr[$i]['step_kind']==3){//予約日
			if($arr[$i]['step_time']==2 || $arr[$i]['step_time']==3){//時間　分　start_timeもチェック対象
				if($sw==1){
					$sql="select * from member_reserve_detail where visit_flg<>99 and reserve_date ='".$chkdt."' and
							start_time between '".$chktime2."' and '".$chktime2plus."'";
				}
				else{
					$sql="select * from member_reserve_detail where visit_flg<>99 and reserve_date ='".$chkdt."' and
							end_time between '".$chktime2."' and '".$chktime2plus."'";

				}
			}
			else{
				$sql="select * from member_reserve_detail where visit_flg<>99 and reserve_date ='".$chkdt."'";

			}
		}
		else if($arr[$i]['step_kind']==4){//購入コース利用期限

			if($sw==1){//前
				$sql="select * from member_buy where finish_flg=0 and limit_date ='".$chkdt."'";

			}
			else{//後
				$sql="select * from member_buy where finish_flg=2 and limit_date ='".$chkdt."'";

			}

		}

		echo $sql;
		echo "<br />";


		$sqltmp=$commonDao->get_sql($sql);

		for($j=0;$j<count($sqltmp);$j++){

			$member_id=$sqltmp[$j]['member_id'];

			$memArr=$commonDao->get_data_tbl("member","member_id",$member_id);

			//テンプレート
			$template_no=$arr[$i]['template_no'];
			$tmp=$commonDao->get_data_tbl("mail_template","template_no",$template_no);
			$template_mail_text=$tmp[0]['mail_text']."\n\n";
			$subject=$tmp[0]['subject'];

			//署名
			$tmp=$commonDao->get_data_tbl("mail_sig");
			$sigArr=$tmp[0];

			$mailBody=$template_mail_text.$sigArr['sig'];

			
			// send_mail($memArr[0]['email'], MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody,"",RETURN_EMAIL);
			// send_mail("ksuzuki@apice-tec.co.jp", MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody,"",RETURN_EMAIL);


			//send_mail("arafat@mailinator.com", MAIL_FROM, MAIL_FROM_NAME, $subject, $mailBody);

		}


//print_r_with_pre($tmp);



	}



}


?>
