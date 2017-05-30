<?php
class SiteConfigDao extends DAOBase{

	/**
	 * SiteConfig一覧情報を取得する
	 * @param String $where WHERE句
	 * @param String $limit LIMIT句
	 * @return type
	 */
	public function getSiteConfigList($where="", $limit="", $order="") {
		if ($order == "") $order = " ORDER BY sort ASC ";
		$sql = "SELECT
					a.*
				FROM
					site_config a
				{$where}
				{$order}
				{$limit}
			 ";
//		$this->setFetchClass("SiteConfig");
		return $this->executeQuery($sql);
	}

	/**
	 * SiteConfigを取得する
	 * @param String $config_key
	 * @return SiteConfigオブジェクト（検索できなかった時はnull）
	 */
	public function getSiteConfig($config_key) {
		$config_key = $this->db->quote(addslashes($config_key));
        $sql = "SELECT
        			a.*
                FROM
                    site_config a
                WHERE
                    a.config_key = {$config_key}
                ";
        $this->setFetchClass("SiteConfig");
        $rs = $this->executeQuery($sql);
		if (!$rs) return false;
        return $rs[0];
	}

	/**
	 * 検索結果一覧
	 * @param SiteConfig $search
	 * @param Int $limit 1ページ内表示件数
	 * @return Array 検索結果
	 */
	public function doSearch($search, $limit=null) {
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
		return $this->getSiteConfigList($where, $limit_str);
	}

	/**
	 * 検索条件生成
	 * @param SiteConfigSearchCondition $search
	 * @return String WHERE句
	 */
	private function makeSearchCondition($search) {
		$where = " WHERE 1=1 ";

		// ConfigKey
		if ($search[config_key]) {
			$where .= " AND a.config_key = '".addslashes($search[config_key])."' ";
		}

		return $where;
	}

	/**
	 * 検索件数を取得
	 * @param SiteConfigSearchCondition $search
	 * @return Int 件数
	 */
	public function doSearchCount($search) {
		$where = $this->makeSearchCondition($search);
		$sql = "SELECT
					COUNT(a.config_key)
				FROM
					site_config a
				{$where}
			 ";
//		$this->setFetchMode(PDO::FETCH_NUM);
		return $this->executeQuery($sql);
	}

	/**
	 * SiteConfig更新
	 * @param SiteConfig $config
	 * @return Boolean 処理結果
	 */
	public function update(SiteConfig $config) {
		$config_key = $this->db->quote(htmlspecialchars($config->getConfigKey(), ENT_QUOTES));
		$config_name = $this->db->quote(htmlspecialchars($config->getConfigName(), ENT_QUOTES));
		$config_value = $this->db->quote(htmlspecialchars($config->getConfigValue(), ENT_QUOTES));
		$config_explain = $this->db->quote(htmlspecialchars($config->getConfigExplain(), ENT_QUOTES));
		$sort = $this->db->quote(htmlspecialchars($config->getSort(), ENT_QUOTES));
		$data_type = $this->db->quote(htmlspecialchars($config->getDataType(), ENT_QUOTES));
		$length = $this->db->quote(htmlspecialchars($config->getLength(), ENT_QUOTES));

		$sql = "UPDATE site_config
				SET
					config_name = {$config_name}
					, config_value = {$config_value}
					, config_explain = {$config_explain}
					, sort = {$sort}
					, data_type = {$data_type}
					, length = {$length}
				WHERE
					config_key = {$config_key}
				";

		$this->db->beginTransaction();
		try{
			// 実行
			$this->executeUpdate($sql);

			// コミット
			$this->db->commit();
		}catch(Exception $e){
			$this->addMessage(SYSTEM_MESSAGE_ERROR, "Failed to update 'SiteConfig'. " . $e);
			$this->db->rollBack();
			return false;
		}
		return true;
	}
}
?>


