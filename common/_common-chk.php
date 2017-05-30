<?php
/**
 * common.config.php
 * @version 0.1
 * @author takeshima
 * @since 2012/05/14
 */

// 共通チェック配列クラス
class CommonChkArray {


	/*
	 *
	 * チェック配列の数字意味
	   ========================================================================================
	   string  --　項目名
	　 chk     --  チェックするタイプ (0:なし 1:半角英数 2:数値のみ 3:e-mail 5:郵便番号/電話番号等(数字と"-")
	　　　　　　　 6:全角カナ //7:全角かな  8:半角カナ 11:数値と/ 12:数値と小数点)
		       14:数値と-と:
	   nchk    --  必須項目フラグ(1:必須　0:任意）　　
	   ========================================================================================
	*/
//カート入力チェック用配列(登録時に使用するので、テーブルに入れたい項目を、dbstringのみフォームのinput全項目セットしておく。別テーブルに入れる場合は、ここには入れずにソース内で調整）
//string は エラー時に表示される文字列
//、

/*******************************************************
 *
 *  ユーザー側 予約チェック
 *
 *******************************************************/

	public  static $reserveCheckData = Array(
	   "dbstring" =>  array(
	),
	"string" =>  array(
			"shop_no"		=> "店舗",
			"menu_no"	 	=> "メニュー",
			"number" 		=> "人数",
			"reserve_date" 	=> "予約日",
			"reserve_time" 	=> "予約時間",

	),
     "type" => array(
			"shop_no"		=> "select",
			"menu_no"	 	=> "radio",
			"number" 		=> "select",
			"reserve_date" 	=> "text",
			"reserve_time" 	=> "text",

	),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
  		 ),
	"nchk" => array(
			"shop_no"		=> "1",
			"menu_no"	 	=> "1",
			"number" 		=> "1",
			"reserve_date" 	=> "1",
			"reserve_time" 	=> "1",

			)
		);


