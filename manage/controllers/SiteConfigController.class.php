<?php
class SiteConfigController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
		require_once sprintf("%s/structure/SiteConfig.class.php", MODEL_PATH);
		require_once sprintf("%s/condition/SiteConfigSearchCondition.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/SiteConfigDao.class.php", MODEL_PATH);
	}

	// トップページ表示
    public function displayAction() {

    	$configDao = new SiteConfigDao();

    	// formがsubmitされた
    	if (isset($_REQUEST["submit_data"])) {
    		for ($i=0; $i<count($_REQUEST["config_key"]); $i++) {
    			$config = $configDao->getSiteConfig($_REQUEST["config_key"][$i]);
    			if ($config) {
    				$config->setConfigValue($_REQUEST["config_value"][$i]);
    				$configDao->update($config);
    			}
    		}

    		$this->addMessage(SYSTEM_MESSAGE_INFO, "システム設定を更新しました");
    	}

    	// 設定一覧を取得
    	$search = new SiteConfigSearchCondition();
    	$configList = $configDao->doSearch($search);
    	$this->view->assign("config_list", $configList);

    	// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        $this->setTemplatePath("site-config/edit.tpl");
        return;
	}


}
?>