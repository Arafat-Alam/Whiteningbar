<?php
class ShopDAO extends DAOBase {


	/**
	 * 登録
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 *        $item:フォームデータ
	 * @return
	 */
	public function InsertAttrData($shop_no,$baseData,$input_data) {

		$commonDao=new CommonDao();

		$this->db->beginTransaction();
		try {

				//該当店舗の情報を削除
				$sql="delete from shop_attr where  shop_no=".$shop_no;
				$this->executeUpdate($sql);

				//営業曜日
				if($input_data['days']){
					foreach($input_data['days'] as $key=>$val){
						$sql="insert into shop_attr(shop_no,attr_key,attr_value) values(".$shop_no.",'days',".$val.")";
						$this->executeUpdate($sql);
					}
				}

				//基本事項
				foreach($baseData['dbstring'] as $key=>$val){
						$sql="insert into shop_attr(shop_no,attr_key,attr_value) values(".$shop_no.",'".$key."','".$input_data[$key]."')";
						$this->executeUpdate($sql);
				}

				// コミット
				$this->db->commit();

		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'shop_attr'." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

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

		$sql="update company set $ins $where";

		$this->db->beginTransaction();
		try {
			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'company'." . $e);
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

		$sql="select count(*) as cnt from company ".$tbl.$where;

		$tmp=$this->executeQuery($sql);

		return $tmp[0]['cnt'];

	}

	public function makeSearch($search) {

		//------- 検索条件 --------------------
		$where="";
		$tbl="";

		//会社名
		if($search["company_name"]){
			$whTmp[]="company_name like '%".addslashes($search["company_name"])."%'";
		}
		//担当者名
		if($search["tanto_name"]){
			$whTmp[]="tanto_name like '%".addslashes($search["tanto_name"])."%'";
		}
		//キーワード
		if($search["keyword"]){
			$keyTmp=array();
			$keyTmp[]="nickname like '%".addslashes($search["keyword"])."%'";

			$whTmp[]="(".implode(" or ",$keyTmp).")";
		}

		//承認非承認
		if(isset($search["admit_flg"])){
			$whTmp[]="admit_flg='".addslashes($search["admit_flg"])."'";
		}

		//企業ID
		if(isset($search["company_id"])){
			$whTmp[]="company_id='".addslashes($search["company_id"])."'";
		}

		if($whTmp){
			$where=" where ".implode(" and ",$whTmp);
		}
		if($tblTmp){
			$tbl=" , ".implode(" , ",$tblTmp);
		}

		return array($where,$tbl);

	}

	/**
	 * 会員検索
	 * @param $search:検索条件
	 * @return 検索結果
	 */
	public function search($search="",$orderby="",$limit="") {


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

		$sql="select * from company".$where;

		$prodArr=$this->executeQuery($sql);

		//属性情報を取得する
		$commonDao=new CommonDao();
		for($i=0;$i<count($prodArr);$i++){
			$sql="select * from company_ext_attrs where company_id=".$prodArr[$i]['company_id']." order by attr_key , seq";
			$tmp=$this->executeQuery($sql);
			for($j=0;$j<count($tmp);$j++){
				$attr_key=$tmp[$j]['attr_key'];
				if($tmp[$j]['attr_value1']){
					$prodArr[$i][$attr_key]=$tmp[$j]['attr_value1'];
				}
				else{
					$prodArr[$i][$attr_key]=$tmp[$j]['attr_value3'];
				}
			}
		}

		return $prodArr;

	}

		//削除
	/**
	 *
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 * @return
	 */
	public function getShopName($shop_no) {
		$commonDao= new CommonDao();
		$tmp = $commonDao->get_data_tbl("shop","shop_no",$shop_no);
		
		return $tmp[0]['name'];

	}

	public function getMenuName($menu_no) {
		$commonDao= new CommonDao();
		$tmp = $commonDao->get_data_tbl("mst_menu","menu_no",$menu_no);
		return $tmp[0]['name'];

	}
	public function getCourseName($course_no) {
		$commonDao= new CommonDao();
		$tmp = $commonDao->get_data_tbl("mst_course","course_no",$course_no);
		return $tmp[0]['name'];

	}


	//削除
	/**
	 * 法人削除　関連データも全て削除
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 * @return
	 */
	public function delData($company_id) {







	}

}
?>