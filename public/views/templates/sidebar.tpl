
<!--
**************************************************
   ユーザー様基本情報 (右カラム)
**************************************************
-->

<div id="subWrap">

<div id="userWrap_my-one">

	<p class="userName"><strong>{$login_member.name}</strong>さん</p>

  <dl>
  	<dt><img src="{$login_member.img}" alt="{$login_member.name}さんプロフィール画像" width="60" height="60" /></dt>
    <dd style="text-align: center;">所有している<br/>いいね!数</dd>
    <dd style="text-align: center;">{$login_member.like_cnt|number_format}</dd>
  </dl>
  <div class="clearBoth"></div>
 <div id="pay_my-owner">
    <div align="center" style="line-height:1em;">
	     	<p>現在のポイント</p>
	      <p class="markRed">{$login_member.point|number_format} pt</p>
		   {if $login_member.point >=1000 && $login_member.furigana!="" && $login_member.change_flg}
		     <a href="{$smarty.const.URL_NOSSL}/mypage/change/"><img src="/images/btn_kankin.jpg" alt="換金する" width="90" height="20" /></a>
		   {else}
		    <img src="/images/btn_kankin_gray.jpg" alt="換金する" width="90" height="20" />
		    {/if}
	 <p class="msg1">1,000pt単位で換金可能</p>
	  {if $login_member.change_flg==0}
	  <p class="msg1">{$login_member.change_date}より換金可能</p>
	  {elseif $login_member.furigana==""}
	  	<p class="msg2">換金するにはユーザー情報<br/>の登録が必要です</p>
	  {/if}
	</div>
</div>

  <p class="txtMenu"><a href="{$smarty.const.URL_NOSSL}/mypage/">>> マイページトップ</a></p>
  <p class="txtMenu"><a href="{$smarty.const.URL_NOSSL}/search/list/?likes=1">>> いいね！したページ</a></p>
  <p class="txtMenu"><a href="{$smarty.const.URL_NOSSL}/search/list/">>> FBページを探す</a></p>
{if $login_member.furigana==""}
  <p class="msg2" align="center" >ユーザー情報を<br/>登録してください</p>
{/if}
  <p class="txtMenu"><a href="{$smarty.const.URL_SSL}/mypage/edit/">>>
  {if $login_member.furigana==""}
  	ユーザー情報の登録
  {else}
  	ユーザー情報の変更
  {/if}
  	</a></p>
  <p class="txtMenu"><a href="https://www.facebook.com/" target="_blank">>> Facebookへ</a></p>
</div>
<ul>
    <li>
    	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fspreaders.jp&amp;width=180&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:auto; width:180px; height:290px;" allowTransparency="true"></iframe>
    </li>
	{foreach from=$toprightAdArr item="item"}
		<li><a href="{$item.link}" target="_blank"><img src="{$smarty.const.URL_IMG_AD}{$item.img_name}" alt="banner"  width="181" /></a></li>
	{/foreach}
</ul>

</div><!-- /#subWrap -->



