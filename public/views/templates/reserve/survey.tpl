{include file="head.tpl"}
<title>歯のホワイトニング専門店Whitening Bar　予約受付</title>
<meta name="Keywords" content="Whitening Bar, ホワイトニング, 歯のホワイトニング, 予約" />
<meta name="Description" content="歯のホワイトニング専門店Whitening Bar　予約を受け付けいたします。" />

{include file="head_under.tpl"}
<script type="text/javascript">
<!--
{literal}



{/literal}
-->
</script>

<body>
	<div id="wrap">
{include file="header.tpl"}

		<div class="content">
		<h1>予約する</h1>
		<form action="" method="post">
			<h2>アンケート</h2>
			<div class="content-inner">
				<p>下記項目に入力後、「次へ」ボタンをクリックしてください。</p>

				{if $result_messages}
					{foreach from=$result_messages item=item}
						<p class="txt-red mt5">{$item}</p>
					{/foreach}
				{/if}
				<table class="table mt10">
				{foreach from=$setArr item=item}
					<tr>
						<th>
						{$item.name}
						{if $item.status==1}
							<span class="label">必須</span>
						{/if}
						{if $item.in_min>0}
							<br />{$item.in_min}文字以上
						{/if}
						{if $item.in_max>0}
							{$item.in_max}文字以下
						{/if}

						</th>
						<td>
					{assign var=itemno value=$item.komoku_no }
					{if $item.form_type==1}<!-- input  -->
							<input name="no[{$itemno}]" value="{$input_data.no.$itemno}" type="text" class="form-lg">
					{elseif $item.form_type==2}<!-- textarea  -->
							<textarea name="no[{$itemno}]">{$input_data.no.$itemno}</textarea>
					{elseif $item.form_type==3}<!-- select  -->
							{html_options name="no[$itemno]" options=$item.opt selected=$input_data.no.$itemno}
					{elseif $item.form_type==4}<!-- radio  -->
							{html_radios name="no[$itemno]" options=$item.opt selected=$input_data.no.$itemno}
					{elseif $item.form_type==5}<!-- checkbox  -->
							{html_checkboxes name="no[$itemno]" options=$item.opt selected=$input_data.no.$itemno}
					{/if}
								<br><span class="txt-sm">{$item.comment}</span>
							</td>
						</tr>
				{/foreach}
				</table>
				<div class="tc mt35">
				<input type="button" name="back" class="btn btn-lg btn-gray" value="戻る"  onclick="location.href='/reserve/list/?back'">&nbsp;&nbsp;

				<input type="submit" name="submit" class="btn btn-lg" value="次へ"></div>
			</div>
		</form>
		</div>
		<div id="push"></div>
	</div><!-- / #wrap -->
	<p id="page-top" style="display: block;">
		<a href="#wrap"><span><i class="fa fa-arrow-up fa-4x"></i></span></a>
	</p>

{include file="footer.tpl"}

</body>
</html>
