<?php
require_once("../../libs/Smarty-2.6.26/libs/Smarty.class.php");
require_once("Request.class.php");

class Dispatcher {

    private $sysRoot;

    /**
     * システムのルートディレクトリを設定
     * @param unknown_type $path
     */
    public function setSystemRoot($path) {
		$this->sysRoot = rtrim($path, "/");
    }

    /**
     * 振分け処理実行
     */
	public function dispatch() {

		// パラメーター取得（末尾の / は削除）
		$param = mb_ereg_replace("/?$", "", $_SERVER["REQUEST_URI"]);
		
		$params = array();

		if ("" != $param) {
			// パラメーターを / で分割
			$params = explode("/", $param);
		}


		// URLパラメータからcontrollerとactionを取得
		if (count($params) < 3) {

			// controllerを取得
			if (isset($_REQUEST["controller"])) {
				$controller = $_REQUEST["controller"];
			}

			// actionを取得
			if (isset($_REQUEST["action"])) {
				$action = $_REQUEST["action"];
			}

			if ($controller == "") {
				$controller = $params[1];
				$action = "display";
			}
		}
		// URLパスからcontrollerとactionを取得
		else {
			// 1番目のパラメーターをcontrollerとして取得
			$controller = $params[1];

			// controllerが未指定でパラメータが渡された場合はIndexControllerに渡す
			if (strstr($params[1], "?") && strpos($params[1], "?") ===0) {
				$controller = "index";
			}

			// 2番目のパラメーターをactionとして取得
			if (1 < count($params) ) {
				if (isset($params[2])) {
					$action = $params[2];
				}
			}

			// コントローラーが未指定でパラメータが渡された場合はIndexController@displayを実行
			if (strstr($params[1], "?") && strpos($params[1], "?") ===0) {
				$action = "display";
			}

		}

		// コントローラークラスインスタンス取得
		$controllerInstance = $this->getControllerInstance($controller);


		if (null == $controllerInstance) {
			header("HTTP/1.0 404 Not Found");
			exit;
		}

		// アクションメソッドの存在確認
		if (false == method_exists($controllerInstance, $action . "Action")) {
			print("action '" . $action . "Action' does not exist.");
			header("HTTP/1.0 404 Not Found");
			exit;
		}

		// コントローラー初期設定
		$controllerInstance->setSystemRoot($this->sysRoot);
		$controllerInstance->setControllerAction($controller, $action);

		// 処理実行
		//exit;
		$controllerInstance->run();
	}

    /**
     * コントローラークラスのインスタンスを取得
     * @param unknown_type $controller
     */
    private function getControllerInstance($controller) {
    	// 一文字目のみ大文字に変換＋"Controller"
		//$className = ucfirst(strtolower($controller)) . "Controller";
		$className = ucfirst($controller) . "Controller";

		// コントローラーファイル名
		$controllerFileName = sprintf("%s/controllers/%s.class.php", $this->sysRoot, $className);

		// ファイル存在チェック
		if (false == file_exists($controllerFileName)) {
			print("Controller '" . $className . "Controller' does not exist.");
			return null;
		}
		// クラスファイルを読込
		require_once $controllerFileName;

        // クラスが定義されているかチェック
		if (false == class_exists($className)) {
			print("Class '" . $className . "Controller' is not difined.");
			return null;
		}

		// クラスインスタンス生成
		$controllerInstarnce = new $className();

		return $controllerInstarnce;
	}
}

?>