<?php

/**
 * 部分文字列を返す
 * @param unknown_type $str
 * @param unknown_type $start
 * @param unknown_type $length
 */
function my_substr($str, $start, $length, $after = "...") {
	if (mb_strlen($str) > $length) {
		return mb_substr($str, $start, $length) . $after;
	}
	else {
		return $str;
	}
}

/**
 * 暗号化文字列を返す
 */
function to_hash($str) {
	return hash_hmac("sha256", $str, false);
}

/**
 * HTML出力時のエスケープ
 * @param String $str
 */
function html_escape($str) {

	// 指定タグ以外は除く
	$str = strip_tags($str, "<img><div><p><br>");

	// 改行コードが含まれているか？
	$br = preg_match("/(\r\n|\n|\r)/", $str);
	if ($br != 0) {
		// 改行を<br />タグに置き換える
		$str = preg_replace("/(\r\n|\n|\r)/", "<br />", $str);
	}

	return $str;
}

/**
 * 都道府県名を取得する
 * @param int $prefCode
 */
function get_pref_name($prefCode) {
	foreach (CommonArray::$prefs_array as $prefs) {
		foreach ($prefs as $code => $val) {
			if ($prefCode == $code) {
				return $val;
			}
		}
	}
}

/**
 * 1か月のカレンダー用の配列を取得する
 * Enter description here ...
 * @param unknown_type $year
 * @param unknown_type $month
 * @param unknown_type $day
 */
function get_monthly_calandar($year, $month, $day) {

	// 返却データ
	$data = array("result" => "success");

	$baseTs = mktime(0, 0, 0, $month, $day, $year);
	$data["prev"] = date("Ym", mktime(0, 0, 0, $month-1, $day, $year));
	$data["next"] = date("Ym", mktime(0, 0, 0, $month+1, $day, $year));

	// 1日の曜日を数値で取得
	$firstWeekday = date("w", mktime(0, 0, 0, $month, 1, $year));

	$data["cal"]["weekdays"] = array();

	$i = 0; // カウント値リセット
	while( $i <= 6 ){ // 曜日分ループ
		$data["cal"]["weekdays"][$i]["value"] = CommonArray::$weekday_array[$i];
		$i ++;
	}

	// リセットされないカウント
	$cnt = 0;
	$data["cal"]["days"] = array();

	$i = 0; //カウント値リセット（曜日カウンター）
	while($i != $firstWeekday){ //１日の曜日まで空白（&nbsp;）で埋める
		$data["cal"]["days"][$cnt]["value"] = "blank";
		$i ++;
		$cnt++;
	}

	// 今月の日付が存在している間ループする
	for( $day=1; checkdate( $month, $day, $year ); $day++){

		// 曜日の最後まできたらカウント値（曜日カウンター）を戻して行を変える
		if( $i > 6 ){
			$i = 0;
			$data["cal"]["days"][$cnt]["value"] = "\n";
			$cnt++;
		}

		// 日曜日
		if( $i == 0 ){
			$data["cal"]["days"][$cnt]["holiday"] = "t";
		}

		$data["cal"]["days"][$cnt]["value"] = $day;

		$i++; //カウント値（曜日カウンター）+1
		$cnt++;
	}

	while( $i < 7 ){ //残りの曜日分空白で埋める
		$data["cal"]["days"][$cnt]["value"] = "blank";
		$i++;
		$cnt++;
	}

	return $data;
}

/**
 * mb_send_mailを使ってメールを送信する
 * @param String $to 宛先メールアドレス
 * @param String_type $fromAddress 差出人メールアドレス
 * @param String_type $fromName 差出人名
 * @param String_type $subject 件名
 * @param String_type $mailBody 本文
 */
function send_mail($to, $fromAddress, $fromName, $subject, $mailBody,$ccAddress="",$retAddress="") {
	try {
		$cc = '';
		mb_language("japanese");
		mb_internal_encoding("utf-8");
		$from = mb_encode_mimeheader(mb_convert_encoding($fromName, "JIS","utf-8"))."<" . $fromAddress . ">";
		//$headers = "Content-Type: text/html; charset=UTF-8" ;

		$header = "From: WhiteningBAR運営 <info@whiteningbar.net>\r\n"; 
		// $header.= "MIME-Version: 1.0\r\n"; 
		// $header.= "Content-Type: text/html; charset=UTF-8\r\n"; 
		// $header.= "X-Priority: 1\r\n";

		$newsubject='=?UTF-8?B?'.base64_encode($subject).'?=';
		if($ccAddress!=""){
			$cc = "\nCc:".$ccAddress;
		}
		if($retAddress!=""){
			$retp = '-f'.$retAddress;
			$mail = mb_send_mail($to, $subject, $mailBody, $header,$retp);
		}
		else{
			$mail = mb_send_mail($to, $subject, $mailBody, $header );
			// $mail = mail($to, $newsubject, $mailBody, $headers);
		}

	}catch (Exception $e) {
		print($e->getMessage());
	}
}


