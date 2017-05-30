<?php

abstract class ControllerBase extends MVCBase{

	protected $systemRoot;
	protected $controller = "index";
	protected $action = "index";
	protected $view;
	protected $model;
	protected $request;
	protected $templatePath = null;
	private $redirected = false;
	protected abstract function isLogin();
	protected abstract function outHttpResponseHeader();
	
    // コンストラクタ
    public function __construct() {
    	parent::__construct();
		$this->request = new Request();
    }

    // システムのルートディレクトリパスを設定
    public function setSystemRoot($path) {
		$this->systemRoot = $path;
	}

 	// システムのルートディレクトリパスを取得
    public function getSystemRoot() {
		return $this->systemRoot;
	}

	// コントローラーとアクションの文字列設定
	public function setControllerAction($controller, $action) {
		$this->controller = $controller;
		$this->action = $action;
    }

    // 処理実行
	public function run(){
        try {
			// ビューの初期化
			$this->initializeView();

			// モデルの初期化

			// 共通前処理
			$this->preAction();

			// アクションメソッド実行
			$methodName = sprintf("%sAction", $this->action);

			echo $this->$methodName();
			//echo "string"; exit();
			// 別ページにリダイレクトされた場合は後続の処理を実行しない
			if ($this->redirected) {
				return;
			}

			// 共通後処理
			$this->afterAction();

			// テンプレート表示
			if (!is_null($this->templatePath)) {
				
        		$this->view->display($this->getTemplatePath());
			}

		} catch (Exception $e) {
			return $e;
			// ログ出力等の処理を記述
		}
	}

	// ビューの初期化
	protected function initializeView() {
		$this->view = new Smarty();
		 $this->view->template_dir = sprintf("%s/views/templates", $this->systemRoot);
		$this->view->compile_dir = sprintf("%s/views/templates_c/", $this->systemRoot);
		$this->view->config_dir = sprintf("%s/views/configs/", $this->systemRoot);
	}

	/*
	// モデルインスタンス生成処理
	protected function initializeModel() {
		// 一文字目のみ大文字に変換
		$className = ucfirst(strtolower($this->controller));
		$classFile = sprintf("%s/structure/%s.class.php", MODEL_PATH, $className);

		// Modelのファイルが存在するか？
		if (false == file_exists($classFile)) {
			//print(sprintf("file '%s' doesn't exist.", $classFile));
			return;
		}
		require_once $classFile;

		// Modelのクラスが存在するか？
		if (false == class_exists($className)) {
			//print(sprintf("class '%s' doesn't exist.", $className));
			return;
		}
		$this->model = new $className();
	}
	*/

	protected function redirect($url, $saveSessionMessage = true) {
		if ($saveSessionMessage) {
			$this->setSessionMessage();
		}
		$this->redirected = true;
		header("Location:  " . $url);
		return;
	}

	// 共通前処理（オーバーライド前提）
	protected function preAction() {}

	// 共通後処理（オーバーライド前提）
	protected function afterAction() {}


	public function getTemplatePath()
	{
	    return $this->templatePath;
	}

	public function setTemplatePath($templatePath)
	{
	    $this->templatePath = $templatePath;
	}

	public function getExecAfterAction()
	{
	    return $this->execAfterAction;
	}

	public function setExecAfterAction($execAfterAction)
	{
	    $this->execAfterAction = $execAfterAction;
	}
}

?>