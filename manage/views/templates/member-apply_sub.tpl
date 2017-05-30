<html>
<script type="text/javascript">
{literal}

	function apply(){

		//確認
		if(window.confirm('内定して良いですか？')){

			document.myform.submit();
			window.opener.location.reload();
	//		window.close();

		}
		else{

		}

	}

{/literal}
</script>

<body>

{if $employ_str}

	{$employ_str}として内定決定しました
	<br />
	<br />
	<a href="" onClick="window.close();">閉じる</a>

{else}
	<form action="" method="post" name="myform">

	{html_radios name="employ_id" options=$applyArr selected=$input_data.employ_id separator='<br />'}

	<input type="button" value="キャンセル" onClick="window.close();">
	<input type="button" value="内定する" onClick="apply();">
	<input type="hidden" name="apply_no" value="{$apply_no}">

	</form>

{/if}

</body>
</html>