{include file="head.tpl"}

<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
		<h3>法人会員情報編集</h3>

		{if $msg}<font color="red">{$msg}</font>{/if}
		<form method="post" name="fm_search" action="company/edit" enctype="multipart/form-data" >
		<table class="search">
		<tr>
			<th>会社名※</th>
			<td>
						{if $result_messages.company_name}
							<font color="red"> {$result_messages.company_name}</font><br />
						{/if}
				<input type="text" name="company_name" id="user_name"  value="{$input_data.company_name}" size="40" />
			</td>
		</tr>
		<tr>
			<th>会社名※</th>
			<td>
						{if $result_messages.company_name_kana}
							<font color="red"> {$result_messages.company_name_kana}</font><br />
						{/if}
				<input type="text" name="company_name_kana" id="user_name"  value="{$input_data.company_name_kana}" size="40" />
			</td>
		</tr>
		<tr>
			<th>郵便番号※</th>
			<td>
						{if $result_messages.zip1}
							<font color="red"> {$result_messages.zip1}</font><br />
						{/if}
				<input type="text" name="zip1" id="user_id"  value="{$input_data.zip1}" size="5" />
				-
				<input type="text" name="zip2" id="user_id"  value="{$input_data.zip2}" size="5" />

			</td>
		</tr>
		<tr>
			<th>都道府県※</th>
			<td>
						{if $result_messages.pref}
							<font color="red"> {$result_messages.pref}</font><br />
						{/if}
				{html_options name=pref options=$prefArr selected=$input_data.pref}
			</td>
		</tr>
		<tr>
			<th>市区町村まで※</th>
			<td>
						{if $result_messages.address1}
							<font color="red"> {$result_messages.address1}</font><br />
						{/if}
				<input type="text" name="address1" id="user_id"  value="{$input_data.address1}" size="50" />
			</td>
		</tr>
		<tr>
			<th>番地、ビル名※</th>
			<td>
						{if $result_messages.address2}
							<font color="red"> {$result_messages.address2}</font><br />
						{/if}
				<input type="text" name="address2" id="user_id"  value="{$input_data.address2}" size="50" />
			</td>
		</tr>
		<tr>
			<th>お申込み責任者様氏名※</th>
			<td>
						{if $result_messages.tanto_name}
							<font color="red"> {$result_messages.tanto_name}</font><br />
						{/if}
				<input type="text" name="tanto_name" id="user_id"  value="{$input_data.tanto_name}" size="40" />
			</td>
		</tr>
		<tr>
			<th>お申込み責任者様氏名(フリガナ)※</th>
			<td>
						{if $result_messages.tanto_name_kana}
							<font color="red"> {$result_messages.tanto_name_kana}</font><br />
						{/if}
				<input type="text" name="tanto_name_kana" id="user_id"  value="{$input_data.tanto_name_kana}" size="40" />
			</td>
		</tr>
		<tr>
			<th>お申込み責任者様役職</th>
			<td>
						{if $result_messages.position}
							<font color="red"> {$result_messages.position}</font><br />
						{/if}
				<input type="text" name="position" id="user_id"  value="{$input_data.position}" size="40" />
			</td>
		</tr>
		<tr>
			<th>お申込み責任者様部署名</th>
			<td>
						{if $result_messages.section}
							<font color="red"> {$result_messages.section}</font><br />
						{/if}
				<input type="text" name="section" id="user_id"  value="{$input_data.section}" size="40" />
			</td>
		</tr>
		<tr>
			<th>お申込み責任者様メールアドレス</th>
			<td>
						{if $result_messages.email}
							<font color="red"> {$result_messages.email}</font><br />
						{/if}
				<input type="text" name="email" id="user_id"  value="{$input_data.email}" size="40" />
			</td>
			</td>
		</tr>
		<tr>
			<th>電話番号※</th>
			<td>
						{if $result_messages.tel}
							<font color="red"> {$result_messages.tel}</font><br />
						{/if}
				<input type="text" name="tel" id="user_id"  value="{$input_data.tel}" size="30" />
			</td>
		</tr>
		<tr>
			<th>FAX番号</th>
			<td>
						{if $result_messages.fax}
							<font color="red"> {$result_messages.fax}</font><br />
						{/if}
				<input type="text" name="fax" id="user_id"  value="{$input_data.fax}" size="30" />
			</td>
		</tr>
		<tr>
			<th>URL※</th>
			<td>
						{if $result_messages.url}
							<font color="red"> {$result_messages.url}</font><br />
						{/if}
				<input type="text" name="url" id="user_id"  value="{$input_data.url}" size="40" />
			</td>
		</tr>
		<tr>
			<th>代表者※</th>
			<td>
						{if $result_messages.ceo}
							<font color="red"> {$result_messages.ceo}</font><br />
						{/if}
				<input type="text" name="ceo" id="user_id"  value="{$input_data.ceo}" size="40" />
			</td>
		</tr>
		<tr>
			<th>詳細ページロゴ画像</th>
			<td>
						{if $result_messages.img}
							<font color="red"> {$result_messages.img}</font><br />
						{/if}

					<input type="file" name="file" />
					{if $smarty.session.TMP_FUP.0!=""}
						<img src="{$smarty.const.URL_IMG_TMP}{$smarty.session.TMP_FUP}" >
					{elseif $input_data.logo!=""}
						<img src="{$smarty.const.URL_IMG_LOGO}{$input_data.logo}?{$smarty.now}" >
						<input type="checkbox" name="file_del" value="{$input_data.logo}">削除
						<input type="hidden" name="logo" value="{$input_data.logo}">
					{/if}

					<br />
					横77px,容量100KB以下<br />※横幅を基準にリサイズされます
			</td>
		</tr>

