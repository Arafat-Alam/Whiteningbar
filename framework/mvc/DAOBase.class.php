<?php
class DAOBase extends MVCBase {

	protected $db;
	private $error;
	private $fetchMode;
	private $fetchClass;


	//arafat
	private $dsn;
	private $db_user;
	private $db_pass;

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
		$this->db = $this->getConnection();
		$this->initFetchMode();
	}

	public function dbConnection() {
		$this->__destruct();

		$this->db = $this->getConnection();
		$this->initFetchMode();
	}

	/**
	 * デストラクタ
	 * Enter description here ...
	 */
 	public function __destruct() {
        $this->db = null;
    }

	//-------- 複数DBを使用する際に必要  ここから------
 	public function setDbConne($db_conne = null) {

  		/*$this->setDsn($db_conne[dsn]);
 		$this->setDbUser($db_conne[db_user]);
 		$this->setDbPass($db_conne[db_pass]);
		*/
 		$this->setDsn('mysql:dbname=whitening;host=localhost');
 		$this->setDbUser('root');
 		$this->setDbPass('');
 	}
	public function getDsn()
	{

	    return $this->dsn;
	}
	public function setDsn($dsn)
	{

	    $this->dsn = $dsn;
	}
	public function getDbUser()
	{
	    return $this->db_user;
	}
	public function setDbUser($db_user)
	{
	    $this->db_user = $db_user;
	}
	public function getDbPass()
	{
	    return $this->db_pass;
	}
	public function setDbPass($db_pass)
	{
	    $this->db_pass = $db_pass;
	}


	public function getDAODb()
	{
	    return $this->db;
	}
	public function setDAODb($db)
	{
	    $this->db = $db;
	}



	//----- ここまで ----------------------------------------


    /**
     * DB接続を返す
     */
	function getConnection() {


		$dsn=$this->getDsn();
		$db_user=$this->getDbUser();
		$db_pass=$this->getDbPass();

		if($dsn==""){
			$db_conne = new CommonArray;


			/*$dsn=$db_conne[dsn];
			$db_user=$db_conne[db_user];
			$db_pass=$db_conne[db_pass];*/
		}

		try {
			$db = new PDO(DSN, DB_USER, DB_PASS);
//			$db = new PDO($dsn, $db_user, $db_pass);

			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->query("SET NAMES utf8");
			return $db;
		}catch (Exception $e) {
			$this->logger->error("Exception:" . $e);
			print($e->getMessage());
		}

	}

	/**
	 * 更新系クエリを実行する
	 * @param unknown_type $sql
	 * @throws Exception
	 */
	protected function executeUpdate($sql,$db_conne=array()) {

		$this->logger->debug($sql);
		$result = true;
		try {
			$result = $this->db->exec($sql);
		}catch (Exception $e) {
			print($e);
			$this->logger->error("Exception:" . $e);
			throw new Exception($e);
		}


		return $result;
	}

	/**
	 * 戻り値取得系クエリを実行する
	 * @param unknown_type $sql
	 * @throws Exception
	 */
	protected function executeQuery($sql,$db_conne=array()) {

		ini_set('memory_limit', '1024M');
		
		$this->logger->debug($sql);
		$rs = true;
		try {
			$stmt = $this->db->query($sql);

			switch ($this->getFetchMode()) {
				case PDO::FETCH_CLASS:
					$stmt->setFetchMode($this->getFetchMode(), (String)$this->getFetchClass());
					$rs = $stmt->fetchAll();
					// echo count($rs);
					if (is_null($rs)) {
						$rs = false;
					}
					break;
				case PDO::FETCH_ASSOC:
					$stmt->setFetchMode(PDO::FETCH_ASSOC);
					$rs = $stmt->fetchAll();

					break;
				case PDO::FETCH_NUM:
					$stmt->setFetchMode(PDO::FETCH_NUM);
					$rs = $stmt->fetch();

					if (is_null($rs)) {
						$rs = 0;
					}
					else {
						if (count($rs) == 1) {
							$rs = $rs[0];
						}
					}
					break;
			}

			$stmt->closeCursor();
			$this->initFetchMode();
		}catch (Exception $e) {
			print($e);
			$this->logger->error("Exception:" . $e);
			throw new Exception($e);
		}
		return $rs;

	}

	/**
	 * FetchModeの初期化
	 */
	private function initFetchMode() {
		$this->fetchMode = PDO::FETCH_CLASS;
	}

    /**
	 * エラーメッセージを返す
	 * @return String エラーメッセージ
	 */
	protected function getError() {
		return $this->error;
	}

	public function getFetchMode()
	{
	    return $this->fetchMode;
	}

	public function setFetchMode($fetchMode)
	{
	    $this->fetchMode = $fetchMode;
	}

	public function getFetchClass()
	{
	    return $this->fetchClass;
	}

	public function setFetchClass($fetchClass)
	{
	    $this->fetchClass = $fetchClass;
	}
}
?>