/**
 * ファイル添付付きメール送信
 * mb_send_mailを使ってメールを送信する
 * @param String $to 宛先メールアドレス
 * @param String_type $fromAddress 差出人メールアドレス
 * @param String_type $fromName 差出人名
 * @param String_type $subject 件名
 * @param String_type $file 添付ファイル名配列（パス付） or 文字
 * @param String_type $ccAddress ccアドレス配列 or 文字
 * @param String_type $bccAddress bccアドレス配列 or 文字
 *
 */
function send_mail_Attached($to, $fromAddress, $fromName, $subject, $mailBody, &$file, $ccAddress="",$bccAddress="") {
	try {
		mb_language("japanese");
		mb_internal_encoding("utf-8");

		//添付

		 $boundary = "__Boundary__" . uniqid( rand() , true ) . "__";
		  $mime = "application/octet-stream";


		  //CC
		  if($ccAddress){
			  if(is_array($ccAddress)){
			  	$ccheader="Cc: ".implode(",",$ccAddress)."\n";
			  }
			  else{
			  	$ccheader="Cc: $fromAddress\n";
			  }
		  }
		  //BCC
		  if($bccAddress){
			  if(is_array($bccAddress)){
			  	$bccheader="Bcc: ".implode(",",$bccAddress)."\n";
			  }
			  else{
			  	$bccheader="Bcc: $fromAddress\n";
			  }
		  }




		  $header = "";
		  $header .= "From: $fromAddress\n".$ccheader.$bccheader;
		  $header .= "MIME-Version: 1.0\n";
		  $header .= "Content-Type: Multipart/Mixed; boundary=\"$boundary\"\n";
		  $header .= "Content-Transfer-Encoding: 7bit";


		  $mbody = "--$boundary\n";
		  $mbody .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
		  $mbody .= "Content-Transfer-Encoding: 7bit\n";
		  $mbody .= "\n";
		  $mbody .= mb_convert_encoding( $mailBody , 'ISO-2022-JP' , 'auto' );
		  $mbody .= "\n";

		  if(is_array($file)){

			  for( $i = 0 ; $i < count( $file ) ; $i++ ){

			    $filename = mb_encode_mimeheader( mb_convert_encoding( basename( $file[ $i ] ) ,  "ISO-2022-JP" , 'auto' ) );

			    $mbody .= "--$boundary\n";
			    $mbody .= "Content-Type: $mime; name=\"$filename\"\n";
			    $mbody .= "Content-Transfer-Encoding: base64\n";
			    $mbody .= "Content-Disposition: attachment; filename=\"$filename\"\n";
			    $mbody .= "\n";
			    $mbody .= chunk_split( base64_encode(file_get_contents( $file[ $i ] ) ) , 76 ,"\n" );
			    $mbody .= "\n";

			  }
		  }
		  else{

			    $filename = mb_encode_mimeheader( mb_convert_encoding( basename( $file ) ,  "ISO-2022-JP" , 'auto' ) );

			    $mbody .= "--$boundary\n";
			    $mbody .= "Content-Type: $mime; name=\"$filename\"\n";
			    $mbody .= "Content-Transfer-Encoding: base64\n";
			    $mbody .= "Content-Disposition: attachment; filename=\"$filename\"\n";
			    $mbody .= "\n";
			    $mbody .= chunk_split( base64_encode(file_get_contents( $file ) ) , 76 ,"\n" );
			    $mbody .= "\n";

		  }
			  $mbody .= "--$boundary--\n";

			mail( $to , mb_encode_mimeheader( mb_convert_encoding( $subject , "ISO-2022-JP" , 'auto' )) , $mbody , $header );


	}catch (Exception $e) {
		print($e->getMessage());
	}

}




/**
 * print_rに<pre>タグをつけて実行した結果を出力する
 */
function print_r_with_pre($obj) {
	print "<pre>";
	print print_r($obj);
	print "</pre>";
}

/**
 *
 * メールアドレスの書式チェック
 * @param Boolean true|false
 */
function is_email($str) {
	if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\.\+_-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $str)) {
		return true;
	}
	else {
	    return false;
	}
}
/**
 *
 * URLの書式チェック
 * @param Boolean true|false
 */
function is_url($str) {

	if (preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/', $str)) {
		return true;
	}else{
		return false;
	}
}

/**
 * ファイルの拡張子を取得する
 * @param unknown_type $FilePath
 */
