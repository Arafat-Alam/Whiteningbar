<?php
// common
require_once("../../common/common-config.php");
require_once("../../common/common-func.php");
require_once("../../common/common-chk.php");
require_once("config.php");
require_once("../../libs/Smarty-2.6.26/libs/Smarty.class.php");

// MVCフレームワーク関連
require_once("../../framework/mvc/MVCBase.class.php");
require_once("../../framework/mvc/RequestVariables.class.php");
require_once("../../framework/mvc/QueryString.class.php");
require_once("../../framework/mvc/Post.class.php");
require_once("../../framework/mvc/ControllerBase.class.php");
require_once("../../framework/mvc/Dispatcher.class.php");
require_once("../../framework/mvc/DAOBase.class.php");
require_once("../../framework/mvc/ModelBase.class.php");
require_once("../../framework/mvc/SystemMessage.class.php");

// このサイトの基点コントローラ
require_once("../controllers/AppRootController.class.php");

// log4php
require_once("../../libs/log4php-0.9/src/log4php/LoggerManager.php");

// PEAR(パスを通すこと)
require_once "Net/POP3.php";
require_once "Mail/mimeDecode.php";

?>