<?php
class ReserveDAO extends DAOBase {


	/**
	 * 登録
	 * @param $fi:フィールド名配列  	// Field name array
	 *        $dt:値配列 				//Value array
	 *        $item:フォームデータ		//Form data
	 * @return int 直近の挿入行ID 		//The latest inserted row ID
	 */
	public function InsertItemData($fi,$dt,$item,$end_time) {
		if(is_array($fi)){
	           	for ($i=0;$i<count($fi);$i++){
			    	$tmp1[]=$fi[$i];
					$va=trim($dt[$i]);
					$tmp2[]="'".htmlspecialchars($va, ENT_QUOTES)."'";

		    	}
		}else if($fi){
		    	$tmp1[]=$fi;
			$dt=trim($dt);
			$dt=htmlspecialchars(addslashes($dt));
			$tmp2[]="'".$dt."'";
		}
		$ins=implode(",",$tmp1);
		$valu=implode(",",$tmp2);

		$sql="insert into member_reserve($ins) values($valu)";

		$this->db->beginTransaction();
		try {

			// 実行
			$this->executeUpdate($sql);
			// 直近の挿入行IDを取得
			$lastInsertId = $this->db->lastInsertId();

			$baseData=CommonChkArray::$rsvDetailAdminCheckData;
			$baseData2=CommonChkArray::$rsvDetail2AdminCheckData;

			if($item['start_time']){
				$start_time=$item['start_time'];
			}
			else{
				$start_time=$item['hour'].":".$item['minute'];
			}

			//予約人数分の予約を入れる
			for($i=0;$i<$item['number'];$i++){


				for($j=0;$j<$item['use_count'];$j++){
					$dkey=array();
					$dval=array();

					if($i==0){//お申込者
						foreach($baseData['dbstring'] as $key=>$val){
							$dkey[]=$key;
							@$dval[]="'".htmlspecialchars(trim($item[$key]), ENT_QUOTES)."'";
						}
					}
					else{//お連れ様
						foreach($baseData2['dbstring'] as $key=>$val){
							$dkey[]=$key;
							$dval[]="'".htmlspecialchars(trim($item[$key]), ENT_QUOTES)."'";
						}
					}
					

					if($j==0){
						$dkey[]="reserve_no";
						$dval[]=$lastInsertId;
					}
					else{
						$dkey[]="p_no";
						$dval[]=$detaillastInsertId;
					}
					// $dkey[]="buy_no";
					// $dval[]="'".$item['buy_no']."'";
					$dkey[]="start_time";
					$dval[]="'".$start_time."'";
					$dkey[]="end_time";
					$dval[]="'".$end_time."'";
					$dkey[]="insert_date";
					$dval[]="'".date("Y-m-d H::i:s")."'";
					$dkey[]="update_date";
					$dval[]="'".date("Y-m-d H::i:s")."'";
					// echo "<pre>"; print_r($dkey);print_r($dval);exit();
					$ins=implode(",",$dkey);
					$valu=implode(",",$dval);

					$sql="insert into member_reserve_detail($ins) values($valu)";

					// 実行
					$this->executeUpdate($sql);
					if($j==0){
						$detaillastInsertId = $this->db->lastInsertId();
					}

				}

			}


			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'member_reserve'." . $e);
			$this->db->rollBack();
			return false;
		}

		return $lastInsertId;

	}
	/**
	 * 会員 更新処理
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 *        $item:フォームデータ
	 * @return
	 */
	public function upItemData($fi,$dt,$wfi,$wdt,$item="") {
		
		if(is_array($fi)){
	           	for ($i=0;$i<count($fi);$i++){
					$va=trim($dt[$i]);
					$tmp1[]=$fi[$i]."='".htmlspecialchars($va, ENT_QUOTES)."'";
		    	}
		}else if($fi){
			$dt=trim($dt);
			$dt=htmlspecialchars(addslashes($dt));
			$tmp1[]=$fi."='".$dt."'";
		}

		$ins=implode(",",$tmp1);

		if(is_array($wfi)){
		    $tmp=array();
	            for ($i=0;$i<count($wfi);$i++){
		    	$tmp[]=$wfi[$i]."='".addslashes($wdt[$i])."'";
		    }
		    $where=" where ".implode(" and ",$tmp);
		}else if($wfi){
			$where=" where ".$wfi."='".addslashes($wdt)."'";
		}

		$sql="update member_reserve set $ins $where";

		$this->db->beginTransaction();
		try {
			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'member_reserve'." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

	}

		/**
	 * 検索 件数
	 * @param $search:検索条件
	 * @return 検索結果
	 */
	public function searchCount($search="") {
		list($where,$tbl)=$this->makeSearch($search);

		$sql="select distinct r.* from member_reserve as r,member_reserve_detail as d, member as m
		where r.reserve_no=d.reserve_no and r.member_id=m.member_id and m.member_id=d.member_id ".$where;
		$tmp=$this->executeQuery($sql);
		// echo $sql;exit();

		return count($tmp);

	}

	public function makeSearch($search) {
		//------- 検索条件 --------------------
		$where="";
		$tbl="";
		//
		if(isset($search["shop_no"]) && $search["shop_no"] != ''){
			$whTmp[]="d.shop_no =".addslashes($search["shop_no"]);
		}
		if(isset($search["reserve_no"]) && $search["reserve_no"] != null){
			$whTmp[]="r.reserve_no = '".addslashes($search["reserve_no"])."'";
		}
		if(isset($search["d_reserve_no"]) && $search["d_reserve_no"] != null){
			$whTmp[]="d.reserve_no like '%".addslashes($search["d_reserve_no"])."%'";
		}
		if(isset($search["reserve_date"]) && $search["reserve_date"] != null){
			$whTmp[]="d.reserve_date ='".addslashes($search["reserve_date"])."'";
		}
		if(isset($search["start_time"]) && $search["start_time"] != null){
			$whTmp[]="d.start_time ='".addslashes($search["start_time"])."'";
		}
		if(isset($search["visit_flg_parts"])){
			$whTmp[]="(d.visit_flg ='0' or d.visit_flg ='1' or d.visit_flg ='2')";
		}

		//担当者名
		if(isset($search["name"]) && $search["name"] != null){
			$keyTmp=array();
			$keyTmp[]="concat(m.name,m.name_kana) like '%".addslashes($search["name"])."%'";
			$keyTmp[]="m.name_kana like '%".addslashes($search["name"])."%'";

			$whTmp[]="(".implode(" or ",$keyTmp).")";
		}

		
		//メニュー
		if(isset($search["menu_no"]) && $search["menu_no"] != null){
			$whTmp[]="d.menu_no ='".addslashes($search["menu_no"])."'";
		}

		//予約日
		if(isset($search["b_year"]) && $search["b_year"] != null){
			$whTmpTmp[]=addslashes($search["b_year"]);
		}
		if(isset($search["b_month"]) && $search["b_month"] != null){
			$whTmpTmp[]=sprintf("%02d",addslashes($search["b_month"]));
		}
		if(isset($search["b_day"]) && $search["b_day"] != null){
			$whTmpTmp[]=sprintf("%02d",addslashes($search["b_day"]));
		}
		if(isset($whTmpTmp)){
			$whTmp[]="reserve_date like '%".implode("-",$whTmpTmp)."%'"; 
		}

		if(isset($search["start_date"], $search["end_date"]) && $search["start_date"] != null){
			$whTmp[]="reserve_date between '".$search["start_date"]."' and '".$search["end_date"]."'";

		}
		else if(isset($search["start_date"]) && $search["start_date"] != null){
			$whTmp[]="reserve_date ='".$search["start_date"]."'";
		}
		else if(isset($search["end_date"]) && $search["end_date"] != null){
			$whTmp[]="reserve_date ='".$search["end_date"]."'";
		}

		//予約を登録した日
		if(isset($search["r_start_date"] , $search["r_end_date"]) && $search["r_start_date"] != null){
			$whTmp[]="d.insert_date between '".$search["r_start_date"]." 00-00-00' and '".$search["r_end_date"]." 23:59:59'";

		}
		else if(isset($search["r_start_date"]) && $search["r_start_date"] != null){
			$whTmp[]="d.insert_date ='".$search["r_start_date"]."'";
		}
		else if(isset($search["r_end_date"]) && $search["r_end_date"] != null){
			$whTmp[]="d.insert_date ='".$search["r_end_date"]."'";
		}






		//登録日
		if(isset($search["ins_start"], $search["ins_end"]) && $search["ins_start"] != null){
			$whTmp[]="r.insert_date between '".str_replace("/","-",$search["ins_start"])." 00-00-00' and '".str_replace("/","-",$search["ins_end"])." 23:59:59'";

		}
		else if(isset($search["ins_start"]) && $search["ins_start"] != null){
			$whTmp[]="r.insert_date like '".str_replace("/","-",$search["ins_start"])."%'";
		}
		else if(isset($search["ins_end"]) && $search["ins_start"] != null){
			$whTmp[]="r.insert_date like '".str_replace("/","-",$search["ins_end"])."%'";
		}

		//ユーザー側からの予約
		if(isset($search["regist_flg"]) && $search["regist_flg"] != null){
			$whTmp[]="regist_flg ='".addslashes($search["regist_flg"])."'";
		}


		if(isset($whTmp)){
			$where=" and ".implode(" and ",$whTmp);
		}
		if(isset($tblTmp)){
			$tbl=" , ".implode(" , ",$tblTmp);
		}

		// echo "<pre>";print_r($where);exit();
		return array($where,$tbl);

	}

	/**
	 * 会員検索
	 * @param $search:検索条件
	 * @return 検索結果
	 */
	public function search($search="",$orderby="",$limit="") {
		$desc = 'DESC';
		$ord = '';
	  // echo "<pre>";	print_r($search);exit();
		list($where,$tbl)=$this->makeSearch($search);
		//ソート
		if($orderby<>""){
			if(is_array($orderby)){
		            for ($i=0;$i<count($orderby);$i++){
			    	$tmpo[]=$orderby[$i];
			    }

			    $ord="order by ".implode(",",$tmpo);

			}else{
				$ord=" order by $orderby";
			}
		}

		//リミット
		if (!$limit) {
			$limit_str = "";
		} else {
			 if(!$search["page"]) $search["page"]=1;
			 $limits = (int)$limit;
			 $offset = ((int)$search["page"]  - 1) * $limit;
			 $limit_str = " LIMIT {$limits} OFFSET {$offset} ";
		}

		$sql="select distinct m.*,r.*,d.reserve_date,d.start_time,d.end_time,d.shop_no as shop,d.menu_no,d.buy_no
			from member_reserve as r,member_reserve_detail as d, member as m
			where r.reserve_no=d.reserve_no and r.member_id=m.member_id and m.member_id=d.member_id ".$where.$ord.$limit_str;
// echo $sql;exit();
		$prodArr=$this->executeQuery($sql);
 		return array($prodArr,$limits,$offset);

	}

	/**
	 * 検索
	 * @param $search:検索条件
	 * @return 検索結果
	 *
	 *
	 * 予約状況に会員番号が無い予約も取得する為
	 *
	 */
	public function search2($search="",$orderby="",$limit="") {
		$desc = '';

		list($where,$tbl)=$this->makeSearch($search);

		//ソート
		if($orderby<>""){
			if(is_array($orderby)){
		            for ($i=0;$i<count($orderby);$i++){
			    	$tmpo[]=$orderby[$i];
			    }

			    $ord="order by ".implode(",",$tmpo);

			}else{
				$ord=" order by $orderby $desc";
			}
		}

		//リミット
		if (!$limit) {
			$limit_str = "";
		} else {
			 if(!$search["page"]) $search["page"]=1;
			 $limit = (int)$limit;
			 $offset = ((int)$search["page"]  - 1) * $limit;
			 $limit_str = " LIMIT {$limit} OFFSET {$offset} ";
		}

//		$sql="select distinct m.*,r.*,d.reserve_date,d.start_time,d.end_time,d.shop_no,d.menu_no,d.buy_no
//			from member_reserve as r,member_reserve_detail as d, member as m
//			where r.reserve_no=d.reserve_no and r.member_id=m.member_id and m.member_id=d.member_id ".$where.$ord.$limit_str;


		$sql="select d.*,m.name,m.name_kana,s.name as shop_name from (member_reserve_detail as d left join member as m on m.member_id=d.member_id),shop as s where s.shop_no=d.shop_no and d.p_no=0 ".$where;

//echo  $sql;
//echo "<br />";

		$prodArr=$this->executeQuery($sql);

		return $prodArr;

	}


	/**
	 * 検索
	 * @param $search:検索条件
	 * @return 検索結果
	 *
	 *
	 * 予約カレンダー用検索スペシャル
	 *
	 */
	public function search3($search="",$lastEndTime="", $orderby="",$limit="",$offset="") {

		$desc = null;
		list($where,$tbl)=$this->makeSearch($search);
		//ソート
		if($orderby<>""){
			if(is_array($orderby)){
		            for ($i=0;$i<count($orderby);$i++){
			    	$tmpo[]=$orderby[$i];
			    }
			    $ord="order by ".implode(",",$tmpo);
			}else{
				$ord=" order by $orderby $desc";
			}
		}

		//リミット
		if (!$limit) {
			$limit_str = "";
		} else {
			 if(!isset($search["page"])) $search["page"]=1;
			 $limit = (int)$limit;
			 $offset = (int)$offset;
			 $limit_str = " LIMIT {$limit} OFFSET {$offset} ";
		}


		//
		$startWh="";
		if($lastEndTime!=""){
			$startWh=" and start_time >='".$lastEndTime."'";
		}
// echo $startWh.$where.$limit_str."<br><br>";

		$sql="select d.*,m.name,m.name_kana,s.name as shop_name
			from (member_reserve_detail as d left join member as m on m.member_id=d.member_id),shop as s
			where s.shop_no=d.shop_no and d.p_no=0 ".$startWh.$where.$limit_str;




		// $sql="select d.*,m.name,m.name_kana,s.name as shop_name
		// from (member_reserve_detail as d left join member as m on m.member_id=d.member_id),shop as s
		// where s.shop_no=d.shop_no and d.p_no=0 and d.shop_no =2 and d.reserve_date ='2017-03-14' and d.start_time ='10:00' and (d.visit_flg ='0' or d.visit_flg ='1')LIMIT 1 OFFSET 0";

// echo  $sql;
// echo "<br />";

		$prodArr=$this->executeQuery($sql);

		return $prodArr;

	}

	//予約数
	/**
	 *  予約希望時間からその時間帯にかかっている予約の数を取得する
	 * @param $ins:検索配列
	 *
	 * @return
	 */
	public function getReserveCount($ins,$shop_booth_cnt) {

		$ck=explode("-",$ins['reserve_date']);//check for date format if - or /
		if (count($ck)>1) {
			$dt = explode("-",$ins['reserve_date']);
		}
		else{
			$dt = explode("/",$ins['reserve_date']);
		}

		$stm=explode(":",$ins['start_time']);//予約時間をばらす
		$etm=explode(":",$ins['end_time']);//予約時間をばらす
		
/*
		//最初に開始時刻でチェック <=  < 等の関係で境界時間の場合に正確にチェック出来ないので、分けて考える
		$kari_end=date("H:i",mktime($stm[0],$stm[1]+15,0,$dt[1],$dt[2],$dt[0]));

		$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_date='".$ins[reserve_date]."' and
				(`end_time` > '".$ins[start_time]."' and `start_time` <'".$kari_end."')";

			$tmp=$this->executeQuery($sql);

			if($shop_booth_cnt<count($tmp)+$ins[number]){
				return false;
			}


		//終了時刻でチェック <=  < 等の関係で境界時間の場合に正確にチェック出来ないので、分けて考える
		$kari_end=date("H:i",mktime($etm[0],$etm[1]-15,0,$dt[1],$dt[2],$dt[0]));

		$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_date='".$ins[reserve_date]."' and
				(`end_time` > '".$kari_end."' and `start_time` <'".$ins[start_time]."')";

			$tmp=$this->executeQuery($sql);

			if($shop_booth_cnt<count($tmp)+$ins[number]){
				return false;
			}
*/




		for($i=1;$i<=12;$i++){
			$plus=15*$i;
			$plus2=$plus+15;
			$kari_start=date("H:i",mktime($stm[0],$stm[1]+$plus,0,$dt[1],$dt[2],$dt[0]));
			$kari_end=date("H:i",mktime($stm[0],$stm[1]+$plus,0,$dt[1],$dt[2],$dt[0]));

			if($kari_start>$ins['end_time']){
				return true;
				break;
			}

			$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins['shop_no']." and reserve_date='".$ins['reserve_date']."' and
				(`end_time` >= '".$kari_start."' and `start_time` <'".$kari_end."')";

			$tmp=$this->executeQuery($sql);

// echo $sql;
// echo "<br />";
// echo $shop_booth_cnt;
// echo count($tmp);
// echo $ins['number'];
// exit;

 
			if($shop_booth_cnt<count($tmp)+$ins['number']){
				return false;
			}


		}

		return true;


/*
		if($flg=="start"){
			$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_date='".$ins[reserve_date]."' and
				((`start_time` >= '".$ins[start_time]."' and `start_time` <'".$ins['end_time']."'))";

		}
		else if($flg=="end"){
			$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_date='".$ins[reserve_date]."' and
				((`end_time`  > '".$ins[start_time]."' and `end_time`  <='".$ins['end_time']."'))";

		}
*/

//		$sql="SELECT * FROM `member_reserve_detail` WHERE
//			visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_date='".$ins[reserve_date]."' and
//			((`start_time` >= '".$ins[start_time]."' and `start_time` <'".$ins['end_time']."') or
//			(`end_time`  > '".$ins[start_time]."' and `end_time`  <='".$ins['end_time']."'))";

//echo $sql;
//echo "<br />";

//		$tmp=$this->executeQuery($sql);

//		return count($tmp);

	}


	//予約数
	/**
	 *
	 *  自分の予約番号以外の
	 *  予約希望時間からその時間帯にかかっている予約の数を取得する
	 * @param $ins:検索配列
	 *
	 * @return
	 */
	public function getReserveExistCount($ins,$shop_booth_cnt) {


		$dt=explode("/",$ins['reserve_date']);//予約日をばらす
		$stm=explode(":",$ins['start_time']);//予約時間をばらす


		//最初に開始時刻でチェック <=  < 等の関係で境界時間の場合に正確にチェック出来ないので、分けて考える




		//終了時刻でチェック <=  < 等の関係で境界時間の場合に正確にチェック出来ないので、分けて考える


		for($i=1;$i<=12;$i++){
			$plus=15*$i;
			$plus2=$plus+15;
			@$kari_start=date("H:i",mktime($stm[0],$stm[1]+$plus,0,$dt[1],$dt[2],$dt[0]));
			@$kari_end=date("H:i",mktime($stm[0],$stm[1]+$plus,0,$dt[1],$dt[2],$dt[0]));
			if($kari_start>$ins['end_time']){
				return true;
				break;
			}

			$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins['shop_no']." and reserve_no<>".$ins['reserve_no']." and reserve_date='".$ins['reserve_date']."' and
				(`end_time` >= '".$kari_start."' and `start_time` <'".$kari_end."')";

			$tmp=$this->executeQuery($sql);
			if($shop_booth_cnt<count($tmp)+$ins['number']){
				return false;
			}


		}

		return true;



/*
		if($flg=="start"){
			$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_no<>".$ins[reserve_no]." and reserve_date='".$ins[reserve_date]."' and
				((`start_time` >= '".$ins[start_time]."' and `start_time` <'".$ins['end_time']."'))";
		}
		else if($flg=="end"){
			$sql="SELECT * FROM `member_reserve_detail` WHERE
				visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_no<>".$ins[reserve_no]." and reserve_date='".$ins[reserve_date]."' and
				((`end_time`  > '".$ins[start_time]."' and `end_time`  <='".$ins['end_time']."'))";

		}

*/

//		$sql="SELECT * FROM `member_reserve_detail` WHERE
//			visit_flg<>99 and reserve_no>0 and shop_no=".$ins[shop_no]." and reserve_no<>".$ins[reserve_no]." and reserve_date='".$ins[reserve_date]."' and
//			((`start_time` >= '".$ins[start_time]."' and `start_time` <'".$ins['end_time']."') or
//			(`end_time`  > '".$ins[start_time]."' and `end_time`  <='".$ins['end_time']."'))";

//echo $sql;
//echo "<br />";

//		$tmp=$this->executeQuery($sql);

//		return count($tmp);

	}

	//calendarで使用
	public function getReserveCount2($ins) {

		$sql="SELECT * FROM `member_reserve_detail` WHERE
			visit_flg<>99 and shop_no=".$ins['shop_no']." and reserve_date='".$ins['reserve_date']."' and reserve_no>0 and
			(`start_time`< '".$ins['start_time']."' and `end_time` > '".$ins['start_time']."')";

		$tmp=$this->executeQuery($sql);

		return count($tmp);

	}

	//ゆーざー側　予約状況確認で使用 未使用
	public function getReserveCount3($ins) {

		$sql="SELECT * FROM `member_reserve_detail` WHERE
			visit_flg<>99 and shop_no=".$ins['shop_no']." and reserve_date='".$ins['reserve_date']."' and reserve_no>0 and
			(`start_time`<= '".$ins['start_time']."' and `end_time` > '".$ins['start_time']."')";

		$tmp=$this->executeQuery($sql);

		return count($tmp);

	}




	/**
	 *  予約数取得 TOP集計用
	 * @param $ins:検索配列
	 *
	 * @return
	 */
	public function getTotalReserveCount($ins) {


		if($ins['shop_no']){
			$ftmp[]="shop_no=".addslashes($ins['shop_no']);
		}
		if($ins['reserve_date']){
			$ftmp[]="reserve_date like '%".addslashes($ins['reserve_date'])."%'";
		}

		if($ftmp){
			$where=implode(" and ", $ftmp);
		}

		$sql="SELECT * FROM `member_reserve_detail` WHERE visit_flg<>99 and reserve_no>0 and $where";
		$tmp=$this->executeQuery($sql);

		return count($tmp);

	}


	//予約詳細取得
	/**
	 *
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 * @return
	 */
	public function getDetailInfo($no) {

		$commonDao=new CommonDao();

		$tmp=$commonDao->get_data_tbl("member_reserve_detail","no",$no);
		$arr=$tmp[0];

		//申し込み人数
		$tmp=$commonDao->get_data_tbl("member_reserve","reserve_no",$tmp[0]['reserve_no']);
		$arr['number']=$tmp[0]['number'];
		$arr['reserve_comment']=$tmp[0]['comment'];
		$arr['reserve_kanri_comment']=$tmp[0]['kanri_comment'];


		//メニュー名、店舗名、コース名の取得
		if($arr['menu_no']){
			$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$arr['menu_no']);
			$arr['menu_name']=$tmp[0]['name'];
			$arr['use_count']=$tmp[0]['use_count'];

			$tmp=$commonDao->get_data_tbl("shop","shop_no",$arr['shop_no']);
			$arr['shop_name']=$tmp[0]['name'];

			$sql="select c.*,b.fee_flg,b.coupon_id,b.buy_no from member_buy as b, mst_course as c where c.course_no=b.course_no and b.buy_no=".$arr['buy_no'];
			// echo $sql;exit();
			$tmp=$commonDao->get_sql($sql);
			if($tmp){
				$arr['course_name']=$tmp[0]['name'];
				$arr['course_no']=$tmp[0]['course_no'];
				$arr['fee_flg']=$tmp[0]['fee_flg'];
				$arr['buy_no']=$tmp[0]['buy_no'];
				//クーポン名
				$tmp=$commonDao->get_data_tbl("mst_category1","id",$tmp[0]['coupon_id']);
				if (count($tmp)>0) {
					$arr['coupon_name']=$tmp[0]['name'];
				}

				//何回目の来店か（予約含んで）
				$sql="select * from member_reserve_detail as d where d.buy_no=".$arr['buy_no']." and visit_flg<>99";
				$tmp=$this->executeQuery($sql);

				$arr['raiten_cnt']=count($tmp);
			}


		}

			

		return $arr;

	}


