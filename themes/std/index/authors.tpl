{extends file='../layout.tpl'}

{block name=title}{$lang.authors} -- {$sitename}{/block}

{block name=body}
    <div class="page">
        <p>{$lang.authors_text1}</p>

        <p>{$lang.authors_text2}</p><br>

        {while $list = $data->fetch(PDO::FETCH_ASSOC)}
            {$list.username = $list.name|escape:html}
            {include file="../parts/search_user.tpl"}
        {/while}
        
        <p>{$lang.authors_text3}</p>
    </div><br>
{/block}