//********* 店舗登録 **********************************
	//店舗新規登録/編集
	public  static $shopCheckData = Array(
	   "dbstring" =>  array(
			"name" 			=> "店名",
			"zip" 			=> "郵便番号",
			"address" 		=> "住所",
			"tel" 			=> "電話番号",
			"send_email"	=> "メール送信先Email",
			),
	"string" =>  array(
			"name" 			=> "店名",
			"zip" 			=> "郵便番号",
			"address" 		=> "住所",
			"tel" 			=> "電話番号",
			"send_email"	=> "メール送信先Email",

			),
     "type" => array(
			"name" 			=> "text",
			"zip" 			=> "text",
			"address" 		=> "text",
			"tel" 			=> "text",
			"send_email"	=> "text",

 			),
	"chk" => array(
			"zip" 			=> "5",
			"tel" 			=> "5",
 			"send_email" 			=> "3",

			),
	"max" => array(
			),
	"min" => array(
			),
	"nchk" => array(
			"name" 			=> "1",
			"zip" 			=> "0",
			"address" 		=> "0",
			"tel" 			=> "0",
			)
		);
	//店舗営業設定
	public  static $operateCheckData = Array(
	   "dbstring" =>  array(
			"booth" 		=> "ブース数",
			"from_def_h" 	=> "営業時間（通常）の開始時間",
			"from_def_m" 	=> "営業時間（通常）の開始分",
			"to_def_h" 		=> "営業時間（通常）の終了時間",
			"to_def_m" 		=> "営業時間（通常）の終了分",
			"from_1_h" 		=> "営業時間（月）の開始時間",
			"from_1_m" 		=> "営業時間（月）の開始分",
			"to_1_h" 		=> "営業時間（月）の終了時間",
			"to_1_m" 		=> "営業時間（月）の終了分",
			"from_2_h" 		=> "営業時間（月）の開始時間",
			"from_2_m" 		=> "営業時間（月）の開始分",
			"to_2_h" 		=> "営業時間（月）の終了時間",
			"to_2_m" 		=> "営業時間（月）の終了分",

		),
	"string" =>  array(
			"booth" 		=> "ブース数",
			"from_def_h" 	=> "営業時間（通常）の開始時間",
			"from_def_m" 	=> "営業時間（通常）の開始分",
			"to_def_h" 		=> "営業時間（通常）の終了時間",
			"to_def_m" 		=> "営業時間（通常）の終了分",

			),
     "type" => array(
			"booth" 			=> "text",
			"from_def_h" 	=> "select",
			"from_def_m" 	=> "select",
			"to_def_h" 		=> "select",
			"to_def_m" 		=> "select",

			),
	"chk" => array(
			"booth" 		=> "2",
			),
	"max" => array(
			),
	"min" => array(
			),
	"nchk" => array(
			"booth" 		=> "1",
			"from_def_h" 	=> "1",
			"from_def_m" 	=> "1",
			"to_def_h" 		=> "1",
			"to_def_m" 		=> "1",

			)
		);

	//店舗 予約ブロック設定 日付
	public  static $blockDateCheckData = Array(
	   "dbstring" =>  array(
			"start_date" 	=> "開始日",
			"end_date" 		=> "終了日",
			"start_time" 	=> "開始時間",
			"end_time" 		=> "終了時間",
			"kind_flg" 		=> "種類",
			),
	"string" =>  array(
			"start_date" 	=> "開始日",
			),
     "type" => array(
			"start_date" 			=> "text",
 			),
	"chk" => array(
			),
	"max" => array(
			),
	"min" => array(
			),
	"nchk" => array(
			"start_date" 			=> "1",
			)
		);

	//店舗 予約ブロック設定 日付
	public  static $blockTimeCheckData = Array(
	   "dbstring" =>  array(
			"start_date" 	=> "開始日",
			"start_time" 	=> "開始時間",
			"end_time" 		=> "終了時間",
			"kind_flg" 		=> "種類",
			),
	"string" =>  array(
			"start_date_t" 	=> "開始日",
			"start_time_t" 	=> "開始時間",
			"end_time_t" 		=> "終了時間",
			),
     "type" => array(
			"start_date" 	=> "text",
			"start_time" 	=> "text",
			"end_time" 		=> "text",
 			),
	"chk" => array(
			),
	"max" => array(
			),
	"min" => array(
			),
	"nchk" => array(
			"start_date" 	=> "1",
			"start_time" 	=> "1",
			"end_time" 		=> "1",
			)
		);

	//店舗 予約ブロック設定 日付
	public  static $blockRepeatCheckData = Array(
	   "dbstring" =>  array(
			"start_date" 	=> "開始日",
			"end_date" 		=> "終了日",
			"start_time" 	=> "開始時間",
			"end_time" 		=> "終了時間",
			"kind_flg" 		=> "種類",
			),
	"string" =>  array(
			"start_date_r" 	=> "開始日",
			"end_date_r" 	=> "終了日",
			"start_time_r" 	=> "開始時間",
			"end_time_r" 	=> "終了時間",

			),
     "type" => array(
			"start_date_r" 	=> "text",
			"end_date_r" 	=> "text",
			"start_time_r" 	=> "text",
			"end_time_r" 	=> "text",
 			),
	"chk" => array(
			),
	"max" => array(
			),
	"min" => array(
			),
	"nchk" => array(
			"start_date_r" 	=> "1",
			"end_date_r" 	=> "1",
			"start_time_r" 	=> "1",
			"end_time_r" 	=> "1",
			)
		);

//********* コース登録 **********************************
	public  static $courseCheckData = Array(
	   "dbstring" =>  array(
			"name" 			=> "コース名",
			"fee" 			=> "料金",
			"fee_comment" 	=> "料金についての説明",
			"number" 		=> "回数",
			"limit_month" 	=> "使用期限",
			"invite_flg" 		=> "ご招待ステータス",
			"view_flg" 		=> "表示ステータス",
			),
	"string" =>  array(
			"name" 			=> "コース名",
			"fee" 			=> "料金",
			"fee_comment" 	=> "料金についての説明",
			"number" 		=> "回数",
			"limit_month" 	=> "使用期限",
			),
     "type" => array(
			"name" 			=> "text",
			"fee" 			=> "text",
			"fee_comment" 	=> "textarea",
			"number" 		=> "text",
			"limit_month" 	=> "text",
 			),
	"chk" => array(
			"fee" 			=> "2",
			"number" 		=> "2",
			"limit_month" 	=> "2",

 			),
	"max" => array(
			),
	"min" => array(
			),
	"nchk" => array(
			"name" 			=> "1",
			"fee" 			=> "1",
			"fee_comment" 	=> "0",
			"number" 		=> "1",
			"limit_month" 	=> "1",
			)
		);

