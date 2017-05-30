<?php
class CategoryDao extends DaoBase {

	/**
	 * Category一覧を取得する
	 * @param unknown_type $where
	 * @param unknown_type $limit
	 * @param unknown_type $order
	 */
	public function getCategoryList($where="", $limit="", $order="") {
		if ($order == "") $order = " ORDER BY a.v_order ASC ";
		$sql = "SELECT
		            a.*
				FROM
					mst_category  a
				{$where}
				{$order}
				{$limit}
			 ";

//		$this->setFetchClass("Category1");
		$categories_src = $this->executeQuery($sql);
		return $categories_src;
/*
		$categories = array();
		foreach ($categories_src as $category_src) {
			$categories[] = $this->getRentalCategory($category_src->getRentalCategoryNo());
		}
		return $categories;
*/
	}
	public function getCategoryList_Arr($where="", $limit="", $order="") {
		if ($order == "") $order = " ORDER BY a.v_order ASC ";
		$sql = "SELECT
		            a.*
				FROM
					mst_category1  a
				{$where}
				{$order}
				{$limit}
			 ";

		$categories_src = $this->executeQuery($sql);
		return $categories_src;
	}

	/**
	 * RentalCategoryを取得する
	 * @param int $category_no
	 * @return RentalCategory
	 */
	public function getRentalCategory($id) {
		$id = $this->db->quote(addslashes($id));
        $sql = "SELECT
                    a.*
                FROM
                    mst_category1  a
                WHERE
                    id = {$id}
                ";
//        $this->setFetchClass("Category1");
        $rs = $this->executeQuery($sql);

		if (!$rs) {
			return false;
		}

		$category = $rs[0];

/*
		// 親カテゴリ名の取得
		if ($category->getParentNo() != "0") {
			$parent = $this->getRentalCategory($category->getParentNo());
			$category->setParentName($parent->getRentalCategoryName());
		}

		// 拡張属性の取得
		$attr_dao = new RentalCategoryExtAttrDAO();
		$search = new RentalCategorySearchCondition();
		$search->setRentalCategoryNo($category->getRentalCategoryNo());
		$category->setExtAttrList($attr_dao->doSearch($search));
*/
		return $category;
	}
	public function getRentalCategoryArr($id) {
		$id = $this->db->quote(addslashes($id));
        $sql = "SELECT
                    a.*
                FROM
                    mst_category1  a
                WHERE
                    id = {$id}
                ";
//        $this->setFetchClass("RentalCategory");
        $rs = $this->executeQuery($sql);

		if (!$rs) {
			return false;
		}

		$category = $rs[0];
		return $category;
	}

	/**
	 * valueを指定してRentalCategoryを取得する
	 * @param int $category_no
	 * @return RentalCategory
	 */
	public function getRentalCategoryByValue($value) {
		$value = $this->db->quote(addslashes($value));
        $sql = "SELECT
                    a.*
                FROM
                    mst_category1  a
                WHERE
                    value = {$value}
                ";
        $this->setFetchClass("Category1");
        $rs = $this->executeQuery($sql);

		if (!$rs) {
			return false;
		}

		$category = $rs[0];

		return $category;
	}

	/**
	 *
	 * @param int $category_no
	 * @return RentalCategory
	 */
	public function getRentalCategoryByName($name) {
		$value = $this->db->quote(addslashes($name));
        $sql = "SELECT
                    a.*
                FROM
                    mst_category1  a
                WHERE
                    name = {$value}
                ";
//        $this->setFetchClass("RentalCategory");
        $rs = $this->executeQuery($sql);

		if (!$rs) {
			return false;
		}

		return $rs[0];
	}


