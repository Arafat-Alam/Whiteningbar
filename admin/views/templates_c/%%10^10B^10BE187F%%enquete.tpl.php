<?php /* Smarty version 2.6.26, created on 2017-04-19 19:03:39
         compiled from shop/enquete.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'shop/enquete.tpl', 120, false),)), $this); ?>
<?php 
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='enquete';
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
<?php echo '

//入力チェック
function validate() {
	var msg = "";

	// お名前
	if ($("#name").val() == "") {
		msg += "・項目名を入力してください\\n";
	}
	// フォームタイプ
	if ($("#form_type").val() == "") {
		msg += "・フォームタイプを選択してください\\n";
	}
	if (msg != "") {
		alert(msg);
		return false;
	}

	$("#fm").submit();
	return true;
}

function mainup( id, val )
{

	document.fm_list.action = "/shop/enquete/";
	document.fm_list.id.value = id;
	document.fm_list.value.value = val;
	document.fm_list.exec.value = "mainup";
	document.fm_list.submit();
}
function maindown( id, val )
{
	document.fm_list.action = "/shop/enquete/";
	document.fm_list.id.value = id;
	document.fm_list.value.value = val;
	document.fm_list.exec.value = "maindown";
	document.fm_list.submit();
}


function entryChange(){

	if($("input:radio[name=\'form_type\']:checked").val()==3 || $("input:radio[name=\'form_type\']:checked").val()==4 ||$("input:radio[name=\'form_type\']:checked").val()==5){
		//項目用タグを表示
		document.getElementById(\'c_category1\').style.display = "";
		document.getElementById(\'c_category2\').style.display = "none";
		document.getElementById(\'c_category3\').style.display = "none";
	}
	else{
		//非表示
		document.getElementById(\'c_category1\').style.display = "none";
		document.getElementById(\'c_category2\').style.display = "";
		document.getElementById(\'c_category3\').style.display = "";

	}

}

$(document).ready(function(){

	entryChange();

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
$this->_smarty_include(array('smarty_include_tpl_file' => "shop/menu_shop.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<h3>基本設定</h3>
		<p>会員登録時に表示するアンケート項目になります。</p>



		<h4>アンケート作成</h4>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "messages.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

		<form id="fm" name="fm" method="post" action="">
		<input type="hidden" id="no" name="komoku_no" value="<?php echo $this->_tpl_vars['input_data']['komoku_no']; ?>
" />
		<input type="hidden" name="id"  />
		<input type="hidden" name="exec"/>
		<input type="hidden" name="value" />
		<table class="admins">
			<tr>
				<th style="width:150px;">項目名<span class="red">※</span></th>
				<td>
							<?php if ($this->_tpl_vars['result_messages']['name']): ?>
								<span class="red"> <?php echo $this->_tpl_vars['result_messages']['name']; ?>
</span><br />
							<?php endif; ?>

					<input type="text" id="name" name="name" size="20" value="<?php echo $this->_tpl_vars['input_data']['name']; ?>
" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<th>ステータス<span class="red">※</span></th>
				<td>
					<label><input type="radio"  id="status" name="status" value="1" <?php if ($this->_tpl_vars['input_data']['status'] == '1'): ?>checked<?php endif; ?> >必須項目</label>
					<label><input type="radio"  id="status" name="status" value="0" <?php if ($this->_tpl_vars['input_data']['status'] == '0'): ?>checked<?php endif; ?> >自由入力</label>
				</td>
			</tr>
			<tr>
				<th>フォームタイプ<span class="red">※</span></th>
				<td>
							<?php if ($this->_tpl_vars['result_messages']['form_type']): ?>
								<span class="red"> <?php echo $this->_tpl_vars['result_messages']['form_type']; ?>
</span><br />
							<?php endif; ?>
					<?php echo smarty_function_html_radios(array('name' => 'form_type','options' => $this->_tpl_vars['makeformArr']['type'],'selected' => $this->_tpl_vars['input_data']['form_type'],'id' => 'form_type','separator' => "<br />",'onClick' => "entryChange();"), $this);?>

				</td>
			</tr>
			<tr id="c_category1">
				 <th>選択肢</th>
				 <td >
					<input type="text" name="opt[]" value="<?php echo $this->_tpl_vars['input_data']['opt']['0']; ?>
" />
					<input type="text" name="opt[]" value="<?php echo $this->_tpl_vars['input_data']['opt']['1']; ?>
" />
					<input type="text" name="opt[]" value="<?php echo $this->_tpl_vars['input_data']['opt']['2']; ?>
" />
					<input type="text" name="opt[]" value="<?php echo $this->_tpl_vars['input_data']['opt']['3']; ?>
" />
					<input type="text" name="opt[]" value="<?php echo $this->_tpl_vars['input_data']['opt']['4']; ?>
" />
				 </td>
			  </tr>
			<tr>
				<th>入力項目の説明</th>
				<td>
					<textarea name="comment" rows="" cols=""><?php echo $this->_tpl_vars['input_data']['comment']; ?>
</textarea>
				</td>
			</tr>
			<tr id="c_category2">
				<th>入力文字数</th>
				<td>
							<?php if ($this->_tpl_vars['result_messages']['in_min']): ?>
								<span class="red"> <?php echo $this->_tpl_vars['result_messages']['in_min']; ?>
</span><br />
							<?php endif; ?>
							<?php if ($this->_tpl_vars['result_messages']['in_max']): ?>
								<span class="red"> <?php echo $this->_tpl_vars['result_messages']['in_max']; ?>
</span><br />
							<?php endif; ?>
					<input type="text" id="in_min" name="in_min" size="5" value="<?php echo $this->_tpl_vars['input_data']['in_min']; ?>
" />文字以上
					<input type="text" id="in_max" name="in_max" size="5" value="<?php echo $this->_tpl_vars['input_data']['in_max']; ?>
" />文字以下

				</td>
			</tr>
			<tr id="c_category3">
				<th>入力制限</th>
				<td>
					<?php echo smarty_function_html_radios(array('name' => 'in_chk','options' => $this->_tpl_vars['makeformArr']['check'],'selected' => $this->_tpl_vars['input_data']['in_chk'],'separator' => "<br />"), $this);?>


				</td>
			</tr>
		</table>
<?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		<div class="tc mt20">
			<button type="submit" name="sbm_save" onClick="return validate();" class="btn-lg">登録</button>
		</div>
<?php endif; ?>
		</form>




		
		 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
		  <!--<a href="/shop/enquete/" class="btn">新規作成</a>-->
		<?php endif; ?>
		<h4>アンケート管理</h4>
					<form name="fm_list" id="fm_list" method="POST" action="/shop/enquete/">
		<input type="hidden" name="id"  />
		<input type="hidden" name="exec"/>
		<input type="hidden" name="value" />
			<table class="clear admins">
			<tr>
				<th width="50">編集</th>
				<th width="100">項目名</th>
				<th width="100">ステータス</th>
				<th width="8" >表示順</th>
				<th width="8" >表示順</th>
				<th width="20">削除</th>
			</tr>
			<?php $_from = $this->_tpl_vars['arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
				<tr>
					<td class="tc"><a href="/shop/enquete/?sn=<?php echo $this->_tpl_vars['item']['komoku_no']; ?>
" class="btn btn-sm"><i class="fa fa-lg fa-pencil"></i></a></td>
					<td><?php echo $this->_tpl_vars['item']['name']; ?>
</td>
					<td><?php if ($this->_tpl_vars['item']['status'] == 1): ?>必須項目<?php else: ?>自由入力<?php endif; ?></td>
					<td class="tc"><?php if (($this->_foreach['name']['iteration']-1) != 0): ?><a href="javascript:void( 0 );" onClick="mainup(<?php echo $this->_tpl_vars['item']['komoku_no']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▲</a><?php endif; ?></td>
					<td class="tc">
						<?php if ($this->_foreach['name']['iteration'] != count ( $this->_tpl_vars['arr'] )): ?>
							<a href="javascript:void( 0 );" onClick="maindown(<?php echo $this->_tpl_vars['item']['komoku_no']; ?>
, <?php echo $this->_tpl_vars['item']['v_order']; ?>
 )" class="btn btn-sm">▼</a><?php endif; ?>
					</td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="<?php echo $this->_tpl_vars['item']['komoku_no']; ?>
"  /></td>
				</tr>
			<?php endforeach; else: ?>
				<tr>
					<td colspan="8">メニュー未設定</td>
				</tr>
			<?php endif; unset($_from); ?>
			</table>
<!--
			<div class="paging">
				<div class="left"><b><?php echo $this->_tpl_vars['total_cnt']; ?>
</b>件のデータが見つかりました。</div>
				<div class="right"><?php echo $this->_tpl_vars['navi']; ?>
</div>
				<div class="end"></div>
			</div>
 -->
 <?php if ($this->_tpl_vars['login_admin']['shop_no'] >= 0): ?>
			<div class="tc mt20">
				<input type="submit" name="upsubmit" value="削除" onClick="return confirm('チェックされたアンケートを削除します。良いですか？');" class="btn-delete">
			</div>
<?php endif; ?>
			</form>


	</div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>
