<?php /* Smarty version 2.6.26, created on 2017-04-24 19:47:38
         compiled from member/list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'member/list.tpl', 83, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='member';
$_SESSION['tab']='customer';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#member_no").val("");
	$("#tel").val("");
	$("#user_name").val("");
	$("#shop_no").val("");
	 $("#member_flg").attr("checked", false);
}

function rsv_submit( member_id, buy_no )
{

	document.fm_list.action = "reserve/adminEdit/";
	document.fm_list.member_id.value = member_id;
	document.fm_list.buy_no.value = buy_no;
	document.fm_list.exec.value = "rsv_submit";
	document.fm_list.submit();
}

function orderbyChange() {
	document.orderbyForm.action = "/member/list/";
	document.orderbyForm.submit(); 
}


function pageFunc() {
	var val = $(\'#page\').val();
	if (val < 1) {
		alert(\'Page no should be gretter then 0\');
		return false;
	}
	document.pageForm.action = "/member/list/";
	document.pageForm.submit();
}




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
$this->_smarty_include(array('smarty_include_tpl_file' => "member/menu_member.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>顧客一覧</h3>

		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php if ($this->_tpl_vars['result_messages']): ?>
			<center><span class="red"><?php echo $this->_tpl_vars['result_messages']; ?>
</span></center>
		<?php endif; ?>

		<form method="post" name="fm_search" action="/member/list/">
		<table class="search center">
		<tr>
			<th>名前</th>
			<td>
				<input type="text" name="name" id="user_name"  value="<?php echo $this->_tpl_vars['search']['name']; ?>
" size="20" />
			</td>
			<th>会員番号</th>
			<td>
				<input type="text" name="member_no" id="member_no"  value="<?php echo $this->_tpl_vars['search']['member_no']; ?>
" size="20" />
			</td>

		</tr>
		<tr>
			<th>電話番号</th>
			<td>
				<input type="text" name="tel" id="tel"  value="<?php echo $this->_tpl_vars['search']['tel']; ?>
" size="20" />
			</td>
				<th>店舗</th>
				<td>
					<?php echo smarty_function_html_options(array('name' => 'shop_no','options' => $this->_tpl_vars['shopArr'],'selected' => $this->_tpl_vars['search']['shop_no'],'id' => 'shop_no'), $this);?>

				</td>
		<tr>
			<th>削除会員も含む</th>
			<td>
				<input type="checkbox" name="member_flg" id="member_flg"  value="1" <?php if ($this->_tpl_vars['search']['member_flg'] == 1): ?>checked<?php endif; ?> />
			</td>
		</tr>
		</table>
		<div class="mt20 tc">
			<button type="submit" name="sbm_search" class="btn-lg" >検索</button>&nbsp;
			<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
		</div>
		</form>
<hr>
<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
<a href="/member/edit/" class="btn">新規作成</a>
<br />
<?php endif; ?>
<form action="" method="post">

<button type="submit" name="csv" class="btn-lg mt10">CSV出力</button>&nbsp;
<button type="submit" name="csv_history" class="btn-lg mt10">CSV(履歴付き)出力</button>&nbsp;
</form>


		<p class="mt10">未使用の購入済みコースがある会員様の削除は出来ません。<br/>
予約中→来店に変更しない場合には、規定回数に達しても来店状況に表示され続けます</p>
			<div class="paging clearfix">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
			</div>

			<div>
				<div class="left">
					<form action="" method="GET" name="orderbyForm">
					ソート : 
						<select name="orderby" onchange="orderbyChange()">
							<option value="none">ソートの選択</option>
							<option value="member_id" <?php if ($this->_tpl_vars['ord'] == 'member_id'): ?><?php echo 'selected'; ?>
<?php endif; ?>>会員 ID</option>
							<option value="name" <?php if ($this->_tpl_vars['ord'] == 'name'): ?><?php echo 'selected'; ?>
<?php endif; ?>>お名前</option>
						</select>
					</form>
				</div>
				<div class="right">
					<form action="" method="GET" name="pageForm">
						<div class="right">
							Jump to Page No : <input type="number" name="page" min="1" id="page">
									<input type="button" name="btn" value="Jump" onclick="pageFunc()">
						</div>
					</form>
				</div>
			</div>


			<!--<table id="tablefix" class="admins clear">-->
			<table  class="admins clear" style="margin-top: 50px;">

			<tr>
				<th>編集</th>
				<th width="100">会員No</th>
				<th width="150">お名前</th>
				<th>電話番号</th>
				<th>購入/残回数</th>
				<th >管理用備考</th>
				<th>削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['member']):
?>

				<tr>
					<!--<td class="tc"><a href="member/history/?member_id=<?php echo $this->_tpl_vars['member']['member_id']; ?>
" class="btn btn-sm"><i class="fa fa-lg fa-history"> </i></a></td>  -->
					<td class="tc"><a href="member/edit/?member_id=<?php echo $this->_tpl_vars['member']['member_id']; ?>
" class="btn btn-sm"><i class="fa fa-lg fa-pencil"> </i></a></td>
					<td><?php echo $this->_tpl_vars['member']['member_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['member']['name']; ?>
<br /><?php echo $this->_tpl_vars['member']['name_kana']; ?>
</td>
					<td><?php echo $this->_tpl_vars['member']['tel']; ?>
</td>
					<td>
						<?php $_from = $this->_tpl_vars['member']['reserve']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
                        	<div class="mb5">
							<?php echo $this->_tpl_vars['item']['name']; ?>
/残<?php echo $this->_tpl_vars['item']['zan']; ?>
回
                            </div>
						<?php endforeach; endif; unset($_from); ?>
						<?php if ($this->_tpl_vars['member']['rplan'] == 1): ?>予約あり<?php endif; ?>
					</td>


					<td>
						<form name="fm_list" id="fm_list" method="POST" action="/member/list/">
                    	<div class="left w60">
							<textarea name="kanri_comment[<?php echo $this->_tpl_vars['member']['member_id']; ?>
]" class="w100"><?php echo $this->_tpl_vars['member']['kanri_comment']; ?>
</textarea>
                        </div>
                        <?php if ($this->_tpl_vars['member']['shop_no'] == $this->_tpl_vars['login_admin']['shop_no'] || $this->_tpl_vars['login_admin']['shop_no'] == 0): ?>
                        <div class="right">
							<input type="submit" name="submit" value="更新">
                         </div>
                         <?php endif; ?>
						</form>
					</td>
					<td class="tc">
					<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
						<?php if ($this->_tpl_vars['member']['member_flg'] == 99): ?>
							削除会員
						<?php elseif (! $this->_tpl_vars['member']['reserve'] && $this->_tpl_vars['member']['rplan'] != 1 && ( $this->_tpl_vars['member']['shop_no'] == $this->_tpl_vars['login_admin']['shop_no'] || $this->_tpl_vars['login_admin']['shop_no'] == 0 )): ?>
						<form name="fm_list" id="fm_list" method="POST" action="/member/list/">
							<input type="submit" name="delete_dummy[<?php echo $this->_tpl_vars['member']['member_id']; ?>
]" value="削除" onClick="return confirm('<?php echo $this->_tpl_vars['member']['name']; ?>
様のデータを削除しますが良いですか？');" class="btn-delete btn-sm">
						</form>
						<?php endif; ?>
					<?php endif; ?>
					</td>

				</tr>

			<?php endforeach; else: ?>
				<tr>
					<td colspan="11">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>
			<div class="paging">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
				<div class="end"></div>
			</div>


	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
