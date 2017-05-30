{include file="head.tpl"}
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="maildeliver/menu_mail.tpl"}
		<h3>メール管理</h3>
<h4>メールテンプレート作成</h4>

		{include file="messages.tpl"}


<form action="" method="post"  >
      <table class="center w80">
        <tr>
          <th>テンプレートタイトル&nbsp;&nbsp;<span class="red">※</span></th>
          <td>
	 		{if $result_messages.title}
				<span class="red">{$result_messages.title}</span><br />
			{/if}

          <input type="text" size="30" name="title" value="{$input_data.title}" /></td>
        </tr>
        <tr>
          <th>件名（subject)&nbsp;&nbsp;<span class="red">※</span><br />メール送信時の件名</th>
          <td>
	 		{if $result_messages.subject}
				<span class="red">{$result_messages.subject}</span><br />
			{/if}

          <input type="text" size="30" name="subject" value="{$input_data.subject}" /></td>
        </tr>
	        <tr>
	          <th>メール本文&nbsp;&nbsp;<span class="red">※</span></th>
	          <td>
	 		{if $result_messages.mail_text}
				<span class="red">{$result_messages.mail_text}</span><br />
			{/if}
				<textarea name="mail_text" rows="25" cols="40">{$input_data.mail_text}</textarea>

	          </td>
	        </tr>
<!--
        <tr>
          <th>緊急のお知らせ</th>
          <td>
          <label><input type="checkbox" name="em_flg" value="1" {if $input_data.em_flg==1}checked{/if} />
          ※メール不要の顧客にも緊急メールとして送信します。</label>
          </td>
        </tr>
 -->
     </table>


      <div class="mt20 tc">
        <input type="submit"  name="submit" value="登録" class="btn-lg" />
        <input type="hidden" name="template_no" value="{$input_data.template_no}">
      </div>

</form>
</div>
</div>
{include file="footer.tpl"}
</body>
</html>
