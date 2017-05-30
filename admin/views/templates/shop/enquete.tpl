{php}
session_start();
$_SESSION['page']='shop';
$_SESSION['tab']='enquete';
{/php}

{include file="head.tpl"}
<script type="text/javascript">
{literal}

//入力チェック
function validate() {
	var msg = "";

	// お名前
	if ($("#name").val() == "") {
		msg += "・項目名を入力してください\n";
	}
	// フォームタイプ
	if ($("#form_type").val() == "") {
		msg += "・フォームタイプを選択してください\n";
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

	if($("input:radio[name='form_type']:checked").val()==3 || $("input:radio[name='form_type']:checked").val()==4 ||$("input:radio[name='form_type']:checked").val()==5){
		//項目用タグを表示
		document.getElementById('c_category1').style.display = "";
		document.getElementById('c_category2').style.display = "none";
		document.getElementById('c_category3').style.display = "none";
	}
	else{
		//非表示
		document.getElementById('c_category1').style.display = "none";
		document.getElementById('c_category2').style.display = "";
		document.getElementById('c_category3').style.display = "";

	}

}

$(document).ready(function(){

	entryChange();

});

{/literal}
</script>
<body>
<div id="wrapper">
	{include file="header.tpl"}
{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="shop/menu_shop.tpl"}
		<h3>基本設定</h3>
		<p>会員登録時に表示するアンケート項目になります。</p>



		<h4>アンケート作成</h4>
		{include file="messages.tpl"}

		<form id="fm" name="fm" method="post" action="">
		<input type="hidden" id="no" name="komoku_no" value="{$input_data.komoku_no}" />
		<input type="hidden" name="id"  />
		<input type="hidden" name="exec"/>
		<input type="hidden" name="value" />
		<table class="admins">
			<tr>
				<th style="width:150px;">項目名<span class="red">※</span></th>
				<td>
							{if $result_messages.name}
								<span class="red"> {$result_messages.name}</span><br />
							{/if}

					<input type="text" id="name" name="name" size="20" value="{$input_data.name}" maxlength="20"/>
				</td>
			</tr>
			<tr>
				<th>ステータス<span class="red">※</span></th>
				<td>
					<label><input type="radio"  id="status" name="status" value="1" {if $input_data.status=="1"}checked{/if} >必須項目</label>
					<label><input type="radio"  id="status" name="status" value="0" {if $input_data.status=="0"}checked{/if} >自由入力</label>
				</td>
			</tr>
			<tr>
				<th>フォームタイプ<span class="red">※</span></th>
				<td>
							{if $result_messages.form_type}
								<span class="red"> {$result_messages.form_type}</span><br />
							{/if}
					{html_radios name="form_type" options=$makeformArr.type selected=$input_data.form_type id="form_type" separator="<br />" onClick="entryChange();"}
				</td>
			</tr>
			<tr id="c_category1">
				 <th>選択肢</th>
				 <td >
					<input type="text" name="opt[]" value="{$input_data.opt.0}" />
					<input type="text" name="opt[]" value="{$input_data.opt.1}" />
					<input type="text" name="opt[]" value="{$input_data.opt.2}" />
					<input type="text" name="opt[]" value="{$input_data.opt.3}" />
					<input type="text" name="opt[]" value="{$input_data.opt.4}" />
				 </td>
			  </tr>
			<tr>
				<th>入力項目の説明</th>
				<td>
					<textarea name="comment" rows="" cols="">{$input_data.comment}</textarea>
				</td>
			</tr>
			<tr id="c_category2">
				<th>入力文字数</th>
				<td>
							{if $result_messages.in_min}
								<span class="red"> {$result_messages.in_min}</span><br />
							{/if}
							{if $result_messages.in_max}
								<span class="red"> {$result_messages.in_max}</span><br />
							{/if}
					<input type="text" id="in_min" name="in_min" size="5" value="{$input_data.in_min}" />文字以上
					<input type="text" id="in_max" name="in_max" size="5" value="{$input_data.in_max}" />文字以下

				</td>
			</tr>
			<tr id="c_category3">
				<th>入力制限</th>
				<td>
					{html_radios name="in_chk" options=$makeformArr.check selected=$input_data.in_chk separator="<br />"}

				</td>
			</tr>
		</table>
{if $login_admin.shop_no>=0}
		<div class="tc mt20">
			<button type="submit" name="sbm_save" onClick="return validate();" class="btn-lg">登録</button>
		</div>
{/if}
		</form>




		{* 検索結果 *}

		 {if $login_admin.shop_no>=0}
		  <!--<a href="/shop/enquete/" class="btn">新規作成</a>-->
		{/if}
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
			{foreach from=$arr name=name item="item"}
				<tr>
					<td class="tc"><a href="/shop/enquete/?sn={$item.komoku_no}" class="btn btn-sm"><i class="fa fa-lg fa-pencil"></i></a></td>
					<td>{$item.name}</td>
					<td>{if $item.status==1}必須項目{else}自由入力{/if}</td>
					<td class="tc">{if $smarty.foreach.name.index!=0}<a href="javascript:void( 0 );" onClick="mainup({$item.komoku_no}, {$item.v_order} )" class="btn btn-sm">▲</a>{/if}</td>
					<td class="tc">
						{if $smarty.foreach.name.iteration!=count($arr)}
							<a href="javascript:void( 0 );" onClick="maindown({$item.komoku_no}, {$item.v_order} )" class="btn btn-sm">▼</a>{/if}
					</td>
					<td class="tc"><input type="checkbox" name="delete_dummy[]" value="{$item.komoku_no}"  /></td>
				</tr>
			{foreachelse}
				<tr>
					<td colspan="8">メニュー未設定</td>
				</tr>
			{/foreach}
			</table>
<!--
			<div class="paging">
				<div class="left"><b>{$total_cnt}</b>件のデータが見つかりました。</div>
				<div class="right">{$navi}</div>
				<div class="end"></div>
			</div>
 -->
 {if $login_admin.shop_no>=0}
			<div class="tc mt20">
				<input type="submit" name="upsubmit" value="削除" onClick="return confirm('チェックされたアンケートを削除します。良いですか？');" class="btn-delete">
			</div>
{/if}
			</form>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

