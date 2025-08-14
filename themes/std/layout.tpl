<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{$themedir}/stylesheet.css">
        <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
        <title>{block name=title}Default Page Title{/block}</title>
        <script src="{$themedir}/js.js"></script>
        {block name=head}{/block}
    </head>
    <body>
        {* Хэдер *}

        <div class="clearfix header">
            <a style="float: left;">
                {$sitename}
            </a>
            
            <a href="javascript:openmenu('side');" id="openmenu" class="header_link">
                {$lang.menu}
            </a>

            {if isset($smarty.session.user.token)}
                <a href="logout.php" class="header_link">
                    {$lang.logout}
                </a>
            {/if}
            
            {foreach from=$site_header key=side_name item=side_link}
                <a class="header_link" href="{$side_link}">
                    {$side_name}
                </a>
            {/foreach}
        </div>

        {* Сайдбар *}

        <div class="side">
            {foreach from=$side_menu key=side_name item=side_link}
                <a class="href" href="{$side_link}">
                    {$side_name}
                </a><br>
            {/foreach}<hr>
        </div>

        {block name=body}{/block}

        <div style="max-width: 640px; margin: auto; text-align: center;">
            <div>
                {foreach from=$footer_links key=name item=link}
                    <a href="{$link}" class="link">{$name}</a> 
                {/foreach}
            </div>
            
            <p>php: {$phpver} | MySQL: {$sqlver}</p>

            <p> | 
                {foreach from=$links key=name item=link}
                    <a href="{$link}" class="link">{$name}</a> | 
                {/foreach}
            </p>
        </div>
    </body>
</html>