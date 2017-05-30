<?php
// サイトタイトル
define("STR_SITE_TITLE", "facebook 会員管理: 法人会員様 管理画面");
define("FOOTER_COPYRIGHT", "Copyright &copy; 2014 Krowl Web Director All Rights Reserved.");

// Log4PHPの設定ファイル
define("LOG4PHP_CONFIGURATION", "/var/workspace/Spreaders/spreaders/manage/log4php.properties");

// サイトのルートディレクトリパス
define("ROOT_PATH", realpath(dirname(__FILE__) . "/."));

// 店舗管理者のユーザーID文字数
define("SHOP_ADMIN_USER_ID_LENGTH", 8);


// 共通テーブルクラス
class CommonTbl {

	// ショップ管理者種別テーブル
	public static $manager_type_tbl = array(
		"super" => "スーパー",
		"normal" => "ノーマル"
	);

}
?>