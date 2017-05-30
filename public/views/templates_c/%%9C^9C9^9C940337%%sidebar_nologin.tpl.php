<?php /* Smarty version 2.6.26, created on 2014-06-17 11:48:21
         compiled from sidebar_nologin.tpl */ ?>
<!--
**************************************************
   右カラム
**************************************************
-->

<div id="subWrap">

	<ul>
  	<li>
    	<a href="https://www.facebook.com/" target="_blank"><img src="/images/btn_register.jpg" alt="ボタン_Facebookに登録する" width="181" height="50" /></a></li>
    <li>
    	<a href="https://www.facebook.com/pages/create/" target="_blank"><img src="/images/btn_make.jpg" alt="ボタン_Facebookページを作成" width="181" height="50" /></a>
    </li>
    <li>
    	<a href="/mypage/login/" onClick="return confirm('ユーザーログインを行います。はじめての方はユーザー登録後にログインします。良いですか？')"><img src="/images/btn_participate-user.jpg" alt="ボタン_Spreadersに参加する" /></a>
    </li>
	 <li>
    	<a href="/owner/login/" onClick="return confirm('オーナーログインを行います。はじめての方はオーナー登録後にログインします。良いですか？')"><img src="/images/btn_participate-owner.jpg" alt="ボタン_Spreadersに参加する" /></a>
    </li>
    <li>
    	<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fspreaders.jp&amp;width=180&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:auto; width:180px; height:290px;" allowTransparency="true"></iframe>
    </li>

	<?php $_from = $this->_tpl_vars['toprightAdArr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<li><a href="<?php echo $this->_tpl_vars['item']['link']; ?>
" target="_blank"><img src="<?php echo @URL_IMG_AD; ?>
<?php echo $this->_tpl_vars['item']['img_name']; ?>
" alt="banner"  width="181" /></a></li>
	<?php endforeach; endif; unset($_from); ?>


  </ul>

</div><!-- /#subWrap -->