{extends file='../layout.tpl'}

{block name=title}{$lang.settings} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        <form method="post">
            <p>
                <p>{$lang.name}: </p>
                <input type="text" name="name" value="{$data.username}" maxlength="50">
            </p>
            <p>
                <p>{$lang.desc}: </p>
                <p>{$lang.markdown_support}</p>
                <textarea name="desc" maxlength="512">{$data.description}</textarea>
            </p>
            <p>
                <p>{$lang.yes_post}: </p>
                <select name="yespost">
					<option 
                        value="0"
                        {if $data.openwall == NULL}selected{/if}>
                        {$lang.cant}
                    </option>

					<option 
                        value="1"
                        {if $data.openwall == 1}selected{/if}>
                        {$lang.can}
                    </option>
				</select>
            </p>
            <p>
                <p>{$lang.lang}: </p>
                <select name="language">
                    {foreach from=$langs key=langg_id item=langg_name}
					    <option 
                            value="{$langg_id}" 
                            {if $langg_id == $smarty.session.lang}selected{/if} >
                            {$langg_name}
                        </option>
                    {/foreach}
				</select>
            </p>
            <p>
                <p>{$lang.style}: </p>
                <select name="theme">
                    {foreach from=$themes key=theme_id item=theme_name}
					    <option 
                            value="{$theme_id}" 
                            {if $theme_id == $smarty.session.theme}selected{/if} >
                            {$theme_name}
                        </option>
                    {/foreach}
				</select>
            </p>
            <button type="submit" name="do_change">{$lang.change}</button>
        </form><br>

        <a href="?page=otp">
            {if $user_account.2fa == 1}
                {$lang.disable_2fa}
            {else}
                {$lang.enable_2fa}
            {/if}
        </a><br>

        <a href="?page=pass">{$lang.change_pass}</a>
    </div><br>
{/block}