	/**
	 * カテゴリーを親カテゴりー順番の中のサブカテゴリー順番で取得
	 * @param int $category_no
	 * @return SellCategory
	 */
	public function getRentalCategorySort() {

		$result=array();
		//最初に親カテゴリの順番で取得
		$sql="select c.name,c.id,c.parentid,c.v_order,c.cflag
				FROM mst_category1 AS c
				where c.parentid=0 order by c.v_order ";

//		$this->setFetchClass("Category1");
		$rs = $this->executeQuery($sql);

		foreach($rs as $res){
		        	//親のデータを配列に
        	array_push($result,$res);

        	//該当の親に紐づいている中カテゴリ
	       	$sql="SELECT c.name, c.id,c.parentid,c.v_order,c.cflag
					FROM mst_category1 AS c
					where c.parentid=".$res[id]." ORDER BY c.parentid,c.v_order";

	        		$nrs = $this->executeQuery($sql);
	        		foreach($nrs as $nres){
	        			array_push($result,$nres);

			        	//該当の親に紐づいている小カテゴリー
			        	$sql="SELECT c.name, c.id,c.parentid,c.v_order,c.cflag
							FROM mst_category1 AS c
							where c.parentid=".$nres[id]." ORDER BY c.parentid,c.v_order";

			        		$nrs = $this->executeQuery($sql);
			        		foreach($nrs as $nnres){
			        			array_push($result,$nnres);
			          		}
	          		}
        }
//print_r_with_pre($result);


		return $result;


	}

	/**
	 * レンタルカテゴリーとそのカテゴリーに属している商品数
	 *  ソート順：親カテゴリーの下に紐づいているカテゴリーを表示順に並べる
	 * @param int $category_no
	 * @return RentalCategory
	 */
	public function getRentalCategoryCount() {

		$result=array();
		//最初に親カテゴリの順番で取得
		$sql="select c.name,c.id,c.parentid,c.v_order,c.cflag,c.color_flag,c.size_flag,count( rc.category_id ) as cnt
				FROM mst_category1 AS c
				LEFT JOIN tbl_item_categoryControll AS rc ON rc.item_flag=2 and c.id = rc.category_id
				INNER JOIN pe_rentalitem AS r ON rc.item_id=r.id and r.run=1
				where c.parentid is null group by c.id v_order by c.v_order ";
		$this->setFetchClass("RentalCategory");
		$rs = $this->executeQuery($sql);

		foreach($rs as $res){
        	//親のデータを配列に
 			array_push($result,$res);

 			$cnt=0;

        	//該当の親に紐づいている中カテゴリー(もしくは、中カテゴリー
        	$sql="SELECT c.name, c.id,c.parentid,c.v_order,c.color_flag,c.cflag,c.size_flag,count( rc.category_id ) as cnt
				FROM mst_category1 AS c
				LEFT JOIN tbl_item_categoryControll AS rc ON rc.item_flag=2 and c.id = rc.category_id
				LEFT JOIN pe_rentalitem AS r ON rc.item_id=r.id and r.run=1
				where c.parentid=".$res->getId()." GROUP BY c.id ORDER BY c.parentid,c.v_order";

        		$nrst = $this->executeQuery($sql);

        		foreach($nrst as $nres){
        			array_push($result,$nres);


		        	//該当の親に紐づいている小カテゴリーと商品数
		        	$sql="SELECT c.name, c.id,c.parentid,c.v_order,c.cflag,c.color_flag,c.size_flag,count( rc.category_id ) as cnt
						FROM mst_category1 AS c
						LEFT JOIN tbl_item_categoryControll AS rc ON rc.item_flag=2 and c.id = rc.category_id
						INNER JOIN pe_rentalitem AS r ON rc.item_id=r.id and r.run=1
						where c.parentid=".$nres->getId()." GROUP BY c.id ORDER BY c.parentid,c.v_order";
		        		$nrstmp = $this->executeQuery($sql);

		        		foreach($nrstmp as $nnres){
		        			array_push($result,$nnres);
		        			$cnt+=$nnres->getCnt();
		        		}

        		}

			//大カテゴリに紐づいている中、小カテゴリの数
			$mainCnt[$res->getId()]=$cnt;

        }

		//カテゴリーID
		foreach($result as $item){
			if($item->getParentid()==""){
				$newCnt=$mainCnt[$item->getId()];
				$item->setCnt($newCnt);
			}
			//カテゴリ番号を追加
			$dao=new RentalCategoryDao();
			$ret=$dao->getRentalCategoryByName($item->getName());
			$item->setCategoryId($ret[id]);

		}



		return $result;


	}

