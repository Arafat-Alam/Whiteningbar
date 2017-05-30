{$smarty.const.SITE_TITLE} 運営者様


会員様の御予約に変更がありましたのでお知らせいたします。


【会員様のお名前】

◆お名前：{$input_data.name}様

◆メールアドレス：{$input_data.email}



【変更後のご予約内容】

◆予約番号：{$reserve_datail.reserve_no}

◆予約日：{$reserve_datail.reserve_date}

◆時間：{$reserve_datail.start_time} ～ {$reserve_datail.end_time}

◆人数：{$reserve_datail.number}人

◆店舗：{$reserve_datail.shop_name}

◆メニュー：{$menu_name}


【変更前のご予約内容】

◆予約番号：{$oldReserveArr.reserve_no}

◆予約日：{$oldReserveArr.reserve_date|replace:"-":"/"}

◆時間：{$oldReserveArr.start_time|date_format:"%H:%M"} ～ {$oldReserveArr.end_time|date_format:"%H:%M"}

◆人数：{$oldReserveArr.number}人

◆店舗：{$oldshop_name}

◆メニュー：{$oldmenu_name}

