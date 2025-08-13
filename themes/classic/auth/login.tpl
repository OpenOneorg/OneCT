{extends file='../layout.tpl'}

{block name=title}{$lang.login} -- {$sitename}{/block}

{block name=body}
    <div class="main_app">
		<div class="main">
            <form action="" method="post">
                <p>
                    <p>{$lang.email}:</p>
                    <input type="email" name="email">
                </p>
                
                <p>
                    <p>{$lang.pass}:</p>
                    <input type="password" name="pass">
                </p>
                
                <p>
                    <p>{$lang.2fa_if}:</p>
                    <input type="text" name="code">
                </p>

                <p>
                    <button type="submit" name="login">{$lang.login}</button>
                </p>
            </form>
            <p>{$text}</p>
        </div>
	</div>
{/block}