<?php

// 共通呼び出しファイル
require_once("../require.php");

$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(ROOT_PATH);
$dispatcher->dispatch();

?>
