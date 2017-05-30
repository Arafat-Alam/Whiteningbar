
{if $login_member}
		<header>
			<div class="pc clearfix">
				<div class="logo fl"><a href="http://whiteningbar.jp/"><img src="/images/logo.gif" alt="歯のホワイトニング専門店Whitening Bar"></a></div>
				<div class="nav fr">
					<ul>
						<li class="nav-appointment"><a href="/member/reserve/">予約する</a></li>
						<li><a href="/member/">マイページ</a></li>
						<li><a href="/member/logout/">ログアウト</a></li>
					</ul>
				</div>
			</div>
			<div class="sp clearfix">
				<div class="logo fl"><a href="index.html"><img src="/images/logo_sp.gif" alt="歯のホワイトニング専門店Whitening Bar"></a></div>
				<div class="nav fr">
					<ul>
						<li class="nav-appointment"><a href="/member/reserve/">予約する</a></li>
						<li><a href="/member/">マイページ</a></li>
						<li><a href="/member/logout/">ログアウト</a></li>
					</ul>
				</div>
			</div>
		</header>


{else}
		<header>
			<div class="pc clearfix">
				<div class="logo fl"><a href="http://whiteningbar.jp/"><img src="/images/logo.gif" alt="歯のホワイトニング専門店Whitening Bar"></a></div>
				<div class="nav fr">
					<ul>
						<li><a href="/">ログイン</a></li>
						<!--<li><a href="register.html">新規登録</a></li> -->
						<li class="nav-appointment"><a href="/reserve/list/">予約する</a></li>
					</ul>
				</div>
			</div>
			<div class="sp clearfix">
				<div class="logo fl"><a href="index.html"><img src="/images/logo_sp.gif" alt="歯のホワイトニング専門店Whitening Bar"></a></div>
				<div class="nav fr">
					<ul>
						<li><a href="/">ログイン</a></li>
						<!--<li><a href="register.html">新規登録</a></li> -->
						<li class="nav-appointment"><a href="/reserve/list/">予約する</a></li>
					</ul>
				</div>
			</div>
		</header>

{/if}