function get_ext($FilePath){
	$f = strrev($FilePath);
	$ext = substr($f,0,strpos($f,"."));
	return strrev($ext);
}

/**
 * 年月日と加算日からn日後、n日前を求める関数
 * @param $year 年
 * @param $month 月
 * @param $day 日
 * @param $addDays 加算日。マイナス指定でn日前も設定可能
 * @param $format 出力フォーマット(Y-m-d H:i:s)
 *
 */
function compute_date($year, $month, $day, $addDays, $format = null) {
	if (is_null($format)) $format = "Y-m-d H:i:s";
	$baseSec = mktime(0, 0, 0, $month, $day, $year);//基準日を秒で取得
	$addSec = $addDays * 86400;//日数×１日の秒数
	$targetSec = $baseSec + $addSec;
	return date($format, $targetSec);
}

/**
 * ランダムな文字列を生成する。
 * @param int $nLengthRequired 必要な文字列長。省略すると 8 文字
 * @param String $seed ランダム抽出される文字列
 * @return String ランダムな文字列
 */
function get_random_string($nLengthRequired = 8, $seed = "abcdefghijklmnopqrstuvwxyz0123456789"){
    mt_srand();
    $sRes = "";
	for ($i=0; $i<$nLengthRequired; $i++) {
		$sRes .= $seed{mt_rand(0, strlen($seed)-1)};
	}
    return $sRes;
}

/**
 * 画像リサイズ
 * @param String $source 元ファイル名
 * @param Stirng $target リサイズファイル名
 * @param Int $width リサイズ幅
 * @param Int $height リアサイズ高
 * @return Boolean 処理結果
 */
function resize_image($source, $target, $width, $height) {
	if (!$target) return false;

	// 画像のサイズとタイプを取得
	list($s_width,$s_height, $type) = getimagesize($source);

	// 画像を読み込む
	if ($type == 1) {
		$s_img = imagecreatefromgif($source);
	} else if ($type == 2) {
		$s_img = imagecreatefromjpeg($source);
	} else if ($type == 3) {
		$s_img = imagecreatefrompng($source);
	} else if ($type == 15) {
		$s_img = imagecreatefromwbmp($source);
	} else {
		return false;
	}

	// リサイズ後のサイズを計算
	// 縦長の場合
	if ($s_height > $s_width) {
		$new_height =  $height;
		$new_width = floor($s_width * ($new_height / $s_height));
	} else {
		// 横長
		$new_width = $width;
		$new_height = floor($s_height * ($new_width / $s_width));
	}

	// 空の画像を作成する
	$d_img = imageCreateTrueColor($new_width, $new_height);

	// 画像のリサイズ
	ImageCopyResampled($d_img,$s_img,0,0,0,0,$new_width,$new_height,$s_width,$s_height);

	// ファイルへ保存
	if ($type == 1) {
		imagegif($d_img, $target, 100);
	} else if ($type == 2) {
		imagejpeg($d_img, $target, 100);
	} else if ($type == 3) {
		imagepng($d_img, $target, 1);
	} else {
		imagebmp($d_img, $target, 100);
	}

	// メモリを解放する
	imagedestroy ($s_img);
	imagedestroy ($d_img);
	return true;
}

/**
 * 画像リサイズ
 *
 * 横幅は固定　基準の画像の縦横比率にてリサイズ
 *
 *
 * @param String $source 元ファイル名
 * @param Stirng $target リサイズファイル名
 * @param Int $width リサイズ幅
 * @param Int $height リアサイズ高
 * @return Boolean 処理結果
 */
function resize_image2($source, $target, $width, $height) {
	if (!$target) return false;

	// 画像のサイズとタイプを取得
	list($s_width,$s_height, $type) = getimagesize($source);

	// 画像を読み込む
	if ($type == 1) {
		$s_img = imagecreatefromgif($source);
	} else if ($type == 2) {
		$s_img = imagecreatefromjpeg($source);
	} else if ($type == 3) {
		$s_img = imagecreatefrompng($source);
	} else if ($type == 15) {
		$s_img = imagecreatefromwbmp($source);
	} else {
		return false;
	}

	// リサイズ後のサイズを計算

		$new_width = $width;
		$new_height = floor($s_height * ($new_width / $s_width));

/*
	// 縦長の場合
	if ($s_height > $s_width) {
		$new_width = $width;

		//比率を計算して縦の


		$new_height =  $height;
		$new_width = floor($s_width * ($new_height / $s_height));
	} else {
		// 横長
		$new_width = $width;
		$new_height = floor($s_height * ($new_width / $s_width));
	}
*/
	// 空の画像を作成する
	$d_img = imageCreateTrueColor($new_width, $new_height);

	// 画像のリサイズ
	ImageCopyResampled($d_img,$s_img,0,0,0,0,$new_width,$new_height,$s_width,$s_height);

	// ファイルへ保存
	if ($type == 1) {
		imagegif($d_img, $target, 100);
	} else if ($type == 2) {
		imagejpeg($d_img, $target, 100);
	} else if ($type == 3) {
		imagepng($d_img, $target, 1);
	} else {
		imagebmp($d_img, $target, 100);
	}

	// メモリを解放する
	imagedestroy ($s_img);
	imagedestroy ($d_img);
	return true;
}


