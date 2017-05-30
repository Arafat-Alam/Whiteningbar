<?php
class IndexController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
	}

	// トップページ表示
    public function displayAction() {

    	// HTTPレスポンスヘッダ情報出力
		$this->outHttpResponseHeader();

        $this->setTemplatePath("index.tpl");
        return;
	}


}
?>