<?php
class SiteAdminDao extends DAOBase{

	/**
	 * サイト管理者一覧情報を取得する
	 * @param String $where WHERE句
	 * @param String $limit LIMIT句
	 * @return type
	 */
	public function getAdminList($where="", $limit="", $order="") {
		if ($order == "") $order = " ORDER BY admin_no ASC ";
		$sql = "SELECT
					a.*
				FROM
					site_administrators a
				{$where}
				{$order}
				{$limit}
			 ";

		$this->setFetchClass("SiteAdmin");
		return $this->executeQuery($sql);
	}

	/**
	 * サイト管理者情報を取得する
	 * @param int $admin_no 管理者No.
	 * @return SiteAdminオブジェクト（検索できなかった時はnull）
	 */
	public function getAdmin($admin_no) {
		$admin_no = $this->db->quote($admin_no);
        $sql = "SELECT
        			a.*
                FROM
                    site_administrators a
                WHERE
                    a.admin_no = {$admin_no}
                ";
//        $this->setFetchClass("SiteAdmin");
        $rs = $this->executeQuery($sql);
		if (!$rs) return false;
        return $rs[0];
	}

	/**
	 * 検索結果一覧
	 * @param SiteAdminSearchCondition $search SearcInfoオブジェクト
	 * @param Int $limit 1ページ内表示件数
	 * @return Array 検索結果
	 */
	public function doSearch($search="", $limit=null) {
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
		return $this->getAdminList($where, $limit_str);
	}

	/**
	 * 検索条件生成
	 * @param SearchCondition $search SiteAdminSearchConditionオブジェクト
	 * @return String WHERE句
	 */
	private function makeSearchCondition($search="") {
		$where = " WHERE 1=1 ";

		// ユーザーID
		if (isset($search['user_id'])) {
			$where .= " AND a.user_id = '".addslashes($search['user_id'])."' ";
		}

		// パスワード
		if (isset($search['password'])) {
			$where .= " AND a.password = '" . to_hash(addslashes($search['password'])) . "' ";
		}

		// 名前
		if (isset($search['user_name'])) {
			$where .= " AND a.user_name LIKE '%".addslashes($search['user_name'])."%' ";
		}

		// ステータス
		if (isset($search['status'])) {
			$where .= " AND a.status = '".addslashes($search['status'])."' ";
		}

		// 店舗
		if (isset($search['shop_no'])) {
			$where .= " AND a.shop_no = '".addslashes($search['shop_no'])."' ";
		}

		// 予約情報権限
		if (isset($search['reserve_auth_type'])) {
			$where .= " AND a.reserve_auth_type = '".addslashes($search['reserve_auth_type'])."' ";
		}

		// お客様情報権限
		if (isset($search['member_auth_type'])) {
			$where .= " AND a.member_auth_type = '".addslashes($search['member_auth_type'])."' ";
		}



/*
		// AdminNo不一致条件
		if ($search->getAdminNoNotIn()) {
			$where .= " AND a.admin_no NOT IN('".addslashes($search->getAdminNoNotIn())."') ";
		}
		// ステータス
		if ($search->getStatus()) {
			$where .= " AND a.status = '".addslashes($search->getStatus())."' ";
		}

		// ユーザーID
		if ($search->getUserId()) {
			$where .= " AND a.user_id = '{$search->getUserId()}' ";
		}

		// パスワード
		if ($search->getPassword()) {
			$where .= " AND a.password = '" . to_hash($search->getPassword()) . "' ";
		}

		// 名前
		if ($search->getUserName()) {
			$where .= " AND a.user_name LIKE '%{$search->getUserName()}%' ";
		}

		// 管理者種別
		if ($search->getAdminType()) {
			$where .= " AND a.manager_type = '{$search->getManagerType()}' ";
		}
*/


		return $where;
	}

	/**
	 * 検索件数を取得
	 * @param SiteAdminSearchCondition $search SiteAdminSearchConditionオブジェクト
	 * @return Int 件数
	 */
	public function doSearchCount(SiteAdminSearchCondition $search) {
		$where = $this->makeSearchCondition($search);
		$sql = "SELECT
					COUNT(a.admin_no)
				FROM
					site_administrators a
				{$where}
			 ";
		$this->setFetchMode(PDO::FETCH_NUM);
		return $this->executeQuery($sql);
	}

