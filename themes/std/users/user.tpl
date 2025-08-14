{extends file='../layout.tpl'}

{block name=title}{$data_user.0.username} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        {* Аватарка пользователя *}

        <img src="{$data_user.0.img100}" width="100px" style="float: left; margin-right: 8px;">

        {* Имя пользователя *}

        <h2>
            {$data_user.0.username}
            {if $data_user.0.privilege >= 1}
                <img src="../themes/std/imgs/verif.gif">
            {/if}
        </h2>

        {* Описание пользователя *}

        <p>
            {$lang.desc}: 
            {$data_user.0.description}
        </p><br>

        <h1 align="center" class="block_name">
            {$lang.wall} 
        </h1>

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
    </div><br>
{/block}