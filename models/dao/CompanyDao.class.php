<?php
class CompanyDAO extends DAOBase {


	/**
	 * 登録
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 *        $item:フォームデータ
	 * @return int 直近の挿入行ID
	 */
	public function InsertItemData($fi,$dt,$item) {

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

		$sql="insert into company($ins) values($valu)";
		$this->db->beginTransaction();
		try {

			// 実行
			$this->executeUpdate($sql);
			// 直近の挿入行IDを取得
			$lastInsertId = $this->db->lastInsertId();

			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'company'." . $e);
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

		return $tmp[0][cnt];

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
			$sql="select * from company_ext_attrs where company_id=".$prodArr[$i][company_id]." order by attr_key , seq";
			$tmp=$this->executeQuery($sql);
			for($j=0;$j<count($tmp);$j++){
				$attr_key=$tmp[$j][attr_key];
				if($tmp[$j][attr_value1]){
					$prodArr[$i][$attr_key]=$tmp[$j][attr_value1];
				}
				else{
					$prodArr[$i][$attr_key]=$tmp[$j][attr_value3];
				}
			}
		}

		return $prodArr;

	}

	//削除
	/**
	 * 法人削除　関連データも全て削除
	 * @param $fi:フィールド名配列
	 *        $dt:値配列
	 * @return
	 */
	public function delData($company_id) {




		//------------- 求人系の削除 -------------
		$commonDao=new CommonDao();

		$jobtmp=$commonDao->get_data_tbl("job_offer","company_id", $company_id);

;


		//求人関係の削除
		for($i=0;$i<count($jobtmp);$i++){

			$job_no=$jobtmp[$i][job_no];

			$ret=$commonDao->del_Data("job_jyoken", "job_no", $job_no);
			if(!$ret){
				return false;
			}
			$ret=$commonDao->del_Data("job_ext_attrs", "job_no", $job_no);
			if(!$ret){
				return false;
			}
			$ret=$commonDao->del_Data("job_bookmark", "job_no", $job_no);
			if(!$ret){
				return false;
			}

			//求人画像系削除
			$tmp=$commonDao->get_data_tbl("job_images","job_no", $job_no);
			for($j=0;$j<count($tmp);$j++){
				$file_name=$tmp[$j][file_name];
				if(is_file(DIR_IMG_JOB.$file_name)) unlink(DIR_IMG_JOB.$file_name);
			}
			$ret=$commonDao->del_Data("job_images", "job_no", $job_no);
			if(!$ret){
				return false;
			}

		}

		//応募状況

		$tmp=$commonDao->get_sql("select p.apply_no from member_apply as a,member_apply_person as p
			where p.apply_no=a.apply_no and a.company_id=".$company_id);
		for($i=0;$i<count($tmp);$i++){
			$ret=$commonDao->del_Data("member_apply_person", "apply_no", $tmp[$i][apply_no]);
			if(!$ret){
				return false;
			}
		}
		$ret=$commonDao->del_Data("member_apply", "company_id", $company_id);
		if(!$ret){
			return false;
		}

		//---------------- 企業系の削除 -----------------------------------
		$tmp=$commonDao->get_data_tbl("company", "company_id", $company_id);
		//ロゴ系
		if(is_file(DIR_IMG_LOGO.$tmp[0][logo])) unlink(DIR_IMG_LOGO.$tmp[0][logo]);

		$ret=$commonDao->del_Data("company_ext_attrs", "company_id", $company_id);
		if(!$ret){
			return false;
		}

		$ret=$commonDao->del_Data("company", "company_id", $company_id);
		if(!$ret){
			return false;
		}



	}

}
?>