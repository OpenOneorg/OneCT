{extends file='../layout.tpl'}

{block name=title}{$lang.authors} -- {$sitename}{/block}

{block name=body}
    <div class="main_app">
		<div class="main">
            <h2>{$lang.authors_text1}</h2>

            <h2>{$lang.authors_text2}</h2>

            {while $list = $data->fetch(PDO::FETCH_ASSOC)}
                {$list.username = $list.name|escape:html}
                {include file="../parts/search_user.tpl"}
            {/while}
            
            <h2>{$lang.authors_text3}</h2>
        </div>
    </div>
{/block}