//********* メニュー登録 **********************************
	public  static $menuCheckData = Array(
	   "dbstring" =>  array(
			"course_no" 	=> "コース",
			"name" 			=> "メニュー名",
			"kind_flg" 		=> "何回目のメニューか",
			"use_count" 	=> "何回分か",
			"times" 		=> "所要時間",
			"comment" 		=> "一覧用紹介コメント",
			"number" 		=> "人数",
			"color_no" 		=> "スケジュール表示色",
			"view_flg" 		=> "表示ステータス",
			),
	"string" =>  array(
			"course_no" 	=> "コース",
			"name" 			=> "メニュー名",
			"times" 		=> "所要時間",
			"comment" 		=> "一覧用紹介コメント",
			"number" 		=> "人数",
			"color_no" 		=> "スケジュール表示色",
			"view_flg" 		=> "表示ステータス",
			),
     "type" => array(
			"course_no" 	=> "select",
			"name" 			=> "text",
			"times" 		=> "text",
			"comment" 		=> "textarea",
			"number" 		=> "text",
			"color_no" 		=> "radio",
			"view_flg" 		=> "radio",
 			),
	"chk" => array(
			"times" 		=> "2",
			"number" 		=> "2",
 			),
	"max" => array(
			),
	"min" => array(
			),
	"nchk" => array(
			"course_no" 	=> "1",
			"name" 			=> "1",
			"times" 		=> "1",
			"comment" 		=> "0",
			"number" 		=> "1",
			"color_no" 		=> "1",
			"view_flg" 		=> "1",
			)
		);


