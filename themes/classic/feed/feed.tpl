{extends file='../layout.tpl'}

{block name=title}{$lang.feed} -- {$sitename}{/block}

{block name=head}
    <script src="{$themedir}/js.js"></script>
{/block}

{block name=body}
    <div class="main_app">
		<div class="wall">
            {* Блок для постинга *}

            {include file="../parts/posting.tpl"}   

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