/**
 * ページング文字列を返す
 * @param Int $totalCnt 全件数
 * @param Int $pageLimit 1ページ内表示件数
 * @param Int $curPage カレントページ
 * @param String $url リンク先URL
 * @param String $aTagClass <a>タグのCSSクラス名
 * @param array $params URLパラメータの配列
 * @param String anchor ページ内リンク
 * @param String $prevStr 戻るリンクに表示する文字列。デフォルト：戻る
 * @param String $nextStr 次へリンクに表示する文字列。デフォルト：次へ
 * @return String ページナビ文字列
 */
function get_page_navi(
	$totalCnt,
	$pageLimit,
	$curPage,
	$url,
	$aTagClass = null,
	$params = null,
	$anchor = null,
	$prevStr = "前へ",
	$nextStr = "次へ"
	) {
	$type = "link";

	// URLにjavascriptが渡された場合
	if (preg_match("/^javascript:/", $url)) {
		$type = "js";
		$func_name = substr($url, strpos($url, ":")+1);
		$func_name = str_replace("()", "", $func_name);
	}

	if ($totalCnt == 0) return "";

	// 全ページ数
	$totalPage  = ceil($totalCnt / $pageLimit);
	if ($totalPage == 1) return "";

	// 前リンク
	$prevPage =$curPage - 1;
	if ($prevPage < 1) {
		$prevPage = 1;
	}
	if ($curPage > $prevPage) {
		$pagingBefore .= "<li><a href=\"";

		if ($type == "link") {
			$pagingBefore .= $url . "?page=" . $prevPage;
		}
		else if ($type == "js") {
			$pagingBefore .= "javascript:" . $func_name . "(" . $prevPage;
		}

		// パラメータの数だけループ
		if (!is_null($params)) {
			$cnt = 0;
			foreach ($params as $key => $val) {
				// 通常リンク
				if ($type == "link") {
					$pagingBefore .= "&" . $key . "=" . $val;
				}
				// javascript
				else if ($type == "js") {
					if ($cnt < count($params)) {
						$pagingBefore .= ",";
					}
					$pagingBefore .= $val;
				}
				$cnt++;
			}
		}

		// ページ内リンク
		if ($anchor != null) {
			$pagingBefore .= $anchor;
		}

		if ($type == "link") {
			$pagingBefore .= "\"";
		}
		else if ($type == "js") {
			$pagingBefore .= ")\"";
		}

		if ($aTagClass != null) {
			$pagingBefore .= " class=\"" . $aTagClass . "\"";
		}
		$pagingBefore .= ">";
		$pagingBefore .= $prevStr . "</a></li>";
	}
	else {
		$pagingBefore = $prevStr;
	}

	// 次リンク
	$nextPage = $curPage + 1;
	if ($nextPage > $totalPage ) {
		$nextPage = $totalPage;
	}
	if ($curPage < $nextPage) {

		$pagingNext .= "<a href=\"";

		if ($type == "link") {
			$pagingNext .= $url . "?page=" . $nextPage;
		}
		else if ($type == "js") {
			$pagingNext .= "javascript:" . $func_name . "(" . $nextPage;
		}

		// パラメータの数だけループ
		if (!is_null($params)) {
			$cnt = 0;
			foreach ($params as $key => $val) {
				// 通常リンク
				if ($type == "link") {
					$pagingNext .= "&" . $key . "=" . $val;
				}
				// javascript
				else if ($type == "js") {
					if ($cnt < count($params)) {
						$pagingNext .= ",";
					}
					$pagingNext .= $val;
				}
				$cnt++;
			}
		}
		// ページ内リンク
		if ($anchor != null) {
			$pagingNext .= $anchor;
		}

		if ($type == "link") {
			$pagingNext .= "\"";
		}
		else if ($type == "js") {
			$pagingNext .= ")\"";
		}

		if ($aTagClass != null) {
			$pagingNext .= " class=\"" . $aTagClass . "\"";
		}
		$pagingNext .= ">";
		$pagingNext .= $nextStr . "</a>";
	}
	else {
		$pagingNext = $nextStr;
	}

	// ページ間ナビ
	$pagingStr = "";
	for ($i=1;$i<=$totalPage;$i++) {
		if ($curPage != $i){

			$pagingStr .= "<li><a href=\"";

			if ($type == "link") {
				$pagingStr .= $url . "?page=" . $i;
			}
			else if ($type == "js") {
				$pagingStr .= "javascript:" . $func_name . "(" . $i;
			}

			// パラメータの数だけループ
			if (!is_null($params)) {
				$cnt = 0;
				foreach ($params as $key => $val) {
					// 通常リンク
					if ($type == "link") {
						$pagingStr .= "&" . $key . "=" . $val;
					}
					// javascript
					else if ($type == "js") {
						if ($cnt < count($params)) {
							$pagingStr .= ",";
						}
						$pagingStr .= $val;
					}
					$cnt++;
				}
			}
			// ページ内リンク
			if ($anchor != null) {
				$pagingStr .= $anchor;
			}

			if ($type == "link") {
				$pagingStr .= "\"";
			}
			else if ($type == "js") {
				$pagingStr .= ")\"";
			}

			if ($aTagClass != null) {
				$pagingStr .= " class=\"" . $aTagClass . "\"";
			}
			$pagingStr .= ">";
			$pagingStr .= $i . "</a></li>";
		}
		else {
			$pagingStr .= "<li>$i</li>";
		}
	}

	$navi = "<ul class=\"list-paging\">";
	$navi .= "<li class=\"pre\">".$pagingBefore."</li>";
	$navi .= $pagingStr;
	$navi .= "<li class=\"next\">".$pagingNext."</li>";
	$navi .="</ul>";

	return $navi;

	}
