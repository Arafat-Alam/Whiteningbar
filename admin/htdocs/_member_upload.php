<?php

/*
 *  旧システムからの顧客データのアップロード
 *
 */

require_once("../require.php");
require_once sprintf("%s/dao/CommonDao.class.php", MODEL_PATH);
require_once sprintf("%s/dao/MemberDao.class.php", MODEL_PATH);

$commonDao = new CommonDao();



if($_POST['submit']){

	$shop_no=$_POST['shop_no'];

	if(is_uploaded_file($_FILES["file"]["tmp_name"])){
		$temp_up_fname = "member_up.csv";//
		//仮フォルダに入れておく
		copy($_FILES["file"]['tmp_name'],DIR_IMG_TMP.$temp_up_fname);


echo DOCUMENT_ROOT_ADMIN."member_upload_exec".$shop_no.".php";


		exec("php ".DOCUMENT_ROOT_ADMIN."member_upload_exec".$shop_no.".php");

		$fini=1;
	}


}



?>

<html>
<body>

<form action="" method="post" enctype="multipart/form-data" >

<?php
if($fini==1){
?>
顧客データのアップロードを開始しました。
<?php
}
else{
?>
各店舗ごとに、客ファイルをアップロードします。
<br />顧客に店舗IDをつけるため。

<select name="shop_no">
<option value="1">表参道原宿店</option>
<option value="2">渋谷道玄坂店</option>
<option value="3">心斎橋オ―パ店</option>
<option value="4">大宮店</option>
<option value="5">柏店</option>
<option value="6">麻布十番店</option>
</select>



<input type="file" name="file">
<input type="submit" name="submit" value="アップロード">
<?php
}
?>

</form>
</body>
</html>