	/**
	 * サイト管理者登録
	 * @param SiteAdmin $admin SiteAdminオブジェクト
	 * @return Int 登録されたadmin_no
	 */
	public function insert(SiteAdmin $admin) {

		$user_id = $this->db->quote(htmlspecialchars($admin->getUserId(), ENT_QUOTES));
		$password = $this->db->quote(htmlspecialchars($admin->getPassword(), ENT_QUOTES));
		$email = $this->db->quote(htmlspecialchars($admin->getEmail(), ENT_QUOTES));
		$user_name = $this->db->quote(htmlspecialchars($admin->getUserName(), ENT_QUOTES));
		$admin_type = $this->db->quote(htmlspecialchars($admin->getAdminType(), ENT_QUOTES));
		$status = $this->db->quote(htmlspecialchars($admin->getStatus(), ENT_QUOTES));
//		$insert_user_id = $this->db->quote(htmlspecialchars(addslashes($admin->getInsertUserId())));
//		$update_user_id = $this->db->quote(htmlspecialchars(addslashes($admin->getUpdateUserId())));
		$sql = "INSERT
				INTO site_administrators(
					user_id
					, password
					, email
					, user_name
					, admin_type
					, status
					, insert_date
					, update_date
				)
				VALUES (
					{$user_id}
					, {$password}
					, {$email}
					, {$user_name}
					, {$admin_type}
					, {$status}
					, NOW()
					, NOW()
				);
			";
 		$this->db->beginTransaction();
		try{
			// 実行
			$this->executeUpdate($sql);

			// 直近の挿入行IDを取得
			$lastInsertId = $this->db->lastInsertId();

			// コミット
			$this->db->commit();
		}catch(Exception $e){
			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to insert 'SiteAdmin'. " . $e);
			$this->db->rollBack();
			return;
		}

		// 直近の挿入行IDを返す
		return $lastInsertId;
	}

	/**
	 * サイト管理者更新
	 * @param SiteAdmin $admin
	 * @return Boolean 処理結果
	 */
	public function update(SiteAdmin $admin) {
		$admin_no = $this->db->quote(htmlspecialchars($admin->getAdminNo(), ENT_QUOTES));
		$user_id = $this->db->quote(htmlspecialchars($admin->getUserId(), ENT_QUOTES));
		$password = $this->db->quote(htmlspecialchars($admin->getPassword(), ENT_QUOTES));
		$email = $this->db->quote(htmlspecialchars($admin->getEmail(), ENT_QUOTES));
		$user_name = $this->db->quote(htmlspecialchars($admin->getUserName(), ENT_QUOTES));
		$admin_type = $this->db->quote(htmlspecialchars($admin->getAdminType(), ENT_QUOTES));
		$status = $this->db->quote(htmlspecialchars($admin->getStatus(), ENT_QUOTES));
//		$update_user_id = $this->db->quote(htmlspecialchars(addslashes($admin->getUpdateUserId())));
		$sql = "UPDATE site_administrators
				SET
					user_id = {$user_id}
					, password = {$password}
					, email = {$email}
					, user_name = {$user_name}
					, admin_type = {$admin_type}
					, status = {$status}
					, update_date = NOW()
				WHERE
					admin_no = {$admin_no};
				";


		$this->db->beginTransaction();
		try{
			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){
			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to update 'SiteAdmin'. " . $e);
			$this->db->rollBack();
			return false;
		}
		return true;
	}

	/**
	 * サイト管理者削除
	 * @param SiteAdmin $admin
	 * @return Boolean 処理結果
	 */
	public function delete(SiteAdmin $admin) {
		$admin_no = $this->db->quote(addslashes($admin->getAdminNo()));
		$this->db->beginTransaction();
		try{
			$sql = "DELETE
					FROM
						site_administrators
					WHERE admin_no = {$admin_no}
			";

			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){
			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to delete 'SiteAdmin'. " . $e);
			$this->db->rollBack();
			return false;
		}
		return true;
	}

	/**
	 * ユーザーIDを生成する
	 * @return 生成されたユーザーID
	 */
	function getGgeneratedUserId(){
		while(true){
			$user_id = get_random_string(8);
			$search = new SiteAdminSearchCondition();
			$search->setUserId($user_id);
			if ($this->doSearchCount($search) == 0) {
				return $user_id;
			}
		}
	}

}
?>


