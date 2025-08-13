    <div id="{"post{$data.id}"}">
        {* Аватарка пользователя *}

        <img style="float: left; margin-right: 8px;" src="{$user_ids[$i].img50}" width="50px"> 

        <div class="post_block1">

            {* Имя пользователя *}

            <b>{$from_ids[$i].username}</b>

            {* Текст закрепления *}

            <span>
                {if $data.is_pin}
                    {$lang.pin}
                {/if}
            </span><br>

            {* Кнопки действий *}

            {if $post->isbuttons($i)}
                <div style="float: right;">
                    <a href="?id={$smarty.get.id}&del={$data.id}">
                        <img src="{$themedir}/imgs/del.gif">
                    </a>
                    
                    <a href="?id={$smarty.get.id}&pin={$data.id}">
                        <img src="{$themedir}/imgs/pin.gif">
                    </a>
                </div>
            {/if}

            {* Дата поста *}

            <span>{$data.date|date_format:$lang.date}</span><br>

            {* Выкладыватель поста *}

            <b>
                {$lang.by}: 
                <a href="user.php?id={$user_ids[$i].id}">
                    {$user_ids[$i].username}
                </a>
            </b><br>

        </div>

        {* Картинка поста *}

        {if isset($data.image)}
            <img src="{$data.image}" width="100%">
        {/if}

        {* Текст поста *}

        <p>{$data.text_html}</p>

        {* Лайки *}
        
        <a href="?id={$smarty.get.id}&p={$smarty.get.p}&like={$data.id}" style="float: right;">
            {if $data.liked}
                <img src="{$themedir}/imgs/like_sel.gif">
            {else}
                <img src="{$themedir}/imgs/like.gif">
            {/if}

            {$data.likes}
        </a>

        {* Кнопка с комментариями *}

        {if isset($data.comments)}
            <a href="comments.php?id={$data.id}">
                {$lang.comments} 
                ({$data.comments})
            </a>
        {/if}<br><br>
    </div>