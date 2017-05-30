<?php /* Smarty version 2.6.26, created on 2017-05-29 18:40:01
         compiled from reserve/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'reserve/list.tpl', 140, false),array('function', 'html_radios', 'reserve/list.tpl', 275, false),array('modifier', 'date_format', 'reserve/list.tpl', 147, false),array('modifier', 'nl2br', 'reserve/list.tpl', 270, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='reserve';
$_SESSION['tab']='reserve';
$page = $_GET['page'];
$this->assign('page',$page);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#shop_no").val("");
	$("#user_name").val("");
	$("#start_date").val("");
	$("#end_date").val("");
	$("#ins_start").val("");
	$("#ins_end").val("");
	$("#course_no").val("");


}

function orderbyChange() {
	// document.orderbyForm.action = "/reserve/list/";
	// document.orderbyForm.submit(); 
	var order = $("#selectOrderBy").val();
	$("#orders").val(order);
	$("#sbm_search").click();

}

function pageFunc() {
	var lastPage = '; ?>
<?php echo $this->_tpl_vars['lastPage']; ?>
<?php echo ';
	var val = $(\'#page\').val();
	if (val < 1 ) {
		alert(\'Page no should be gretter then 0\');
		return false;
	}else if (val > lastPage) {
		alert(\'Maximum page no is \'+lastPage);
		return false;
	}
	document.pageForm.action = "/reserve/list/";
	document.pageForm.submit();
}


function clickDisableChk(obj) {
	var id = $(obj).attr("id").replace("disabled_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#disabled_" + id).val("t");
	}
	else {
		$("#disabled_" + id).val("f");
	}
}

function clickDeleteChk(obj) {
	var id = $(obj).attr("id").replace("delete_dummy_", "");
	if ($(obj).attr("checked") == "checked") {
		$("#delete_" + id).val("t");
	}
	else {
		$("#delete_" + id).val("f");
	}
}

function getList(){

	target1 = $("#menu");
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList2/",
		cache : false,
		dataType: "text",
		data : {
			course_no: $("#course_no").val(),
			menu_no: '; ?>
<?php if ($this->_tpl_vars['input_data']['menu_no']): ?><?php echo $this->_tpl_vars['input_data']['menu_no']; ?>
<?php else: ?>0<?php endif; ?><?php echo '
		},
		success: function(data, dataType) {
			console.log(data);
			// target1.after(data.html);
			target1.html(data);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}


$(function(){
	$("#start_date").datepicker({
		dateFormat: "yy/mm/dd"
	});
	$("#end_date").datepicker({
		dateFormat: "yy/mm/dd"
	});
	$("#ins_start").datepicker({
		dateFormat: "yy/mm/dd"
	});
	$("#ins_end").datepicker({
		dateFormat: "yy/mm/dd"
	});

	if($("#course_no").val()){
		getList();
	}


});


'; ?>

</script>
<body>
<div id="wrapper">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "sidebar.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<div id="main_content">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "reserve/menu_reserve.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>予約一覧</h3>

	<div class="w80 center search_section">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['result_messages']): ?>
			<center><span class="red"><?php echo $this->_tpl_vars['result_messages']; ?>
</span></center>
		<?php endif; ?>

		<form method="post" name="fm_search" action="/reserve/list/" name="searchForm">
		<table class="admins clear mt10">
		<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
			<tr>
				<th>予約店舗</th>
				<td>
					<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['search']['shop_no'],'id' => 'shop_no'), $this);?>

				</td>
			</tr>
		<?php endif; ?>
		<tr>
				<th>予約日</th>
				<td>
				<input type="text" id="start_date" name="start_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
				～
				<input type="text" id="end_date" name="end_date" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>

<input type="submit" name="submit_today" value="本日">
				</td>
		</tr>
		<tr>
				<th>予約登録日</th>
				<td>
				<input type="text" id="ins_start" name="ins_start" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['ins_start'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>
				～
				<input type="text" id="ins_end" name="ins_end" size="25" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['search']['ins_end'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y/%m/%d') : smarty_modifier_date_format($_tmp, '%Y/%m/%d')); ?>
" style="ime-mode:disabled;"/>

				</td>
		</tr>
		<tr>
				<th>コース > メニュー</th>
				<td>
					<?php echo smarty_function_html_options(array('name' => 'course_no','options' => $this->_tpl_vars['courseArr'],'selected' => $this->_tpl_vars['search']['course_no'],'id' => 'course_no','onChange' => "getList()"), $this);?>

※コースを選択すると対応するメニューが表示されます
					<div id="menu"></div>
				</td>
		</tr>
		<tr>
			<th>お申込者名</th>
			<td>
				<input type="text" name="name" id="user_name"  value="<?php echo $this->_tpl_vars['search']['name']; ?>
" size="20" />
			</td>
		</tr>
		<tr>
			<th>ソート</th>
			<td>
				予約日が
				<label><input type="radio" name="orderby" value="1" <?php if ($this->_tpl_vars['search']['orderby'] == 1): ?>checked<?php endif; ?>>新しい順　</label>
				<label><input type="radio" name="orderby" value="2" <?php if ($this->_tpl_vars['search']['orderby'] == 2): ?>checked<?php endif; ?>>古い順　</label>/　
				予約登録日が
				<label><input type="radio" name="orderby" value="3" <?php if ($this->_tpl_vars['search']['orderby'] == 3): ?>checked<?php endif; ?>>新しい順　</label>
				<label><input type="radio" name="orderby" value="4" <?php if ($this->_tpl_vars['search']['orderby'] == 4): ?>checked<?php endif; ?>>古い順　</label>

				<!-- <input type="hidden" name="page" id="page" value="<?php echo $this->_tpl_vars['page']; ?>
"> -->
			</td>
		</tr>


		</table>
		<!-- <p class="tc">※店舗とお申込者を入力した場合、該当のお客様が予約をした店舗で検索します。</p> -->

		<div class="mt10 tc">
			<button type="submit" name="sbm_search" class="btn-lg" id="sbm_search">検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
	</div>
<hr>
<form action="" method="post">

<button type="submit" name="csv" class="btn-lg">CSV出力</button>&nbsp;
<button type="button" class="btn-lg" onclick="window.print();">印刷する</button>&nbsp;
</form>

		
			<div class="paging clearfix">
				<div class="left">Showing <?php echo $this->_tpl_vars['from']; ?>
 to <?php echo $this->_tpl_vars['to']; ?>
 of <?php echo $this->_tpl_vars['total_cnt']; ?>
 items  
										</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
			</div>
				<div>
					<form action="" method="POST" name="orderbyForm">
					<div class="left">
					ソート : 
						<select name="orderbyselect" onchange="orderbyChange()" id="selectOrderBy">
							<option value="none">ソートの選択</option>
							<option value="reserve_date" <?php if ($this->_tpl_vars['ord'] == 'reserve_date'): ?><?php echo 'selected'; ?>
<?php endif; ?>>予約日</option>
							<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
							<option value="shop" <?php if ($this->_tpl_vars['ord'] == 'shop'): ?><?php echo 'selected'; ?>
<?php endif; ?>>予約店舗</option>
							<?php endif; ?>
							<option value="reserve_no" <?php if ($this->_tpl_vars['ord'] == 'reserve_no'): ?><?php echo 'selected'; ?>
<?php endif; ?>>予約番号</option>
						</select>
					</div>
					</form>
					<form action="" method="GET" name="pageForm">
					<div class="right">
						Jump to Page No : <input type="number" name="page" min="1" id="page">
								<input type="button" name="btn" value="Jump" onclick="pageFunc()">
					</div>
					</form>
				</div>

			<table  class="admins clear" style="margin-top: 50px; " id="dataTable">
				<thead>	
					<tr>
						<th width="80">予約番号</th>
						<th width="80">予約日</th>
						<th width="80">時間</th>
						<th width="120">お申込者</th>
						<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
							<th width="100">予約店舗</th>
						<?php endif; ?>
						<th width="130">メニュー</th>
						<th class="nowrap">人数</th>
						<!--  <th width="150">メッセージ</th>-->
						<th  id="right_th">管理メモ</th>
					</tr>
				</thead>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
			 <?php $this->assign('rno', ($this->_tpl_vars['item']).".reserve_no"); ?>
			 <tbody>
				<tr>
					<td><a href="/reserve/edit/?reserve_no=<?php echo $this->_tpl_vars['item']['reserve_no']; ?>
"><?php echo $this->_tpl_vars['item']['reserve_no']; ?>
</a></td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['reserve_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
</td>
					<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['start_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
～<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['end_time'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%H:%M") : smarty_modifier_date_format($_tmp, "%H:%M")); ?>
</td>
					<td><?php echo $this->_tpl_vars['item']['name']; ?>
/<?php echo $this->_tpl_vars['item']['name_kana']; ?>
<br />
						<a href="/member/edit/?member_id=<?php echo $this->_tpl_vars['item']['member_id']; ?>
" class="btn btn-sm">詳細</a>&nbsp;<a href="/member/history/?member_id=<?php echo $this->_tpl_vars['item']['member_id']; ?>
" class="btn btn-sm">履歴</a>
						<br />(<?php echo $this->_tpl_vars['item']['member_no']; ?>
)
					</td>
					<?php if ($this->_tpl_vars['login_admin']['shop_no'] <= 0): ?>
						<td><?php echo $this->_tpl_vars['item']['shop_name']; ?>
</td>
					<?php endif; ?>
					<td><?php echo $this->_tpl_vars['item']['menu_name']; ?>
</td>
					<td class="tc"><?php echo $this->_tpl_vars['item']['number']; ?>
人</td>
					<!-- <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['comment'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
</td>-->
					<td id="right_com">
						<form name="fm_list" id="fm_list" method="POST" action="/reserve/list/">
                        <div class="left w60">
                            <textarea name="kanri_comment" class="w100"><?php echo $this->_tpl_vars['item']['kanri_comment']; ?>
</textarea>
                            <!-- <?php echo smarty_function_html_radios(array('name' => 'tel_flg','options' => $this->_tpl_vars['telArr'],'selected' => $this->_tpl_vars['item']['tel_flg']), $this);?>
 -->
                        </div>
                        <div class="right">
                            <input type="submit" name="submit" value="更新">
                            <input type="hidden" name="reserve_no" value="<?php echo $this->_tpl_vars['item']['reserve_no']; ?>
">
                        </div>
						</form>
					</td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="11">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			<?php endif; unset($_from); ?>
			</tbody>
			</table>
			<div class="paging">
				<div class="left">Showing <?php echo $this->_tpl_vars['from']; ?>
 to <?php echo $this->_tpl_vars['to']; ?>
 of <?php echo $this->_tpl_vars['total_cnt']; ?>
 items  
										</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
				<div class="end"></div>
			</div>
			</form>

	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style type="text/css">
<?php echo '
	@media print {
		table { page-break-after:auto }
		tr    { page-break-inside:avoid; page-break-after:auto }
		td    { page-break-inside:avoid; page-break-after:auto }
		thead { display:table-header-group }
		tfoot { display:table-footer-group }

		header { display: none; }
		head{ display: none;}
		h3 { display: none; }
		button { display: none; }
		hr { display: none; }
		form { display: none; }
		#header{ display: none; }
		#jMenu{ display: none; }
		#footer{ display: none; }/*
		#right_com{ display: none; }
		#right_th{ display: none; }*/
		.search_section{ display: none; }
		.scrollToTop{ display: none ! important; }
		.tab{ display: none; }
		.paging{ display: none; }
		.left{ display: none; }
		.right{ display: none; }
		#dataTable{margin-top: -100px;}
	}
'; ?>

</style>
<script type="text/javascript">
<?php echo '
/*$(document).ready(function() {
    $(\'#dataTable\').DataTable();
} );*/
'; ?>

</script>
</body>
</html>