/**
 * ページング文字列を返す  件数が多い場合（10P以上はヤフー形式風
 * 例
 * $vCnt=10で全20Pの場合
 * カレントページが・・
 * 1～5： 				前へ 1 2 3 4 5 6 7 8 9 10... 次へ 最後
 * MaxPage-5～MaxPage：	最初 前へ ... 11 12 13 14 15 16 17 18 19 20 次へ
 * ↑以外：				最初 前へ ... 2 3 4 5 6 7 8 9 10 11 ... 次へ 最後
 *

 * @param Int $totalCnt 全件数
 * @param Int $pageLimit 1ページ内表示件数
 * @param Int $curPage カレントページ
 * @param String $url リンク先URL
 * @param String $prevStr 戻るリンクに表示する文字列。デフォルト：前へ
 * @param String $nextStr 次へリンクに表示する文字列。デフォルト：次へ
 * @return String $param_ope パラメータのオペレーション
 */
	function get_page_navi2(
	$totalCnt,
	$pageLimit,
	$curPage,
	$url,
	$allFirstPage=null,
	$allLastPage=null,
	$vCnt=10,
	$prevStr = "&lsaquo; Prev",
	$nextStr = "Next &rsaquo;",
	$param_ope="?"
	) {
	$paging = '';

	if($curPage=="") $curPage=1;
	//全部のページ
	if($totalCnt==0){
		$all_p=1;
	}
	else{
		$all_p=ceil($totalCnt/$pageLimit);
	}
	//前へのリンク
	if($curPage!=1){
		$bp=$curPage-1;
		$b_paging="<a href=\"".$url.$param_ope."page=".$bp."\">".$prevStr."</a>&nbsp;";
	}
	else{
		$b_paging="<span>".$prevStr."</span>&nbsp; ";
	}
	//次へのリンク
	if($all_p!=$curPage){
		$bp=$curPage+1;
		$n_paging="&nbsp;<a href=\"".$url.$param_ope."page=".$bp."\">".$nextStr."</a>&nbsp;";
	}
	else{
		$n_paging="<span>".$nextStr."</span>&nbsp; ";
	}
	//ループのページング
	if($all_p<=$vCnt){//$vCnt以下なら通常

		$paging=setPage(0,$all_p,$all_p, $curPage, $url,"",$param_ope);
	}
	else{

		$allLastPage="<a href=\"".$url.$param_ope."page=".$all_p."\">Last &raquo;</a>";
		$allFirstPage="<a href=\"".$url.$param_ope."page=1\">&laquo; First</a>&nbsp;";

		//Lastの$vCntのPageは何ページからになるのか？
		$lastPageStart=$all_p-$vCnt;

		$vvv=ceil($vCnt/2);
		if($curPage<=($vCnt-$vvv)){
			$paging=setPage(0,$vCnt,$all_p, $curPage, $url,$paging,$param_ope);
			$paging.="<span>...</span>";

			//最初は不要
			$allFirstPage="";

		}
		else if($curPage>=($all_p-$vvv)){//ラストまでのページング

			$paging="<span>...</span>&nbsp;";
			$paging=setPage($lastPageStart,$all_p,$all_p, $curPage, $url,$paging,$param_ope);

			//最後は不要
			$allLastPage="";

		}
		else{

			$b=$curPage-$vvv;
			$n=$curPage+$vvv;

			$paging="<span>...</span>&nbsp;";
			$paging=setPage($b,$n, $all_p, $curPage, $url,$paging,$param_ope);

			$paging.="<span>...</span>&nbsp;";

		}

	}

	$navi=$allFirstPage.$b_paging.$paging.$n_paging.$allLastPage;

	return array($navi,$all_p);

}

	function setPage($start,$end,$all_p, $curPage,$url,$paging="",$param_ope="?"){

		for($i=$start;$i<$end;$i++){
				$ii=$i+1;
				if($ii==$curPage){
					$paging.="<span class=\"current\">".$ii."&nbsp;</span>";
				}else{
					$paging.="<a class=\"inactive\" href=\"".$url.$param_ope."page=".$ii."\">".$ii."</a>&nbsp;";
				}
			}

		return $paging;

	}


	/**年のリストを作成する
	 *
	 * $start:リスト開始年　nullであれば1900年～
	 * $end:現在の年+何年を終了年にするか　現在の年が2013 $end=2 とした場合、2015年までがリストに表示される
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定
	 * return 年リストの配列
	 */
	function makeYearList($start=1900,$end,$nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="--";

		//endは現在の年＋$end
		$end=date("Y",time())+$end;

		for($c=$start;$c<=$end;$c++){
			$ret[$c]=$c;
		}
		return $ret;
	}

	/*
	 *
	 * $start:現在から何年前をstartにするか
	 * $end:何年までを表示するか
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定
	 * return 年リストの配列
	 */
	function makeYearList2($start,$end,$nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="--";

		//startは現在の年-$start
		$start=date("Y",time())-$start;

		for($c=$start;$c>=$end;$c--){
			$ret[$c]=$c;
		}
		return $ret;

	}

	/**年度のリストを作成する
	 *
	 * 年度なので、1/1～3/31までは去年の西暦基準で計算
	 * 4/1～12/31まで、今年の西暦で計算する
	 *
	 * $start:現在から何年前をstartにするか
	 * $end:何年先までを表示するか
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定

	 * return 年リストの配列
	 */
	function makeNendoYearList($start,$end,$nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="--";

		$yy=date("Y");
		$today=time();

		if($tody >=mktime(0,0,0,1,1,$yy) || $tody <=mktime(23,59,59,3,31,$yy)){
			$yy=$yy-1-$start;
		}
		else{
			$yy=$yy-$start;
		}

		$end=$yy+$end;

		for($c=$start;$c<=$end;$c++){
			$ret[$c]=$c;
		}
		return $ret;

	}

	/**年度の過去リストを作成する
	 *
	 * 年度なので、1/1～3/31までは去年の西暦基準で計算
	 * 4/1～12/31まで、今年の西暦で計算する
	 *
	 *
	 * $start:現在から何年先をstartにするか
	 * $end:過去何年までを表示するか
	 * $flg:1= 現在に近い西暦からStart
	 * $flg:2= 過去の西暦からstart
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定
	 *
	 * return 年リストの配列
	 */
	function makeNendoYearPastList($start,$end,$flg,$nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="--";

		$yy=date("Y");
		$today=time();

		if($today >=mktime(0,0,0,1,1,$yy) && $today <=mktime(23,59,59,3,31,$yy)){
			$yy=$yy-1+$start;
		}
		else{
			$yy=$yy+$start;
		}

		$end=$yy-$end;

		if($flg==1){
			for($c=$yy;$c>=$end;$c--){
				$ret[$c]=$c;
			}
		}
		else{

			for($c=$end;$c<=$yy;$c++){
				$ret[$c]=$c;
			}
		}



		return $ret;

	}

	/**月のリストを作成する
	 *
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定
	 * return 月リストの配列
	 */
	function makeMonthList($nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="--";
		for($c=1;$c<=12;$c++){
			$ret[$c]=$c;
		}
		return $ret;
	}

	/**日のリストを作成する
	 *
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定
	 * return日リストの配列
	 */
	function makeDayList($nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="--";
		for($c=1;$c<=31;$c++){
			$ret[$c]=$c;
		}
		return $ret;
	}

	/*
	 * プルダウン作成
	 * 開始と終了を指定して、smartyのhtml_option用の配列を作成する
	 * $start:
	 * $end:
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定
	 * return リストの配列
	 */
	function makePulldownList($start,$end,$nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="";

		for($c=$start;$c<=$end;$c++){
			$ret[$c]=$c;
		}
		return $ret;
	}

	/*
	 * プルダウン作成 radio、checkbox
	 * tableから取得した配列から、keyとvalueを指定して、smartyのhtml_option用の配列を作成する
	 * $arr:
	 * $key:
	 * $value
	 * $nullstr:リストボックスの一番上にnull選択を入れる場合は１を指定
	 * return リストの配列
	 */
	function makePulldownTableList($arr,$key,$value,$nullstr=0) {
		$ret=array();
		if($nullstr==1) $ret[""]="選択してください。";
		for($c=0;$c<count($arr);$c++){
			$opt=$arr[$c][$key];
			$ret[$opt]=$arr[$c][$value];
		}
		return $ret;
	}

	/*文字汎用性版*/
	function makePulldownTableList2($arr,$key,$value,$nullstr="") {
		$ret=array();
		if($nullstr!="") $ret[""]=$nullstr;

		for($c=0;$c<count($arr);$c++){
			$opt=$arr[$c][$key];
			$ret[$opt]=$arr[$c][$value];
		}
		return $ret;
	}


	function obj2arr($obj){

		if ( !is_object($obj) ) return $obj;
		$arr = (array) $obj;
		foreach ( $arr as &$a ){
			$a = obj2arr($a);
		}
		return $arr;
	}

	//受け取ったパラメータをエンティティ
	function makeGetRequest($param) {
		if(is_array($param)){

			foreach($param as $key=>$val){
				if(is_array($val)){
					foreach($val as $k2=>$v2){
						if(is_array($v2)){
							foreach($v2 as $k3=>$v3){
								$v_input_data[$key][$k2][$k3]=htmlspecialchars($v3,ENT_QUOTES);
							}
						}
						else{
							$v_input_data[$key][$k2]=htmlspecialchars($v2,ENT_QUOTES);
						}
					}
				}
				else{
					$v_input_data[$key]=htmlspecialchars($val,ENT_QUOTES);
				}
			}
			return $v_input_data;
		}
		else{
			return htmlspecialchars($param,ENT_QUOTES);
		}
	}

	function makeGetRequest_decode($param) {
		if(is_array($param)){
			foreach($param as $key=>$val){
				if(is_array($val)){
					foreach($val as $k2=>$v2){

						if(is_array($v2)){
							foreach($v2 as $k3=>$v3){
								$v_input_data[$key][$k2][$k3]=htmlspecialchars_decode($v3,ENT_QUOTES);
							}
						}
						else{
							$v_input_data[$key][$k2]=htmlspecialchars_decode($v2,ENT_QUOTES);
						}
					}
				}
				else{
					$v_input_data[$key]=htmlspecialchars_decode($val,ENT_QUOTES);
				}
			}
			return $v_input_data;
		}
		else{
			return htmlspecialchars_decode($param,ENT_QUOTES);
		}
	}



	//ダウンロード処理
	function execDownload($dfile,$fname) {

			//ダウンロード処理
//			$tmp_file = $dfile;
//			$j_file   = $fname;
//			$j_file   = mb_convert_encoding($j_file, "SJIS", "EUC");
			// ヘッダ
			header("Content-Type: application/octet-stream");
			// ダイアログボックスに表示するファイル名
			header("Content-Disposition: attachment; filename=$fname");
			header('Content-Length:' . filesize($dfile));
			header('Pragma: no-cache');
			header('Cache-Control: no-cache');
			// 対象ファイルを出力する。
			ob_end_clean();
			readfile($dfile);
			exit;

	}
	//ダウンロード処理
	/*
	 * 出力するファイルをサーバーに落としていない場合のダウンロード処理
	 *
	 */
	function execDownloadNoFile($dfile,$fname) {

			// ヘッダ
			header("Content-Type: application/octet-stream");
			// ダイアログボックスに表示するファイル名
			header("Content-Disposition: attachment; filename=$fname");
			header('Pragma: no-cache');
			header('Cache-Control: no-cache');
			// 対象ファイルを出力する。
			ob_end_clean();
			echo $dfile;
			exit;



	}

