<?php
/**
 * common.config.php
 * @version 0.1
 * @author Suzuki
 * @since 2013/08/
 */
ini_set("display_errors", 1);
// 内部エンコーディング
define("INTERNAL_ENCODING", "UTF-8");
// ライブラリのディレクトリパス
define("LIB_PATH", realpath(dirname(__FILE__) . "/../libs"));
// modelのディレクトリパス
define("MODEL_PATH", realpath(dirname(__FILE__) . "/../models"));

// 公開サイトのURLとドキュメントルート(※スラッシュで終えること)
define("TEMPLATE_ROOT", "/var/workspace/Whitening/whitening/public/views/templates/");
define("DOCUMENT_ROOT", "/var/workspace/Whitening/whitening/public/htdocs/");
define("SHELL_ROOT", "/var/workspace/Whitening/whitening/public/");


// 管理サイトのURLとドキュメントルート(※スラッシュで終えること)
 define("ROOT_URL_ADMIN", "http://admin.wb-yoyaku.com/");

define("DOCUMENT_ROOT_ADMIN", "/var/workspace/Whitening/whitening/admin/htdocs/");


//URL
define("ROOT_URL", "http://wb-yoyaku.com/");
//define("FACEBOOK_REDIRECT_MEMBER", ROOT_URL."mypage/facebookRedirct/");

define("URL_NOSSL", "http://wb-yoyaku.com");
define("URL_SSL", "https://wb-yoyaku.com");


//サイト名
define("SITE_TITLE", "whiteningBAR");

//元サイトのURL
define("PARENT_URL", "http://whiteningbar.jp/");

// DB設定
define("DSN", "mysql:dbname=whitening;host=localhost");
define("DB_USER", "whitening");
define("DB_PASS", "ftCpQFLjFLsLFyZe");


//1p 表示件数
define("V_CNT", "10");

define("ADMIN_V_CNT", "30");

//管理者のメールアドレス
 define("SITE_ADMIN_EMAIL", "ksuzuki@apice-tec.co.jp");

//メールのReturn-Pathのアドレス
define("RETURN_EMAIL", "kyuro_s@yahoo.co.jp");


//お問い合わせ用メールアドレス
define("INQ_ADMIN_EMAIL", "ksuzuki@apice-tec.co.jp");

// メール差出人設定
define("MAIL_FROM", "ksuzuki@apice-tec.co.jp");
define("MAIL_FROM_NAME", "WhiteningBAR運営");

// メールCC設定
define("MAIL_CC", "");	//送信しない場合はブランクにする

// メッセージレベル
//define("SYSTEM_MESSAGE_DEBUG", 1);
//define("SYSTEM_MESSAGE_INFO", 2);
//define("SYSTEM_MESSAGE_ALERT", 3);
//define("SYSTEM_MESSAGE_VALID", 4);
//define("SYSTEM_MESSAGE_WARN", 5);
//define("SYSTEM_MESSAGE_ERROR", 6);
//define("SYSTEM_MESSAGE_FATAL", 7);

// 会員のログイン情報保持セッション名
define("MEMBER_SESSION_NAME", "member_session");

// 店舗管理者のログイン情報保持セッション名
define("SHOP_MANAGER_SESSION_NAME", "shop_manager_session");

// サイト管理者のログイン情報保持セッション名
define("SITE_ADMIN_SESSION_NAME", "site_admin_session");

// 会員のプロフィール画像の最大サイズ(バイト)
define("MEMBER_PROFILE_IMAGE_MAX_SIZE", 153600);

// 会員の仮登録→本登録までの猶予(時間)
define("MEMBER_REGIST_APPLY_LIMIT_HOUR", 24);

// 画像URL
define("URL_IMG_TMP", ROOT_URL ."user_data/tmp/");
define("URL_IMG_MEMBER", ROOT_URL ."user_data/img_member/");
define("URL_IMG_NEWS", ROOT_URL ."user_data/img_news/");
define("URL_IMG_LOGO", ROOT_URL ."user_data/img_logo/");
define("URL_IMG_JOB", ROOT_URL ."user_data/img_job/");
define("URL_IMG_AD", ROOT_URL ."user_data/banner/");


// 画像ディレクトリ
define("DIR_IMG_TMP", DOCUMENT_ROOT . "user_data/tmp/");
define("DIR_IMG_MEMBER", DOCUMENT_ROOT . "user_data/img_member/");
define("DIR_IMG_NEWS", DOCUMENT_ROOT . "user_data/img_news/");
define("DIR_IMG_LOGO", DOCUMENT_ROOT . "user_data/img_logo/");
define("DIR_IMG_JOB", DOCUMENT_ROOT . "user_data/img_job/");
define("DIR_IMG_AD", DOCUMENT_ROOT . "user_data/banner/");


//法人登録の承認作業
define("COMPANY_ADMIT", 0);//承認作業ありの場合は0　承認作業無しの場合は1 (この値が登録時のadmit_flgに入る）


