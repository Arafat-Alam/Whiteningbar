<?php
class MasterController extends AppRootController {

	/**
	 * コンストラクタ
	 */
	public function __construct() {
		parent::__construct();
	}

		public function displayAction() {

			header("location:/");

		}


	/**
	 *
	 * カテゴリマスタ種類１(子あり）
	 *
	 * カテゴリー１　職種
	 */
	public function Category1Action() {
		$msg = '';
		$tbl="mst_category1";

		$commonDao=new CommonDao();
		@$exec = $_POST[ "exec" ];

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid =0 and v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}

		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid=0 and v_order > " . $order." order by v_order limit 1");
			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;

				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if( $exec == "subup" || $exec == "middleup"){
			$targetId = $_POST[ "id" ];//クリックしたID
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order < " . $order." order by v_order desc limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "subdown" || $exec == "middledown" ){
			$targetId = $_POST[ "id" ];
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order > " . $order." order by v_order  limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "id" ];

			$commonDao->del_Data($tbl, "id", $targetId);
			$msg="カテゴリーを削除しました。";

		}

		$cateArr=$commonDao->get_category_sort($tbl);

		//親カテゴリーの数を数える
		$pidcount=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['parentid']=="0"){
				$pidcount++;
			}
		}

		//親カテゴリーの調整 とサブカテゴリーの数を数えておく
		$oya=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==1){//親
				$oya++;
				$cateArr[$i]['mainup']=1;
				$cateArr[$i]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					$cateArr[$i]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					$cateArr[$i]['mainup']=0;//▲を表示しない
				}

				//該当の親を持つ中カテゴリーがあるか(カテゴリーがあれば、削除ボタンを出さないようにするため)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$midChildCnt[$cateArr[$i]['id']]=count($ret);
			}
			else if($cateArr[$i]['cflag']==2){//中
			}
			else if($cateArr[$i]['cflag']==3){//小　中カテゴリがなくて、大カテの下が小カテの場合。大カテを持つ小カテの数を数えておく。
			}
		}

		//該当の中カテゴリを持つ小カテゴリの数を出しておく
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){//中
				//該当の親を持つ小カテゴリーが存在するか（あれば、削除ボタンを出さない)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$subChildCnt[$cateArr[$i]['id']]=count($ret);
			}
		}

		//中カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){

				$cateArr[$i]['middleup']=1;
				$cateArr[$i]['middledown']=1;

				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['middleup']=0;
					$cateArr[$i]['middledown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['middledown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['middleup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($midChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;
				}
			}
		}

		//小カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==3){
				$cateArr[$i]['subup']=1;
				$cateArr[$i]['subdown']=1;

				//同親ID内での最終サブカテゴリー（上で取得したサブカテゴリーの数とソート順の番号が同じであれば）
				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['subup']=0;
					$cateArr[$i]['subdown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['subdown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['subup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if(@$subChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;//1がセットされたら、削除ボタンを出さない
				}
			}
		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		//ログイン済み
		$this->setTemplatePath("mst_category1.tpl");

		return;
	}


	/**
	 *
	 */
	public function category1editAction() {

		$tbl="mst_category1";

		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];
		$parentid = $_POST[ "parentid" ];
		$ctitle = $_POST[ "ctitle" ];

		if($_POST['regist']){


			$itemObj=$_POST;
			$this->view->assign("name", $itemObj['name']);
			$this->view->assign("fee", $itemObj['fee']);
			$this->view->assign("kind_flg", $itemObj['kind_flg']);
			$this->view->assign("report_flg", $itemObj['report_flg']);

			if($_POST['name']==""){
				$this->addMessage("category","クーポン名を入力してください。");
				$id = $_POST[ "id" ];
			}
			if($_POST['parentid']>0 && $_POST['name_kana']==""){//サブカテゴリの場合
				$this->addMessage("name_kana","ふりがなを入力してください。");
				$id = $_POST[ "id" ];
			}
			if($_POST['parentid']>0 && ($_POST['kind_flg']==0 && $_POST['fee']=="")){//サブカテゴリの場合
				$this->addMessage("fee","割引金額を入力してください。");
				$id = $_POST[ "id" ];
			}

			if (count($this->getMessages()) ==0) {

				$msg=1;
				//登録処理
				$obj['fee']=$_POST['fee'];
				$obj['name']=$_POST['name'];
				$obj['name_kana']=$_POST['name_kana'];
				$obj['kind_flg']=$_POST['kind_flg'];
				$obj['report_flg']=$_POST['report_flg'];
				if($_POST['id']==""){//新規

					if($_POST['parentid']!=""){//サブカテゴリー新規追加

						$ret=$commonDao->get_data_tbl($tbl,"parentid",$_POST['parentid'],"v_order desc",1);

						$obj['parentid']=$_POST['parentid'];

						if($exec=="middle"){
							$obj['cflag']=2;
						}
						else{
							$obj['cflag']=3;
						}
					}
					else{//メインカテゴリー新規追加
						$ret=$commonDao->get_data_tbl($tbl,"parentid",0,"v_order desc",1);

						$obj['parentid']=0;
						$obj['cflag']=1;
					}
					if($ret){
						$tmpObj=$ret[0];
						$order=$tmpObj['v_order']+1;
					}
					else{
						$order=1;
					}

					$obj['v_order']=$order;
					$obj['regdate']=date("Y-m-d");

					$commonDao->InsertItemData2($tbl, $obj);

				}
				else{//編集

					$wobj['id']=$_POST['id'];
					$commonDao->updateData2($tbl, $obj, $wobj);

				}

				//ふりがなによる自動ソート処理 2015.04.06 add suzuki
				$fi['parentid']=$_POST['parentid'];
				$oTmp=$commonDao->get_data_tbl2($tbl,$fi,"name_kana asc");

				for($i=0;$i<count($oTmp);$i++){
					//番号
					$id=$oTmp[$i]['id'];

					$fi=array();
					$wfi=array();
					$fi['v_order']=($i+1);
					$wfi['id']=$id;

					$commonDao->updateData2($tbl, $fi, $wfi);
				}
				//-------- ここまで ----------------------------------------------


				header("location:/master/category1/");
				exit;

			}
			else{

				foreach($this->getMessages() as $err_msg){
					$result_messages[$err_msg->getMessageLevel()]=$err_msg->getMessageBody();
				}

				$this->view->assign("result_messages", $result_messages);

			}

		}else if($_POST['id']!="" && ($exec=="sub" || $exec=="middle")){//中、小カテゴリー追加

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$parentid=$itemObj['id'];

			$ctitle=2;

		}else if($_POST['id']!=""){//カテゴリー変更
			//データ取得

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$this->view->assign("name", $itemObj['name']);
			$this->view->assign("name_kana", $itemObj['name_kana']);
			$this->view->assign("fee", $itemObj['fee']);
			$this->view->assign("kind_flg", $itemObj['kind_flg']);
			$this->view->assign("report_flg", $itemObj['report_flg']);
			$id=$itemObj['id'];
			$parentid=$itemObj['parentid'];
			$cflag=$itemObj['cflag'];

			$ctitle=1;

		}

		$this->view->assign("itemObj", $itemObj);
		$this->view->assign("cflag", $cflag);
		$this->view->assign("ctitle", $ctitle);
		$this->view->assign("id", $id);
		$this->view->assign("parentid", $parentid);
		$this->view->assign("exec", $exec);

		$this->setTemplatePath("category1_add.tpl");

	}

	/**
	 *
	 * カテゴリマスタ種類１(子あり）
	 *
	 * カテゴリー2　業種
	 */
	public function Category2Action() {
		$subChildCnt = $msg = '';
		$tbl="mst_category2";

		$commonDao=new CommonDao();
		@$exec = $_POST[ "exec" ];

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid =0 and v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}

		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid=0 and v_order > " . $order." order by v_order  limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if( $exec == "subup" || $exec == "middleup"){
			$targetId = $_POST[ "id" ];//クリックしたID
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order < " . $order." order by v_order desc limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "subdown" || $exec == "middledown" ){
			$targetId = $_POST[ "id" ];
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order > " . $order." order by v_order  limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "id" ];

			$commonDao->del_Data($tbl, "id", $targetId);
			$msg="カテゴリーを削除しました。";

		}

		$cateArr=$commonDao->get_category_sort($tbl);

		//親カテゴリーの数を数える
		$pidcount=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['parentid']=="0"){
				$pidcount++;
			}
		}

		//親カテゴリーの調整 とサブカテゴリーの数を数えておく
		$oya=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==1){//親
				$oya++;
				$cateArr[$i]['mainup']=1;
				$cateArr[$i]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					$cateArr[$i]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					$cateArr[$i]['mainup']=0;//▲を表示しない
				}

				//該当の親を持つ中カテゴリーがあるか(カテゴリーがあれば、削除ボタンを出さないようにするため)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$midChildCnt[$cateArr[$i]['id']]=count($ret);
			}
			else if($cateArr[$i]['cflag']==2){//中
			}
			else if($cateArr[$i]['cflag']==3){//小　中カテゴリがなくて、大カテの下が小カテの場合。大カテを持つ小カテの数を数えておく。
			}
		}

		//該当の中カテゴリを持つ小カテゴリの数を出しておく
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){//中
				//該当の親を持つ小カテゴリーが存在するか（あれば、削除ボタンを出さない)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$subChildCnt[$cateArr[$i]['id']]=count($ret);
			}
		}

		//中カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){

				$cateArr[$i]['middleup']=1;
				$cateArr[$i]['middledown']=1;

				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['middleup']=0;
					$cateArr[$i]['middledown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['middledown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['middleup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($midChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;
				}
			}
		}

		//小カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==3){
				$cateArr[$i]['subup']=1;
				$cateArr[$i]['subdown']=1;

				//同親ID内での最終サブカテゴリー（上で取得したサブカテゴリーの数とソート順の番号が同じであれば）
				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['subup']=0;
					$cateArr[$i]['subdown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['subdown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['subup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if(@$subChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;//1がセットされたら、削除ボタンを出さない
				}
			}
		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		//ログイン済み
		$this->setTemplatePath("mst_category2.tpl");

		return;
	}


	/**
	 *
	 */
	public function category2editAction() {

		$tbl="mst_category2";

		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];
		$parentid = $_POST[ "parentid" ];
		$ctitle = $_POST[ "ctitle" ];

		if($_POST['regist']){

			if($_POST['name']==""){
				$errmsg=1;
				$id = $_POST[ "id" ];
			}
			else{

				$msg=1;
				//登録処理
				if($_POST['id']==""){//新規

					if($_POST['parentid']!=""){//サブカテゴリー新規追加

						$ret=$commonDao->get_data_tbl($tbl,"parentid",$_POST['parentid'],"v_order desc",1);

						$obj['parentid']=$_POST['parentid'];

						if($exec=="middle"){
							$obj['cflag']=2;
						}
						else{
							$obj['cflag']=3;

						}

					}
					else{//メインカテゴリー新規追加
						$daoArr=new Category2Dao();
						$ret=$commonDao->get_data_tbl($tbl,"parentid",0,"v_order desc",1);

						$obj['parentid']=0;
						$obj['cflag']=1;

					}

					if($ret){
						$tmpObj=$ret[0];
						$order=$tmpObj['v_order']+1;
					}
					else{
						$order=1;
					}

					$obj['v_order']=$order;
					$obj['fee']=$_POST['fee'];
					$obj['name']=$_POST['name'];
					$obj['regdate']=date("Y-m-d");

					$commonDao->InsertItemData2($tbl, $obj);

				}
				else{//編集

					$obj['name']=$_POST['name'];
					$obj['fee']=$_POST['fee'];
					$wobj['id']=$_POST['id'];
					$commonDao->updateData2($tbl, $obj, $wobj);

				}
			}

			header("location:/master/category2/");
			exit;

		}else if($_POST['id']!="" && ($exec=="sub" || $exec=="middle")){//中、小カテゴリー追加

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$parentid=$itemObj['id'];

			$ctitle=2;

		}else if($_POST['id']!=""){//カテゴリー変更
			//データ取得

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$this->view->assign("itemObj", $itemObj);
			$id=$itemObj['id'];
			$parentid=$itemObj['parentid'];
			$cflag=$itemObj['cflag'];

			$ctitle=1;

		}

		$this->view->assign("cflag", $cflag);
		$this->view->assign("ctitle", $ctitle);
		$this->view->assign("id", $id);
		$this->view->assign("parentid", $parentid);
		$this->view->assign("exec", $exec);
		$this->view->assign("msg", $msg);
		$this->view->assign("errmsg", $errmsg);

		$this->setTemplatePath("category2_add.tpl");

	}


	/**
	 *	 *
	 * こだわり条件マスタ
	 *
	 */
	public function CharacterAction() {

		$tbl="mst_character";
		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid =0 and v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid=0 and v_order > " . $order." limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if( $exec == "subup" || $exec == "middleup"){
			$targetId = $_POST[ "id" ];//クリックしたID
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order < " . $order." order by v_order desc limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "subdown" || $exec == "middledown" ){
			$targetId = $_POST[ "id" ];
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order > " . $order." limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "id" ];

			$commonDao->del_Data($tbl, "id", $targetId);
			$msg="カテゴリーを削除しました。";

		}

		$cateArr=$commonDao->get_category_sort($tbl);

		//親カテゴリーの数を数える
		$pidcount=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['parentid']=="0"){
				$pidcount++;
			}
		}

		//親カテゴリーの調整 とサブカテゴリーの数を数えておく
		$oya=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==1){//親
				$oya++;
				$cateArr[$i]['mainup']=1;
				$cateArr[$i]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					$cateArr[$i]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					$cateArr[$i]['mainup']=0;//▲を表示しない
				}

				//該当の親を持つ中カテゴリーがあるか(カテゴリーがあれば、削除ボタンを出さないようにするため)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$midChildCnt[$cateArr[$i]['id']]=count($ret);
			}
			else if($cateArr[$i]['cflag']==2){//中
			}
			else if($cateArr[$i]['cflag']==3){//小　中カテゴリがなくて、大カテの下が小カテの場合。大カテを持つ小カテの数を数えておく。
			}
		}

		//該当の中カテゴリを持つ小カテゴリの数を出しておく
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){//中
				//該当の親を持つ小カテゴリーが存在するか（あれば、削除ボタンを出さない)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$subChildCnt[$cateArr[$i]['id']]=count($ret);
			}
		}

		//中カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){

				$cateArr[$i]['middleup']=1;
				$cateArr[$i]['middledown']=1;

				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['middleup']=0;
					$cateArr[$i]['middledown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['middledown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['middleup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($midChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;
				}
			}
		}

		//小カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==3){
				$cateArr[$i]['subup']=1;
				$cateArr[$i]['subdown']=1;

				//同親ID内での最終サブカテゴリー（上で取得したサブカテゴリーの数とソート順の番号が同じであれば）
				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['subup']=0;
					$cateArr[$i]['subdown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['subdown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['subup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($subChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;//1がセットされたら、削除ボタンを出さない
				}
			}
		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		//ログイン済み
		$this->setTemplatePath("mst_character.tpl");

		return;
	}


	/**
	 *
	 */
	public function charactereditAction() {

		$tbl="mst_character";

		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];
		$parentid = $_POST[ "parentid" ];
		$ctitle = $_POST[ "ctitle" ];

		if($_POST['regist']){

			if($_POST['name']==""){
				$errmsg=1;
				$id = $_POST[ "id" ];
			}
			else{

				$msg=1;
				//登録処理
				if($_POST['id']==""){//新規

					if($_POST['parentid']!=""){//サブカテゴリー新規追加

						$ret=$commonDao->get_data_tbl($tbl,"parentid",$_POST['parentid'],"v_order desc",1);

						$obj['parentid']=$_POST['parentid'];

						if($exec=="middle"){
							$obj['cflag']=2;
						}
						else{
							$obj['cflag']=3;

						}

					}
					else{//メインカテゴリー新規追加
						$daoArr=new Category2Dao();
						$ret=$commonDao->get_data_tbl($tbl,"parentid",0,"v_order desc",1);

						$obj['parentid']=0;
						$obj['cflag']=1;

					}

					if($ret){
						$tmpObj=$ret[0];
						$order=$tmpObj['v_order']+1;
					}
					else{
						$order=1;
					}

					$obj['v_order']=$order;
					$obj['name']=$_POST['name'];
					$obj['regdate']=date("Y-m-d");

					$commonDao->InsertItemData2($tbl, $obj);

				}
				else{//編集

					$obj['name']=$_POST['name'];
					$wobj['id']=$_POST['id'];
					$commonDao->updateData2($tbl, $obj, $wobj);

				}
			}

			header("location:/master/character/");
			exit;

		}else if($_POST['id']!="" && ($exec=="sub" || $exec=="middle")){//中、小カテゴリー追加

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$parentid=$itemObj['id'];

			$ctitle=2;

		}else if($_POST['id']!=""){//カテゴリー変更
			//データ取得

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$this->view->assign("name", $itemObj['name']);
			$id=$itemObj['id'];
			$parentid=$itemObj['parentid'];
			$cflag=$itemObj['cflag'];

			$ctitle=1;

		}

		$this->view->assign("cflag", $cflag);
		$this->view->assign("ctitle", $ctitle);
		$this->view->assign("id", $id);
		$this->view->assign("parentid", $parentid);
		$this->view->assign("exec", $exec);
		$this->view->assign("msg", $msg);
		$this->view->assign("errmsg", $errmsg);

		$this->setTemplatePath("character_add.tpl");

	}

	/**
	 *
	 * スキル
	 *
	 */
	public function SkillAction() {

		$tbl="mst_skill";
		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid =0 and v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}

		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid=0 and v_order > " . $order." limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if( $exec == "subup" || $exec == "middleup"){
			$targetId = $_POST[ "id" ];//クリックしたID
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order < " . $order." order by v_order desc limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "subdown" || $exec == "middledown" ){
			$targetId = $_POST[ "id" ];
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order > " . $order." limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "id" ];

			$commonDao->del_Data($tbl, "id", $targetId);
			$msg="カテゴリーを削除しました。";

		}

		$cateArr=$commonDao->get_category_sort($tbl);

		//親カテゴリーの数を数える
		$pidcount=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['parentid']=="0"){
				$pidcount++;
			}
		}

		//親カテゴリーの調整 とサブカテゴリーの数を数えておく
		$oya=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==1){//親
				$oya++;
				$cateArr[$i]['mainup']=1;
				$cateArr[$i]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					$cateArr[$i]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					$cateArr[$i]['mainup']=0;//▲を表示しない
				}

				//該当の親を持つ中カテゴリーがあるか(カテゴリーがあれば、削除ボタンを出さないようにするため)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$midChildCnt[$cateArr[$i]['id']]=count($ret);
			}
			else if($cateArr[$i]['cflag']==2){//中
			}
			else if($cateArr[$i]['cflag']==3){//小　中カテゴリがなくて、大カテの下が小カテの場合。大カテを持つ小カテの数を数えておく。
			}
		}

		//該当の中カテゴリを持つ小カテゴリの数を出しておく
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){//中
				//該当の親を持つ小カテゴリーが存在するか（あれば、削除ボタンを出さない)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$subChildCnt[$cateArr[$i]['id']]=count($ret);
			}
		}

		//中カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){

				$cateArr[$i]['middleup']=1;
				$cateArr[$i]['middledown']=1;

				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['middleup']=0;
					$cateArr[$i]['middledown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['middledown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['middleup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($midChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;
				}
			}
		}

		//小カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==3){
				$cateArr[$i]['subup']=1;
				$cateArr[$i]['subdown']=1;

				//同親ID内での最終サブカテゴリー（上で取得したサブカテゴリーの数とソート順の番号が同じであれば）
				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['subup']=0;
					$cateArr[$i]['subdown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['subdown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['subup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($subChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;//1がセットされたら、削除ボタンを出さない
				}
			}
		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		//ログイン済み
		$this->setTemplatePath("mst_skill.tpl");

		return;
	}


	/**
	 *
	 */
	public function skilleditAction() {

		$tbl="mst_skill";

		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];
		$parentid = $_POST[ "parentid" ];
		$ctitle = $_POST[ "ctitle" ];

		if($_POST['regist']){

			if($_POST['name']==""){
				$errmsg=1;
				$id = $_POST[ "id" ];
			}
			else{

				$msg=1;
				//登録処理
				if($_POST['id']==""){//新規

					if($_POST['parentid']!=""){//サブカテゴリー新規追加

						$ret=$commonDao->get_data_tbl($tbl,"parentid",$_POST['parentid'],"v_order desc",1);

						$obj['parentid']=$_POST['parentid'];

						if($exec=="middle"){
							$obj['cflag']=2;
						}
						else{
							$obj['cflag']=3;

						}

					}
					else{//メインカテゴリー新規追加
						$daoArr=new Category2Dao();
						$ret=$commonDao->get_data_tbl($tbl,"parentid",0,"v_order desc",1);

						$obj['parentid']=0;
						$obj['cflag']=1;

					}

					if($ret){
						$tmpObj=$ret[0];
						$order=$tmpObj['v_order']+1;
					}
					else{
						$order=1;
					}

					$obj['v_order']=$order;
					$obj['name']=$_POST['name'];
					$obj['regdate']=date("Y-m-d");

					$commonDao->InsertItemData2($tbl, $obj);

				}
				else{//編集

					$obj['name']=$_POST['name'];
					$wobj['id']=$_POST['id'];
					$commonDao->updateData2($tbl, $obj, $wobj);

				}
			}

			header("location:/master/skill/");
			exit;

		}else if($_POST['id']!="" && ($exec=="sub" || $exec=="middle")){//中、小カテゴリー追加

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$parentid=$itemObj['id'];

			$ctitle=2;

		}else if($_POST['id']!=""){//カテゴリー変更
			//データ取得

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$this->view->assign("name", $itemObj['name']);
			$id=$itemObj['id'];
			$parentid=$itemObj['parentid'];
			$cflag=$itemObj['cflag'];

			$ctitle=1;

		}

		$this->view->assign("cflag", $cflag);
		$this->view->assign("ctitle", $ctitle);
		$this->view->assign("id", $id);
		$this->view->assign("parentid", $parentid);
		$this->view->assign("exec", $exec);
		$this->view->assign("msg", $msg);
		$this->view->assign("errmsg", $errmsg);

		$this->setTemplatePath("skill_add.tpl");

	}

	/**
	 *
	 * カテゴリマスタ種類2(子なし）
	 *
	 * 雇用形態
	 */
	public function employAction() {

		$tbl="mst_employ";
		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid =0 and v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid=0 and v_order > " . $order." limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if( $exec == "subup" || $exec == "middleup"){
			$targetId = $_POST[ "id" ];//クリックしたID
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order < " . $order." order by v_order desc limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "subdown" || $exec == "middledown" ){
			$targetId = $_POST[ "id" ];
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order > " . $order." limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "id" ];

			$commonDao->del_Data($tbl, "id", $targetId);
			$msg="カテゴリーを削除しました。";

		}

		$cateArr=$commonDao->get_category_sort($tbl);

		//親カテゴリーの数を数える
		$pidcount=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['parentid']=="0"){
				$pidcount++;
			}
		}

		//親カテゴリーの調整 とサブカテゴリーの数を数えておく
		$oya=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==1){//親
				$oya++;
				$cateArr[$i]['mainup']=1;
				$cateArr[$i]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					$cateArr[$i]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					$cateArr[$i]['mainup']=0;//▲を表示しない
				}

				//該当の親を持つ中カテゴリーがあるか(カテゴリーがあれば、削除ボタンを出さないようにするため)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$midChildCnt[$cateArr[$i]['id']]=count($ret);
			}
			else if($cateArr[$i]['cflag']==2){//中
			}
			else if($cateArr[$i]['cflag']==3){//小　中カテゴリがなくて、大カテの下が小カテの場合。大カテを持つ小カテの数を数えておく。
			}
		}

		//該当の中カテゴリを持つ小カテゴリの数を出しておく
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){//中
				//該当の親を持つ小カテゴリーが存在するか（あれば、削除ボタンを出さない)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$subChildCnt[$cateArr[$i]['id']]=count($ret);
			}
		}

		//中カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){

				$cateArr[$i]['middleup']=1;
				$cateArr[$i]['middledown']=1;

				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['middleup']=0;
					$cateArr[$i]['middledown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['middledown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['middleup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($midChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;
				}
			}
		}

		//小カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==3){
				$cateArr[$i]['subup']=1;
				$cateArr[$i]['subdown']=1;

				//同親ID内での最終サブカテゴリー（上で取得したサブカテゴリーの数とソート順の番号が同じであれば）
				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['subup']=0;
					$cateArr[$i]['subdown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['subdown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['subup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($subChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;//1がセットされたら、削除ボタンを出さない
				}
			}
		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		//ログイン済み
		$this->setTemplatePath("mst_employ.tpl");

		return;
	}


	/**
	 *
	 */
	public function employeditAction() {

		$tbl="mst_employ";

		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];
		$parentid = $_POST[ "parentid" ];
		$ctitle = $_POST[ "ctitle" ];

		if($_POST['regist']){

			if($_POST['name']==""){
				$errmsg=1;
				$id = $_POST[ "id" ];
			}
			else{

				$msg=1;
				//登録処理
				if($_POST['id']==""){//新規

					if($_POST['parentid']!=""){//サブカテゴリー新規追加

						$ret=$commonDao->get_data_tbl($tbl,"parentid",$_POST['parentid'],"v_order desc",1);

						$obj['parentid']=$_POST['parentid'];

						if($exec=="middle"){
							$obj['cflag']=2;
						}
						else{
							$obj['cflag']=3;
						}
					}
					else{//メインカテゴリー新規追加
						$daoArr=new Category2Dao();
						$ret=$commonDao->get_data_tbl($tbl,"parentid",0,"v_order desc",1);

						$obj['parentid']=0;
						$obj['cflag']=1;
					}

					if($ret){
						$tmpObj=$ret[0];
						$order=$tmpObj['v_order']+1;
					}
					else{
						$order=1;
					}

					$obj['v_order']=$order;
					$obj['name']=$_POST['name'];
					$obj['regdate']=date("Y-m-d");

					$commonDao->InsertItemData2($tbl, $obj);

				}
				else{//編集

					$obj['name']=$_POST['name'];
					$wobj['id']=$_POST['id'];
					$commonDao->updateData2($tbl, $obj, $wobj);

				}
			}

			header("location:/master/employ/");
			exit;

		}else if($_POST['id']!="" && ($exec=="sub" || $exec=="middle")){//中、小カテゴリー追加

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$parentid=$itemObj['id'];

			$ctitle=2;

		}else if($_POST['id']!=""){//カテゴリー変更
			//データ取得

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$this->view->assign("name", $itemObj['name']);
			$id=$itemObj['id'];
			$parentid=$itemObj['parentid'];
			$cflag=$itemObj['cflag'];

			$ctitle=1;

		}

		$this->view->assign("ctitle", $ctitle);
		$this->view->assign("id", $id);
		$this->view->assign("exec", $exec);
		$this->view->assign("msg", $msg);
		$this->view->assign("errmsg", $errmsg);

		$this->setTemplatePath("employ_add.tpl");

	}

	/**
	 *
	 * カテゴリマスタ種類2(子なし）
	 *
	 * 職務経歴の職種マスタ
	 */
	public function expAction() {

		$tbl="mst_exp";
		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid =0 and v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid=0 and v_order > " . $order." limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if( $exec == "subup" || $exec == "middleup"){
			$targetId = $_POST[ "id" ];//クリックしたID
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order < " . $order." order by v_order desc limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "subdown" || $exec == "middledown" ){
			$targetId = $_POST[ "id" ];
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order > " . $order." limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "id" ];

			$commonDao->del_Data($tbl, "id", $targetId);
			$msg="カテゴリーを削除しました。";

		}

		$cateArr=$commonDao->get_category_sort($tbl);

		//親カテゴリーの数を数える
		$pidcount=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['parentid']=="0"){
				$pidcount++;
			}
		}

		//親カテゴリーの調整 とサブカテゴリーの数を数えておく
		$oya=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==1){//親
				$oya++;
				$cateArr[$i]['mainup']=1;
				$cateArr[$i]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					$cateArr[$i]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					$cateArr[$i]['mainup']=0;//▲を表示しない
				}

				//該当の親を持つ中カテゴリーがあるか(カテゴリーがあれば、削除ボタンを出さないようにするため)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$midChildCnt[$cateArr[$i]['id']]=count($ret);
			}
			else if($cateArr[$i]['cflag']==2){//中
			}
			else if($cateArr[$i]['cflag']==3){//小　中カテゴリがなくて、大カテの下が小カテの場合。大カテを持つ小カテの数を数えておく。
			}
		}

		//該当の中カテゴリを持つ小カテゴリの数を出しておく
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){//中
				//該当の親を持つ小カテゴリーが存在するか（あれば、削除ボタンを出さない)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$subChildCnt[$cateArr[$i]['id']]=count($ret);
			}
		}

		//中カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){

				$cateArr[$i]['middleup']=1;
				$cateArr[$i]['middledown']=1;

				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['middleup']=0;
					$cateArr[$i]['middledown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['middledown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['middleup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($midChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;
				}
			}
		}

		//小カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==3){
				$cateArr[$i]['subup']=1;
				$cateArr[$i]['subdown']=1;

				//同親ID内での最終サブカテゴリー（上で取得したサブカテゴリーの数とソート順の番号が同じであれば）
				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['subup']=0;
					$cateArr[$i]['subdown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['subdown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['subup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($subChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;//1がセットされたら、削除ボタンを出さない
				}
			}
		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		//ログイン済み
		$this->setTemplatePath("mst_exp.tpl");

		return;
	}


	/**
	 *
	 *
	 */
	public function expeditAction() {

		$tbl="mst_exp";

		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];
		$parentid = $_POST[ "parentid" ];
		$ctitle = $_POST[ "ctitle" ];

		if($_POST['regist']){

			if($_POST['name']==""){
				$errmsg=1;
				$id = $_POST[ "id" ];
			}
			else{

				$msg=1;
				//登録処理
				if($_POST['id']==""){//新規

					if($_POST['parentid']!=""){//サブカテゴリー新規追加

						$ret=$commonDao->get_data_tbl($tbl,"parentid",$_POST['parentid'],"v_order desc",1);

						$obj['parentid']=$_POST['parentid'];

						if($exec=="middle"){
							$obj['cflag']=2;
						}
						else{
							$obj['cflag']=3;
						}
					}
					else{//メインカテゴリー新規追加
						$daoArr=new Category2Dao();
						$ret=$commonDao->get_data_tbl($tbl,"parentid",0,"v_order desc",1);

						$obj['parentid']=0;
						$obj['cflag']=1;
					}

					if($ret){
						$tmpObj=$ret[0];
						$order=$tmpObj['v_order']+1;
					}
					else{
						$order=1;
					}

					$obj['v_order']=$order;
					$obj['name']=$_POST['name'];
					$obj['regdate']=date("Y-m-d");

					$commonDao->InsertItemData2($tbl, $obj);

				}
				else{//編集

					$obj['name']=$_POST['name'];
					$wobj['id']=$_POST['id'];
					$commonDao->updateData2($tbl, $obj, $wobj);

				}
			}

			header("location:/master/exp/");
			exit;

		}else if($_POST['id']!="" && ($exec=="sub" || $exec=="middle")){//中、小カテゴリー追加

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$parentid=$itemObj['id'];

			$ctitle=2;

		}else if($_POST['id']!=""){//カテゴリー変更
			//データ取得

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$this->view->assign("name", $itemObj['name']);
			$id=$itemObj['id'];
			$parentid=$itemObj['parentid'];
			$cflag=$itemObj['cflag'];

			$ctitle=1;

		}

		$this->view->assign("cflag", $cflag);
		$this->view->assign("ctitle", $ctitle);
		$this->view->assign("id", $id);
		$this->view->assign("parentid", $parentid);
		$this->view->assign("exec", $exec);
		$this->view->assign("msg", $msg);
		$this->view->assign("errmsg", $errmsg);

		$this->setTemplatePath("exp_add.tpl");

	}

	/**
	 *
	 * 希望勤務地マスタ
	 */
	public function placeAction() {

		$tbl="mst_place";
		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];

		//メインカテゴリー
		if($exec=="mainup"){

			$targetId = $_POST[ "id" ];//クリックしたID
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid =0 and v_order < " . $order." order by v_order desc limit 1");

			if($ret){
				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if($exec=="maindown"){
			$targetId = $_POST[ "id" ];
			$order = $_POST[ "value" ];

			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid=0 and v_order > " . $order." limit 1");

			if($ret){

				//選択したIDよりもひとつ小さい番号を一つだけ取得
				//その取得したカテゴリーをクリックした表示番号（$orderにする）
				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);

			}
		}
		else if( $exec == "subup" || $exec == "middleup"){
			$targetId = $_POST[ "id" ];//クリックしたID
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order < " . $order." order by v_order desc limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order-1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "subdown" || $exec == "middledown" ){
			$targetId = $_POST[ "id" ];
			$tmp=$commonDao->get_data_tbl($tbl,"id",$targetId);
			$targetObj=$tmp[0];

			$parentid = $targetObj['parentid'];
			$order = $_POST[ "value" ];
			$ret=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$parentid." and v_order > " . $order." limit 1");

			if($ret){

				$commonDao->updateData($tbl, "v_order", $order, "id", $ret[0]['id']);

				//最初に選択したカテゴリーは一つ上（表示順を一つ上にする）
				$v_order=$order+1;
				$commonDao->updateData($tbl, "v_order", $v_order, "id", $targetId);
			}
		}
		else if( $exec == "delete" ){
			$targetId = $_POST[ "id" ];

			$commonDao->del_Data($tbl, "id", $targetId);
			$msg="カテゴリーを削除しました。";

		}

		$cateArr=$commonDao->get_category_sort($tbl);

		//親カテゴリーの数を数える
		$pidcount=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['parentid']=="0"){
				$pidcount++;
			}
		}

		//親カテゴリーの調整 とサブカテゴリーの数を数えておく
		$oya=0;
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==1){//親
				$oya++;
				$cateArr[$i]['mainup']=1;
				$cateArr[$i]['maindown']=1;
				if($oya==$pidcount){//ソート最後の親カテゴリ
					$cateArr[$i]['maindown']=0;//▼を表示しない
				}
				if($oya==1){//ソート最初の親カテゴリ
					$cateArr[$i]['mainup']=0;//▲を表示しない
				}

				//該当の親を持つ中カテゴリーがあるか(カテゴリーがあれば、削除ボタンを出さないようにするため)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$midChildCnt[$cateArr[$i]['id']]=count($ret);
			}
			else if($cateArr[$i]['cflag']==2){//中
			}
			else if($cateArr[$i]['cflag']==3){//小　中カテゴリがなくて、大カテの下が小カテの場合。大カテを持つ小カテの数を数えておく。
			}
		}

		//該当の中カテゴリを持つ小カテゴリの数を出しておく
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){//中
				//該当の親を持つ小カテゴリーが存在するか（あれば、削除ボタンを出さない)
				$ret=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['id']);
				$subChildCnt[$cateArr[$i]['id']]=count($ret);
			}
		}

		//中カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==2){

				$cateArr[$i]['middleup']=1;
				$cateArr[$i]['middledown']=1;

				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['middleup']=0;
					$cateArr[$i]['middledown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['middledown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['middleup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($midChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;
				}
			}
		}

		//小カテゴリーの調整
		for($i=0;$i<count($cateArr);$i++){
			if($cateArr[$i]['cflag']==3){
				$cateArr[$i]['subup']=1;
				$cateArr[$i]['subdown']=1;

				//同親ID内での最終サブカテゴリー（上で取得したサブカテゴリーの数とソート順の番号が同じであれば）
				//同じ親を持つカテゴリが一つしかない場合は、▼▲両方出さない
				$tmp=$commonDao->get_data_tbl($tbl,"parentid",$cateArr[$i]['parentid']);
				if(count($tmp)==1){
					$cateArr[$i]['subup']=0;
					$cateArr[$i]['subdown']=0;
				}
				else{

					//該当IDより後ろのv_orderが無ければ、最終カテゴリ
					$tmp=$commonDao->get_sql("select * from ".$tbl." where parentid = ".$cateArr[$i]['parentid']." and v_order > " . $cateArr[$i]['v_order']);
					if(!$tmp){
						$cateArr[$i]['subdown']=0;//▼を表示しない
					}
					if($cateArr[$i]['v_order']==1){
						$cateArr[$i]['subup']=0;//▲を表示しない
					}
				}
			}
			else{
				//サブカテゴリーがあるか
				if($subChildCnt[$cateArr[$i]['id']]<>0){
					$cateArr[$i]['subflag']=1;//1がセットされたら、削除ボタンを出さない
				}
			}
		}

		$this->view->assign("cateArr", $cateArr);
		$this->view->assign("pidcount", $pidcount);
		$this->view->assign("msg", $msg);


		//ログイン済み
		$this->setTemplatePath("mst_place.tpl");

		return;
	}


	/**
	 *
	 *
	 */
	public function placeeditAction() {

		$tbl="mst_place";

		$commonDao=new CommonDao();
		$exec = $_POST[ "exec" ];
		$parentid = $_POST[ "parentid" ];
		$ctitle = $_POST[ "ctitle" ];

		if($_POST['regist']){

			if($_POST['name']==""){
				$errmsg=1;
				$id = $_POST[ "id" ];
			}
			else{

				$msg=1;
				//登録処理
				if($_POST['id']==""){//新規

					if($_POST['parentid']!=""){//サブカテゴリー新規追加

						$ret=$commonDao->get_data_tbl($tbl,"parentid",$_POST['parentid'],"v_order desc",1);

						$obj['parentid']=$_POST['parentid'];

						if($exec=="middle"){
							$obj['cflag']=2;
						}
						else{
							$obj['cflag']=3;
						}
					}
					else{//メインカテゴリー新規追加
						$daoArr=new Category2Dao();
						$ret=$commonDao->get_data_tbl($tbl,"parentid",0,"v_order desc",1);

						$obj['parentid']=0;
						$obj['cflag']=1;
					}

					if($ret){
						$tmpObj=$ret[0];
						$order=$tmpObj['v_order']+1;
					}
					else{
						$order=1;
					}

					$obj['v_order']=$order;
					$obj['name']=$_POST['name'];
					$obj['regdate']=date("Y-m-d");

					$commonDao->InsertItemData2($tbl, $obj);

				}
				else{//編集

					$obj['name']=$_POST['name'];
					$wobj['id']=$_POST['id'];
					$commonDao->updateData2($tbl, $obj, $wobj);

				}
			}

			header("location:/master/place/");
			exit;

		}else if($_POST['id']!="" && ($exec=="sub" || $exec=="middle")){//中、小カテゴリー追加

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$parentid=$itemObj['id'];

			$ctitle=2;

		}else if($_POST['id']!=""){//カテゴリー変更
			//データ取得

			$tmp=$commonDao->get_data_tbl($tbl,"id",$_POST['id']);
			$itemObj=$tmp[0];

			$this->view->assign("name", $itemObj['name']);
			$id=$itemObj['id'];
			$parentid=$itemObj['parentid'];
			$cflag=$itemObj['cflag'];

			$ctitle=1;

		}

		$this->view->assign("cflag", $cflag);
		$this->view->assign("ctitle", $ctitle);
		$this->view->assign("id", $id);
		$this->view->assign("parentid", $parentid);
		$this->view->assign("exec", $exec);
		$this->view->assign("msg", $msg);
		$this->view->assign("errmsg", $errmsg);

		$this->setTemplatePath("place_add.tpl");

	}

}
?>

