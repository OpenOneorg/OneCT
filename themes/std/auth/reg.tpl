{extends file='../layout.tpl'}

{block name=title}{$lang.reg} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        <form action="" method="post">
            <p>
				<p>{$lang.nickname}:</p>
				<input type="text" name="username" maxlength="50">
			</p>
			<p>
				<p>{$lang.email}:</p>
				<input type="email" name="email">
			</p>
			<p>
				<p>{$lang.pass}:</p>
				<input type="password" name="pass" maxlength="20">
			</p>
			<p>
				<p>{$lang.repeat_pass}:</p>
				<input type="password" name="pass2">
			</p>
			<p>
				<p>{$lang.captcha}:</p>
				<img src="resources/captcha.php"><br>
				<input type="text" name="captcha">
			</p>
			<p>
				<button type="submit" name="do_signup">
                    {$lang.register}
                </button>
			</p>
        </form>
		<p>{$text}</p>
    </div>
    </div><br>
{/block}