//********* 新規ユーザー(メンバー)登録 **********************************
	// ユーザー新規登録
	public  static $memberRegistCheckData = Array(
	"dbstring" =>  array(
			"shop_no" 		=> "顧客店舗",
			"email" 		=> "メールアドレス",
			"password" 		=> "パスワード",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
			"intro" 		=> "ご紹介者",
			"comment" 		=> "備考",

			),
	"string" =>  array(
			"email" 		=> "メールアドレス",
			"password" 		=> "パスワード",
			"password2" 		=> "確認パスワード",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
			"comment" 		=> "備考",

			),
     "type" => array(
			"email" 		=> "text",
			"password" 		=> "text",
			"password2" 	=> "text",
			"name" 			=> "text",
			"name_kana" 	=> "text",
			"tel"			=> "text",
			"zip" 			=> "text",
			"pref" 			=> "select",
			"address1" 		=> "text",
			"address2" 		=> "text",
			"sex" 			=> "radio",
			"year" 			=> "select",
			"month" 		=> "select",
			"day" 			=> "select",
			"comment" 		=> "textarea",
			),
	"chk" => array(
			"email" 		=> "3",
			"password" 		=> "1",
			"name_kana" 	=> "7",
			"tel"			=> "5",
			"zip" 			=> "5",
		),
		"max" => array(
			),
	"min" => array(
			"password" 		=> "6",
			),

	"nchk" => array(
			"email" 		=> "1",
			"password" 		=> "1",
			"password2" 	=> "1",
			"name" 			=> "0",
			"name_kana" 	=> "0",
			"tel"			=> "0",
			"zip" 			=> "0",
			"pref" 			=> "0",
			"address1" 		=> "0",
			"sex" 			=> "0",
			"year" 			=> "0",
			"month" 		=> "0",
			"day" 			=> "0",
			)
		);


	// 管理画面から ユーザー新規登録
	public  static $memberRegistAdminCheckData = Array(
	"dbstring" =>  array(
			"shop_no" 		=> "顧客店舗",
			"email" 		=> "メールアドレス",
			"password" 		=> "パスワード",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
			"intro" 		=> "ご紹介者",
			"comment" 		=> "備考",

			),
	"string" =>  array(
			"email" 		=> "メールアドレス",
			"password" 		=> "パスワード",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
			"comment" 		=> "備考",

			),
     "type" => array(
			"email" 		=> "text",
			"password" 		=> "text",
			"name" 			=> "text",
			"name_kana" 	=> "text",
			"tel"			=> "text",
			"zip" 			=> "text",
			"pref" 			=> "select",
			"address1" 		=> "text",
			"address2" 		=> "text",
			"sex" 			=> "radio",
			"year" 			=> "select",
			"month" 		=> "select",
			"day" 			=> "select",
			"comment" 		=> "textarea",
			),
	"chk" => array(
			"email" 		=> "3",
			"password" 		=> "1",
			"name_kana" 	=> "7",
			"tel"			=> "5",
			"zip" 			=> "5",
		),
		"max" => array(
			),
	"min" => array(
			"password" 		=> "6",
			),

	"nchk" => array(
			"email" 		=> "1",
			"password" 		=> "1",
			"name" 			=> "0",
			"name_kana" 	=> "0",
			"tel"			=> "0",
			"zip" 			=> "0",
			"pref" 			=> "0",
			"address1" 		=> "0",
			"sex" 			=> "0",
			"year" 			=> "0",
			"month" 		=> "0",
			"day" 			=> "0",
			)
		);



	// ユーザー新規登録 カレンダーからの簡易登録編 必須がお名前のみ
	public  static $memberRegistCalCheckData = Array(
	"dbstring" =>  array(
			"shop_no" 		=> "顧客店舗",
			"email" 		=> "メールアドレス",
			"password" 		=> "パスワード",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
			"intro" 		=> "ご紹介者",
//			"mail_flg" 		=> "お知らせメール",
			"comment" 		=> "備考",

			),
	"string" =>  array(
			"email" 		=> "メールアドレス",
			"password" 		=> "パスワード",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
//			"mail_flg" 		=> "お知らせメール",
			"comment" 		=> "備考",

			),
     "type" => array(
			"email" 		=> "text",
			"password" 		=> "text",
			"name" 			=> "text",
			"name_kana" 	=> "text",
			"tel"			=> "text",
			"zip" 			=> "text",
			"pref" 			=> "select",
			"address1" 		=> "text",
			"address2" 		=> "text",
			"sex" 			=> "radio",
			"year" 			=> "select",
			"month" 		=> "select",
			"day" 			=> "select",
//			"mail_flg" 		=> "radio",
			"comment" 		=> "textarea",
			),
	"chk" => array(
			"email" 		=> "3",
			"password" 		=> "1",
			"name_kana" 	=> "7",
			"tel"			=> "5",
			"zip" 			=> "5",
		),
		"max" => array(
			),
	"min" => array(
			"password" 		=> "6",
			),

	"nchk" => array(
			"name" 			=> "1",
			)
		);

	// ユーザー編集
	public  static $memberModifyCheckData = Array(
	"dbstring" =>  array(
			"email" 		=> "メールアドレス",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
			"intro" 		=> "ご紹介者",
//			"mail_flg" 		=> "お知らせメール",
			"comment" 		=> "備考",

			),
	"string" =>  array(
			"email" 		=> "メールアドレス",
			"name" 			=> "お名前",
			"name_kana" 	=> "ふりがな",
			"tel"			=> "電話番号",
			"zip" 			=> "郵便番号",
			"pref" 			=> "都道府県",
			"address1" 		=> "市区町村・番地",
			"address2" 		=> "ビル名",
			"sex" 			=> "性別",
			"year" 			=> "生年月日：年",
			"month" 		=> "生年月日：月",
			"day" 			=> "生年月日：日",
//			"mail_flg" 		=> "お知らせメール",
			"comment" 		=> "備考",

			),
     "type" => array(
			"email" 		=> "text",
			"name" 			=> "text",
			"name_kana" 	=> "text",
			"tel"			=> "text",
			"zip" 			=> "text",
			"pref" 			=> "select",
			"address1" 		=> "text",
			"address2" 		=> "text",
			"sex" 			=> "radio",
			"year" 			=> "select",
			"month" 		=> "select",
			"day" 			=> "select",
//			"mail_flg" 		=> "radio",
			"comment" 		=> "textarea",
			),
	"chk" => array(
			"email" 		=> "3",
			"name_kana" 	=> "7",
			"tel"			=> "5",
			"zip" 			=> "5",
		),
		"max" => array(
			),
	"min" => array(
			),

	"nchk" => array(
			"email" 		=> "1",
			"name" 			=> "1",
			"name_kana" 	=> "1",
			"tel"			=> "1",
			"zip" 			=> "1",
			"pref" 			=> "1",
			"address1" 		=> "1",
			"sex" 			=> "1",
			"year" 			=> "1",
			"month" 		=> "1",
			"day" 			=> "1",
//			"mail_flg" 		=> "1",
			)
		);


	// ユーザー編集
	public  static $memberOptionAdminCheckData = Array(
	"dbstring" =>  array(
//			"tanto" 		=> "担当者",
			"tooth_flg" 		=> "歯磨き粉",
			"kanri_comment" => "管理用備考",

			),
		);

	public  static $memberPasswordCheckData = Array(
	   "dbstring" =>  array(
			"password" => "パスワード",
		),
	"string" =>  array(
			"old_password" => "旧パスワード",
			"password" => "新パスワード",
				),
     "type" => array(
			"old_password" => "text",
				"password" => "text",
		 ),
    "max" => array(
 		 ),
    "min" => array(
			"password" => "6",
 		 ),
 	"chk" => array(
			"password" 	=> "1",

			),
	"nchk" => array(
			"old_password" => "1",
			"password" => "1",
			)
		);
	public  static $memberPasswordAdminCheckData = Array(
	   "dbstring" =>  array(
			"password" => "パスワード",
		),
	"string" =>  array(
			"password" => "パスワード",
				),
     "type" => array(
				"password" => "text",
		 ),
    "max" => array(
 		 ),
    "min" => array(
			"password" => "6",
 		 ),
 	"chk" => array(
			"password" 	=> "1",

			),
	"nchk" => array(
			"password" => "1",
			)
		);