/**
 * エラーログ出力処理
 */
function write_log($str) {

            $note = "\n".$str."\n";

			$fp = fopen(LOG_F, "a+");

			flock($fp,2);
			fwrite($fp,$note);
			flock($fp,3);
			fclose($fp);
}

    /*
     *
     * チェック用関数
     * ※フォームでの入力チェックで使用するが、パラでも使用可能
     *
     * $s:チェックする文字列
     * $chk:チェック番号
     *
     *
     * $inputmaxLen:MAX文字数
     * $inputminLen:MIN文字数
     */

 	function chkString($s, $chk,$inputmaxLen,$inputminLen){

		if($inputmaxLen>0 && mb_strlen($s,"UTF-8") > $inputmaxLen){
			return 1;
		}

		if (mb_strlen($s,"UTF-8") < $inputminLen){
			return 5;
		}

		switch($chk) {
			case 1 :  // 半角英数チェック
				$s=str_replace(" ","",$s);
	        	if (!mb_ereg("^[0-9a-zA-Z\-\_\.:/~#=&\?-]*$",$s)){
					return 2;
				}
				return 0;
				break;
			case 2 :  // 数値チェック
				if (!mb_ereg("^[[:digit:]]+$", $s)){
					return 2;
				}
				return 0;
				break;

			case 3 :  //E-mailチェック
	       		if(!mb_ereg("^[a-zA-Z0-9!#$%&*+/=?^_{|}~.-]+\@[a-zA-Z0-9-]+\.+[a-zA-Z0-9.-]+$", $s)) {
	            	return 2;
	        	}
	        	return 0;
	        	break;
			case 5 : //郵便番号/電話番号等 数字と"-"チェック
				if (!mb_ereg("^[0-9-]*$",$s)){
            		return 2;
        		}

				return 0;
	        	break;

			case 6: //全角カナチェック

				$s=str_replace(array(" ","　"),"",$s);
				$zenkanaK = "　アイエウオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲンァィゥェォヴガギグゲゴザジズゼゾダヂヅデドバビブベボパピプペポャュョッー（）・";
				for($i=0;$i<strlen($s);$i=$i+2){
					$p = strpos($zenkanaK, substr($s, $i ,2));
					if($p == FALSE){
						return 2;
					}
				}
				return 0;
				break;
			case 7: //全角かなチェック

				$s=str_replace(array(" ","　"),"",$s);
				$zenkanaH = " あいうえおかきくけこさしすせそたちつてとなにぬねのはひふへほ".
							"まみむめもやゆよらりるれろわをんぁぃぅぇぉがぎぐげござじずぜぞ".
							"だぢづでどばびぶべぼぱぴぷぺぽゃゅょっー ";
				for($i=0;$i<mb_strlen($s,"UTF-8");$i++){
					$p = mb_strpos($zenkanaH, mb_substr($s, $i ,1,"UTF-8"));
					if($p == FALSE){
						return 2;
					}
				}
				return 0;
				break;
			case 8: //半角カナが含まれていたらout

				if (mb_ereg('[ｱ-ﾝ]',$s)){
	            	return 2;
	        	}
				return 0;
				break;
			case 11: //数値と/
				if (!mb_ereg("^[0-9./･]*$",$s)){
	            	return 2;
	        	}
				return 0;
				break;
			case 12: //数値と.
				if (!mb_ereg("^[0-9.]*$",$s)){
					return 2;
	        	}
				return 0;
				break;

			default:
				return 0;
	        	break;

	     }

		 return 0;
	}

	/*
	 * 日付から曜日を取得
	 *
	 */
 	function getYoubi($date){

			$datetime = new DateTime($date);
			$week = array("日", "月", "火", "水", "木", "金", "土");
			$w = (int)$datetime->format('w');
			return $week[$w];


 	}

 	/*  自動リンク処理
 	 *
 	 *  文字列の中にhttp:// https:// のURLがあれば、自動でリンクを入れる
 	 *
 	 *
 	 */
 	function autoLink($str){

		$mojiretu = nl2br($str);
		$patterns = array("/(https?|ftp)(:\/\/[[:alnum:]\+\$\;\?\.%,!#~*\/:@&=_-]+)/i");
		$replacements = array("<a href=\"\\1\\2\" target=_blank>\\1\\2</a>");
		$mojiretu = preg_replace($patterns, $replacements, $mojiretu);

		return $mojiretu;

 	}





/*


select distinct m.*,r.*,d.reserve_date,d.start_time,d.end_time,d.shop_no,d.menu_no,d.buy_no
from member_reserve as r,member_reserve_detail as d, member as m
where r.reserve_no=d.reserve_no and r.member_id=m.member_id and m.member_id=d.member_id 
and d.shop_no =22 and (d.visit_flg ='0' or d.visit_flg ='1') 
and (m.name like '%福田優子使わない%' or m.name_kana like '%福田優子使わない%') 
and d.menu_no ='17' and reserve_date between '' and '' 
and r.insert_date between '2013-01-01 00-00-00' and '2017-03-31 23:59:59' 
order by reserve_date desc, start_time desc
LIMIT 30 OFFSET 0;*/
?>