<!--
		<tr>
			<th>
				※承認/非承認
			</th>
			<td>
				<input type="radio" name="admit_flg" value="1"{if $input_data.admit_flg=="1"} checked="checked"{/if}/>承認
				&nbsp;<input type="radio" name="admit_flg" value="0"{if $input_data.admit_flg=="0"} checked="checked"{/if}/>非承認

			</td>
		</tr>
 -->
		</tr>
		</table>
		請求書送付先情報
		<table class="search">
		<tr>
			<th>会社住所と同じ</th>
			<td>
				<input type="checkbox" name="bill_flg" id="user_name"  value="1" {if $input_data.bill_flg==1}checked{/if} />
			</td>
		</tr>
		<tr>
			<th>郵便番号※</th>
			<td>
						{if $result_messages.bill_zip}
							<font color="red"> {$result_messages.bill_zip}</font><br />
						{/if}
				<input type="text" name="bill_zip" id="user_id"  value="{$input_data.bill_zip}" size="20" />
			</td>
		</tr>
		<tr>
			<th>都道府県※</th>
			<td>
						{if $result_messages.bill_pref}
							<font color="red"> {$result_messages.bill_pref}</font><br />
						{/if}
				{html_options name=bill_pref options=$prefArr selected=$input_data.bill_pref}
			</td>
		</tr>
		<tr>
			<th>住所※</th>
			<td>
						{if $result_messages.bill_address1}
							<font color="red"> {$result_messages.bill_address1}</font><br />
						{/if}
				<input type="text" name="bill_address1" id="user_id"  value="{$input_data.bill_address1}" size="50" />
			</td>
		</tr>
		<tr>
			<th>ビル名</th>
			<td>
						{if $result_messages.bill_address2}
							<font color="red"> {$result_messages.bill_address2}</font><br />
						{/if}
				<input type="text" name="bill_address2" id="user_id"  value="{$input_data.bill_address2}" size="50" />
			</td>
		</tr>
		<tr>
			<th>担当者名※</th>
			<td>
						{if $result_messages.bill_tanto_name}
							<font color="red"> {$result_messages.bill_tanto_name}</font><br />
						{/if}
				<input type="text" name="bill_tanto_name" id="user_id"  value="{$input_data.bill_tanto_name}" size="40" />
			</td>
		</tr>
		<tr>
			<th>担当者役職</th>
			<td>
						{if $result_messages.bill_position}
							<font color="red"> {$result_messages.bill_position}</font><br />
						{/if}
				<input type="text" name="bill_position" id="user_id"  value="{$input_data.bill_position}" size="40" />
			</td>
		</tr>
		<tr>
			<th>担当者部署名</th>
			<td>
						{if $result_messages.bill_section}
							<font color="red"> {$result_messages.bill_section}</font><br />
						{/if}
				<input type="text" name="bill_section" id="user_id"  value="{$input_data.bill_section}" size="40" />
			</td>
		</tr>

		</table>
		求人票 共通情報
		<table class="search">
