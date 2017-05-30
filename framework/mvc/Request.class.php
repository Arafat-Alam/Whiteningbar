<?php

class Request {

	// POSTパラメータ
	private $_post;
	// GETパラメータ
	private $_query;

	// コンストラクタ@
	public function __construct() {
		$this->_post = new Post();
		$this->_query = new QueryString();
	}

	/**
	 * POST/GET入力値を取得する
	 * @param StringまたはArray $name
	 * @return StringまたはArray 入力値、引数が配列の場合は2次元配列で返す
	 */
	public function getParam($name) {
		$ret_arr = null;

		// 配列以外
		if (!is_array($name)) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				return $_POST[$name];
			} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
				return $_GET[$name];
			} else {
				return null;
			}
		}
		// 配列の場合
		$ret_arr = array();
		foreach ($name as $key) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				$ret_arr[$key] = $_POST[$key];
			} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){
				$ret_arr[$key] = $_GET[$key];
			} else {
				$ret_arr[$key] = null;
			}
		}
		return $ret_arr;
	}

	// POST変数取得
	public function getPost($key = null) {
		if (null == $key) {
			return $this->_post->get();
		}
		if (false == $this->_post->has($key)) {
			return null;
		}
		return $this->_post->get($key);
	}

	// GET変数取得
	public function getQuery($key = null) {
		if (null == $key) {
			return $this->_query->get();
		}
		if (false == $this->_query->has($key)) {
			return null;
		}
		return $this->_query->get($key);
	}

}

?>