/*******************************************************
 * admin 予約関係
 *******************************************************/

	//管理画面の顧客一覧からの予約登録 メインの登録
	public  static $rsvAdminCheckData = Array(
	   "dbstring" =>  array(
			"member_id" => "顧客ID(お申込者）",
//			"tel_flg" => "電話フラグ",
			"number"		 => "予約数",
			"comment" => "備考",
			"kanri_comment" => "管理用備考",
	),
	"string" =>  array(
			"reserve_date"		 => "予約日",
	),
     "type" => array(
			"reserve_date"		 => "text",
	),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
 		 ),
	"nchk" => array(
			"reserve_date"		 => "1",

			)
		);

	//管理画面の顧客一覧からの予約登録 メインの登録
	public  static $rsvDetailAdminCheckData = Array(
	   "dbstring" =>  array(
			"member_id" 	=> "顧客ID",
			"shop_no" 		=> "店舗",
			"menu_no"		 => "予約メニュー",
			"reserve_date"	 => "予約日",
			"buy_no" => "購入コース番号",
			"tel_flg" => "電話フラグ",
			"regist_flg" => "どこからの登録か",

		),
	);
	public  static $rsvDetail2AdminCheckData = Array(
	   "dbstring" =>  array(
			"shop_no" 		=> "店舗",
			"menu_no"		 => "予約メニュー",
			"reserve_date"	 => "予約日",
			"regist_flg" => "どこからの登録か",

		),
	);

	//カレンダーからの新規予約登録時(詳細テーブル登録項目)
	public  static $rsvDetailCalendarCheckData = Array(
	   "dbstring" =>  array(
			"member_id" 	=> "顧客ID",
			"shop_no" 		=> "店舗",
			"menu_no"		 => "予約メニュー",
			"reserve_date"	 => "予約日",
			"buy_no" => "購入コース番号",

		),
		"string" =>  array(
			"member_id" 	=> "顧客ID",
			"shop_no" 		=> "店舗",
			"start_time" 	=> "時間",
//			"minute" 		=> "分",
			"menu_no"		 => "予約メニュー",
			"reserve_date"	 => "予約日",
			"buy_no" => "購入コース番号",
			),
	     "type" => array(
			"member_id" 	=> "text",
			"shop_no" 		=> "text",
			"start_time" 			=> "select",
//			"minute" 		=> "select",
			"menu_no"		 => "select",
			"reserve_date"	 => "text",
			"buy_no" => 	"select",
		),
	    "max" => array(
	 		 ),
	    "min" => array(
	  		 ),
	 	"chk" => array(
	 		 ),
		"nchk" => array(
			"member_id" 	=> "1",
			"shop_no" 		=> "1",
			"start_time" 	=> "1",
//			"minute" 		=> "1",
			"menu_no"		=> "1",
			"reserve_date"	=> "1",
			"buy_no" => 	"0",
		)
	);




	//予約 来店者の来店時詳細情報
	public  static $rsvDetailCheckData = Array(
	   "dbstring" =>  array(
			"visit_flg"		 => "来店チェック",
			"shop_no"	 	=> "店舗",
			"reserve_date"	 => "予約日",
			"start_time"	 		=> "予約時間",
			"end_time"	 		=> "予約終了時間",
			"staff_no" => "担当者",
			"tel_flg" => "電話確認",
			"kanri_comment" => "管理用備考",
	),
	"string" =>  array(
			"visit_flg"		 => "来店チェック",
			"shop_no"	 	=> "店舗",
			"reserve_date"	 => "予約日",
			"start_time"	 		=> "予約時間",
			"end_time"	 		=> "予約終了時間",
			"kanri_comment" => "管理用備考",
	),
     "type" => array(
			"visit_flg"		 => "check",
			"shop_no"	 	=> "select",
			"reserve_date"	 => "select",
			"start_time"	 		=> "select",
			"end_time"	 		=> "select",
			"kanri_comment" => "textarea",
	),
 	"chk" => array(
  		 ),
	"nchk" => array(
			"reserve_date"	 => "1",
			"start_time"	 		=> "1",
  		 )
		);


