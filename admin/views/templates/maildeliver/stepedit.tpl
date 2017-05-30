{include file="head.tpl"}
<body>
<div id="wrapper">
	{include file="header.tpl"}
	{include file="sidebar.tpl"}
	<div id="main_content">
	{include file="maildeliver/menu_mail.tpl"}
		<h3>メール管理</h3>
<h4>ステップメール詳細設定</h4>

		{if $fini_flg==1}
		{include file="messages.tpl"}
		{/if}

		<form action="" method="post"  >
		      <table class="w80 center">

			        <tr>
			          <th>タイトル<span class="red">※</span></th>
			          <td>
				 		{if $result_messages.title}
							<span class="red">{$result_messages.title}</span><br />
						{/if}

						<input type="text" name="title" value="{$input_data.title}" size="60">
			          </td>
			        </tr>

			        <tr>
			          <th>配信タイミング<span class="red">※</span></th>
			          <td>
				 		{if $result_messages.step_long}
							<span class="red">{$result_messages.step_long}</span><br />
						{/if}
						{html_options name=step_kind options=$stepArr.kind selected=$input_data.step_kind }の
						<input type="text" name="step_long" value="{$input_data.step_long}" size="10">
						{html_options name=step_time options=$stepArr.time selected=$input_data.step_time }
						{html_options name=step_when options=$stepArr.when selected=$input_data.step_when }
			          </td>
			        </tr>

			        <tr>
			          <th>テンプレート選択<span class="red">※</span></th>
			          <td>
						{html_options name=template_no options=$templateArr selected=$input_data.template_no }
			          </td>
			        </tr>

		     </table>


		      <div class="mt20 tc">
		        <input type="submit"  name="submit" value="設定" class="btn-lg" />
		        <input type="hidden" name="no" value="{$input_data.no}">
		      </div>

		</form>
	</div>
</div>
{include file="footer.tpl"}
</body>
</html>