//コース期限
define("COURSE_LIMIT", 365);//365日

//ログファイルパス
$today=date("Ymd",time());
define("LOG_F","/logs/".$today.".txt"); //adminからのパス




// 共通配列クラス
class CommonArray {


	//menuスケジュール表示色
/*
	public static $menuColor_array = array(
		"salmon" => "#fa8072",
		"hotpink" => "#ff69b4",
		"pink" => "#ffc0cb",
		"orange" => "#ffa500",
		"gold" => "#ffd700",
		"yellow" => "#ffff00",
		"greenyellow" => "#adff2f",
		"green" => "#008000",
		"lime" => "#00ff00",
		"palegreen" => "#98fb98",
		"lightseagreen" => "#20b2aa",
		"turquoise" => "#40e0d0",
		"aqua" => "#00ffff",
		"deepskyblue" => "#00bfff",
		"skyblue" => "#87ceeb",
		"silver" => "#c0c0c0",
		"lightgrey" => "#d3d3d3",
		"blueviolet" => "#8a2be2",
		"violet" => "#ee82ee",
		"plum" => "#dda0dd",
	);
*/

	public static $siteColor_array = array(
		"1" => "#4693B2",
		"2" => "#FF558C",
		"3" => "#F9D546",
		"4" => "#F9690E",
		"5" => "#333",
	);
	public static $siteColorFile_array = array(
		"1" => "blue.css",
		"2" => "pink.css",
		"3" => "yellow.css",
		"4" => "orange.css",
		"5" => "black.css",
	);

	public static $menuColor_array = array(
		"1" => "#fa8072",
		"2" => "#ff69b4",
		"3" => "#ffc0cb",
		"4" => "#ffa500",
		"5" => "#ffd700",
		"6" => "#ffff00",
		"7" => "#adff2f",
		"8" => "#eee8aa",
		"9" => "#00ff00",
		"10" => "#98fb98",
		"11" => "#20b2aa",
		"12" => "#40e0d0",
		"13" => "#00ffff",
		"14" => "#00bfff",
		"15" => "#87ceeb",
		"16" => "#ccfffa",
		"17" => "#e6e6fa",
		"18" => "#fff0f5",
		"19" => "#ee82ee",
		"20" => "#dda0dd",
	);




	//管理者の処理権限
	public static $adminType_array = array(
		"1" => "編集可能",
		"2" => "閲覧のみ",
		"3" => "権限なし",
	);

	//登録店舗に追加する（サイト管理で使用する）
	public static $adminShopType_array = array(
		"0" => "本部",
		"-1" => "その他",
		"-2" => "アフィリエイトのみ",
	);

	//stepMail 配信タイミングの選択肢
	public static $stepMail_array=array(
		"kind" => array(
			"1" => "最終来店",
			"2" => "コース購入",
			"3" => "予約日",
			"4" => "コース使用期限",
		),
		"when" => array(
			"1" => "前",
			"2" => "後",
		),
		"time" => array(
			"1" => "日",
			"2" => "時間",
			"3" => "分",
		),
	);

	//stepMail 配信タイミングの選択肢
	public static $makeForm_array=array(
		"type" => array(
			"1" => "テキストボックス（1行）",
			"2" => "テキストエリア（複数行）",
			"3" => "セレクトボックス",
			"4" => "ラジオボタン（一つ選択）",
			"5" => "チェックボックス(複数選択）",

		),
		"check" => array(
			"0" => "入力制限無し",
			"1" => "半角英数字のみ",
			"2" => "数字のみ",
			"5" => "数字と「-」",
			"12" => "数字と小数点",
			"7" => "全角ひらがなのみ",
			"6" => "全角カタカナのみ",
			"3" => "メールアドレス",

		),
	);

	//予約フォームで電話フラグ
	public static $adminReserveTel_array = array(
		"1" => "OK",
		"2" => "NG",
		"3" => "不在",
		"4" => "留守電",
		"0" => "未",

	);

	//予約時間
	public static $rsv_time_array = array(
		"00" => "00",
		"15" => "15",
		"30" => "30",
		"45" => "45",
	);
	public static $rsv_timeCount_array = array(
		"1" => "00",
		"2" => "15",
		"3" => "30",
		"4" => "45",
	);
	//予約管理カレンダー　開始時間によって、カレンダースタート位置の空白分のpxを指定
	public static $rsv_timePx_array = array(
		"00" => "0",
		"15" => "25",
		"30" => "50",
		"45" => "75",
	);
	//所要時間により、style.cssでのclass名を変更（幅）
	public static $rsv_timeType_array = array(
		"30" => "1",
		"45" => "2",
		"60" => "3",
		"75" => "4",
		"90" => "5",
	);

	public static $menu_time_array = array(
		"30" => "30",
		"45" => "45",
		"60" => "60",
		"75" => "75",
		"90" => "90",
	);

	//来店状況
	public static $visit_arr = array(
		"0" => "予約中",
		"1" => "来店",
		"99" => "キャンセル",

	);


//アプリの情報を$configに格納