/*******************************************************
 * メール配信システム関係のチェック配列
 *******************************************************/

	//メール配信　メールテンプレート登録
	public  static $mailTemplateCheckData = Array(
	   "dbstring" =>  array(
			"title"		 => "タイトル",
			"subject"	 => "件名",
			"mail_text" => "メール文章",
			"em_flg" => "緊急メールフラグ",
	),
	"string" =>  array(
			"title"		 => "タイトル",
			"subject"	 => "件名",
			"mail_text" => "メール文章",
	),
     "type" => array(
			"title" 	=> "text",
			"subject"	 => "text",
			"mail_text" => "text",
	),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
			),
	"nchk" => array(
			"title"		 => "1",
			"subject"	 => "1",
			"mail_text" 	=> "1",

			)
		);

	//ステップメール設定
	public  static $stepMailCheckData = Array(
	   "dbstring" =>  array(
			"title"		 	=> "タイトル",
			"template_no"	=> "テンプレート番号",
			"step_kind" 	=> "",
			"step_when" 	=> "",
			"step_long" 	=> "",
			"step_time" 	=> "",
	),
	"string" =>  array(
			"title"		 => "タイトル",
			"step_long" => "配信タイミングの日",
	),
     "type" => array(
			"title" 	=> "text",
			"step_long"	 => "text",
	),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
			"step_long"	 => "2",
  		 ),
	"nchk" => array(
			"title"		 => "1",
			"step_long"	 => "1",
			)
		);


/*******************************************************
 *
 * フォーム作成の登録項目チェック
 *
 *******************************************************/

	public  static $formSetCheckData = Array(
	   "dbstring" =>  array(
			"name"		 => "項目名",
			"status"	 => "ステータス",
			"form_type" => "フォームタイプ",
			"comment" 	=> "入力項目の説明",
			"in_min" 	=> "入力文字数の最低文字数",
			"in_max" 	=> "入力文字数の最高文字数",
			"in_chk" 	=> "入力制限",

	),
	"string" =>  array(
			"name"		 => "項目名",
			"status"	 => "ステータス",
			"form_type" => "フォームタイプ",
			"in_min" 	=> "入力文字数の最低文字数",
			"in_max" 	=> "入力文字数の最高文字数",

	),
     "type" => array(
			"name"		 => "text",
			"status"	 => "radio",
			"form_type" => "text",
			"in_min" 	=> "text",
			"in_max" 	=> "text",

	),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
			"in_min" 	=> "2",
			"in_max" 	=> "2",
  		 ),
	"nchk" => array(
			"name"		 => "1",
			"status"	 => "1",
			"form_type" => "1",


			)
		);


