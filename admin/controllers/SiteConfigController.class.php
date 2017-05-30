<?php
class SiteConfigController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
//		require_once sprintf("%s/structure/SiteConfig.class.php", MODEL_PATH);
		require_once sprintf("%s/dao/SiteConfigDao.class.php", MODEL_PATH);
	}

	// トップページ表示
    public function displayAction() {

    	$configDao = new SiteConfigDao();
    	$commonDao = new CommonDao();

    	// formがsubmitされた
    	if (isset($_REQUEST["submit_data"])) {
    		for ($i=0; $i<count($_REQUEST["config_key"]); $i++) {
    			$config = $configDao->getSiteConfig($_REQUEST["config_key"][$i]);
    			if ($config) {

    				$ret=$commonDao->updateData("site_config", "config_value", $_REQUEST["config_value"][$i], "config_key", $_REQUEST["config_key"][$i]);

    				if(!$ret){
    					$this->addMessage("error", "サイト表示設定の更新エラーです");
    				}

    			}
    		}

    		$this->addMessage(info, "サイト表示設定を更新しました");
    	}


    	$siteColorArr=CommonArray::$siteColor_array;
    	$this->view->assign("siteColorArr", $siteColorArr);



    	// 設定一覧を取得
//    	$search = new SiteConfig();

    	$configList = $configDao->doSearch($search);

    	$this->view->assign("config_list", $configList);

    	// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        $this->setTemplatePath("site-config/edit.tpl");
        return;
	}

}
?>