<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{$themedir}/stylesheet.css">
        <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
        <title>{block name=title}Default Page Title{/block}</title>
        {block name=head}{/block}
    </head>
    <body>
        {* Хэдер *}

        <div class="header clearfix">
            <a class="sitename">
                {$sitename}
            </a>

            {if isset($smarty.session.user.token)}
                <a class="href" href="logout.php">
                    {$lang.logout}
                </a>
            {/if}

            {foreach from=$side_menu key=side_name item=side_link}
                <a class="href" href="{$side_link}">
                    {$side_name}
                </a>
            {/foreach}
        </div>

        {block name=body}{/block}

        <div class="footer">
            <div class="links">
                {foreach from=$footer_links key=name item=link}
                    <a href="{$link}" class="link">{$name}</a> 
                {/foreach}
            </div>
            
            <p>php: {$phpver} | MySQL: {$sqlver}</p>

            <p> | 
                {foreach from=$links key=name item=link}
                    <a href="{$link}">{$name}</a> | 
                {/foreach}
            </p>
        </div>
    </body>
</html>