	/**
	 * レンタルカテゴリーとそのカテゴリーに属している商品数
	 *  ソート順：親カテゴリーの下に紐づいているカテゴリーを表示順に並べる
	 *
	 *  配列版
	 *  htdocs下でのPHPファイルで使用。
	 *
	 *
	 * @param int $category_no
	 * @return RentalCategory
	 */
	public function getRentalCategoryCount_arr() {

		$result=array();
		//最初に親カテゴリの順番で取得
		$sql="select c.name,c.id,c.parentid,c.v_order,c.cflag,count( rc.category_id ) as cnt
				FROM mst_category1 AS c
				LEFT JOIN tbl_item_categoryControll AS rc ON rc.item_flag=2 and c.id = rc.category_id
				INNER JOIN pe_rentalitem AS r ON rc.item_id=r.id and r.run=1
				where c.parentid is null group by c.id order by c.v_order ";
//echo $sql;
//		$this->setFetchClass("RentalCategory");
		$rs = $this->executeQuery($sql);

		foreach($rs as $res){
        	//親のデータを配列に
 			array_push($result,$res);

 			$cnt=0;

        	//該当の親に紐づいている中カテゴリー(もしくは、小カテゴリー
        	$sql="SELECT c.name, c.id,c.parentid,c.v_order,c.cflag,count( rc.category_id ) as cnt
				FROM mst_category1 AS c
				LEFT JOIN tbl_item_categoryControll AS rc ON rc.item_flag=2 and c.id = rc.category_id
				LEFT JOIN pe_rentalitem AS r ON rc.item_id=r.id and r.run=1
				where c.parentid=".$res[id]." GROUP BY c.id ORDER BY c.parentid,c.v_order";
        		$nrst = $this->executeQuery($sql);

        		foreach($nrst as $nres){
        			array_push($result,$nres);


		        	//該当の親に紐づいている小カテゴリーと商品数
		        	$sql="SELECT c.name, c.id,c.parentid,c.v_order,c.cflag,count( rc.category_id ) as cnt
						FROM mst_category1 AS c
						LEFT JOIN tbl_item_categoryControll AS rc ON rc.item_flag=2 and c.id = rc.category_id
						INNER JOIN pe_rentalitem AS r ON rc.item_id=r.id and r.run=1
						where c.parentid=".$nres[id]." GROUP BY c.id ORDER BY c.parentid,c.v_order";
		        	$nrstmp = $this->executeQuery($sql);

			        	foreach($nrstmp as $nnres){
			        			array_push($result,$nnres);
			        			$cnt+=$nnres[cnt];
			        	}
        		}

			//大カテゴリに紐づいている中、小カテゴリの数
			$mainCnt[$res[id]]=$cnt;

        }

		//カテゴリーID
		for($i=0;$i<count($result);$i++){

			if($result[$i][parentid]==""){
//				$newCnt=$mainCnt[$result[$i][id]];
//				$result[$i][cnt]=$newCnt;
			}


			//カテゴリ番号を追加
			$result[$i][category_id]=$result[$i][id];
/*
			$dao=new RentalCategoryDao();
			$ret=$dao->getRentalCategoryByName($result[$i][name]);
			$result[$i][category_id]=$ret[id];
*/
		}

		return $result;


	}

	/**
	 * レンタル検索用　レンタルカテゴリー サイズ　色
	 *  ソート順：親カテゴリーの下に紐づいているカテゴリーを表示順に並べる
	 *
	 * @param int $category_no
	 * @return RentalCategory
	 */
	public function getRentalCategorySearch_arr($flag) {



		$result=array();
		//最初に親カテゴリの順番で取得
		$sql="select *
				FROM mst_category1 AS c
				where c.parentid is null group by c.id order by c.v_order ";

		$rs = $this->executeQuery($sql);

		foreach($rs as $res){
        	//親のデータを配列に
// 			array_push($result,$res);

 			$cnt=0;

        	//該当の親に紐づいている中カテゴリー(もしくは、小カテゴリー
        	$sql="SELECT *
				FROM mst_category1 AS c
				where c.parentid=".$res[id]." GROUP BY c.id ORDER BY c.parentid,c.v_order";
        		$nrst = $this->executeQuery($sql);

        		foreach($nrst as $nres){
        			array_push($result,$nres);


		        	//該当の親に紐づいている小カテゴリーと商品数
		        	$sql="SELECT *
						FROM mst_category1 AS c
						where c.parentid=".$nres[id]." GROUP BY c.id ORDER BY c.parentid,c.v_order";

		        	$nrstmp = $this->executeQuery($sql);
			        	foreach($nrstmp as $nnres){
			        			array_push($result,$nnres);
			        	}

        		}


        }

		//カテゴリーID
		for($i=0;$i<count($result);$i++){


			//カテゴリ番号を追加
//			$result[$i][category_id]=$result[$i][id];
/*
			$dao=new RentalCategoryDao();
			$ret=$dao->getRentalCategoryByName($result[$i][name]);
			$result[$i][category_id]=$ret[id];
*/
		}

		return $retResult;


	}



