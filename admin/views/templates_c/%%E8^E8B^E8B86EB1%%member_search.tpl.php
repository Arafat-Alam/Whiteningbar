<?php /* Smarty version 2.6.26, created on 2014-08-01 13:55:33
         compiled from reserve/member_search.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

function clearSearchForm() {
	$("#user_id").val("");
	$("#user_name").val("");
}

function getList(member_id){

	target1 = $("#menu_"+member_id);
	//$(".category_m_id").remove();
	$("#menu_no").remove();
	$.ajaxSetup({scriptCharset:"utf-8"});
	$.ajax({
		type: "POST",
		url: "/reserve/getMenuList/",
		cache : false,
		dataType: "json",
		data : {
			buy_no: $("#buy_no_"+member_id).val(),
		},
		success: function(data, dataType) {

			target1.after(data.html);

		},
		error: function(xhr, textStatus, errorThrown) {
			alert("Error! " + textStatus + " " + errorThrown);
		}
	});
}

function setOpener(){
//	window.opener.location.reload();
	window.opener.location.href="/reserve/detail/?no='; ?>
<?php echo $this->_tpl_vars['no']; ?>
<?php echo '";
	window.close();
}
function setOpener2(){
	window.opener.location.href="/calendar/edit/?no='; ?>
<?php echo $this->_tpl_vars['no']; ?>
<?php echo '";
	window.close();
}


'; ?>

</script>
<body <?php echo $this->_tpl_vars['onl']; ?>
>
<div id="wrapper">
	<div id="main_content">
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
		<div class="center">
			<form method="post" name="fm_search" action="">
			<table class="search center">
			<tr>
				<th>名前で探す：</th>
				<td>
					<input type="text" name="name" id="user_name"  value="<?php echo $this->_tpl_vars['search']['name']; ?>
" size="20" />
				</td>
			</tr>
			</table>
			<div class="mt20 tc">
				<button type="submit" name="sbm_search" class="btn-lg" >検索</button>&nbsp;
				<button type="button" onClick="clearSearchForm()" class="btn-gray">クリア</button>
			</div>
			</form>
		</div>
<hr>
		
		<p>コース選択プルダウンには使用可能な購入済みコースが表示されていますので、今回の来店予約に使用するコースを選択してください。</p>

			<div class="paging">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
			</div>
			<br/>

				<form name="fm_list" id="fm_list" method="POST" action="">

			<table class="admins clear mt10">
			<tr>
				<th width="80">会員No</th>
				<th width="150">お名前</th>
				<th width="200">メールアドレス</th>
				<th>電話番号</th>
				<th>コース選択</th>
				<th>選択</th>
			</tr>
			<?php $_from = $this->_tpl_vars['members']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['member']):
?>

				<tr>
					<td><?php echo $this->_tpl_vars['member']['member_no']; ?>
</td>
					<td><?php echo $this->_tpl_vars['member']['name']; ?>
</td>
					<td><?php echo $this->_tpl_vars['member']['email']; ?>
</td>
					<td><?php echo $this->_tpl_vars['member']['tel']; ?>
</td>
					<td>
						<select name="buy_no[<?php echo $this->_tpl_vars['member']['member_id']; ?>
]" id=buy_no_<?php echo $this->_tpl_vars['member']['member_id']; ?>
 onChange="getList('<?php echo $this->_tpl_vars['member']['member_id']; ?>
')">
							<?php $_from = $this->_tpl_vars['member']['courseArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
								<option value=<?php echo $this->_tpl_vars['key']; ?>
><?php echo $this->_tpl_vars['item']; ?>
</option>
							<?php endforeach; endif; unset($_from); ?>
						</select>


					<div id=menu_<?php echo $this->_tpl_vars['member']['member_id']; ?>
></div>

					</td>
					<td>
					<input type="submit" name="choice[<?php echo $this->_tpl_vars['member']['member_id']; ?>
]" value="選択" onClick="return confirm('<?php echo $this->_tpl_vars['member']['name']; ?>
様をご来店の会員とします。良いですか？');">
					</td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="6">指定された検索条件では一致するデータがありませんでした。</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>
							</form>

			<div class="paging">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
				<div class="end"></div>
			</div>


	</div>
</div>
<ul id="jMenu" style="display:hidden;">
	<li><ul><li></li></ul></li>
</ul>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
