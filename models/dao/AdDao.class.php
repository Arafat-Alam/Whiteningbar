<?php
class AdDao extends DaoBase {

	/**
	 * バナー　表示、期間内、指定場所のバナーを取得
	 * @param unknown_type $where
	 * @param unknown_type $limit
	 * @param unknown_type $order
	 */
	public function getAdList($search) {

		//期間
		$tdy=date("Y-m-d H:i:s");

		$whTmp[]=" view_start <= '".$tdy."'";
		$whTmp[]=" view_end >= '".$tdy."'";
		$whTmp[]=" view_flg=1";

		$whTmp[]=" p_point='".addslashes($search["p_point"])."'";

		$whTmp[]=" v_point='".addslashes($search["v_point"])."'";


		$wh =implode(" and ",$whTmp);

		$sql="select * from mst_ad where" .$wh." order by v_order";

		return $this->executeQuery($sql);
	}

	public function getCategoryList($where="", $limit="", $order="") {
		if ($order == "") $order = " ORDER BY a.v_order ASC ";
		$sql = "SELECT
		            a.*
				FROM
					mst_ad  a
				{$where}
				{$order}
				{$limit}
			 ";

		$categories_src = $this->executeQuery($sql);
		return $categories_src;
	}


}
?>