	/**
	 * 検索結果一覧
	 * @param RentalCategorySearchCondition $search
	 * @param Int $limit 1ページ内表示件数
	 * @return Array 検索結果
	 */
	public function doSearch(RentalCategorySearchCondition $search, $limit=null) {
		$where = $this->makeSearchCondition($search);
		// 検索制限句生成
		if (!$limit) {
			$limit_str = "";
		}
		else {
			 $limit = (int)$limit;
			 $offset = ((int)$search->getCurPage()  - 1) * $limit;
			 $limit_str = " LIMIT {$limit} OFFSET {$offset} ";
		}
		// ORDER BY句生成
		$order = "";
		if ($search->getOrderByInsertDate()) {
			$order = "ORDER BY insert_date " . $search->getOrderByInsertDate();
		}

		return $this->getRentalCategoryList($where, $limit_str, $order);
	}


	/**
	 * 検索件数を取得
	 * @param RentalCategorySearchCondition $search
	 * @return Int 件数
	 */
	public function doSearchCount(RentalCategorySearchCondition $search) {
		$where = $this->makeSearchCondition($search);
		$sql = "SELECT
					COUNT(*)
				FROM
					mst_category1  a
				{$where}
			 ";
		$this->setFetchMode(PDO::FETCH_NUM);
		return $this->executeQuery($sql);
	}

	/**
	 * 検索条件生成
	 * @param RentalCategorySearchCondition $search
	 * @return String WHERE句
	 */
	private function makeSearchCondition(RentalCategorySearchCondition $search) {
		//$where = " WHERE  ";

		// 親カテゴリNo.
		if ($search->getParentNo() != "") {
			$where .= " AND a.parent_no = '{".addslashes($search->getParentNo())."}' ";
		}

		// カテゴリ名
		if ($search->getCategoryName()) {
			$where .= " AND a.category_name LIKE '%{".addslashes($search->getCategoryName())."}%' ";
		}

		//カテゴリID
		if ($search->getCategoryId()) {
			$where .= " AND c.category_id={$search->getCategoryId()} ";
		}




		// 拡張属性
		if (count($search->getExtAttrList()) > 0) {
			$ecnt = 0;
			foreach ($search->getExtAttrList() as $attr) {
				if (strlen($attr->getAttrKey()) > 0 && strlen($attr->getAttrValue1()) > 0) {
					$ecnt++;
				}
			}

			if ($ecnt != 0) {
				$where .= " AND (";
					$cnt = 0;
					foreach ($search->getExtAttrList() as $attr) {
						if (strlen($attr->getAttrKey()) > 0 && strlen($attr->getAttrValue1()) > 0) {
							if ($cnt > 0) {
								$where .= "AND ";
							}
							$where .= "0<>(SELECT COUNT(attr_no) FROM category_ext_attrs WHERE category_no = a.category_no AND attr_key = '{$attr->getAttrKey()}' AND attr_value1 {$attr->getOperator()} '{$attr->getAttrValue1()}') ";
							$cnt++;
						}
					}
				$where .= ") ";
			}
		}
		return $where;
	}

