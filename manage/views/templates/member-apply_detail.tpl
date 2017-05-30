{include file="head.tpl"}


<body>
<div id="wrapper">
	{include file="header.tpl"}
{include file="sidebar.tpl"}
	<div id="main_content">
		<h3>応募管理 > Web履歴詳細</h3>

<!--
						{if $item.apply_status<=1}
							<input type="submit" name="apply_ng[{$item.no}]" value="不採用" onClick="return confirm('不採用としますが、よろしいですか？');">
							<input type="submit" name="apply_ok[{$item.no}]" value="採用" onClick="return confirm('採用としますが、よろしいですか？');">
						{else}
							-
						{/if}

  -->


<table width=500>
<colgroup>
	<col class="cols25" />
	<col class="cols75" />
</colgroup>
<tr class="theader">
	<th>応募雇用形態</th>
</tr>
{foreach from=$job_result item=item}
<tr>
	<td>
		{$item.name}
	</td>
</tr>
{/foreach}
<!-- /tbl-form-01 --></table>

<br />
<table width=500>
<colgroup>
	<col class="cols25" />
	<col class="cols75" />
</colgroup>
<tr class="theader">
	<th colspan="2">プロフィール</th>
</tr>
<tr>
	<th>氏名</th>
	<td>{$input_data.name}（{$input_data.name_kana}）</td>
</tr>
<tr>
	<th>性別</th>
	<td>{if $input_data.sex==1}男性{else}女性{/if}</td>
</tr>
<tr>
	<th>生年月日</th>
	<td> {$input_data.birth_year}
	            年
	            {$input_data.birth_month}
	            月
	            {$input_data.birth_day}
	            日
	</td>
</tr>
<tr>
	<th>住所</th>
	<td>{$input_data.pref_str}{$input_data.address1}{$input_data.address2}</td>
</tr>
<tr>
	<th>電話番号</th>
	<td>【自宅】{$input_data.tel}<br />【携帯】{$input_data.mobile}</td>
</tr>
<tr>
	<th>メールアドレス</th>
	<td>{$input_data.email}</td>
</tr>
<tr>
	<th>最終学歴</th>
	<td>{$input_data.last_year}年に{$input_data.last_school}&nbsp;{$input_data.last_depart}{$input_data.last_flg_str}</td>
</tr>
<!-- /tbl-form-01 --></table>
<br />
<table width=500>
<colgroup>
	<col class="cols25" />
	<col class="cols75" />
</colgroup>
<tr class="theader">
	<th colspan="2">スキルシート</th>
</tr>

{foreach from=$skArr key=k item=item }
	<tr>
		<th>{$item.b_name}</th>
		<td>
	{foreach from=$item.name item=s_item key=kk name=aaa}
		{$s_item}{if $item.skill.$kk}：{$item.skill.$kk}{/if}
		{if $item.name|@count>$smarty.foreach.aaa.iteration}
		、&nbsp;
		{/if}
	{/foreach}
	</td>
	</tr>
{foreachelse}
<th colspan="2">スキルシートはまだ登録されていません</th>
{/foreach}
{if $input_data.skill_comment}
<tr>
	<th>スキル補足</th>
	<td>{$input_data.skill_comment|nl2br}</td>
</tr>
{/if}
<!-- /tbl-form-01 --></table>
<br />
<table width=500>
<tr class="theader">
	<th>職務経歴</th>
</tr>
<tr>
	<td>

		{foreach from=$input_data.job item=item name=jj}
		{if $item.company_name}
			<p class="blk-title-01">職務経歴{$smarty.foreach.jj.iteration}</p>
			<table>
			<colgroup>
				<col class="cols25" />
				<col class="cols75" />
			</colgroup>
			<tr>
				<th>会社名</th>
				<td>{$item.company_name}</td>
			</tr>
			<tr>
				<th>勤務期間</th>
				<td>{$item.f_job_year}年
				{$item.f_job_month}月
				～
				{$item.t_job_year}年
				{$item.t_job_month}月</td>
			</tr>
			<tr>
				<th>職種</th>
				<td>{$item.exp_str}</td>
			</tr>
			<tr>
				<th>雇用形態</th>
				<td>{$item.employ_str}</td>
			</tr>
			<tr>
			<th>職務内容</th>
				<td>{$item.detail|nl2br}
				</td>
			</tr>
			</table>
		{/if}
		{/foreach}



	</td>
</tr>
<!-- /tbl-form-01 --></table>
<br />
<table width=500>
<tr class="theader">
	<th>自己PR・志望動機</th>
</tr>
<tr>
	<td class="alg-c">
	{$input_data.pr|nl2br}
	</td>
</tr>
<!-- /tbl-form-01 --></table>




	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

