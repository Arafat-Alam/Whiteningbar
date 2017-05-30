<?php

//ステータス変更
//使用期限が過ぎた購入コースを使用不可にする
//member_buy.finish_flg=2
//毎日0時起動


require_once("../require.php");
require_once sprintf("%s/dao/CommonDao.class.php", MODEL_PATH);


$tdy=date("Y-m-d");

//提案締め切りを過ぎたものを出す

$commonDao=new CommonDao();
$res=$commonDao->get_sql("select * from member_buy where finish_flg=0 and limit_date<>'0000-00-00' and limit_date <'".$tdy."'");

for($i=0;$i<count($res);$i++){
	//過ぎたものに関して、使用不可にする
	$commonDao->updateData("member_buy","finish_flg",2,"buy_no",$res[$i][buy_no]);

}


?>