/* ------------------------------------------------ */
	//管理サイト　サイト管理者登録
	public  static $adminUpCheckData = Array(
	   "dbstring" =>  array(
			"user_id" => "ユーザーID",
			"user_name" => "名前",
			"email" 	=> "メールアドレス",
		),
	"string" =>  array(
			"user_id" => "ユーザーID",
			"user_name" => "名前",
			"email" 	=> "メールアドレス",
				),
     "type" => array(
			"user_id" => "text",
			"user_name" => "text",
			"email" 	=> "text",
		 ),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
			"email" 	=> "3",

			),
	"nchk" => array(
			"user_id" => "1",
			"user_name" => "1",
			"email" 	=> "1",

			)
		);



	public  static $inquiryCheckData = Array(
	   "dbstring" =>  array(

		),
	"string" =>  array(
			"name" 	=> "氏名",
			"email" => "メールアドレス",
			"title" => "タイトル",
			"pur" 	=> "お問い合わせの目的",
			"inq" 	=> "内容",
		),
     "type" => array(
			"name" 	=> "text",
			"email" => "text",
			"title" 	=> "text",
			"pur" 	=> "radio",
			"inq" 	=> "textarea",
		 ),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
			"email" 	=> "3",

			),
	"nchk" => array(
			"name" 		=> "1",
			"email"	 	=> "1",
			"title" 	=> "1",
			"pur" 		=> "1",
			"inq" 		=> "1",

			)
		);

//********* 管理サイト　サイト管理者更新 **************************
	public  static $adminNewCheckData = Array(
	   "dbstring" =>  array(
			"user_id" => "ユーザーID",
			"user_name" => "名前",
			"reserve_auth_type" => "名前",
			"member_auth_type" => "名前",
			"shop_no" => "名前",
			"email" => "メールアドレス",
		),
	"string" =>  array(
			"user_id" => "ユーザーID",
			"email" => "メールアドレス",
			"user_name" => "名前",
		),
     "type" => array(
			"user_id" => "text",
			"user_name" => "text",
		 ),
    "max" => array(
 		 ),
    "min" => array(
  		 ),
 	"chk" => array(
			"email" => "3",

			),
	"nchk" => array(
			"user_id" => "1",
			"user_name" => "1",
			"email" => "1",

			)
		);




//********* お知らせ **********************************
	public  static $newsCheckData = Array(
	   "dbstring" =>  array(
			"title" 	=> "お知らせタイトル",
			"detail" 	=> "内容",
			"news_date" => "投稿日設定",
			"display_flg" => "表示/非表示",
	),
	"string" =>  array(
			"title" 	=> "お知らせタイトル",
			"detail" 	=> "内容",
			"news_date" => "投稿日設定",
	),
     "type" => array(
			"title" 	=> "text",
			"detail" 	=> "text",
 		 ),
    "max" => array(
	 ),
    "min" => array(
	 ),
 	"chk" => array(
	 ),
	"nchk" => array(
			"title" 	=> "1",
			"detail" 	=> "1",
			"news_date" => "1",
	 )
	);




}

	/*
	 *
	 * チェック配列の数字意味
	   ========================================================================================
	   string  --　項目名
	　 chk     --  チェックするタイプ (0:なし 1:半角英数 2:数値のみ 3:e-mail 5:郵便番号/電話番号等(数字と"-")
	　　　　　　　 6:全角カナ //7:全角かな  8:半角カナ 11:数値と/ 12:数値と小数点)
		       14:数値と-と:
	   nchk    --  必須項目フラグ(1:必須　0:任意）　　
	   ========================================================================================
	*/

?>
