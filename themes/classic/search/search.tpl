{extends file='../layout.tpl'}

{block name=title}{$lang.search} -- {$sitename}{/block}

{block name=body}
    <div class="main_app">
		<div class="main">
            <!-- Форма поиска -->

            <form action="" method="get">
                <input type="text" name="q" placeholder="{$lang.user_search}" value="{$smarty.get.q}">
            </form>

            <p>{$data_count} {$lang.results}</p>

            <!-- Сами пользователи -->

            {foreach $data as $list}
                {include file="../parts/search_user.tpl"}
            {/foreach}
        </div>

        <!-- Навигация по страницам -->
            
        {include file="../parts/search_buttons.tpl"}
	</div>
{/block}