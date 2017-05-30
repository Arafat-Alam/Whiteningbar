<?php
// サイトタイトル
define("STR_SITE_TITLE", "WhiteningBAR");

// サイトのルートディレクトリパス
define("ROOT_PATH", realpath(dirname(__FILE__) . "/."));
//echo "<br>".realpath(dirname(__FILE__));

// Log4PHPの設定ファイル
define("LOG4PHP_CONFIGURATION", "/var/workspace/Whitening/whitening/public/log4php.properties");

//logファイルの保存フォルダ
$today=date("Ymd",time());
//arafat
//define("LOG_F",ROOT_PATH."/logs/".$today.".txt");


?>