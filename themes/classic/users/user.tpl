{extends file='../layout.tpl'}

{block name=title}{$data_user.0.username} -- {$sitename}{/block}

{block name=head}
    <script src="{$themedir}/js.js"></script>
{/block}

{block name=body}
    <div class="main_app">
		<div class="main">
            <div class="changeuser">
                {foreach from=$site_header key=side_name item=side_link}
                    <a href="{$side_link}">
                        {$side_name}
                    </a>
                {/foreach}
            </div>

            <table class="user">
                <tr>
                    {* Аватарка пользователя *}

					<td><img class="img100" src="{$data_user.0.img100}"></td>

                    {* Имя пользователя *}
                    
					<td class="info">
						<h1>
                            {$data_user.0.username}
                            {if $data_user.0.privilege >= 1}
                                <img src="../themes/std/imgs/verif.gif">
                            {/if}
                        </h1>
					</td>
				</tr>
			</table>
            
            <h1>{$lang.desc}: {$data_user.0.description}</h1>
        </div>

        <h1 class="head">{$lang.wall}</h1>

        <div class="wall">

            {* Блок для постинга *}

            {if $post->openwall()}
                {include file="../parts/posting.tpl"}
            {/if}         

            {* Посты *}

            {$i = 0}
            {foreach $data_wall as $data}
                {include file="../parts/post.tpl"}
                {$i = $i + 1}
            {/foreach}

            {* Кнопки страниц *}

            {include file="../parts/buttons.tpl"}
        </div>
    </div>
{/block}