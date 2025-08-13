{extends file='../layout.tpl'}

{block name=title}{$lang.settings} -- {$sitename}{/block}

{block name=body}
    <div class="main_app">
		<div class="main">
            <p>{$lang.2fa_text}</p>
            <img width="300px" style="background: white;" src="{$qrimg}"><br>
            <p>{$lang.your_secret}: {$secret}</p>
            <p>{$lang.code}:</p>
            <form action="" method="post">
                <input type="text" name="code">
                <button type="submit" name="do_2fa">{$lang.bind}</button>
            </form>
            {$text}
        </div>
    </div>
{/block}