<!--
		<tr>
			<th>求人広告住所</th>
			<td>
				<input type="radio" name="ad_flg" id="user_name"  value="1" {if $input_data.ad_flg==1}checked{/if} />会社住所と同じ
				<input type="radio" name="ad_flg" id="user_name"  value="2" {if $input_data.ad_flg==1}checked{/if} />請求書住所と同じ
			</td>
		</tr>
		<tr>
			<th>郵便番号※</th>
			<td>
						{if $result_messages.ad_zip}
							<font color="red"> {$result_messages.ad_zip}</font><br />
						{/if}
				<input type="text" name="ad_zip" id="user_id"  value="{$input_data.ad_zip}" size="20" />
			</td>
		</tr>
		<tr>
			<th>都道府県※</th>
			<td>
						{if $result_messages.ad_pref}
							<font color="red"> {$result_messages.ad_pref}</font><br />
						{/if}
				{html_options name=ad_pref options=$prefArr selected=$input_data.ad_pref}
			</td>
		</tr>
		<tr>
			<th>住所※</th>
			<td>
						{if $result_messages.ad_address1}
							<font color="red"> {$result_messages.ad_address1}</font><br />
						{/if}
				<input type="text" name="ad_address1" id="user_id"  value="{$input_data.ad_address1}" size="50" />
			</td>
		</tr>
		<tr>
			<th>ビル名</th>
			<td>
				<input type="text" name="ad_address2" id="user_id"  value="{$input_data.ad_address2}" size="50" />
			</td>
		</tr>
		<tr>
			<th>社名</th>
			<td>
						{if $result_messages.ad_company_name}
							<font color="red"> {$result_messages.ad_company_name}</font><br />
						{/if}
				<input type="text" name="ad_company_name" id="user_id"  value="{$input_data.ad_company_name}" size="40" />
			</td>
		</tr>
		<tr>
			<th>URL</th>
			<td>
						{if $result_messages.ad_url}
							<font color="red"> {$result_messages.ad_url}</font><br />
						{/if}
				<input type="text" name="ad_url" id="user_id"  value="{$input_data.ad_url}" size="40" />
			</td>
		</tr>
		<tr>
			<th>代表者氏名</th>
			<td>
				<input type="text" name="dept" id="user_id"  value="{$input_data.dept}" size="40" />
			</td>
		</tr>
  -->
		<tr>
			<th>設立</th>
			<td>
	             {html_options name="foundation_year" options=$yearArr selected=$input_data.foundation_year}
	            年
	            {html_options name="foundation_month" options=$monthArr selected=$input_data.foundation_month}
	            月
			</td>
		</tr>
		<tr>
			<th>資本金</th>
			<td>
				<input type="text" name="found" id="user_id"  value="{$input_data.found}" size="40" />円
			</td>
		</tr>
				<tr>
			<th>従業員数</th>
			<td>
				<input type="text" name="employee_number" id="user_id"  value="{$input_data.employee_number}" size="20" />人
			</td>
		</tr>
		<tr>
			<th>事業内容</th>
			<td>
				<textarea name="description" rows="5" cols="40">{$input_data.description}</textarea>
			</td>
		</tr>
		<tr>
			<th>主要取引先</th>
			<td>
				<textarea name="partner" rows="5" cols="40">{$input_data.partner}</textarea>
			</td>
		</tr>

<!--
		<tr>
			<th>企業特性</th>
			<td>
	            {html_checkboxes name="special" options=$specialArr selected=$input_data.special}
			</td>
		</tr>
		<tr>
			<th>証券コード</th>
			<td>
				<input type="text" name="ticker_symbol" id="user_id"  value="{$input_data.ticker_symbol}" size="40" />
			</td>
		</tr>
		<tr>
			<th>平均年齢</th>
			<td>
				<input type="text" name="age" id="user_id"  value="{$input_data.age}" size="20" />歳
			</td>
		</tr>
		<tr>
			<th>業種</th>
			<td>
				{html_options name=industry options=$industryArr selected=$input_data.industry}
			</td>
		</tr>
		<tr>
			<th>許可番号</th>
			<td>
				{html_options name=license[0] options=$licenseArr selected=$input_data.license.0}
				{html_options name=license[1] options=$licenseArr selected=$input_data.license.1}
				{html_options name=license[2] options=$licenseArr selected=$input_data.license.2}
			</td>
		</tr>
		<tr>
			<th>年間売上</th>
			<td>
				<input type="text" name="sales_year[0]" id="user_id"  value="{$input_data.sales_year.0}" size="10" />年
	            {html_options name="sales_month[0]" options=$sales_monthArr selected=$input_data.sales_month.0}
				<input type="text" name="sales[0]" id="user_id"  value="{$input_data.sales.0}" size="10" />円
				<br />
				<input type="text" name="sales_year[1]" id="user_id"  value="{$input_data.sales_year.1}" size="10" />年
	            {html_options name="sales_month[1]" options=$sales_monthArr selected=$input_data.sales_month.1}
				<input type="text" name="sales[1]" id="user_id"  value="{$input_data.sales.1}" size="10" />円

			</td>
		</tr>
-->
<!--
		<tr>
			<th>お役立ちメール</th>
			<td>
				<input type="radio" name="mail_flg" id="user_name"  value="1" {if $mail_flg==1}checked{/if} />受け取る
				<input type="radio" name="mail_flg" id="user_name"  value="0" {if $mail_flg==1}checked{/if} />受け取らない

			</td>
		</tr>
-->
		</table>



		<div>
			<input type="submit" name="modify" value="編集">&nbsp;
			<input type="reset"  value="クリア">
			<input type="hidden" name="company_id" value="{$input_data.company_id}">

		</div>
		</form>


	</div>
</div>
{include file="footer.tpl"}
</body>
</html>