	/**
	 * RentalCategory登録
	 * @param RentalCategory $category
	 * @return int 直近の挿入行ID
	 */
	public function insert($category) {

		//$parent_id = $this->db->quote($category->getParentid());
		$parent_id = $category->getParentid();
//		if($parent_id=="") $parent_id=NULL;

		$name = $this->db->quote(htmlspecialchars($category->getName(), ENT_QUOTES));
		$order = $this->db->quote(htmlspecialchars($category->getOrder(), ENT_QUOTES));
		$regdate = $this->db->quote(htmlspecialchars($category->getRegdate(), ENT_QUOTES));
		$cflag = $this->db->quote(htmlspecialchars($category->getCflag(), ENT_QUOTES));

		$sql = "INSERT
				INTO mst_category1 (
					parentid
					, name
					, `v_order`
					, regdate
					, cflag
				)
				VALUES (
					$parent_id
					, {$name}
					, {$order}
					, {$regdate}
					, {$cflag}
				);
			";

		$this->db->beginTransaction();
		try{
			// 実行
			$this->executeUpdate($sql);
/*
			$id = $this->db->lastInsertId();
			$category->setRentalCategoryNo($id);
*/
			// コミット
			$this->db->commit();

		}catch(Exception $e){
			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'RentalCategory'." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

/*
		// RentalCategoryExtAttrの登録
		$ext_attr_dao = new RentalCategoryExtAttrDAO();
		foreach ($category->getExtAttrList() as $attr) {
			$attr->setRentalCategoryNo($category->getRentalCategoryNo());
			$ext_attr_dao->insert($attr);
		}

		return $lastInsertId;
*/
	}

	/**
	 * RentalCategory更新
	 * @param RentalCategory $category
	 * @return Boolean 処理結果
	 */
	public function update($category,$id) {

		/*
		$category_no = $this->db->quote($category->getCategoryNo());
		$parent_no = $this->db->quote($category->getParentNo());
		$category_name = $this->db->quote($category->getCategoryName());
		$sort = $this->db->quote($category->getSort());
*/

		if($category->getOrder()){
			$setTmp[]=" `v_order` =".$category->getOrder();
		}
		if($category->getName()){
			$setTmp[]=" name ='".$category->getName()."'";
		}

		$setValue=implode(",",$setTmp);



		$sql = "UPDATE mst_category1  SET
				{$setValue}
			WHERE
					id={$id}
		";
//echo $sql;
		$this->db->beginTransaction();
		try{
			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();

		}catch(Exception $e){
			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to update 'Category'." . $e);
			$this->db->rollBack();
			return false;
		}
/*
		// CategoryExtAttrの登録
		$ext_attr_dao = new CategoryExtAttrDAO();
		foreach ($category->getExtAttrList() as $attr) {
			$attr->setCategoryNo($category->getCategoryNo());
			$ext_attr_dao->update($attr);
		}
*/
		return true;
	}

	/**
	 * Category削除
	 * @param Category $category
	 * @return Boolean 処理結果
	 */
	public function delete(RentalCategory $category) {

/*
		// CategoryExtAttrの削除
		$ext_attr_dao = new CategoryExtAttrDAO();
		foreach ($category->getExtAttrList() as $attr) {
			$attr->setCategoryNo($category->getCategoryNo());
			$ext_attr_dao->delete($attr);
		}
*/
		$id = $this->db->quote(addslashes($category->getId()));
		$sql = "DELETE FROM mst_category1
				WHERE id = {$id}";
//echo $sql;
	    $this->db->beginTransaction();
	    try {
	    	// 実行
	    	$this->executeUpdate($sql);

	    	// コミット
			$this->db->commit();

	    }catch(Exception $e){
			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to delete 'Category'." . $e);
			$this->db->rollBack();
			return false;
		}
		return true;
	}

	//


	/*
	 *中カテゴリid から、大カテゴリ名と中カテゴリ名を取得する
	 *
	 */
	public function getCatgoryName($m_id) {
		$id = $this->db->quote(addslashes($m_id));

       $sql = "SELECT
                    *
                FROM
                    mst_category1
                WHERE
                    id ={$id}";

        $rs = $this->executeQuery($sql);

		$ret[m_name]=$rs[0][name];

		//大カテゴリ
      $sql = "SELECT
                    *
                FROM
                    mst_category1
                WHERE
                    id ='".addslashes($rs[0][parentid])."'";

        $rs = $this->executeQuery($sql);
		$ret[b_name]=$rs[0][name];


		return $ret;

	}


}
?>