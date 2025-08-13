{extends file='../layout.tpl'}

{block name=title}{$lang.settings} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        <form method="post">
            <p>
                <p>{$lang.repeat_pass}:</p>
                <input type="password" name="pass">
            </p>
            <p>
                <button type="submit" name="do_unbind">
                    {$lang.unbind}
                </button>
            </p>
            </form>
            <p>{$error}</p>
    </div><br>
{/block}