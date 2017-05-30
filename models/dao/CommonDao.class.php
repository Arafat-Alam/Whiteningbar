<?php
/*
 * 各テーブル共通で使えるような基本的・単純的処理
 *
 * テーブルごとに違う処理はここには書かない。
 *
 */


class CommonDao extends DAOBase{


function set_db($db_conne = null){

	 	$this->setDbConne($db_conne);

		$this->dbConne = $db_conne;

}
function get_db(){

	 return $this->dbConne;

}




/* ********* テーブルデータの取得　**************
      関数名　：　get_data_tbl
      引数　　：
　　　戻り値　：　
　　　内容　　：　テーブルデータの取得
                  条件が全部　and 検索の場合
********************************************************* */
function get_data_tbl($tbl,$fi="",$dt="",$orderby="",$limit="",$page="1"){

	$where="";
	$ord="";

	if($orderby<>""){
		if(is_array($orderby)){
	            for ($i=0;$i<count($orderby);$i++){
		    	$tmpo[]=$orderby[$i];
		    }

		    $ord="order by ".implode(",",$tmpo);

		}else{
			$ord=" order by $orderby ";
		}
	}
	if(is_array($fi)){
            for ($i=0;$i<count($fi);$i++){
	    		$tmp[]=$fi[$i]."='".addslashes($dt[$i])."'";
	    	}

	    $where="where ".implode(" and ",$tmp);

	}else if($fi){
		$where="where $fi='".addslashes($dt)."'";
	}

	//リミット
		if (!$limit) {
			$limit_str = "";
		} else {
			 $limit = (int)$limit;
			 $offset = ((int)$page  - 1) * $limit;
			 $limit_str = " LIMIT {$limit} OFFSET {$offset} ";
		}

	$sql ="select * from $tbl $where $ord $limit_str";
//  echo $sql;
// echo "<BR>";

	//$this->dbConnection();
	//$rs = $this->executeQuery($sql,$this->get_db());

	$this->setFetchMode(PDO::FETCH_ASSOC);//配列モードで取得
	$rs = $this->executeQuery($sql);

	//FETCH_ASSOC

	$Arr=array();
	for($i=0;$i<count($rs);$i++){
		foreach ($rs[$i] as $key => $val){
			$data{$key} = stripslashes(rtrim($val));
		}
		array_push($Arr,$data);
	}

	return $Arr;

}

/* ********* テーブルデータの取得　**************
      関数名　：　get_data_tbl
      引数　　：
　　　戻り値　：　
　　　内容　　：　テーブルデータの取得
                  条件が全部　and 検索の場合
********************************************************* */
function get_data_tbl2($tbl,$fi="",$orderby="",$limit="",$page="1"){

	$where="";
	$ord="";

	if($orderby<>""){
		if(is_array($orderby)){
	            for ($i=0;$i<count($orderby);$i++){
		    	$tmpo[]=$orderby[$i];
		    }
		    $ord="order by ".implode(",",$tmpo);

		}else{
			$ord=" order by $orderby ";
		}
	}

	if($fi){
		foreach($fi as $key=>$val){
	    	$tmp[]=$key."='".addslashes($val)."'";
		}

		$where="where ".implode(" and ",$tmp);
	}
	//リミット
		if (!$limit) {
			$limit_str = "";
		} else {
			 $limit = (int)$limit;
			 $offset = ((int)$page  - 1) * $limit;
			 $limit_str = " LIMIT {$limit} OFFSET {$offset} ";
		}

	$sql="select * from $tbl $where $ord $limit_str";
/*echo $sql;
echo "<BR>";exit;*/

	$rs = $this->executeQuery($sql);

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
	*	指定テーブルの新規登録
	 *
	 */
	public function InsertItemData($tbl,$fi,$dt) {

		if(is_array($fi)){
	           	for ($i=0;$i<count($fi);$i++){
			    	$tmp1[]=$fi[$i];
					$va=trim($dt[$i]);
					$tmp2[]="'".htmlspecialchars($va, ENT_QUOTES)."'";
//					$tmp2[]="'".$va."'";
		    	}
		}else if($fi){
		    $tmp1[]=$fi;
			$dt=trim($dt);
//			$dt=htmlspecialchars(addslashes($dt));
			$tmp2[]="'".htmlspecialchars($dt, ENT_QUOTES)."'";
		}
		$ins=implode(",",$tmp1);
		$valu=implode(",",$tmp2);

		$sql="insert into $tbl($ins) values($valu)";
		// echo $sql;exit();
		$this->dbConnection();
		$this->db->beginTransaction();
try {

			// 実行
			//$this->executeUpdate($sql,$this->get_db());
			$this->executeUpdate($sql);
			// 直近の挿入行IDを取得
			$lastInsertId = $this->db->lastInsertId();
			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'SellItem'." . $e);
			$this->db->rollBack();
			return false;
		}

		return $lastInsertId;

	}


	/**
	*	指定テーブルの新規登録
	 *
	 */
	public function InsertItemData2($tbl,$fi) {


		if($fi){
			foreach($fi as $key=>$val){
			    $tmp1[]=$key;
				$va=trim($val);
				$tmp2[]="'".htmlspecialchars($va, ENT_QUOTES)."'";
			}
		}

		$ins=implode(",",$tmp1);
		$valu=implode(",",$tmp2);

		$sql="insert into $tbl($ins) values($valu)";

		$this->db->beginTransaction();
try {

			// 実行
			$this->executeUpdate($sql);
			// 直近の挿入行IDを取得
			$lastInsertId = $this->db->lastInsertId();

			// コミット
			$this->db->commit();
		}catch(Exception $e){


			write_log($sql);


			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'SellItem'." . $e);
			$this->db->rollBack();
			return false;
		}

		return $lastInsertId;
		//return true;

	}

/*
 * 指定テーブルのアップデート
 *
 * アップデートの検索条件が全てS
 *
 *
 */
	public function updateData($tbl,$fi,$dt,$wfi,$wdt) {

		if(is_array($fi)){
	           	for ($i=0;$i<count($fi);$i++){
					$va=trim($dt[$i]);
//					$tmp1[]=$fi[$i]."='".$va."'";
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

		$sql="update $tbl set $ins $where ";

		// print $sql."<br>";exit();
		$this->dbConnection();
		$this->db->beginTransaction();
		try {

			// 実行
			//$this->executeUpdate($sql,$this->get_db());
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();

		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to Update." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

	}
	public function updateData2($tbl,$fi,$wfi) {
		// echo "<pre>"; print_r($fi); exit();

		if($fi){
			foreach($fi as $key=>$val){
					$va=trim($val);
//					$tmp1[]=$fi[$i]."='".$va."'";
					$tmp1[]=$key."='".htmlspecialchars($va, ENT_QUOTES)."'";
			}
		}
		$ins=implode(",",$tmp1);

		if($wfi){
			foreach($wfi as $key=>$val){
		    	$tmp[]=$key."='".$val."'";
			}
		}
		$where=" where ".implode(" and ",$tmp);

		$sql="update $tbl set $ins $where ";

 		$this->db->beginTransaction();
		try {

			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();

		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to Update." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

	}

/*
 * 指定テーブルの削除
 *
 *
 *
 */

function del_Data($tbl,$fi,$dt){


	if(is_array($fi)){
        for ($i=0;$i<count($fi);$i++){
			//$va=mb_convert_encoding($dt[$i],"EUC","UTF-8");
	    	$tmp[]=$fi[$i]."='".addslashes($dt[$i])."'";
	    }
	    $where="where ".implode(" and ",$tmp);
	}else if($fi){
		$where="where $fi='".addslashes($dt)."'";
	}

	$sql="delete from $tbl $where";

		$this->dbConnection();
		$this->db->beginTransaction();
		try {

			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){

			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to delete." . $e);
			$this->db->rollBack();
			return false;
		}

		return true;

}


/* ********* SQL処理　**************
      関数名　：　get_sql
      引数　　：  $sql:sql文
　　　戻り値　：　
　　　内容　　：　$sqlのSQL文のデータ取得

********************************************************* */
function get_sql($sql,$dbname=""){

	//$this->dbConnection(); //comment by arafat
	//$rs = $this->executeQuery($sql,$this->get_db());

	$rs = $this->executeQuery($sql);

	$Arr=array();
	for($i=0;$i<count($rs);$i++){
		foreach ($rs[$i] as $key => $val){
			$data{$key} = stripslashes(rtrim($val));
		}
		array_push($Arr,$data);
	}

	return $Arr;

}


function run_sql($sql,$dbname=""){

	$this->dbConnection();
	$this->db->beginTransaction();
	try {

		// 実行
		$this->executeUpdate($sql);

		// コミット
		$this->db->commit();
	}catch(Exception $e){

		$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to run sql." . $e);
		$this->db->rollBack();
		return false;
	}

	return true;

}
/* ********* カテゴリー（親子）取得処理　**************
      関数名　：　get_sql
      引数　　：  $sql:sql文
　　　戻り値　：　
　　　内容　　：　$sqlのSQL文のデータ取得

********************************************************* */
function get_category_sort($tbl){


		$result=array();
		//最初に親カテゴリの順番で取得
//		$sql="select c.name,c.id,c.parentid,c.v_order,c.cflag
		$sql="select c.*
				FROM ".$tbl." AS c
				where c.parentid=0 order by c.v_order ";

//		$this->setFetchClass("Category1");
		$rs = $this->executeQuery($sql);

		foreach($rs as $res){
		        	//親のデータを配列に
        	array_push($result,$res);

        	//該当の親に紐づいている中カテゴリ
	       	$sql="SELECT c.*
					FROM ".$tbl." AS c
					where c.parentid=".$res['id']." ORDER BY c.parentid,c.v_order";


	        		$nrs = $this->executeQuery($sql);
	        		foreach($nrs as $nres){
	        			array_push($result,$nres);

			        	//該当の親に紐づいている小カテゴリー
			        	$sql="SELECT c.*
							FROM ".$tbl." AS c
							where c.parentid=".$nres['id']." ORDER BY c.parentid,c.v_order";

			        		$nrs = $this->executeQuery($sql);
			        		foreach($nrs as $nnres){
			        			array_push($result,$nnres);
			          		}
	          		}
        }

		return $result;

}

/* ********* カテゴリー（親子）取得処理　**************
      関数名　：　get_categoryArr
      引数　　：  $tbl:table名
      			  $flg:1=中カテまで　2:小カテまで
　　　戻り値　：　
　　　内容　　：　$sqlのSQL文のデータ取得

********************************************************* */
function get_categoryArr($tbl){

	$categoryArr=array();

		$result=array();
		//最初に親カテゴリの順番で取得
		$sql="select c.name,c.id,c.parentid,c.v_order,c.cflag
				FROM ".$tbl." AS c
				where c.parentid=0 order by c.v_order ";

		$rs = $this->executeQuery($sql);

		//該当カテゴリを親にもとカテゴリをその下にまとめる
		$cnt=0;
		foreach($rs as $res){

			$categoryArr[$cnt]['id']=$res['id'];
			$categoryArr[$cnt]['name']=$res['name'];
       		//該当の親に紐づいている中カテゴリ
	       	$sql="SELECT c.name, c.id,c.parentid,c.v_order,c.cflag
					FROM ".$tbl." AS c
					where c.parentid=".$res['id']." ORDER BY c.parentid,c.v_order";

	        $nrs = $this->executeQuery($sql);
	        for($i=0;$i<count($nrs);$i++){

	        	$categoryArr[$cnt]['m_name'][$nrs[$i]['id']]=$nrs[$i]['name'];
	        	$categoryArr[$cnt]['m_id'][$i]=$nrs[$i]['id'];

	        }

	       	$cnt++;

		}

		return $categoryArr;
}

}


?>