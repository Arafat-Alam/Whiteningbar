<?php
class MemberDAO extends DAOBase {

	public function getMemberName($member_id) {
		$commonDao= new CommonDao();
		$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);

		return $tmp[0]['name'];

	}

	/**
	 * 会員登録
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 *        $item:フォームデータ
	 * @return int 直近の挿入行ID
	 */
	public function InsertItemData($fi,$dt,$item=array(),$reserve_item=array()) {

		$commonDao = new CommonDao();

		if(is_array($fi)){
	           	for ($i=0;$i<count($fi);$i++){
			    	$tmp1[]=$fi[$i];
					$va=trim($dt[$i]);
					$tmp2[]="'".htmlspecialchars($va, ENT_QUOTES)."'";

		    	}
		}else if($fi){
		    	$tmp1[]=$fi;
			$dt=trim($dt);
			$dt=htmlspecialchars($dt, ENT_QUOTES);
			$tmp2[]="'".$dt."'";
		}
		$ins=implode(",",$tmp1);
		$valu=implode(",",$tmp2);

		$sql="insert into member($ins) values($valu)";

		$this->db->beginTransaction();
		try {

			// 実行
			$this->executeUpdate($sql);
			// 直近の挿入行IDを取得
			$lastInsertId = $this->db->lastInsertId();
			//------会員NOを登録する ----------
			//選択した店舗
			$member_no=$item['spid']."-".sprintf("%08d", $lastInsertId);
			$sql="update member set member_no='".$member_no."' where member_id=".$lastInsertId;
			$this->executeUpdate($sql);


			//予約アンケート
			if($_SESSION["survey_input_data"]['no']){
				foreach($_SESSION["survey_input_data"]['no'] as $key=>$val){
					$dkey=array();
					$dval=array();
					$dkey[]="komoku_no";
					$dval[]=$key;
					$dkey[]="member_id";
					$dval[]=$lastInsertId;
					$dkey[]="answer";
					$dval[]="'".$val."'";

					$ins=implode(",",$dkey);
					$valu=implode(",",$dval);
					$sql="insert into member_question($ins) values($valu)";

					$this->executeUpdate($sql);

				}
			}



			//予約情報があれば
			//ユーザー側の新規登録時の場合
			if($reserve_item){
				//会員登録時の初回メニューは予約と同時に、未払いのコース購入とする。
				//来店時に支払がされて、購入済みとする。
				//メニューからこーすNoを出す
				$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_item['menu_no']);
				$tmpcourse=$commonDao->get_data_tbl("mst_course","course_no",$tmp[0]['course_no']);
				$dkey=array();
				$dval=array();
				$dkey[]="member_id";
				$dval[]=$lastInsertId;

				$dkey[]="shop_no";
				$dval[]=$reserve_item['shop_no'];

				$dkey[]="course_no";
				$dval[]=$tmp[0]['course_no'];
				$dkey[]="fee";
				$dval[]=$tmpcourse[0]['fee'];
				$dkey[]="total_fee";
				$dval[]=$tmpcourse[0]['fee'];
				$dkey[]="insert_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$dkey[]="update_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$ins=implode(",",$dkey);
				$valu=implode(",",$dval);
				$sql="insert into member_buy($ins) values($valu)";


				$this->executeUpdate($sql);
				$buylastInsertId = $this->db->lastInsertId();


				$dkey=array();
				$dval=array();
				$dkey[]="member_id";
				$dval[]=$lastInsertId;
				$dkey[]="number";
				$dval[]=$reserve_item['number'];
				$dkey[]="insert_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$dkey[]="update_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$ins=implode(",",$dkey);
				$valu=implode(",",$dval);

				$sql="insert into member_reserve($ins) values($valu)";

				$this->executeUpdate($sql);
				$reservelastInsertId = $this->db->lastInsertId();

			}
			//予約人数分の予約を入れる
			for($i=0;$i<$reserve_item['number'];$i++){

				for($j=0;$j<$reserve_item['use_count'];$j++){
					$dkey=array();
					$dval=array();

					if($j==0){
						$dkey[]="reserve_no";
						$dval[]=$reservelastInsertId;
					}
					else{
						$dkey[]="p_no";
						$dval[]=$detaillastInsertId;
					}

					if($i==0){//お申込者 新規登録済み
						$dkey[]="member_id";
						$dval[]=$lastInsertId;
						$dkey[]="buy_no";
						$dval[]=$buylastInsertId;
					}
					$dkey[]="shop_no";
					$dval[]=$reserve_item['shop_no'];
					$dkey[]="menu_no";
					$dval[]=$reserve_item['menu_no'];
					$dkey[]="reserve_date";
					$dval[]="'".$reserve_item['reserve_date']."'";
					$dkey[]="regist_flg";
					$dval[]=$reserve_item['regist_flg'];;


					$dkey[]="start_time";
					$dval[]="'".$reserve_item['start_time']."'";
					$dkey[]="end_time";
					$dval[]="'".$reserve_item['end_time']."'";
					$dkey[]="insert_date";
					$dval[]="'".date("Y-m-d H:i:s")."'";
					$dkey[]="update_date";
					$dval[]="'".date("Y-m-d H:i:s")."'";



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

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'member'." . $e);
			$this->db->rollBack();
			return false;
		}

		return array($lastInsertId,$reservelastInsertId);

	}
	/**
	 * 会員 更新処理
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 *        $item:フォームデータ
	 * @return
	 */
	public function upItemData($fi,$dt,$wfi,$wdt,$item=array()) {

		if(is_array($fi)){
	           	for ($i=0;$i<count($fi);$i++){
					$va=trim($dt[$i]);
					$tmp1[]=$fi[$i]."='".htmlspecialchars($va, ENT_QUOTES)."'";
		    	}
		}else if($fi){
			$dt=trim($dt);
			$dt=htmlspecialchars($dt, ENT_QUOTES);
			$tmp1[]=$fi."='".$dt."'";
		}

		$ins=implode(",",$tmp1);

		if(is_array($wfi)){
		    $tmp=array();
	            for ($i=0;$i<count($wfi);$i++){
		    	$tmp[]=$wfi[$i]."='".$wdt[$i]."'";
		    }
		    $where=" where ".implode(" and ",$tmp);
		}else if($wfi){
			$where=" where ".$wfi."='".$wdt."'";
		}

		$sql="update member set $ins $where";

		$this->db->beginTransaction();
		try {
			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'Member'." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

	}

	/**
	 * コース購入　借り購入
	 */
	public function InsertCourseData($reserve_item) {
		
		$commonDao = new CommonDao();

		$this->db->beginTransaction();
		try {

				//未払いのコース購入とする。
				//来店時に支払がされて、購入済みとする。
				//メニューからこーすNoを出す
				$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$reserve_item['menu_no']);
				$tmpcourse=$commonDao->get_data_tbl("mst_course","course_no",$tmp[0]['course_no']);

				$dkey=array();
				$dval=array();
				$dkey[]="member_id";
				$dval[]=$reserve_item['member_id'];

				$dkey[]="shop_no";
				$dval[]=$reserve_item['shop_no'];

				$dkey[]="course_no";
				$dval[]=$tmp[0]['course_no'];
				$dkey[]="fee";
				$dval[]=$tmpcourse[0]['fee'];
				$dkey[]="total_fee";
				$dval[]=$tmpcourse[0]['fee'];
				$dkey[]="insert_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$dkey[]="update_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$ins=implode(",",$dkey);
				$valu=implode(",",$dval);
				$sql="insert into member_buy($ins) values($valu)";


				$this->executeUpdate($sql);
				$buylastInsertId = $this->db->lastInsertId();
				// コミット
				$this->db->commit();

		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'member'." . $e);
			$this->db->rollBack();
			return false;
		}

		return $buylastInsertId;;

	}

	public function getBuyNo($item) {
		$menuNo = $item['menu_no'];
		$sql = "select mm.course_no as course_no from mst_menu as mm where mm.menu_no=$menuNo";
		$tmp=$this->executeQuery($sql);
		$item['course_no']=$tmp[0]['course_no'];

		$sql = "select mb.buy_no from member_buy as mb where mb.member_id=".$item['member_id']." and mb.shop_no=".$item['shop_no']." and mb.course_no=".$item['course_no']." ";
		$tmp=$this->executeQuery($sql);

		if ($tmp) {
			return $tmp[0]['buy_no'];
		}else{
			$commonDao = new CommonDao();

			$this->db->beginTransaction();
			try {

				//未払いのコース購入とする。
				//来店時に支払がされて、購入済みとする。
				//メニューからこーすNoを出す
				$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$item['menu_no']);
				$tmpcourse=$commonDao->get_data_tbl("mst_course","course_no",$tmp[0]['course_no']);

				$dkey=array();
				$dval=array();
				$dkey[]="member_id";
				$dval[]=$item['member_id'];

				$dkey[]="shop_no";
				$dval[]=$item['shop_no'];

				$dkey[]="course_no";
				$dval[]=$item['course_no'];
				$dkey[]="fee";
				$dval[]=$tmpcourse[0]['fee'];
				$dkey[]="total_fee";
				$dval[]=$tmpcourse[0]['fee'];
				$dkey[]="insert_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$dkey[]="update_date";
				$dval[]="'".date("Y-m-d H:i:s")."'";
				$ins=implode(",",$dkey);
				$valu=implode(",",$dval);
				$sql="insert into member_buy($ins) values($valu)";


				$this->executeUpdate($sql);
				$buylastInsertId = $this->db->lastInsertId();
				// コミット
				$this->db->commit();

			}catch(Exception $e){

				$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'member'." . $e);
				$this->db->rollBack();
				return false;
			}

				return $buylastInsertId;
		}

	}



	/**
	 * 会員検索 件数
	 * @param $search:検索条件
	 * @return 検索結果
	 */
	public function searchCount($search="") {

		list($where,$tbl)=$this->makeSearch($search);

		$sql="select distinct count(*) as cnt from member as m ".$tbl.$where;
// echo $sql."<br>";
		$tmp=$this->executeQuery($sql);

		return $tmp[0]['cnt'];

	}


	public function makeSearch($search) {
		// echo "<pre>"; ;print_r($search);
		//------- 検索条件 --------------------
		$where="";
		$tbl="";

		//
		if(isset($search["member_id"]) && $search["member_id"] != ''){
			$whTmp[]="member_id =".addslashes($search["member_id"]);
		}
		if(isset($search["member_no"]) && $search["member_no"] != ''){
			$whTmp[]="member_no like '%".addslashes($search["member_no"])."%'";
		}
		if(isset($search["tel"]) && $search["tel"] != ''){
			$whTmp[]="tel like '%".addslashes($search["tel"])."%'";
		}


		if(isset($search["shop_no"]) && $search["shop_no"] != ''){
			$whTmp[]="m.shop_no =".addslashes($search["shop_no"]);
		}
		//email
		if(isset($search["email"]) && $search["email"] != ''){
			$whTmp[]="email ='".addslashes($search["email"])."'";
		}
		//pass
		if(isset($search["password"]) && $search["password"] != ''){
			$whTmp[]="password ='".addslashes(to_hash($search["password"]))."'";
		}
		//名前
		if(isset($search["name"]) && $search["name"] != ''){
			$tmp[]="concat(m.name,m.name_kana) like '%".addslashes($search["name"])."%'";
			$tmp[]="name_kana like '%".addslashes($search["name"])."%'";
			$whTmp[]="(".implode(" or ",$tmp).")";
		}
		if(isset($search["sex"]) && $search["sex"] != ''){
			$whTmp[]="sex ='".addslashes($search["sex"])."'";
		}

		if(isset($search["year"]) && $search["year"] != ''){
			$whTmp[]="year =".addslashes($search['year'])."";
		}
		if(isset($search["month"]) && $search["month"] != ''){
			$whTmp[]="month =".addslashes($search["month"])."";
		}
		if(isset($search["day"]) && $search["day"] != ''){
			$whTmp[]="day =".addslashes($search["day"])."";
		}

		if(isset($search["course_no"]) && $search["course_no"] != ''){
			$whTmp[]="course_no =".addslashes($search["course_no"]);
		}

		if(isset($search["mail_flg"]) && $search["mail_flg"] != ''){
			$whTmp[]="mail_flg =".addslashes($search["mail_flg"]);
		}


		//来店日
		if(isset($search["start_date"], $search["end_date"]) && $search["start_date"] != '' && $search["end_date"] != ''){
			$tblTmp[]="member_reserve_detail d ";
			$whTmp[]="m.member_id=d.member_id";
			$whTmp[]="d.visit_flg<>99 and d.reserve_date between '".$search["start_date"]."' and '".$search["end_date"]."'";

			$rsv=1;
		}
		else if(isset($search["start_date"]) && $search["start_date"] != ''){
			$tblTmp[]="member_reserve_detail d ";
			$whTmp[]="m.member_id=d.member_id";

			$whTmp[]="d.visit_flg<>99 and d.reserve_date >='".$search["start_date"]."'";
			$rsv=1;
		}
		else if(isset($search["end_date"]) && $search["end_date"] != ''){
			$tblTmp[]="member_reserve_detail d ";
			$whTmp[]="m.member_id=d.member_id";

			$whTmp[]="d.visit_flg<>99 and d.reserve_date <='".$search["end_date"]."'";
			$rsv=1;
		}

		//最終来店日
/*
		if($search["last_reserve_date"]){
			//最終来店日からXカ月後のXが入ってくるので、Xか月以上の計算を行う
			$tdY=date("Y");
			$tdM=date("m");
			$tdD=date("d");

			$lastDt=date("Y-m-d", mktime(0,0,0,$tdM-$search["last_reserve_date"],$tdD,$tdY));
//			$whTmp[]="d.member_id=m.member_id and d.visit_flg<>99 and d.reserve_date <='".$lastDt."'";
			$whTmp[]="d.member_id=m.member_id and d.visit_flg<>99 and d.reserve_date <='".$lastDt."'";

			$tblTmp[]="member_reserve_detail d ";

		}
*/
		//コース
		if(isset($search['course_no']) && $search["course_no"] != ''){
			if($rsv!=1){
				$tblTmp[]="member_reserve_detail d ";
			}
			$tblTmp[]="member_buy b ";
			$whTmp[]="m.member_id=d.member_id";
			$whTmp[]="b.member_id=d.member_id";

			$whTmp[]="d.visit_flg<>99 and d.buy_no=b.buy_no and b.course_no=".$search['course_no'];

		}

		//現役会員のみ
		if(!isset($search['member_flg'])){
			$whTmp[]="member_flg =0";
		}


		if(isset($whTmp)){
			$where=" where ".implode(" and ",$whTmp);
		}
		if(isset($tblTmp)){
			$tbl=" , ".implode(" , ",$tblTmp);
		}

		return array($where,$tbl);

	}

	public function makeSearch2($search) {

		//------- 検索条件 --------------------
		$where="";
		$tbl="";
		$wherePay="";

		//
		if(isset($search["shop_no"])){
			$whTmp[]="shop_no =".addslashes($search["shop_no"]);
		}
		if(isset($search["reserve_shop_no"])){
			$whTmp[]="d.shop_no =".addslashes($search["reserve_shop_no"]);
		}

/*
		if($search["b_year"] ){
			$whTmpTmp[]=addslashes($search["b_year"]);
		}
		if($search["b_month"] ){
			$whTmpTmp[]=sprintf("%02d",addslashes($search["b_month"]));
		}
		if($search["b_day"] ){
			$whTmpTmp[]=sprintf("%02d",addslashes($search["b_day"]));
		}
		if($whTmpTmp){
			$whTmp[]="buy_date like '%".implode("-",$whTmpTmp)."%'";
			$whTmpPay[]="buy_date like '%".implode("-",$whTmpTmp)."%'";
		}

		if($search["start_date"] && $search["end_date"]){
			$whTmp[]="buy_date between '".$search["start_date"]."' and '".$search["end_date"]."'";
			$whTmpPay[]="buy_date between '".$search["start_date"]."' and '".$search["end_date"]."'";

		}
		else if($search["start_date"]){
			$whTmp[]="buy_date ='".$search["start_date"]."'";
			$whTmpPay[]="buy_date ='".$search["start_date"]."'";
		}
		else if($search["end_date"]){
			$whTmp[]="buy_date ='".$search["end_date"]."'";
			$whTmpPay[]="buy_date ='".$search["end_date"]."'";
		}
*/
		if(isset($search["reserve_date"])){
			$whTmp[]="reserve_date = '".addslashes($search["reserve_date"])."'";
		}
		if(isset($search["buy_date"])){
			$whTmp[]="buy_date = '".addslashes($search["buy_date"])."'";
		}
		if(isset($search["buy_date_like"])){
			$whTmp[]="buy_date like '".addslashes($search["buy_date_like"])."'";
		}



		if(isset($search["course_no"])){
			$whTmp[]="course_no =".addslashes($search["course_no"]);
		}

		if(isset($whTmp)){
			$where=" and ".implode(" and ",$whTmp);
		}
		if(isset($whTmpPay)){
			$wherePay=" and ".implode(" and ",$whTmpPay);
		}

		return array($where,$wherePay);

	}

	/**
	 * 会員検索
	 * @param $search:検索条件
	 * @return 検索結果
	 */
	public function search($search="",$orderby="",$limit="") {
		$ord = '';

		list($where,$tbl)=$this->makeSearch($search);
		
		//ソート
		if($orderby<>""){
			if(is_array($orderby)){
		            for ($i=0;$i<count($orderby);$i++){
			    	$tmpo[]=$orderby[$i];
			    }

			    $ord="order by ".implode(",",$tmpo);

			}else{
				$desc = '';
				$ord=" order by $orderby ";
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

		$sql="select distinct m.* from member as m ".$tbl.$where.$ord.$limit_str;

// echo $sql;exit();	

		$rs=$this->executeQuery($sql);
		$Arr=array();
		for($i=0;$i<count($rs);$i++){
			foreach ($rs[$i] as $key => $val){
				$data{$key} = stripslashes(rtrim($val));
			}
			array_push($Arr,$data);

		}

		return $Arr;

	}

	/**
	 * 購入コース検索
	 * @param $search:検索条件
	 * @return 検索結果
	 */
	public function searchBuy($search="",$dt) {
		$arrTmp['totalPrice']=0;
		$commonDao = new CommonDao();

		list($where,$wherePay)=$this->makeSearch2($search);

		@$arr=$this->getDetailReport();

		//その日に来店した人を取得
		$sql="select d.*,m.name,m.member_no,m.name_kana from member_reserve_detail as d,member as m where d.visit_flg<>99 and d.p_no=0 and d.member_id=m.member_id ".$where;
		$rs=$this->executeQuery($sql);
		if($rs){

				$arrTmp=array();
			for($i=0;$i<count($rs);$i++){

				$arrTmp['dt']=$rs[$i]['reserve_date'];
				$arrTmp['name']=$rs[$i]['name'];
				$arrTmp['member_no']=$rs[$i]['member_no'];
				$arrTmp['name_kana']=$rs[$i]['name_kana'];
				$arrTmp['start_time']=$rs[$i]['start_time'];
				
				//コース購入があるか
		
				$sql="select b.*,c.name from member_buy as b,mst_course as c
					where c.course_no=b.course_no  and b.fee_flg=1 and b.member_id=".$rs[$i]['member_id']."";//  and b.buy_date='".$dt."' // //by arafat;

				$tmp=$this->executeQuery($sql);
				if($tmp){
					$arrTmp['course_name']=$tmp[0]['name'];
					if($tmp[0]['coupon_id']>0){
						$ctmp=$commonDao->get_data_tbl("mst_category1","id",$tmp[0]['coupon_id']);
						$arrTmp['coupon_name']=$ctmp[0]['name'];
					}
				}


				$sql="select b.*,c.name from member_buy as b,mst_course as c
					where c.course_no=b.course_no  and b.member_id=".$rs[$i]['member_id']."";
				$tmp=$this->executeQuery($sql);

				if($tmp){
					$arrTmp['price']=$tmp[0]['total_fee'];
				}

				//その他
				$sql="select sum(m.fee) as other_fee from member_pay as m,member_reserve_detail as d
					where m.detail_no=d.no and d.member_id=".$rs[$i]['member_id']." and  m.buy_date like '".$dt."%'";
				$tmp=$this->executeQuery($sql);
				$arrTmp['other_fee']=$tmp[0]['other_fee'];


				//----コース消費----------
				//来店した時のメニューから該当コースを出す。
				$sql="select c.* from mst_menu as m,mst_course as c where m.course_no=c.course_no and m.menu_no=".$rs[$i]['menu_no'];
				$tmp=$this->executeQuery($sql);
				$course_no=$tmp[0]['course_no'];
				$arrTmp['use_course_name']=$tmp[0]['name'];

//				$sql="select count(*) as cnt from mst_menu as m,member_reserve_detail as d
//				  where m.menu_no=d.menu_no and d.visit_flg<>99 and d.member_id=".$rs[$i]d." and m.course_no=".$course_no." and reserve_date <='".$dt."'";
				$sql="select count(*) as cnt from member_reserve_detail as d
				  where d.visit_flg<>99 and d.buy_no=".$rs[$i]['buy_no']." and d.reserve_date <='".$dt."'";

				$tmp=$this->executeQuery($sql);
				$arrTmp['c_cnt']=$tmp[0]['cnt'];



				$arr[]=$arrTmp;

			}


		}
		/* else{
			$arr[]['dt']=$dt;

		}*/ //by arafat

		// echo "<pre>"; print_r($arr);exit();
		$this->setDetailReport($arr);

		return true;
/*

//		$sql="select m.* from member_buy as m where fee_flg=1 ".$where.$ord.$limit_str;
//echo $sql;

		$rs=$this->executeQuery($sql);
		$Arr=array();
		for($i=0;$i<count($rs);$i++){
			//コース名
			$tmp=$commonDao->get_data_tbl("mst_course","course_no",$rs[$i]['course_no']);
			$rs[$i]['course_name']=$tmp[0]['name'];

			foreach ($rs[$i] as $key => $val){
				$data{$key} = stripslashes(rtrim($val));
			}
			array_push($Arr,$data);
		}

		$sql="select m.buy_date,m.fee as total_fee, c.name as course_name from member_pay as m,mst_category2 as c where m.id=c.id ".$wherePay;
		$rs=$this->executeQuery($sql);

		if($rs){
			$salesTmp=array_merge($Arr,$rs);
			foreach($salesTmp as $key=>$value){
	            $buy_date[$key]=$value["buy_date"];
	        }

	        array_multisort($buy_date,SORT_DESC,$salesTmp);
		}
		else{

			$salesTmp=$Arr;
		}

		return $salesTmp;
*/
	}
	function setDetailReport($arr){
		$this->arr=$arr;
	}

	function getDetailReport(){

		return $this->arr;

	}

	/**
	 * 購入コース検索
	 * @param $search:検索条件
	 * @return 検索結果
	 */
	public function searchBuyDay($search="",$dt,$login_admin) {

		$commonDao =new CommonDao();

		$shop_no=$shopwh="";
		if($login_admin['shop_no']>0){
			$shop_no=$login_admin['shop_no'];
			$search['shop_no']=$login_admin['shop_no'];
			$shopwh=" and shop_no=".$shop_no;//add 2015-02-24
		}

		if(isset($search['shop_no']) && $search['shop_no']>0){
			$shop_no=$search['shop_no'];
			$search['shop_no']=$search['shop_no'];
			$shopwh=" and shop_no=".$shop_no;//add 2015-02-24
		}


		

		$arr=array();
		
		$totalArr=array();
		$arr['dt']=$dt;
		@$totalArr=$this->getTotalReport();

		list($where,$wherePay)=$this->makeSearch2($search);
		// echo $where;exit();	
		$sql="select sum(discount) as discount,sum(total_fee) as total_fee, m.shop_no from member_buy as m where fee_flg=1 ".$where." group by buy_date";
// echo $sql."<br>";
		$rs=$this->executeQuery($sql);
		if ($rs) {
			$arr['discount']=$rs[0]['discount'];
			$arr['total_fee']=$rs[0]['total_fee'];
			$arr['shop_no']=$rs[0]['shop_no'];
			$totalArr['discount']=$totalArr['discount']+$rs[0]['discount'];
			@$totalArr['total_fee']=$totalArr['total_fee']+$rs[0]['total_fee'];
		}

		//該当日の総来客数とキャンセル
		$sql="select sum(case when visit_flg<>99 THEN 1 ELSE 0 END) as total_count,sum(case when visit_flg=99 THEN 1 ELSE 0 END) as cancel_count
		 from member_reserve_detail where p_no=0 and reserve_date ='".$dt."'".$shopwh;
		$rs=$this->executeQuery($sql);
		
			$arr['total_count']=$rs[0]['total_count'];
			$arr['cancel_count']=$rs[0]['cancel_count'];
			@$totalArr['total_count']=$totalArr['total_count']+$rs[0]['total_count'];
			@$totalArr['cancel_count']=$totalArr['cancel_count']+$rs[0]['cancel_count'];
		

		//コース売上
		$tmp=$commonDao->get_data_tbl("mst_course","","","v_order");
		for($i=0;$i<count($tmp);$i++){

			$sql="select sum(fee) as fee from member_buy as b where course_no=".$tmp[$i]['course_no']." and buy_date='".$dt."'".$shopwh."";
// echo $sql."<br>";
			$rs=$this->executeQuery($sql);
				$course_no=$tmp[$i]['course_no'];
				@$arr['course_fee'][$course_no]=$rs[0]['fee'];

				@$totalArr['course_fee'][$course_no]=$totalArr['course_fee'][$course_no]+$rs[0]['fee'];

		}

		//コース購入以外の売りあげ
//		$sql="select sum(fee) as other_fee from member_pay as m where buy_date like '".$dt."%'";

		$sql="select sum(m.fee) as other_fee from member_pay as m,member_reserve_detail as r
		where m.detail_no=r.no and buy_date like '".$dt."%'".$shopwh;


		$rs=$this->executeQuery($sql);
			$arr['other_fee']=$rs[0]['other_fee'];
			$arr['total_fee']=$arr['total_fee']+$arr['other_fee'];
			@$totalArr['other_fee']= $totalArr['other_fee']+$rs[0]['other_fee'];
			$totalArr['total_fee']= $totalArr['total_fee']+$arr['other_fee'];

		// echo "<pre>"; print_r($totalArr);
		$this->setTotalReport($totalArr);


		return $arr;

	}

	function setTotalReport($arr){
		$this->arr=$arr;
	}

	function getTotalReport(){

		return $this->arr;

	}





	/**
	 * 顧客のコース購入状況とそのコースに対する来店数
	 * キャンセルを除く
	 *
	 * コース購入は使用可能なコースを取得（規定回数に達していない。使用期限前）
	 *
	 * @param $member_id:顧客ID
	 * @return 検索結果
	 *
	 */
	public function getCourseInfo($member_id, $shop_no="") {
		$fArr = array();
		$commonDao=new CommonDao();
		$member_id=addslashes($member_id);

		if($shop_no){
			$sql="select m.*,c.name,c.number from member_buy as m, mst_course as c
				where m.shop_no=".$shop_no." and m.course_no=c.course_no and m.finish_flg=0 and m.member_id=".$member_id." order by m.buy_no";

		}
		else{
			$sql="select m.*,c.name,c.number from member_buy as m, mst_course as c
				where m.course_no=c.course_no and m.finish_flg=0 and m.member_id=".$member_id." order by m.buy_no";
		}
		$ret=$this->executeQuery($sql);
		$Arr=array();
		for($i=0;$i<count($ret);$i++){
			foreach ($ret[$i] as $key => $val){
				$data{$key} = stripslashes(rtrim($val));
			}
			array_push($Arr,$data);

		}

		for($i=0;$i<count($Arr);$i++){
			//購入コース時のクーポン情報
			$tmp=$commonDao->get_data_tbl("mst_category1","id",$Arr[$i]['coupon_id']);
			if($tmp){
				$Arr[$i]['coupon_name']=$tmp[0]['name'];
			}
			else{
				$Arr[$i]['coupon_name']="-";
			}

			//購入コースに対する来店情報
//			$sql="select * from member_reserve as r,member_reserve_detail as d
//				where r.reserve_no=d.reserve_no and d.member_id=".$member_id." and 										d.buy_no=".$Arr[$i]['buy_no']." and visit_flg<>99";

			$sql="select * from member_reserve_detail as d
				where d.member_id=".$member_id." and d.buy_no=".$Arr[$i]['buy_no']." and d.visit_flg<>99";

			$tmp=$this->executeQuery($sql);

			//ユーザー側からの初回コースでの予約の場合、コース終了フラグは立っていないが、予約が入っている時点で次の予約はない

			$Arr[$i]['raiten_cnt']=count($tmp);
			$Arr[$i]['zan']=$Arr[$i]['number']-$Arr[$i]['raiten_cnt'];

			for($j=0;$j<count($tmp);$j++){
				$Arr[$i]['reserve']=$tmp;
			}
		}

		//予約可能なチケットが残っていなければ省く
		for($i=0;$i<count($Arr);$i++){

			if($Arr[$i]['raiten_cnt']<$Arr[$i]['number']){
				$fArr[]=$Arr[$i];
			}
		}

		return $fArr;
	}

	/**
	 * 顧客の全てのコース購入状況（終了コースも含め）とそのコースに対する来店数
	 * キャンセルも含めて全て
	 *
	 * @param $member_id:顧客ID
	 * @return 検索結果
	 *
	 */
	public function getCourseInfoAll($member_id) {

		$commonDao=new CommonDao();
		$member_id=addslashes($member_id);

		$sql="select m.*,c.name from member_buy as m, mst_course as c
			where m.course_no=c.course_no and m.member_id=".$member_id." order by m.buy_no";

		$ret=$this->executeQuery($sql);
		$Arr=array();
		// echo "<pre>"; print_r($ret);exit();
		for($i=0;$i<count($ret);$i++){
			foreach ($ret[$i] as $key => $val){
				$data{$key} = stripslashes(rtrim($val));
			}
			array_push($Arr,$data);

		}

		for($i=0;$i<count($Arr);$i++){

			//キャンセル以外の予約情報
			$rTmp=$this->getCourseCntInfo($Arr[$i]['buy_no']);
			$Arr[$i]['rcnt']=count($rTmp);

			//購入コース時のクーポン情報
			$tmp=$commonDao->get_data_tbl("mst_category1","id",$Arr[$i]['coupon_id']);
			if($tmp){
				$Arr[$i]['coupon_name']=$tmp[0]['name'];
			}
			else{
				$Arr[$i]['coupon_name']="-";
			}

			//店舗名
			$stmp=$commonDao->get_data_tbl("shop","shop_no",$Arr[$i]['shop_no']);
			$Arr[$i]['shop_name']=$stmp[0]['name'];

			//購入コースに対する来店情報
			$sql="select * from member_reserve as r,member_reserve_detail as d,mst_menu as mm
				where d.reserve_no>0 and mm.menu_no=d.menu_no and r.reserve_no=d.reserve_no and d.member_id=".$member_id." and d.buy_no=".$Arr[$i]['buy_no']." order by d.reserve_no DESC";
				// echo $sql."<br>";
			$tmp=$this->executeQuery($sql);

			$Arr[$i]['reserve']=$tmp;

			for($j=0;$j<count($tmp);$j++){


				//menu名
				$stmp=$commonDao->get_data_tbl("mst_menu","menu_no",$tmp[$j]['menu_no']);
				@$Arr[$i]['reserve'][$j]['menu_name']=$stmp[0]['name'];

				//スタッフ名
				$stmp=$commonDao->get_data_tbl("shop_staff","staff_no",$tmp[$j]['staff_no']);
				@$Arr[$i]['reserve'][$j]['staff_name']=$stmp[0]['name'];


			}


			$Arr[$i]['raiten_cnt']=count($tmp);
		}
		// exit();
		return $Arr;
	}

	/**
	 * 顧客の予約中の情報
	 *
	 * @param $member_id:顧客ID
	 * @return 検索結果
	 *
	 */
	public function getReserveCourseInfo($member_id) {

		$commonDao=new CommonDao();
		$shopDao=new ShopDao();

		$member_id=addslashes($member_id);

		$sql="select * from member_reserve_detail as d, mst_menu as m
			where d.menu_no=m.menu_no and d.reserve_no>0 and d.member_id=".$member_id." and visit_flg=0";


		$ret=$this->executeQuery($sql);
		$Arr=array();
		for($i=0;$i<count($ret);$i++){
			foreach ($ret[$i] as $key => $val){
				$data{$key} = stripslashes(rtrim($val));
			}
			array_push($Arr,$data);
		}

		for($i=0;$i<count($Arr);$i++){
			$Arr[$i]['menu_name']=$Arr[$i]['name'];

			$tmp=$this->getCourseCntInfo($Arr[$i]['buy_no']);
			$Arr[$i]['cnt']=count($tmp);
			if(!$tmp){
				$sql="select c.number,c.name as course_name,b.limit_date from member_buy as b, mst_course as c where b.course_no=c.course_no and b.buy_no=".$Arr[$i]['buy_no'];
				$tmp=$commonDao->get_sql($sql);
			}

//			$Arr[$i]['number']=$tmp[0]['number'];//同じBuy_noだから、全て同じデータが取得されてる
			$Arr[$i]['course_name']=$tmp[0]['course_name'];
			$Arr[$i]['limit_date']=$tmp[0]['limit_date'];
//			$Arr[$i]['zan']=$Arr[$i]['number']-$Arr[$i]['cnt'];
//			$arr[$i][youbi]=getYoubi($arr[$i]['reserve_date']);

			//予約中の店舗名
			$Arr[$i]['shop_name']=$shopDao->getShopName($Arr[$i]['shop_no']);


			//該当の予約が何回目の予約になるのか。

			$sql="select * from member_reserve_detail
				where buy_no=".$Arr[$i]['buy_no']." and member_id=".$member_id." and visit_flg<>99 and reserve_date <='".$Arr[$i]['reserve_date']."'";

			$tmp=$commonDao->get_sql($sql);
			$Arr[$i]['zan']=count($tmp);


		}

		return $Arr;
	}

	/**
	 *
	 * 顧客が購入したコース、buy_noが、規定回数に達していないかをチェック
	 *
	 * @param $buy_no:コース購入番号
	 * @return 検索結果
	 *
	 */
	public function getCourseCountCheck($buy_no) {

		$commonDao=new CommonDao();
		$buy_no=addslashes($buy_no);

		$sql="select b.* from member_buy as b,member_reserve_detail as d
			where b.buy_no=d.buy_no and visit_flg!=99"; //and d.buy_no=".$buy_no."

		$tmp=$this->executeQuery($sql);

		//購入コースの規定回数
		$ctmp=$commonDao->get_data_tbl("mst_course","course_no",$tmp[0]['course_no']);
		$number=$ctmp[0]['number'];


		$res=$number-count($tmp);

		if($res==0){//規定回数に達した
			//終了
			$commonDao->updateData("member_buy", "finish_flg", 1, "buy_no", $buy_no);
		}
		else{
			$commonDao->updateData("member_buy", "finish_flg", 0, "buy_no", $buy_no);
		}
		return true;

	}

	/**
	 *
	 * 予約キャンセルがあった場合、規定回数に達した事により、使用終了となっている購入コースを使用可能にする。
	 * （finish_flg=0にするばOK）
	 * ただし、使用期限が過ぎた事により、終了となっている場合は、そのままとする。
	 *
	 *
	 * @param $no:予約の詳細番号 member_reserve_detail.no
	 * @return 検索結果
	 *
	 */
	public function changeFinishFlgInfo($no) {

		$commonDao=new CommonDao();

		$sql="select b.* from member_buy as b,member_reserve_detail as d
			where b.buy_no=d.buy_no and d.no=".$no;

		$tmp=$this->executeQuery($sql);

		//使用期限が過ぎていなければ、
		if($tmp[0]['finish_flg']!=2){
			if($tmp[0]['buy_no']>0){
				$commonDao->updateData("member_buy", "finish_flg", 0, "buy_no", $tmp[0]['buy_no']);
			}
		}

		return true;

	}

	/**
	 *
	 *  顧客が購入したコース、buy_noに対しての予約、来店回数
	 *
	 * @param $buy_no:購入番号
	 * @return 検索結果
	 *
	 */
	public function getCourseCntInfo($buy_no) {

		$commonDao=new CommonDao();
		$buy_no=addslashes($buy_no);

		$sql="select m.*,c.name as course_name, mm.name as menu_name,c.number,b.limit_date
			from member_reserve_detail as m, mst_course as c, mst_menu as mm,member_buy as b
			where m.buy_no=b.buy_no and b.course_no=c.course_no and m.menu_no=mm.menu_no and mm.course_no=c.course_no and m.visit_flg<>99 and m.buy_no=".$buy_no;
		$ret=$this->executeQuery($sql);

			$Arr=array();
			for($i=0;$i<count($ret);$i++){
				foreach ($ret[$i] as $key => $val){
					$data{$key} = stripslashes(rtrim($val));
				}
				array_push($Arr,$data);

			}
		return $Arr;
	}

	/**
	 *
	 *  顧客が購入したコース、buy_noの情報
	 *
	 * @param $buy_no:購入番号
	 * @param $visit_flg 0:予約中 1:来店 99:キャンセル
	 * @return 検索結果
	 *
	 */
	public function getCourseVisitInfo($buy_no,$visit_flg="") {

		$commonDao=new CommonDao();
		$buy_no=addslashes($buy_no);

		if($visit_flg!=""){
			$wh=" and visit_flg=".$visit_flg;
		}

		$sql="select m.*,c.name as course_name, mm.name as menu_name,c.number from member_reserve_detail as m, mst_course as c, mst_menu as mm
			where m.menu_no=mm.menu_no and mm.course_no=c.course_no $wh and m.buy_no=".$buy_no;

		$ret=$this->executeQuery($sql);
		$Arr=array();
		for($i=0;$i<count($ret);$i++){
			foreach ($ret[$i] as $key => $val){
				$data{$key} = stripslashes(rtrim($val));
			}
			array_push($Arr,$data);

		}


		return $arr;

	}

	/**
	 * 購入したコースのbuy_noに対して
	 *
	 * 残っている残回数に対して、使用可能なメニューを取得する
	 *
	 * 例えば残回数が１なのに、２回連続のメニューは使用不可能である
	 *
	 * ユーザー用：メニューが表示のもの。
	 *
	 */
	public function getUseMenuInfo($buy_no,$select_menu_no="0") {

		$commonDao = new CommonDao();
		$sql="select m.* from mst_menu as m,member_buy as b where m.course_no=b.course_no and m.view_flg=1 and b.buy_no=".$buy_no;

		$menutmp=$commonDao->get_sql($sql);
		//使用するコースの残チケットにより、選べるメニューを変える
		$tmp=$this->getCourseCntInfo($buy_no);
		$cnt=count($tmp);
		if(!$tmp){
				$sql="select c.number from member_buy as b, mst_course as c where b.course_no=c.course_no and b.buy_no=".$buy_no;
				$tmp=$commonDao->get_sql($sql);
		}
		$zan=$tmp[0]['number']-$cnt;

		//現在予約メニュー回数(2015.0415add)
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$select_menu_no);
		$ima_use_count=$tmp[0]['use_count'];

		for($i=0;$i<count($menutmp);$i++){

			//修正の場合、現在選択中のメニューはチケット残は関係なく、表示可能
			if(($select_menu_no>0 && $select_menu_no==$menutmp[$i]['menu_no']) || ($select_menu_no>0 && $zan<>0)){
				$menuArr[]=$menutmp[$i];
			}
			else if($menutmp[$i]['use_count']<=$zan || $ima_use_count>$menutmp[$i]['use_count']){//チケットが余っていたら　または今のコースの回数よりも少ない回数であれば変更可能(2015.0415add)
				$menuArr[]=$menutmp[$i];
			}
		}
		return $menuArr;
	}

	/**
	 * 購入したコースのbuy_noに対して
	 *
	 * 残っている残回数に対して、使用可能なメニューを取得する
	 *
	 * 例えば残回数が１なのに、２回連続のメニューは使用不可能である
	 *
	 * 管理者用：メニューが表示、非表示全て表示
	 *
	 * (2015.0415add)
	 *
	 */
	public function getUseMenuInfoAdmin($buy_no,$select_menu_no="0") {

		$commonDao = new CommonDao();
		$sql="select m.* from mst_menu as m,member_buy as b where m.course_no=b.course_no and b.buy_no=".$buy_no;

		$menutmp=$commonDao->get_sql($sql);
		//使用するコースの残チケットにより、選べるメニューを変える
		$tmp=$this->getCourseCntInfo($buy_no);
		$cnt=count($tmp);
		if(!$tmp){
				$sql="select c.number from member_buy as b, mst_course as c where b.course_no=c.course_no and b.buy_no=".$buy_no;
				$tmp=$commonDao->get_sql($sql);
		}
		$zan=$tmp[0]['number']-$cnt;

		//現在予約メニュー回数(2015.0415add)
		$tmp=$commonDao->get_data_tbl("mst_menu","menu_no",$select_menu_no);
		$ima_use_count=$tmp[0]['use_count'];

		for($i=0;$i<count($menutmp);$i++){


			//修正の場合、現在選択中のメニューはチケット残は関係なく、表示可能
			if(($select_menu_no>0 && $select_menu_no==$menutmp[$i]['menu_no']) || ($select_menu_no>0 && $zan<>0)){
				$menuArr[]=$menutmp[$i];
			}
			else if($menutmp[$i]['use_count']<=$zan || $ima_use_count>$menutmp[$i]['use_count']){//チケットが余っていたら　または今のコースの回数よりも少ない回数であれば変更可能(2015.0415add)
				$menuArr[]=$menutmp[$i];
			}
		}
		return $menuArr;
	}



	/**
	 * Memberの削除
	 *
	 * 論理削除とする
	 *
	 */
	public function delete($member_id) {


		//email取得
		$commonDao = new CommonDao();

		$tmp=$commonDao->get_data_tbl("member","member_id",$member_id);

		//退会処理
		$fi['member_flg']=99;
		$fi['email']="99_".$tmp[0]['email'];
		$wfid=$member_id;
		$ret=$commonDao->updateData2("member", $fi, $wfi);
		if($ret){
			return true;
		}
		else{
			return false;
		}

	}

	public function getYearGraphData($year,$month,$startDate,$endDate,$whdata) {
		$where = '';
		$fromDate = $year.'-'.$month.'-'.$startDate;
		$toDate = $year.'-'.$month.'-'.$endDate;
		if (isset($whdata['shop_no'])) {
			$where = 'and mrd.shop_no='.$whdata['shop_no'];
		}
		//$sql = "select count(mrd.`no`) as total_reserve from member_reserve_detail as mrd where mrd.reserve_date between '$fromDate' and '$toDate' and mrd.p_no=0";
		$sql = "select mb.total_fee, mrd.reserve_date from member_reserve_detail as mrd, member_buy as mb where mrd.buy_no=mb.buy_no and mrd.reserve_date between '$fromDate' and '$toDate' ".$where." group by mrd.buy_no order by mrd.reserve_date";
		
		$tmp = $this->executeQuery($sql);
		if (count($tmp) > 0) {
			for ($i=0; $i < count($tmp); $i++) { 
				@$arr['total_fee'] += $tmp[$i]['total_fee'];
			}
		}else{
			$arr['total_fee'] = 0;
		}
		// echo $arr['total_fee']."<br>";
			$this->setGraphData($arr,$month);
		// echo count($tmp)."<br>";
		return;
	}

	function setGraphData($arr,$key){
		$this->arr[$key]=$arr;
	}

	function getGraphData(){

		return $this->arr;

	}

	public function getMenuTrendData($data = '') {
		$wh = '';
		$where = '';
		$arr = '';
		if (isset($data['shop_no']) && $data['shop_no'] != '') {
			$wh[] = "and mrd.shop_no=".$data['shop_no']."";
		}
		if (isset($data['f_date'], $data['t_date'])) {
			$wh[] = "and mrd.reserve_date between '".$data['f_date']."' and '".$data['t_date']."'";
		}
		if ($wh != '') {
			$where = implode(' ', $wh);
		}

		$sql = "select count(mrd.`no`) as maxTotal,mrd.menu_no, mm.name from member_reserve_detail as mrd left join mst_menu as mm on mrd.menu_no=mm.menu_no where mrd.menu_no=mm.menu_no ".$where." group by mrd.menu_no order by maxTotal DESC";
		$tmp = $this->executeQuery($sql);
		for ($i=0; $i < count($tmp) ; $i++) { 
			// $arr['total'] = $tmp[$i]['maxTotal'];
			// $arr['menu_no'] = $tmp[$i]['menu_no'];
			// $arr['name'] = $tmp[$i]['name'];
			$arr[$tmp[$i]['name']] = $tmp[$i]['maxTotal'];
		}
		return $arr;
	}


}
?>