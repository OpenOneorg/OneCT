{extends file='../layout.tpl'}

{block name=title}{$lang.search} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        <!-- Форма поиска -->

        <form action="" method="get">
            <input type="text" name="q" placeholder="{$lang.user_search}" value="{$smarty.get.q}" class="search">
            <button type="submit">{$lang.search}</button>
        </form>

        <p>{$data_count} {$lang.results}</p>

        <!-- Сами пользователи -->

        {foreach $data as $list}
            {include file="../parts/search_user.tpl"}
        {/foreach}

        <!-- Навигация по страницам -->
        
        {include file="../parts/search_buttons.tpl"}

    </div><br>
{/block}