        // 本番用とりあえずアピス作成のFBアプリアカウント
        public static $facebook_config = array(
                                'appId' => "789342891084857",
                                'secret' => "04f3932b2ce045366dc689dc409ea1d5",
                                        'redirect' => FACEBOOK_REDIRECT_MEMBER
                );




	//画像ロゴの基準
	public static $photo_logo_array = array("77","18");


	public static $photo_array = array(
		"width" => array(
					"0" => "143",
					"1" => "180",
					"2" => "250",
					"3" => "170",
					"4" => "170",
					"5" => "170",
				),
		"height" => array(
					"0" => "107",
					"1" => "100",
					"2" => "300",
					"3" => "100",
					"4" => "100",
					"5" => "100",
				),
		);



/*
	//画像名とサイズ
	public static $photo_array = array("L","S");

	public static $photoW_tate_array = array("270","240");
	public static $photoH_tate_array = array("360","320");

	public static $photoW_yoko_array = array("328","240");
	public static $photoH_yoko_array = array("246","180");
*/



	// 曜日配列
	public static $weekday_array = array( "1"=>"月", "2"=>"火", "3"=>"水", "4"=>"木", "5"=>"金", "6"=>"土","7"=>"日" );

	//エリア配列
	public static $area_array = array(
		"1" => "北海道",
		"2" => "東北",
		"3" => "関東",
		"4" => "北陸・甲信越",
		"5" => "東海",
		"6" => "近畿",
		"7" => "中国",
		"8" => "四国",
		"9" => "九州・沖縄",
		"10" => "その他"
		);


	// 都道府県配列
	public static $prefs_array = array(
		"北海道" => array("1" => "北海道"),
		"東北" => array(
						"2" => "青森県",
						"3" => "岩手県",
						"4" => "宮城県",
						"5" => "秋田県",
						"6" => "山形県",
						"7" => "福島県"),
		"関東" => array(
						"8" => "茨城県",
						"9" => "栃木県",
						"10" => "群馬県",
						"11" => "埼玉県",
						"12" => "千葉県",
						"13" => "東京都",
						"14" => "神奈川県"),
		"北陸・甲信越" => array(
						"15" => "新潟県",
						"16" => "富山県",
						"17" => "石川県",
						"18" => "福井県",
						"19" => "山梨県",
						"20" => "長野県"),
		"東海"		  => array(
						"21" => "岐阜県",
						"22" => "静岡県",
						"24" => "三重県",
						"23" => "愛知県"),
		"近畿" => array(

						"25" => "滋賀県",
						"26" => "京都府",
						"27" => "大阪府",
						"28" => "兵庫県",
						"29" => "奈良県",
						"30" => "和歌山県"),
		"中国" => array(
						"31" => "鳥取県",
						"32" => "島根県",
						"33" => "岡山県",
						"34" => "広島県",
						"35" => "山口県"),
		"四国" => array(
						"36" => "徳島県",
						"37" => "香川県",
						"38" => "愛媛県",
						"39" => "高知県"),
		"九州・沖縄" => array(
						"40" => "福岡県",
						"41" => "佐賀県",
						"42" => "長崎県",
						"43" => "熊本県",
						"44" => "大分県",
						"45" => "宮崎県",
						"46" => "鹿児島県",
						"47" => "沖縄県"),
		"その他" =>array(""=>"")
	);


	// 都道府県テーブル(前の番号に合わせる)
	public static $pref_text_array = array(
			"" => "選択してください",
			"1" => "北海道",
			"2" => "青森県",
			"3" => "岩手県",
			"4" => "宮城県",
			"5" => "秋田県",
			"6" => "山形県",
			"7" => "福島県",
			"8" => "茨城県",
			"9" => "栃木県",
			"10" => "群馬県",
			"11" => "埼玉県",
			"12" => "千葉県",
			"13" => "東京都",
			"14"=> "神奈川県",
			"15" => "新潟県",
			"16" => "富山県",
			"17" => "石川県",
			"18" => "福井県",
			"19" => "山梨県",
			"20" => "長野県",
			"21" => "岐阜県",
			"22" => "静岡県",
			"23" => "愛知県",
			"24" => "三重県",
			"25" => "滋賀県",
			"26" => "京都府",
			"27" => "大阪府",
			"28" => "兵庫県",
			"29" => "奈良県",
			"30" => "和歌山県",
			"31" => "鳥取県",
			"32" => "島根県",
			"33" => "岡山県",
			"34" => "広島県",
			"35" => "山口県",
			"36" => "徳島県",
			"37" => "香川県",
			"38" => "愛媛県",
			"39" => "高知県",
			"40" => "福岡県",
			"41" => "佐賀県",
			"42" => "長崎県",
			"43" => "熊本県",
			"44" => "大分県",
			"45" => "宮崎県",
			"46" => "鹿児島県",
			"47" => "沖縄県",
	);


}

?>