	/**
	 * 購入済みコースでまだ使用可能なコースを取得する
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 * @return
	 */
/*
 * 不要なので、削除OK
	public function getUseCourseInfo($member_id) {

		$commonDao=new CommonDao();

		$sql="select b.*,c.name from member_buy as b,mst_course as c where b.course_no=c.course_no and b.finish_flg=0 and b.member_id=".$member_id;

		$arr=$commonDao->get_sql($sql);

		return $arr;

	}

*/


	/**
	 * 予約のキャンセル
	 * @param $no:予約詳細番号
	 * @return
	 *
	 *
	 */
	public function cancelUpData($no) {


		$this->db->beginTransaction();
		try {

			$sql="update member_reserve_detail set visit_flg=99 where no=".$no;
			// 実行
			$this->executeUpdate($sql);

			$sql="update member_reserve_detail set visit_flg=99 where p_no=".$no;//2回連続コースを予約した場合にいれてるダミーレコード
			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'member_reserve'." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

	}

	//予約ブロックチェック
	/**
	 * 希望の予約の日が予約ブロック設定の対象になっていないかをチェックする
	 *
	 * @param $search:予約希望情報
	 * @param
	 * @param $chkflg:1=希望の時間がとれなかった場合、前後の時間でチェックを行う場合のフラグ（変数値をちょっと変えないと行けないので）
	 * @return
	 */
	public function chkBlockReserve($search, $chkArr,$chkflg="") {

		$commonDao=new CommonDao();

		//ご希望コースの所要時間
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$search['menu_no']);
		$chkArr['rtimes']=$tmp[0]['times'];//所要時間
		if($chkflg==1){
			$start_time=$search['start_time'];
			$end_time=$search['end_time'];
		}
		else{
			$end_time=date("H:i:s", mktime($chkArr['timeTmp'][0],$chkArr['timeTmp'][1]+$tmp[0]['times'],0,$chkArr['dtTmp'][1],$chkArr['dtTmp'][2],$chkArr['dtTmp'][0]));
			$start_time=$search['reserve_time'];
		}
		//日付期間＋時間でチェック
/*
		$sql="select * from shop_block where kind_flg=1 and shop_no=".$search[shop_no]." and
			(start_date<='".$search[reserve_date]."' and end_date>='".$search[reserve_date]."')";
*/
		$sql="select * from shop_block where kind_flg=1 and shop_no=".$search['shop_no']." and
			((start_date='".$search['reserve_date']."' and start_time<='".$start_time."') or
			 (end_date='".$search['reserve_date']."' and end_time>'".$start_time."') or
			 (start_date<'".$search['reserve_date']."' and end_date>'".$search['reserve_date']."'))";

		$ret=$commonDao->get_sql($sql);
		if($ret){
			return array(false,$ret,1);
		}

		//終了時間がブロック時間帯に入っていないかチェック
		$sql="select * from shop_block where kind_flg=1 and shop_no=".$search['shop_no']." and
			((start_date='".$search['reserve_date']."' and start_time<'".$end_time."') or
			 (end_date='".$search['reserve_date']."' and end_time>'".$end_time."') or
			 (start_date<'".$search['reserve_date']."' and end_date>'".$search['reserve_date']."'))";

		$ret=$commonDao->get_sql($sql);
		if($ret){
			return array(false,$ret,4);
		}


		//日付+時間帯でチェック

		//まずは開始時間がブロック時間帯に入っていないかチェック
		$sql="select * from shop_block where kind_flg=2 and shop_no=".$search['shop_no']." and
			start_date='".$search['reserve_date']."' and (start_time<='".$start_time."' and end_time>'".$start_time."')";
		$ret=$commonDao->get_sql($sql);

		if($ret){
			return array(false,$ret,2);
		}

		//終了時間がブロック時間帯に入っていないかチェック
		$sql="select * from shop_block where kind_flg=2 and shop_no=".$search['shop_no']." and
			start_date='".$search['reserve_date']."' and (start_time <'".$end_time."' and end_time>='".$end_time."')";
		$ret=$commonDao->get_sql($sql);
		if($ret){
			return array(false,$ret,3);
		}


		//※リピートブロック
		$sql="select * from shop_block where kind_flg=3 and shop_no=".$search['shop_no']." and
			start_date<='".$search['reserve_date']."' and end_date>='".$search['reserve_date']."' and (start_time<='".$start_time."' and end_time>'".$start_time."')";

		$ret=$commonDao->get_sql($sql);
		if($ret){
			return array(false,$ret,1);
		}

		//終了時間がブロック時間帯に入っていないかチェック
//		$sql="select * from shop_block where kind_flg=3 and shop_no=".$search[shop_no]." and
//			start_date<='".$search[reserve_date]."' and end_date>='".$search[reserve_date]."' and (start_time<'".$end_time."' and end_time>='".$end_time."')";
		$sql="select * from shop_block where kind_flg=3 and shop_no=".$search['shop_no']." and
			start_date<='".$search['reserve_date']."' and end_date>='".$search['reserve_date']."' and
			((start_time>='".$start_time."' and end_time<='".$end_time."') or (start_time <'".$end_time."' and end_time>='".$end_time."'))";
//		echo $sql."<br />";

		$ret=$commonDao->get_sql($sql);
		if($ret){
			return array(false,$ret,4);
		}


		return array(true,"");

	}

	//削除
	/**
	 * 削除　関連データも全て削除
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 * @return
	 */
	public function delData($company_id) {


	}


	/**
	 * 該当顧客の予約が初めての予約かどうか
	 * @param $member_id:顧客ID
	 *        $reserve_date:予約日
	 * @return
	 */
	public function chkFirstReserve($arr) {

		if($arr['visit_flg']==99){
			return false;
		}

		$sql="select * from member_reserve_detail
				where reserve_no>0 and member_id=".$arr['member_id']." and visit_flg<>99
				and (reserve_date<'".$arr['reserve_date']."'
				or (reserve_date ='".$arr['reserve_date']."' and start_time<'".$arr['start_time']."'))";

		$tmp=$this->executeQuery($sql);
		if($tmp){
			return false;
		}

		return true;

	}

}
?>